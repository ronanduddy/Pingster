<?php
App::uses('AppController', 'Controller');
/**
 * UsersUsers Controller
 *
 * @property UsersUser $UsersUser
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersFollowersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

    public function follow($user_id = null){

        $user = $this->Auth->user();
        $user_id = isset($user_id) ? $user_id : $this->request->query['user_id'];

        if(isset($user['id']) && isset($user_id)){

            $retVal = $this->UsersFollower->follow($user['id'], $user_id);

            if($retVal == 2){

                $this->loadModel('Notification');
                $this->Notification->msg($user_id, $user['username'] . " just followed you!");
            }

            $this->set('results', $retVal);
        }

        $this->set('_serialize', 'results');
    }

    public function isAuthorized($user) {

        $user = $this->Auth->user();
        return isset($user['id']);
    }
}