<?php

App::uses('AppController', 'Controller');

/**
 * Projects Controller
 *
 * @property Project $Project
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProjectsController extends AppController {

    public $components = array('Paginator', 'Session');

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

    // list all of the public pings
    public function community($id = null) {
        $this->Paginator->settings = array(
            'conditions' => array('Project.status' => 'public'),
            'limit' => 5,
            'order' => array(
                'Project.created' => 'DESC'
            )
        );
        $data = $this->Paginator->paginate('Project');
        $this->set(compact('data'));
    }

    // list all of the user's pings
    public function myPings($id = null) {
        // get user from auth object. 
        $user = $this->Auth->user();

        $order = 'Project.created DESC';
        $joins = $this->Project->generateHabtmJoin('User', 'INNER');
        $conditions = array('User.id' => $user['id']);
        $limit = 5;

        $this->paginate = compact('joins', 'conditions', 'order', 'limit');
        $projects = $this->paginate();
        $this->set('data', compact('projects'));
    }

    // view ping's data
    public function viewPing($id = null) {

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
        $this->Project->recursive = -1;
        $this->set('project', $this->Project->ProjectsUser->find('first', $options));

        // getting comments
        $this->Paginator->settings = array(
            'conditions' => array('Project.id' => $id),
            'limit' => 10,
            'order' => array('Comment.created' => 'desc'),
        );
        $commentsList = $this->Paginator->paginate('Comment');
        $this->set(compact('commentsList'));
    }

    public function admin_add() {
        $this->addPing();
    }

    // adds a ping 
    public function addPing() {
        $user = $this->Auth->user();

        if ($this->request->is('post')) {
            $this->Project->create();

            if (!empty($this->request->data) && $this->request->data['Project']['image']['size'] != 0) {

                // tmp vars as request data will be nulled
                $tmp_name = $this->request->data['Project']['image']['tmp_name'];
                $name = $this->request->data['Project']['image']['name'];

                $this->request->data['Project']['image_url'] = null;
                $this->request->data['Project']['image'] = null;

                if ($this->Project->saveAssociated($this->request->data)) {

                    // upload to aws
                    $finfo = new finfo(FILEINFO_MIME);
                    if ($finfo) {
                        $file_name = $tmp_name;
                        $file_info = $finfo->file($file_name);
                        $mime_type = substr($file_info, 0, strpos($file_info, ';'));

                        $this->Amazon->S3->set_region(AmazonS3::REGION_IRELAND);

                        $user = $this->Auth->user();
                        // save to pingster/user/project/image.png
                        $saveTo = sprintf('%s/%s/%s', $user['id'], $this->Project->id, $name);

                        $this->Amazon->S3->create_object(
                                $this->s3_bucket, $saveTo, array(
                            'fileUpload' => $tmp_name,
                            'acl' => AmazonS3::ACL_PUBLIC,
                            'meta' => array('Content-Type' => $mime_type)
                        ));
                    }

                    // set project.image_url to the request_url etc.
                    $this->Project->set('image_url', $this->Amazon->S3->request_url);
                    $this->Project->set('image', $name);

                    // update
                    $this->Project->save();

                    $this->Session->setFlash('Ping created.', 'Flashes/success');
                    if ($user['group_id'] == 1) {
                        return $this->redirect(array('action' => 'index'));
                    } else {
                        return $this->redirect(array('action' => 'myPings'));
                    }
                }
            } else {
                $this->Session->setFlash('The Ping could not be saved. Please, try again.', 'Flashes/warning');
                return $this->redirect(array('action' => 'myPings'));
            }
        }
        $this->set('user', $this->Auth->user());
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

    public function editPing($id = null) {
        $user = $this->Auth->user();

        if (!$this->Project->exists($id)) {
            throw new NotFoundException('Invalid project');
        }

        if ($this->request->is(array('post', 'put'))) {

            if ($this->request->data['Project']['image']['size'] != 0) {

                // delete old image    
                $project = $this->Project->findById($id);

                $imagePath = sprintf('%s/%s/%s', $user['id'], $project['Project']['id'], $project['Project']['image']);

                // remove old image
                $this->Amazon->S3->delete_object($this->s3_bucket, $imagePath);

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

                    $this->Amazon->S3->set_region(AmazonS3::REGION_IRELAND);

                    // save to pingster/user/project/image.png
                    $saveTo = sprintf('%s/%s/%s', $user['id'], $this->request->data['Project']['id'], $name);

                    $this->Amazon->S3->create_object(
                            $this->s3_bucket, $saveTo, array(
                        'fileUpload' => $tmp_name,
                        'acl' => AmazonS3::ACL_PUBLIC,
                        'meta' => array('Content-Type' => $mime_type)
                    ));
                }

                // set project.image_url to the request_url etc.
                $this->Project->set('image_url', $this->Amazon->S3->request_url);
                $this->Project->set('image', $name);
                $this->Project->set('id', $this->request->data['Project']['id']);

                // update
                $this->Project->save();
                $this->Session->setFlash('The Ping has been edited..', 'Flashes/success');

                if ($user['group_id'] == 1) {
                    return $this->redirect(array('action' => 'view', $id));
                } else {
                    return $this->redirect(array('action' => 'viewPing', $id));
                }
            } elseif ($this->request->data['Project']['image']['size'] == 0) {

                // set project.image_url to the request_url etc.
                $this->Project->set('title', $this->request->data['Project']['title']);
                $this->Project->set('description', $this->request->data['Project']['description']);
                $this->Project->set('status', $this->request->data['Project']['status']);
                $this->Project->set('id', $this->request->data['Project']['id']);

                if ($this->Project->save()) {
                    $this->Session->setFlash('The Ping has been edited.', 'Flashes/success');
                    if ($user['group_id'] == 1) {
                        return $this->redirect(array('action' => 'view', $id));
                    } else {
                        return $this->redirect(array('action' => 'viewPing', $id));
                    }
                }
            } else {
                $this->Session->setFlash('The Ping could not be edited. Please, try again.', 'Flashes/warning');
            }
        } else {
            $options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
            $this->request->data = $this->Project->find('first', $options);
        }
        $assets = $this->Project->Asset->find('list');
        $users = $this->Project->User->find('list');
        $this->set(compact('assets', 'users'));
    }

    public function admin_delete($id = null) {
        $this->delete($id);
    }

    public function delete($id = null) {
        $this->Project->id = $id;
        $user = $this->Auth->user();
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
            $S3List = $this->Amazon->S3->get_object_list($this->s3_bucket, array(
                'prefix' => sprintf('%s/%s/', $project['ProjectsUser'][0]['user_id'], $id)
            ));


            // delete from S3
            foreach ($S3List as $object) {
                $this->Amazon->S3->delete_object($this->s3_bucket, $object);
            }

            $this->Session->setFlash('The project has been deleted.', 'Flashes/success');
        } else {
            $this->Session->setFlash('The project could not be deleted. Please, try again.', 'Flashes/warning');
        }

        if ($user['group_id'] == 1) {
            return $this->redirect(array('controller' => 'projects', 'action' => 'index'));
        }

        // redirect to ping or team up page going by data in POST
        if ($this->request->query['kind'] === 'ping') {
            return $this->redirect(array('action' => 'myPings'));
        } elseif ($this->request->query['kind'] === 'team_up') {
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

    public function isAuthorized($user) {

        // if pingster tries to edit or delete ping not theirs:
        if ($user['Group']['id'] == 3) {

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

            if (in_array($this->action, array('edit', 'editPing', 'delete'))) {

                $projectId = (int) $this->request->params['pass'][0];

                $options = array(
                    'conditions' => array(
                        'AND' => array(
                            'ProjectsUser.user_id' => $user['id'],
                            'ProjectsUser.project_id' => $projectId
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
            elseif (in_array($this->action, array('view', 'viewPing'))) {

                $projectId = (int) $this->request->params['pass'][0];

                $options = array(
                    'conditions' => array(
                        'ProjectsUser.project_id' => $projectId
                    ),
                );

                $result = $this->Project->ProjectsUser->find('first', $options);

                // if owner & same user id return true
                if ($result['ProjectsUser']['user_role'] === 'owner' && $result['ProjectsUser']['user_id'] == $user['id']) {
                    return true;
                }
                // if public, return true (any one can view
                if ($result['Project']['status'] === 'public') {
                    return true;
                }
                // if private return false
                if ($result['Project']['status'] === 'private' && $result['ProjectsUser']['user_id'] != $user['id']) {
                    $this->Auth->authError = 'That is a private project and you do not own it';
                    $this->Auth->unauthorizedRedirect = array('action' => 'myPings');
                    return false;
                }

                // to get rid of the authError messages that happen when to myPings from a ping;
                // this does not notify the user after denying access:
                $this->Auth->authError = false;
                return false;
            } elseif (in_array($this->action, array('myPings', 'addPing', 'community'))) {
                return true;
            }
        }// end if pingster
        // for admin: 
        elseif ($user['Group']['id'] == 1) {
            return true;
        }

        return parent::isAuthorized($user); // false
    }

// end isAuthorized
}