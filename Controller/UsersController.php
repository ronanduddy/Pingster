<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public $components = array('Paginator', 'Session');

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    public function admin_index() {
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array(
            'conditions' => array(
                'AND' => array(
                    'User.id' => $id
                )
            ),
            'fields' => array(
                'User.id',
                'User.email',
                'User.username',
                'User.age',
                'User.ping_power',
                'User.school',
                'User.created',
                'User.modified',
                'Group.name'
            ),
        );

        $this->loadModel('Assets');
        //$this->set('assets', $this->Assets->findByUserId($id));
        // getting comments
        $this->Paginator->settings = array(
            'conditions' => array('Assets.user_id' => $id),
            'limit' => 10,
            'order' => array('Asset.created' => 'desc'),
        );
        $assets = $this->Paginator->paginate('Assets');
        $this->set(compact('assets'));

        $this->User->recursive = 0;
        $this->set('user', $this->User->find('first', $options));
    }

    public function admin_view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.id' => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved.', 'Flashes/success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Could not save user. Please, try again.', 'Flashes/danger');
            }
        }
        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
    }

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved.', 'Flashes/success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Could not save user. Please, try again.', 'Flashes/danger');
            }
        }
        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
    }

    public function register() {
        $this->layout = 'loginRegister';
        $this->set('title', 'Register');
        $this->checkLoggedIn();

        if ($this->request->is('post')) {
            $this->User->create();

            // set to group id for pingster user
            $this->request->data['User']['group_id'] = 3;

            if ($this->User->save($this->request->data)) {

                // if login succeeds -> direct to dashboard
                if ($this->Auth->login()) {
                    $this->Session->setFlash('Welcome ' . h($this->request->data['User']['username']) . ', you have just been added to Pingster!', 'Flashes/success');
                    return $this->redirect($this->dashboard);
                    // else login fails
                } else {
                    $this->Session->setFlash('Issue with logging you in after sign-up, try loggin in.', 'Flashes/danger');
                    return $this->redirect(array('action' => 'register'));
                }
            } else {
                $this->Session->setFlash('Could not register user. Please, try again.', 'Flashes/danger');
            }
        }

        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
    }

    public function edit($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Your details have been updated, but you may need to logout and then log back in to see the updated changes.', 'Flashes/success');
                return $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash('We couldn\'t update your details. Please, try again.', 'Flashes/danger');
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $users = $this->User->UsersUser->User->find('list');
        $projects = $this->User->Project->find('list');
        $this->set(compact('projects', 'users'));

        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
    }

    public function admin_edit($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved.', 'Flashes/success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be edited. Please, try again.', 'Flashes/danger');
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $users = $this->User->UsersUser->User->find('list');
        $projects = $this->User->Project->find('list');
        $this->set(compact('projects', 'users'));

        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash(__('The user has been deleted.'));
        } else {
            $this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash('The user has been deleted.', 'Flashes/success');
        } else {
            $this->Session->setFlash('The user could not be deleted. Please, try again.', 'Flashes/danger');
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_login() {
        $this->login();
    }

    // log user in
    // See View/Elements/login or View/Users/login
    public function login() {
        $this->layout = 'loginRegister';
        $this->set('title', 'Login');
        $this->checkLoggedIn();

        if ($this->request->is('post')) {
            // authenticate user
            if ($this->Auth->login()) {
                return $this->redirect($this->redirect($this->dashboard));
            } else {
                $this->Session->setFlash('Sorry, invalid username or password. Please try again :)', 'Flashes/danger');
                return false;
            }
        }
    }

    // user's main page. directed here after login/register
    public function dashboard() {
        // get user from auth object. 
        $user = $this->Auth->user();

        if (!$this->User->exists($user['id'])) {
            throw new NotFoundException(__('Invalid user'));
        }

        // find user data and pass to view
        $options = array('conditions' => array('User.id' => $user['id']));
        $this->set('user', $this->User->find('first', $options));
    }

    // user's main page. directed here after login/register
    public function admin_dashboard() {
        // get user from auth object. 
        $user = $this->Auth->user();

        if (!$this->User->exists($user['id'])) {
            throw new NotFoundException(__('Invalid user'));
        }

        // find user data and pass to view
        $options = array('conditions' => array('User.id' => $user['id']));
        $this->set('user', $this->User->find('first', $options));
    }

    // used to change a users password
    public function changePassword($id = null) {

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is(array('post', 'put'))) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Your password has been changed', 'Flashes/success');
                return $this->redirect(array('controller' => 'users', 'action' => 'view', $this->request->data['User']['id']));
            } else {
                $this->Session->setFlash('We couldn\'t change your password. Please, try again.', 'Flashes/danger');
            }
        } else {
            $options = array('conditions' => array('User.id' => $id));
            $this->request->data = $this->User->find('first', $options);
        }
    }

    // check if user is already logged in
    public function checkLoggedIn() {
        //if already logged-in, redirect
        if ($this->Session->check('Auth.User')) {
            $this->redirect($this->dashboard);
        }
    }

    // log user out
    public function logout() {
        $this->Session->setFlash('See you again :)', 'Flashes/success');
        return $this->redirect($this->Auth->logout());
    }

    // This callback is executed before the action
    public function beforeFilter() {

        $this->Auth->authorize = 'Controller';
        parent::beforeFilter();
    }

    public function isAuthorized($user) {

        // if pingster
        if ($user['Group']['id'] == 3) {

            // 1 check if  pingster heads to dashboard, checkLoggedIn or logout
            //  1.1 allow
            // 2 check if pingster ties to edit password
            //  2.1 deny if user does not own password
            //  2.2 allow if user owns password 

            if (in_array($this->action, array('dashboard', 'checkLoggedIn', 'logout', 'view'))) {
                return true;
            } elseif (in_array($this->action, array('edit', 'delete'))) {

                $userId = (int) $this->request->params['pass'][0];

                $options = array(
                    'conditions' => array(
                        'AND' => array(
                            'User.id' => $userId
                        )
                    ),
                );
                $this->User->recursive = 0;
                $result = $this->User->find('first', $options);

                if ($result == null || $result['User']['id'] != $user['id']) {
                    $this->Auth->authError = 'You can not edit or delete that profile, it is not yours';
                    $this->Auth->unauthorizedRedirect = '/';
                    return false;
                }if ($result['User']['id'] == $user['id']) {
                    $this->Auth->authError = false;
                    return true;
                }
            } elseif (in_array($this->action, array('changePassword'))) {

                $userId = (int) $this->request->params['pass'][0];

                if ($userId != (int) $user['id']) {
                    $this->Auth->authError = 'You can not edit that password, it is not yours';
                    $this->Auth->unauthorizedRedirect = array('controller' => 'Users', 'action' => 'changePassword', $user['id']);
                    return false;
                } elseif ($userId == (int) $user['id']) {
                    $this->Auth->authError = false;
                    return true;
                }
            }
        }// end if pingster
        // for admin: 
        elseif ($user['Group']['id'] == 1) {
            return true;
        }

        return parent::isAuthorized($user); // false
    }

