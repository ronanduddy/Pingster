<?php

App::uses('AppController', 'Controller');

/**
 * Home Controller
 *
 */
class HomeController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        // nothing, just render the view
        $this->layout = 'Home/index';

        // for registration
        $this->loadModel('User');
        $groups = $this->User->Group->find('list');

        $this->loadModel('Activity');
        $stream = $this->Activity->get();

        $this->set(compact('groups'));
        $this->set($stream);
    }

    // anyone can view the home/index page
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');

        //if already logged-in, redirect to dashboard
        if ($this->Session->check('Auth.User')) {
            $this->redirect($this->dashboard);
        }
    }

}