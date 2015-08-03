<?php

App::uses('AppController', 'Controller');

/**
 * Comments Controller
 *
 * @property Comment $Comment
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CommentsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'RequestHandler');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Comment->recursive = 0;
        $this->set('comments', $this->Paginator->paginate());
    }

    public function admin_index() {
        $this->index();
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Comment->exists($id)) {
            throw new NotFoundException(__('Invalid comment'));
        }
        $options = array('conditions' => array('Comment.' . $this->Comment->primaryKey => $id));
        $this->set('comment', $this->Comment->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Comment->create();
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('The comment has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
            }
        }
        $users = $this->Comment->User->find('list');
        $projects = $this->Comment->Project->find('list');
        $this->set(compact('users', 'projects'));
    }

    public function commentOnPing() {
        $s3_bucket = Configure::read('Pingster.s3_bucket');

        if ($this->request->is('post')) {
            //debug($this->request->data);exit();
            // create asset & comment if upload was error free; save to db 
            $this->Comment->Project->Asset->create();

            //if asset being uploaded
            if (!empty($this->request->data) && $this->request->data['Asset']['asset']['size'] != 0) {

                // tmp vars as request data will be nulled
                $tmp_name = $this->request->data['Asset']['asset']['tmp_name'];
                $name = $this->request->data['Asset']['asset']['name'];

                $this->request->data['Asset']['asset_url'] = null;
                $this->request->data['Asset']['asset'] = null;


                if ($this->Comment->Project->Asset->saveAssociated($this->request->data)) {

                    // upload to aws
                    $finfo = new finfo(FILEINFO_MIME);
                    if ($finfo) {
                        $file_name = $tmp_name;
                        $file_info = $finfo->file($file_name);
                        $mime_type = substr($file_info, 0, strpos($file_info, ';'));

                        $user = $this->Auth->user();

                        // save to pingster/user/project/asset/image.png
                        $saveTo = sprintf('%s/%s/%s/%s', $user['id'], $this->request->data['Project']['id'], $this->Comment->Project->Asset->id, $name);

                        $result = $this->Amazon->S3->putObject(array(
                            'Bucket' => $s3_bucket,
                            'Key' => $saveTo,
                            'SourceFile' => $tmp_name,
                            'ACL' => 'public-read',
                            'ContentType' => $mime_type
                        ));

                        $this->Comment->Project->Asset->set('asset_url', $result['ObjectURL']);
                    }

                    // set asset.asset_url to the request_url etc.
                    $this->Comment->Project->Asset->set('asset', $name);

                    // update
                    $this->Comment->Project->Asset->save();

                    $this->Session->setFlash('The comment has been saved and asset uploaded.', 'Flashes/success');
                    return $this->redirect(array('controller' => 'Projects', 'action' => 'viewPing', $this->request->data['Comment']['project_id']));
                }
            }

            // create comment and see if it can be saved.
            $this->Comment->create();
            if (!empty($this->request->data) && $this->Comment->save($this->request->data['Comment'])) {
                $this->afterFilter();
                $this->Session->setFlash('The comment has been saved.', 'Flashes/success');
            } else {
                $this->Session->setFlash('The comment could not be saved. Please, try again.', 'Flashes/warning');
                return $this->redirect(array('controller' => 'Projects', 'action' => 'viewPing', $this->request->data['Comment']['project_id']));
            }
        } else {
            $this->Session->setFlash('The asset could not be saved, your comment was however.', 'Flashes/danger');
            return $this->redirect(array('controller' => 'Projects', 'action' => 'myPings', $this->request->data['Comment']['project_id']));
        }
        return $this->redirect($this->referer());
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Comment->exists($id)) {
            throw new NotFoundException(__('Invalid comment'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Comment->saveAssociated($this->request->data)) {
                $this->Session->setFlash(__('The comment has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Comment.' . $this->Comment->primaryKey => $id));
            $this->request->data = $this->Comment->find('first', $options);
        }
        $users = $this->Comment->User->find('list');
        $projects = $this->Comment->Project->find('list');
        $assets = $this->Comment->Project->Asset->find('list');

        $this->set(compact('users', 'projects', 'assets'));
    }

    public function admin_delete($id = null) {
        $user = $this->Auth->user();

        $this->Comment->id = $id;

        if (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid comment'));
        }
        $this->request->allowMethod('post', 'delete');

        // if deleted comment and corresponding asset record
        if ($this->Comment->delete()) {
            $this->Session->setFlash('The comment has been deleted.', 'Flashes/success');
        } else {
            $this->Session->setFlash('The comment could not be deleted. Please, try again.', 'Flashes/warning');
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function delete($id = null) {
        $user = $this->Auth->user();
        $s3_bucket = Configure::read('Pingster.s3_bucket');

        $this->Comment->id = $id;

        if (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid comment'));
        }
        $this->request->allowMethod('post', 'delete');

        $assetID = $this->Comment->findById($id);

        if ($assetID['Comment']['asset_id'] != null) {
            $asset = $this->Comment->Asset->findById($assetID['Comment']['asset_id']);

            // saved to pingster/user/project/asset/image.png
            $assetPath = sprintf('%s/%s/%s/%s', $asset['Asset']['user_id'], $asset['Comment']['project_id'], $asset['Comment']['asset_id'], $asset['Asset']['asset']);

            // if deleted comment and corresponding asset record
            if ($this->Comment->delete() && $this->Comment->Asset->delete($assetID['Comment']['asset_id'])) {
                // delete asset in s3 too
                $result = $this->Amazon->S3->deleteObject(array(
                    'Bucket' => $s3_bucket,
                    'Key' => $assetPath
                ));

                $message = 'The comment & asset have been deleted.';
                $success = true;
            } else {
                $message = 'The comment or asset could not be deleted. Please, try again.';
                $success = false;
            }
        } else {
            // if just deleted comment record
            if ($this->Comment->delete()) {
              $message = 'The comment has been deleted.';
              $success = true;
            } else {
              $message = 'The comment could not be deleted. Please, try again.';
              $success = false;
            }
        }

        if ($this->request->is('ajax'))
        {
          $this->set(compact('message', 'success'));
          $this->set('_serialize', ['message', 'success']);
        }
        else
        {
          $this->Session->setFlash($message, $success ? 'Flashes/success' : 'Flashes/warning');

          // redirect to ping or team up going by data in POST
          if ($this->request->query['kind'] === Project::KIND_PING) {
              return $this->redirect(array('controller' => 'Projects', 'action' => 'viewPing', $this->request->query['projectId']));
          } elseif ($this->request->query['kind'] === Project::KIND_TEAM_UP) {
              return $this->redirect(array('controller' => 'Projects', 'action' => 'viewTeamUp', $this->request->query['projectId']));
          } else {
              return $this->redirect(array('action' => 'index'));
          }
        }
    }

    public function beforeFilter() {

        // check controllers (authorise)
        $this->Auth->authorize = 'Controller';
        parent::beforeFilter();
    }

    public function isAuthorized($user) {

        $group = $user['Group']['name'];

        // if pingster tries to edit or delete comment not theirs:
        if ($group == 'pingsters' || $group == 'mentors') {

            // 1 check if pingster ties to edit or delete comment
            //  1.1 deny if user does not own comment
            //  1.2 allow if user owns comment
            // 2 check of pingster tries to commentOnPing that's private
            //  2.1 allow if user owns it
            //  2.2 allow if project is public
            //  2.3 deny if project is private
            // final return calls parent/base isAuthorized method => false 

            if (in_array($this->action, array('delete'))) {

                $commentId = (int) $this->request->params['pass'][0];

                $options = array(
                    'conditions' => array(
                        'AND' => array(
                            'Comment.user_id' => $user['id'],
                            'Comment.id' => $commentId
                        )
                    ),
                );

                $result = $this->Comment->find('all', $options);

                if ($result == null) {
                    $this->Auth->authError = 'You can not edit or delete that comment, it is not yours';
                    $this->Auth->unauthorizedRedirect = array('controller' => 'Projects', 'action' => 'viewPing', $this->request->query['projectId']);
                    return false;
                } elseif ($result != null) {
                    $this->Auth->authError = false;
                    return true;
                }
            } elseif (in_array($this->action, array('commentOnPing'))) {

                $data = $this->request->data;

                $options = array(
                    'conditions' => array(
                        'AND' => array(
                            'Project.id' => $data['Project']['id']
                        )
                    ),
                );

                $results = $this->Comment->Project->find('first', $options);

                // if owner & same user id return true
                foreach($results['ProjectsUser'] as $result){

                    if($result['user_id'] == $user['id']){
                        return true;
                    }
                }

                // if public, return true (any one can view
                if ($result['Project']['status'] === Project::STATUS_PUBLIC) {
                    return true;
                }
                // if private return false
                if ($result['Project']['status'] === Project::STATUS_PRIVATE && $result['ProjectsUser'][0]['user_id'] != $user['id']) {
                    $this->Auth->authError = 'That is a private project and you do not own it';
                    $this->Auth->unauthorizedRedirect = '/';
                    return false;
                }

                $this->Auth->authError = false;
                return false;
            }
        }// end if pingster
        // for admin: 
        elseif ($group == 'admins') {
            return true;
        }

        return parent::isAuthorized($user); // false
    }

// end isAuthorized
}
