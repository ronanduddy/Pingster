<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $s3_bucket = 'pingster';
    // this is for all controllers to have access to the dashboard url:
    public $dashboard = array('controller' => 'users', 'action' => 'dashboard');
    public $helpers = array(
        'Form' => array('className' => 'BootstrapForm'),
        'Html' => array('className' => 'SideNav'),
        'Js'
    );
    public $components = array(
        'RequestHandler',
        'Amazonsdk.Amazon',
        'Session',
        'Acl',
        'DebugKit.Toolbar',
//        'Security',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            // redirect to dashboard/profile page after login
            'loginRedirect' => array(
                'controller' => 'users',
                'action' => 'dashboard'
            ),
            // redirect to home/landing page after logout
            'logoutRedirect' => array(
                'controller' => 'home',
                'action' => 'index'
            ),
            'unauthorizedRedirect' => array(
                'controller' => 'users',
                'action' => 'dashboard'
            ),
            // access control (unauthorised) message
            'authError' => 'You don\'t have access to that page :(',
            // error in logging in
            'loginError' => 'Invalid Username or Password entered, please try again.',
            // start authorisation at the controller level
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers/'),
            ),
            // for blowfish password
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish',
                )
            )
        )
    );

    // security component handler
    public function blackhole($error) {
//	echo $error;
        return $this->redirect('https://' . env('SERVER_NAME') . $this->here);
    }

    // This callback is executed before an action
    public function beforeFilter() {
//        
        // all login, register and display actions to all
        $this->Auth->allow('display', 'login', 'logout', 'register');

        $user = $this->Auth->user();

        App::import('Controller', 'Notifications');
        $NotificationsController = new NotificationsController();
        $notifications = $NotificationsController->Notification->getList($user['id'], 10, true);
        // send user data to view. send entire user record.
        $this->set('current_user', $user);
        $this->set('Notifications', $notifications);
    }

    public function afterFilter() {
        $this->recordActivity();
    }

    public function isAuthorized($user) {
        // default deny all unless otherwise specified in ACL
        // located in UsersController.php - ACLinit()
        // Only admins can access admin functions
        if (isset($this->request->params['admin'])) {
            return (bool) ($user['Group']['name'] == 'admin');
        }

        return false;
    }

    public function recordActivity() {

        $result = $this->response->statusCode();
        $user = $this->Auth->user();

        if($result >= 200 &&
            $result < 300 &&
            isset($user['id']) &&
            !($this->name == "CakeError")&&
             $this->request->params['pass']
        )
        {

            $activity = array();
            $activity['action'] = $this->request->params['action'];

            if($this->request->is('get')){

                $activity['method'] = "View";

                //If we're viewing a non page like editPing break out
                if(substr($activity['action'], 0, 4) != 'view'){

                    return true;
                }
            }
            else if($this->request->is('post')){

                $activity['method'] = "Create";
            }

            else if($this->request->is('put')){

                $activity['method'] = "Update";
            }

            $activity['model'] = $this->modelClass;
            $activity['user_id'] = $user['id'];
            $activity['username'] = $user['username'];

            $activity['action'] = $this->request->params['action'];

            if(isset($this->request->params['pass'][0])){

                $activity['entity_id'] = $this->request->params['pass'][0];
            }
            $activity['time'] = date('Y-m-d H:i:s');
            $this->loadModel('Activity');
            $this->Activity->store($activity);
        }
    }

}
