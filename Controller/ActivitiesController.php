<?php

App::uses('AppController', 'Controller');

class ActivitiesController extends AppController {

    public function getAll(){

        $user = $this->Auth->user();

        $stream = $this->Activity->get($user);
        $this->set('stream', $stream);
        $this->set('_serialize', 'stream');
    }

    public function getFollowers(){

        $user = $this->Auth->user();
        $this->loadModel('UsersFollower');
        $followers = $this->UsersFollower->getFollowers($user['id']);

        $stream = $this->Activity->get($user, $followers);
        $this->set('stream', $stream);
        $this->set('_serialize', 'stream');
    }

     public function isAuthorized($user) {
        $user = $this->Auth->user();
        return isset($user['Group']['name']);
     }
}