// end isAuthorized

    public function admin_ACLinit() {
        // 1 = admins
        // 2 = mentors
        // 3 = pingsters
        // 4 = guests
        // 5 = parents
        $group = $this->User->Group;
//
//        // allow admins to everything
        $group->id = 1;
//        $this->Acl->allow($group, 'controllers');
//
//        // allow pingsters to:
//        $group->id = 3;
//        $this->Acl->deny($group, 'controllers');
//
//        $this->Acl->allow($group, 'controllers/Projects/viewPing');
//        $this->Acl->allow($group, 'controllers/Projects/myPings');
//        $this->Acl->allow($group, 'controllers/Projects/addPing');
//        $this->Acl->allow($group, 'controllers/Projects/editPing');
//        $this->Acl->allow($group, 'controllers/Projects/delete');
//        $this->Acl->allow($group, 'controllers/Projects/community');
//
//        $this->Acl->allow($group, 'controllers/Users/dashboard');
//        $this->Acl->allow($group, 'controllers/Users/changePassword');
//        $this->Acl->allow($group, 'controllers/Users/checkLoggedIn');
//        $this->Acl->allow($group, 'controllers/Users/logout');
//        $this->Acl->allow($group, 'controllers/Users/register');
//
//        $this->Acl->allow($group, 'controllers/Comments/commentOnPing');
//        $this->Acl->allow($group, 'controllers/Comments/delete');
//        
//
        echo "all done";
        exit;
    }

}