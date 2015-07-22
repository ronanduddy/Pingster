<?php

App::uses('AppController', 'Controller');
App::uses('Project', 'Model');

/**
 * Projects Controller
 *
 * @property Project $Project
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProjectsController extends AppController {

    public $components = array('Paginator', 'Session', 'RequestHandler');
    public $helpers = array('Js');

    public function myTeamUps($id=null) {

        $this->myProjects($id, Project::KIND_TEAM_UP);
    }

    public function viewTeamUp($id = null){

        $this->viewProject($id);
    }

    public function addTeamUp() {

        $this->addProject(Project::KIND_TEAM_UP);
    }

    public function editTeamUp($id=null){

        $this->editProject($id, Project::KIND_TEAM_UP);
    }
    public function myPings($id=null) {

        $this->myProjects($id, Project::KIND_PING);
    }

    public function viewPing($id = null){

        $this->viewProject($id);
    }

    public function addPing($id=null){

        $this->addProject(Project::KIND_PING);
    }

    public function editPing($id=null){

        $this->editProject($id);
    }


    public function index() {
        $this->Project->recursive = 0;
        $this->set('projects', $this->Paginator->paginate());
    }

    public function admin_index() {
        $this->index();
    }

    public function admin_view($id = null) {
        if (!$this->Project->exists($id)) {
            throw new NotFoundException('Invalid project');
        }
        $options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
        $this->set('project', $this->Project->find('first', $options));
    }

    public function view($id = null) {
        if (!$this->Project->exists($id)) {
            throw new NotFoundException('Invalid project');
        }
        $options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
        $this->set('project', $this->Project->find('first', $options));
    }

    // list all of the user's pings
    public function myProjects($id = null, $kind=Project::KIND_PING) {
        // get user from auth object. 
        $user = $this->Auth->user();

        $order = 'Project.created DESC';
        $joins = $this->Project->generateHabtmJoin('User', 'INNER');
        $conditions = array('User.id' => $user['id'],
                            'kind' => $kind);
        $limit = 10;

        $this->paginate = compact('joins', 'conditions', 'order', 'limit');
        $projects = $this->paginate();
        $this->set('data', compact('projects'));
    }

    // view ping's data
    public function viewProject($id = null) {

        if (!$this->Project->exists($id)) {
            throw new NotFoundException('Invalid project');
        }

        // getting project 
        $options = array(
            'conditions' => array(
                'AND' => array(
                    'Project.id' => $id
                ),
            )
        );

        // find project and set into view
        $this->Project->recursive = -1;
        $this->set('project', $this->Project->ProjectsUser->find('first', $options));

        // getting comments
        $this->Paginator->settings = array(
            'conditions' => array('Project.id' => $id),
            'limit' => 3, /* RMV 10 */
            'order' => array('Comment.created' => 'desc'),
        );
        $commentsList = $this->Paginator->paginate('Comment');
        $this->set(compact('commentsList'));

        // get community id from link table
        // options for getting project ids from link table 
        $options = array(
            'conditions' => array(
                'AND' => array(
                    'CommunitiesProject.project_id' => $id
                ),
            ),
            'fields' => array(
                'CommunitiesProject.community_id'
            )
        );

        // find all project ids that are associated with the community (from link table)
        $this->Project->CommunitiesProject->recursive = -1;
        $CommunitiesProject = $this->Project->CommunitiesProject->find('first', $options);

        // if nothing
        if (!empty($CommunitiesProject)) {

            // get name and id of community for view
            $this->Project->CommunitiesProject->Community->recursive = -1;
            $this->set('community', $this->Project->CommunitiesProject->Community->findById($CommunitiesProject['CommunitiesProject']['community_id']));
        }

        $options = array(
            'conditions' => array(
                'AND' => array(
                    'ProjectsUser.project_id' => $id
                ),
            ),
            'fields' => array(
                'ProjectsUser.user_id',
                'ProjectsUser.accepted_invitation'
            )
        );

        $this->Project->ProjectsUser->recursive = 2;
        $ProjectMembers = $this->Project->ProjectsUser->find('list', $options);
        $ProjectUsers = array();
        if(!empty($ProjectMembers)){

            foreach(array_keys($ProjectMembers) as $member){
                $this->Project->User->recursive = -1;
                $user = $this->Project->User->findById($member);
                $user['User']['accepted_invitation'] = $ProjectMembers[$member];
                $ProjectUsers[] = $user['User'];
            }

            $this->set('ProjectUsers', $ProjectUsers);
        }

    }

    public function admin_add() {
        $this->addPing();
    }

    // adds a ping 
    public function addProject($kind=Project::KIND_PING) {
        $user = $this->Auth->user();
        $s3_bucket = Configure::read('Pingster.s3_bucket');

        if ($this->request->is('post')) {
            $this->Project->create();

            if (!empty($this->request->data) && $this->request->data['Project']['image']['size'] != 0) {

                // tmp vars as request data will be nulled
                $tmp_name = $this->request->data['Project']['image']['tmp_name'];
                $name = $this->request->data['Project']['image']['name'];

                $this->request->data['Project']['image_url'] = null;
                $this->request->data['Project']['image'] = null;
                $this->request->data['Project']['kind'] = $kind;

                if ($this->Project->saveAssociated($this->request->data)) {

                    // upload to aws
                    $finfo = new finfo(FILEINFO_MIME);
                    if ($finfo) {
                        $file_name = $tmp_name;
                        $file_info = $finfo->file($file_name);
                        $mime_type = substr($file_info, 0, strpos($file_info, ';'));

                        $user = $this->Auth->user();
                        // save to pingster/user/project/image.png
                        $saveTo = sprintf('%s/%s/%s', $user['id'], $this->Project->id, $name);

                        $result = $this->Amazon->S3->putObject(array(
                            'Bucket' => $s3_bucket,
                            'Key' => $saveTo,
                            'SourceFile' => $tmp_name,
                            'ACL' => 'public-read',
                            'ContentType' => $mime_type
                        ));

                        $this->Project->set('image_url', $result['ObjectURL']);
                    }

                    // set project.image_url to the request_url etc.
                    $this->Project->set('image', $name);

                    // record
                    $this->Project->save();

                    // community project is member of
                    if ($kind == Project::KIND_PING) {

                        $community_id = $this->request->data['Project']['community'];
                        if (isset($community_id) && $community_id != NULL) {
                            $this->Project->CommunitiesProject->create();
                            $this->Project->CommunitiesProject->save(array('project_id' => $this->Project->id, 'community_id' => $community_id));
                        }
                    }
                    elseif ($kind == Project::KIND_PING) {

                        if (isset($this->request->data['Project']['user_ids'])){

                            $project_members = explode(',',$this->request->data['Project']['user_ids']);
                            $owner = $this->Auth->user();

                            foreach($project_members as $member){

                                if($user_id = intval($member)){

                                    $this->Project->ProjectsUser->create();
                                    $this->Project->ProjectsUser->save(
                                        array(
                                            'project_id' => $this->Project->id,
                                            'user_id' => $user_id,
                                            'user_role' => ProjectsUser::USER_ROLE_COLLABORATOR,
                                            'accepted_invitation' => 0
                                        )
                                    );


                                    $url = '/Projects/viewTeamUp/' . $this->Project->id;
                                    $message = $owner['username'] . " wants to team up! <a id='notification_url' href='".$url."'>Check it out!</a>";
                                    $this->Project->User->Notification->msg($user_id, $message);

                                }
                            }
                        }
                    }


                    $message = 'Ping created.';
                    if ($this->request->is('ajax'))
                    {
                      $success = true;

                      $this->set(compact('message', 'success'));
                      $this->set('_serialize', ['message', 'success']);

                      return;
                    }
                    else
                    {
                      $this->Session->setFlash($message, 'Flashes/success');
                      $action = $kind == Project::KIND_PING ? 'viewPing' : 'viewTeamUp';
                      if ($user['group_id'] == 1) {
                          return $this->redirect(array('action' => $action, $this->Project->id, 'admin' => false));
                      } else {
                          return $this->redirect(array('action' => $action, $this->Project->id));
                      }
                    }
                }
            } else {
                $message = 'The Ping could not be saved. Please, try again.';
                if ($this->request->is('ajax'))
                {
                    $success = false;

                    $this->set(compact('message', 'success'));
                    $this->set('_serialize', ['message', 'success']);

                    return;
                }
                else
                {
                    $this->Session->setFlash('The Ping could not be saved. Please, try again.', 'Flashes/warning');
                    return $this->redirect(array('action' => 'myPings'));
                }
            }
        }

        // if any parameters are being passed to controller
        if (isset($this->request->params['named'])) {
            $namedParams = $this->request->params['named'];
        }

        if($kind == Project::KIND_TEAM_UP){

           $users = $this->Project->User->find(
           'list',
            array(
                'fields' => array('User.username'),
                'recursive' => 0
            ));
           $this->set(compact('user', 'users', 'params'));
        }
        $communities = $this->Project->Community->find('list');

        //FIXME: include team up
        $partial = ($kind != Project::KIND_TEAM_UP && $this->request->is('ajax'));

        $this->set(compact('user', 'communities', 'namedParams', 'partial'));
//        $assets = $this->Project->Asset->find('list');
//        $users = $this->Project->User->find('list');
//        $this->set(compact('assets', 'users'));
    }

    public function admin_edit($id = null) {
        $this->editPing($id);
    }

    public function admin_editPing($id = null) {
        $this->editPing($id);
    }

    public function editProject($id = null, $kind = Projects::KIND_PING) {
        $user = $this->Auth->user();
        $s3_bucket = Configure::read('Pingster.s3_bucket');
        $s3_region = Configure::read('Pingster.s3_region');

        if (!$this->Project->exists($id)) {
            throw new NotFoundException('Invalid project');
        }

        if ($this->request->is(array('post', 'put'))) {

            $project = $this->Project->findById($id);
            //   debug($this->request); exit();
            if ($this->request->data['Project']['image']['size'] != 0) {

                // delete old image

                $imagePath = sprintf('%s/%s/%s', $user['id'], $project['Project']['id'], $project['Project']['image']);

                // remove old image
                $result = $this->Amazon->S3->deleteObject(array(
                    'Bucket' => $s3_bucket,
                    'Key' => $imagePath
                ));

                // tmp vars as request data will be nulled
                $tmp_name = $this->request->data['Project']['image']['tmp_name'];
                $name = $this->request->data['Project']['image']['name'];

                $this->request->data['Project']['image_url'] = null;
                $this->request->data['Project']['image'] = null;

                // upload new file to aws
                $finfo = new finfo(FILEINFO_MIME);
                if ($finfo) {
                    $file_name = $tmp_name;
                    $file_info = $finfo->file($file_name);
                    $mime_type = substr($file_info, 0, strpos($file_info, ';'));

                    // save to pingster/user/project/image.png
                    $saveTo = sprintf('%s/%s/%s', $user['id'], $this->request->data['Project']['id'], $name);

                    $result = $this->Amazon->S3->putObject(array(
                        'Bucket' => $s3_bucket,
                        'Key' => $saveTo,
                        'SourceFile' => $tmp_name,
                        'ACL' => 'public-read',
                        'ContentType' => $mime_type
                    ));

                    $this->Project->set('image_url', $result['ObjectURL']);
                }

                // set project.image_url to the request_url etc.
                $this->Project->set('image', $name);
                $this->Project->set('id', $this->request->data['Project']['id']);
                $this->Project->set('tags', $this->request->data['Project']['tags']);

                if ($kind == Projects::KIND_PING) {
                    // update community project is member of
                    $community_id = $this->request->data['Project']['community'];
                    // debug( $this->request->data); exit();
                    if (isset($community_id) && $community_id != NULL) {

                        $comProj_id = $this->Project->CommunitiesProject->findByProjectId($id);
                        if ($comProj_id == null) {
                            $this->Project->CommunitiesProject->create();
                            $this->Project->CommunitiesProject->save(array('project_id' => $id, 'community_id' => $community_id));
                        } else {
                            $this->Project->CommunitiesProject->id = $comProj_id;
                            $this->Project->CommunitiesProject->saveField('community_id', $community_id);
                        }
                    } // end if
                }


                // update
                $this->Project->save();
                $this->Session->setFlash('The Ping has been edited..', 'Flashes/success');

                $action = $kind == Projects::KIND_PING ? 'viewPing' : 'viewTeamUp';
                if ($user['group_id'] == 1) {
                    return $this->redirect(array('action' => $action, $id, 'admin' => false));
                } else {
                    return $this->redirect(array('action' => $action, $id));
                }
            } elseif ($this->request->data['Project']['image']['size'] == 0) {

                // set project.image_url to the request_url etc.
                $this->Project->set('title', $this->request->data['Project']['title']);
                $this->Project->set('description', $this->request->data['Project']['description']);
                $this->Project->set('status', $this->request->data['Project']['status']);
                $this->Project->set('id', $this->request->data['Project']['id']);
                $this->Project->set('tags', $this->request->data['Project']['tags']);

                if($kind == Project::KIND_PING){
                // update community project is member of
                    $community_id = $this->request->data['Project']['community'];
                    // debug( $this->request->data); exit();
                    if (isset($community_id) && $community_id != NULL) {

                        $comProj_id = $this->Project->CommunitiesProject->findByProjectId($id);
                        if ($comProj_id == null) {
                            $this->Project->CommunitiesProject->create();
                            $this->Project->CommunitiesProject->save(array('project_id' => $id, 'community_id' => $community_id));
                        } else {
                            $this->Project->CommunitiesProject->id = $comProj_id;
                            $this->Project->CommunitiesProject->saveField('community_id', $community_id);
                        }
                    } // end if
                }
                elseif ($kind == Project::KIND_TEAM_UP) {

                    if (isset($this->request->data['Project']['user_ids'])){

                        $old_project_members = array();
                        $accepted_invitations = array();

                        foreach($project['ProjectsUser'] as $member){
                            $accepted_invitations[$member['user_id']] = $member['accepted_invitation'];

                            if($member["user_role"] == ProjectsUser::USER_ROLE_COLLABORATOR){

                                $this->Project->ProjectsUser->delete($member['id']);
                                $old_project_members[] = $member['user_id'];
                            }
                            elseif($member["user_role"] == ProjectsUser::USER_ROLE_OWNER){

                                $owner_id = $member["user_id"];
                            }
                        }

                        $new_project_members = explode(',',$this->request->data['Project']['user_ids']);
                        $owner = $this->Auth->user();

                        foreach($new_project_members as $member){

                            $accepted_invitation = 0;

                            if($user_id = intval($member)){

                                if(isset($owner_id) && $user_id == $owner_id){
                                    break;
                                }

                                if(!in_array($user_id, $old_project_members)){
                                    $url = '/Projects/viewTeamUp/' . $project['Project']['id'];
                                    $message = $owner['username'] . " wants to team up! <a id='notification_url' href='".$url."'>Check it out!</a>";
                                    $this->Project->User->Notification->msg($user_id, $message);
                                }
                                else{

                                    $accepted_invitation =  isset($accepted_invitations[$user_id]) && $accepted_invitations[$user_id];
                                }
                                $this->Project->ProjectsUser->create();
                                $this->Project->ProjectsUser->save(
                                    array(
                                        'project_id' => $project['Project']['id'],
                                        'user_id' => $user_id,
                                        'user_role' => ProjectsUser::USER_ROLE_COLLABORATOR,
                                        'accepted_invitation' => $accepted_invitation
                                    )
                                );
                            }
                        }
                    }
                }

                if ($this->Project->save()) {
                    $this->Session->setFlash('The Ping has been edited.', 'Flashes/success');
                    $action = $kind == Project::KIND_PING ? 'viewPing' : 'viewTeamUp';
                    if ($user['group_id'] == 1) {
                        return $this->redirect(array('action' => $action, $id, 'admin' => false));
                    } else {
                        return $this->redirect(array('action' => $action, $id));
                    }
                }
            } else {
                $this->Session->setFlash('The Ping could not be edited. Please, try again.', 'Flashes/warning');
            }
        } else {
            $options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
            $projects = $this->Project->find('first', $options);

            $project_users = "";
            $project_usernames = "";
            foreach($projects["User"] as $user){
                $project_users[] = $user["id"];
                $project_usernames[] = $user["username"];
            }

            $projects["Project"]["user_ids"] = implode(',', $project_users);
            $projects["Project"]["usernames"] = implode(', ', $project_usernames);
            $this->request->data = $projects;
        }

        $assets = $this->Project->Asset->find('list');
        $users = $this->Project->User->find('list');
        $communities = $this->Project->Community->find('list');
        $this->set(compact('assets', 'users', 'communities'));
    }

    public function admin_delete($id = null) {
        $this->delete($id);
    }

    public function delete($id = null) {
        $this->Project->id = $id;
        $user = $this->Auth->user();
        $s3_bucket = Configure::read('Pingster.s3_bucket');
        if (!$this->Project->exists()) {
            throw new NotFoundException('Invalid project');
        }
        $this->request->allowMethod('post', 'delete');

        // 1. get projects from db
        // 2. delete all objects
        // 3. delete all user's assets belonging to the project
        // 4. add all asset ids that belong to the user to array
        // 5. get object list from s3 for project 'folder'

        $project = $this->Project->findById($id);

        // list for db
        $toDelete = array();
        foreach ($project['Asset'] as $asset) {
            // only delete the user's assets, not contributers to the ping
            if ($asset['user_id'] == $project['ProjectsUser'][0]['user_id']) {
                array_push($toDelete, $asset['id']);
            }
        }

        if ($this->Project->delete()) {

            // delete assets in db..
            foreach ($toDelete as $asset) {
                $this->Project->Asset->delete($asset);
            }

            // get list of object to delete in project belonging to user
            // note this will not delete other user's assets that may be 
            // associated with the project. 
            $S3List = $this->Amazon->S3->getIterator('ListObjects', array(
                'Bucket' => $s3_bucket,
                'Prefix' => sprintf('%s/%s/', $project['ProjectsUser'][0]['user_id'], $id)
            ));

            // delete from S3
            foreach ($S3List as $object) {
                $this->Amazon->S3->deleteObject(array(
                  'Bucket' => $s3_bucket,
                  'Key' => $object['Key']
                ));
            }

            $this->Session->setFlash('The project has been deleted.', 'Flashes/success');
        } else {
            $this->Session->setFlash('The project could not be deleted. Please, try again.', 'Flashes/warning');
        }



        // redirect to ping or team up page going by data in POST
        if ($this->request->query['kind'] === Project::KIND_PING) {
            return $this->redirect(array('action' => 'myPings'));
        } elseif ($this->request->query['kind'] === Project::KIND_TEAM_UP) {
            return $this->redirect(array('action' => 'myTeamUps'));
        } else {
            return $this->redirect(array('action' => 'index'));
        }
    }

    public function beforeFilter() {

        // check controllers (authorise)
        $this->Auth->authorize = 'Controller';
        parent::beforeFilter();
    }

    public function displayComments($id=null) {

        // getting project 
        $options = array(
            'conditions' => array(
                'AND' => array(
                    'Project.id' => $id
                ),
            )
        );

        // find project and set into view
        $this->Project->recursive = -1;
        $this->set('project', $this->Project->ProjectsUser->find('first', $options));
        // getting comments
        $this->Paginator->settings = array(
            'conditions' => array('Project.id' => $id),
            'limit' => 3, /* RMV 10 */
            'order' => array('Comment.created' => 'desc'),
        );

        /* If we are off the end, particularly when deleting the last item on a single-element page, redirect to final page */

        try {
          $commentsList = $this->Paginator->paginate('Comment');
        }
        catch (NotFoundException $e)
        {
          //FIXME: Workaround for paginator failing to set pagination metrics before exception (in this version)
          $this->request->params['named']['page'] = 0;
          $this->Paginator->paginate('Comment');
          return $this->redirect([$id, 'page' => $this->request->params['paging']['Comment']['pageCount']]);
        }
        $this->set(compact('commentsList'));
    }

    public function isAuthorized($user) {

        $group = $user['Group']['name'];

        // if pingster tries to edit or delete ping not theirs:
        if ($group == 'pingsters') {

            if (in_array($this->action, array('searchPings', 'searchTeamUps', 'invitationResponse'))) {
                return true;
            }

            // 1 check if pingster ties to edit or delete project
            //  1.1 deny if user does not own project
            //  1.2 allow if user owns project (by join table)
            // 2 check of pingster tries to view project
            //  2.1 allow if user owns project and join table user_id == user id
            //  2.2 allow if project is public
            //  2.3 deny if project is private and join table user_id != user id
            //  2.4 catch all deny*
            // 3 check if pingster tries to add project
            //  3.1 allow
            // final return calls parent/base isAuthorized method => false 

            if (in_array($this->action, array('edit', 'editPing', 'editTeamUp', 'delete'))) {

                $projectId = (int) $this->request->params['pass'][0];

                $options = array(
                    'conditions' => array(
                        'AND' => array(
                            'ProjectsUser.user_id' => $user['id'],
                            'ProjectsUser.project_id' => $projectId,
                            'ProjectsUser.user_role' => ProjectsUser::USER_ROLE_OWNER
                        )
                    ),
                );

                $result = $this->Project->ProjectsUser->find('first', $options);

                // if found join table corresponding to the project id and current user id
                // if not null, return true => project belongs to current user
                if ($result == null) {
                    $this->Auth->authError = 'You can not edit or delete that project, it is not yours';
                    $this->Auth->unauthorizedRedirect = array('action' => 'myPings');
                    return false;
                } elseif ($result != null) {
                    $this->Auth->authError = false;
                    return true;
                }
            }
            // else if pingster tries to view private projects:
            elseif (in_array($this->action, array('view', 'viewPing', 'viewTeamUp', 'displayComments'))) {

                $projectId = (int) $this->request->params['pass'][0];

                $options = array(
                    'conditions' => array(
                        'ProjectsUser.project_id' => $projectId
                    ),
                );

                $results = $this->Project->ProjectsUser->find('all', $options);

                foreach($results as $result){

                    if($result['ProjectsUser']['user_id'] == $user['id']){
                        return true;
                    }
                }

                // if public, return true (any one can view
                if ($result['Project']['status'] === Project::STATUS_PUBLIC) {
                    return true;
                }
                // if private return false
                if ($result['Project']['status'] === Project::STATUS_PRIVATE && $result['ProjectsUser']['user_id'] != $user['id']) {
                    $this->Auth->authError = 'That is a private project and you do not own it';
                    $this->Auth->unauthorizedRedirect = array('action' => 'myPings');
                    return false;
                }

                // to get rid of the authError messages that happen when to myPings from a ping;
                // this does not notify the user after denying access:
                $this->Auth->authError = false;
                return false;
            } elseif (in_array($this->action, array('myPings', 'myTeamUps', 'addTeamUp', 'addPing', 'community'))) {
                return true;
            }
        }// end if pingster
        // for admin: 
        elseif ($group == 'admins') {
            return true;
        }

        return parent::isAuthorized($user); // false
    }

    public function searchPings(){

        $type = Project::KIND_PING;

        $options = array('fields' => array('title', 'description', 'image_url'));

        if(isset($this->request->query['term']))
        {
            $term = $this->request->query['term'];

            $options['conditions'] = array(
                'Project.kind' => $type,
                'Project.status' => Project::STATUS_PUBLIC,
                "OR" => array(
                    "Project.title LIKE" => '%'.$term.'%',
                    "Project.description LIKE" => '%'.$term.'%'
                )
            );

            $options['order'] = array('Project.modified');
            $results = $this->Project->find('all', $options);

            $this->set('project', $results);;
        }

        $this->set('_serialize', 'project');
    }

    public function searchTeamUps(){

        $type = Project::KIND_TEAM_UP;

        $user = $this->Auth->user();

        $options = array('fields' => array('title', 'description', 'image_url'));

        if(isset($this->request->query['term']))
        {
            $term = $this->request->query['term'];

            $options['conditions'] = array(
                'Project.kind' => $type,
                "OR" => array(
                    "Project.status" => Project::STATUS_PUBLIC,
                    "ProjectsUser.user_id" => $user['id'],
                    "User.id" => $user['id']
                ),
                "OR" => array(
                    "Project.title LIKE" => '%'.$term.'%',
                    "Project.description LIKE" => '%'.$term.'%',
                    "Project.tags LIKE" => '%'.$term.'%'
                )
            );

            $options['order'] = array('Project.modified');

            $this->set('project', $this->Project->find('all', $options));;
        }

        $this->set('_serialize', 'project');
    }

    public function invitationResponse(){


        if ($this->request->is(array('post'))) {

            $this->autoRender = false;

            $project_id = isset($this->request->data['project_id']) ?
                            $project_id = $this->request->data['project_id'] :
                            null;

            if($this->request->data['response'] == "yes"){

                $this->acceptInvitation($project_id, $this->Auth->user('id'));
                return  $this->redirect(array('action' => 'viewTeamUp', $project_id));
            }
            else{

                $this->removeUser($project_id, $this->Auth->user('id'));
                return $this->redirect('/');;
            }
        }
    }

    public function removeUser($project_id, $user_id){

        if($project_id && $user_id){

            $options = array(
                'conditions' => array(
                    'ProjectsUser.project_id' => $project_id,
                    'ProjectsUser.user_id' => $user_id
                ),
            );

            $result = $this->Project->ProjectsUser->find('first', $options);
            $this->Project->ProjectsUser->read('accepted_invitation',$result['ProjectsUser']['id']);
            $this->Project->ProjectsUser->delete();
        }
    }

    public function acceptInvitation($project_id, $user_id){

        if($project_id && $user_id){

            $options = array(
                'conditions' => array(
                    'ProjectsUser.project_id' => $project_id,
                    'ProjectsUser.user_id' => $user_id
                ),
            );

            $result = $this->Project->ProjectsUser->find('first', $options);
            $this->Project->ProjectsUser->read('accepted_invitation',$result['ProjectsUser']['id']);
            $this->Project->ProjectsUser->set('accepted_invitation' ,1);
            $this->Project->ProjectsUser->save();

        }
    }

// end isAuthorized
}
