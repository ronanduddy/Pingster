<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {

    public $components = array('Paginator', 'Session', 'RequestHandler');

    public function search() {
        $options = array('fields' => 'username');

        if(isset($this->request->query['term']))
        {
            $term = $this->request->query['term'];
            $options['conditions'] = array('User.username LIKE' => '%'.$term.'%');
            $this->set('user', $this->User->find('list', $options));;
        }

        $this->set('_serialize', 'user');
    }

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

        $this->User->recursive = 1;
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

                $this->afterFilter();
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

            // get id for group

            $this->User->Group->recursive = -1;

            $group = $this->request->data['User']['group_id'] == "Mentor" ? "mentors" : "pingsters";

            $pingsters = $this->User->Group->findByName($group, array('fields' => 'Group.id'));

            // set to group id for user
            $this->request->data['User']['group_id'] = (int) $pingsters['Group']['id'];
            $this->request->data['User']['verified_email'] = false;

            if ($this->User->save($this->request->data)) {

                $this->generateUserEmail();
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

        $userId = (int) $this->request->params['pass'][0];

        $groups = $this->User->Group->find('list');
        $this->set(compact('groups', 'userId'));
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
                return $this->redirect($this->dashboard);
            } else {
                $this->Session->setFlash('Sorry, invalid username or password. Please try again :)', 'Flashes/danger');
                return false;
            }
        } else {
            return false;
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
                $this->Session->setFlash('I have changed the password', 'Flashes/success');
                return $this->redirect(array('controller' => 'users', 'action' => 'view', $this->request->data['User']['id']));
            } else {
                $this->Session->setFlash('I couldn\'t change the password. Please, try again.', 'Flashes/danger');
            }
        } else {
            $options = array('conditions' => array('User.id' => $id));
            $this->request->data = $this->User->find('first', $options);
        }
    }

    public function validateEmail(){

        $passed_token = $this->request->query['token'];
        $user = $this->Auth->user();
        $token_base =  $user['username'].$user['email'].$user['age'];
        if($this->validate_token($passed_token, $token_base)){
            $this->User->findById($user["id"]);

            $this->User->set(array(
                'verified_email' => 'true',
            ));
            $this->User->save();
            $this->Session->setFlash('Email Verified', 'Flashes/success');
            return $this->redirect(array('controller' => 'users', 'action' => 'view', $this->request->data['User']['id']));
        }
    }

    public function admin_changePassword($id = null) {
        $this->changePassword($id);
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

    public function admin_logout() {
        $this->Session->setFlash('See you again :)', 'Flashes/success');
        return $this->redirect($this->Auth->logout());
    }

    // This callback is executed before the action
    public function beforeFilter() {
       // $this->Auth->allow();
        $this->Auth->authorize = 'Controller';
        parent::beforeFilter();
    }

    public function generateUserEmail(){

        $token_base =  $this->request->data['User']['username'].$this->request->data['User']['email'].$this->request->data['User']['age'];
        $token = $this->encrypt_token($token_base);
        $message = "Please verify your email by visiting <a href='" . Router::url('/', true) .
            "Users/verifyEmail/" . $this->User->getInsertID() . "?token=".$token."'>here</a>";

        $Email = new CakeEmail();
        $Email->from(array('userverification@pingster.org' => 'Pingster Email Verification'))
            ->to($this->request->data['User']['email'])
            ->subject('Verify your email!')
            ->send($message);
    }

    public function isAuthorized($user) {

        $group = $user['Group']['name'];
        // is admin
        if ($group == 'admins') {
            return true;
        }
        
        // if pingster
        if (($group == 'pingsters' || $group == 'mentors') && in_array($this->action, array('dashboard', 'checkLoggedIn', 'logout', 'view', 'search', 'validateEmail'))) {
            return true;
        }

        // if pingster
        if (($group == 'pingsters' || $group == 'mentors') && in_array($this->action, array('edit', 'delete'))) {

            // get  id from url
            $userId = (int) $this->request->params['pass'][0];

            $this->User->recursive = 0;

            // find user
            $result = $this->User->findByid($userId);

            // if null or where returned user_id != current user id 
            if ($result === null || $result['User']['id'] != $user['id']) {
                $this->Auth->authError = 'You can not edit or delete that profile, it is not yours';
                $this->Auth->unauthorizedRedirect = '/';
                return false;
            }

            // if returned user id == current user id 
            if ($result['User']['id'] == $user['id']) {
                $this->Auth->authError = false;
                return true;
            }
        } // end if
        // if pingster
        if (($group == 'pingsters' || $group == 'mentors') && in_array($this->action, array('changePassword'))) {

            // get user id from url
            $userId = (int) $this->request->params['pass'][0];

            // if user id from url != current user id
            if ($userId != (int) $user['id']) {
                $this->Auth->authError = 'You can not edit that password, it is not yours';
                $this->Auth->unauthorizedRedirect = array('controller' => 'Users', 'action' => 'changePassword', $user['id']);
                return false;
            } elseif ($userId == (int) $user['id']) {
                $this->Auth->authError = false;
                return true;
            }
        } // end if

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

        // allow admins to everything
        $group->id = 1;
        $this->Acl->allow($group, 'controllers');

        // allow pingsters to:
        $group->id = 3;
        $this->Acl->deny($group, 'controllers');

        $this->Acl->allow($group, 'controllers/Communities/index');
        $this->Acl->allow($group, 'controllers/Communities/view');

        $this->Acl->allow($group, 'controllers/Projects/viewPing');
        $this->Acl->allow($group, 'controllers/Projects/myPings');
        $this->Acl->allow($group, 'controllers/Projects/addPing');
        $this->Acl->allow($group, 'controllers/Projects/editPing');
        $this->Acl->allow($group, 'controllers/Projects/searchPings');
        $this->Acl->allow($group, 'controllers/Projects/delete');
        $this->Acl->allow($group, 'controllers/Projects/community');
        $this->Acl->allow($group, 'controllers/Projects/viewTeamUp');
        $this->Acl->allow($group, 'controllers/Projects/myTeamUps');
        $this->Acl->allow($group, 'controllers/Projects/addTeamUp');
        $this->Acl->allow($group, 'controllers/Projects/editTeamUp');
        $this->Acl->allow($group, 'controllers/Projects/searchTeamUps');
        $this->Acl->allow($group, 'controllers/Projects/invitationResponse');

        $this->Acl->allow($group, 'controllers/Users/dashboard');
        $this->Acl->allow($group, 'controllers/Users/changePassword');
        $this->Acl->allow($group, 'controllers/Users/checkLoggedIn');
        $this->Acl->allow($group, 'controllers/Users/logout');
        $this->Acl->allow($group, 'controllers/Users/register');
        $this->Acl->allow($group, 'controllers/Users/search');
        $this->Acl->allow($group, 'controllers/Users/validateEmail');

        $this->Acl->allow($group, 'controllers/UsersFollowers/follow');

        $this->Acl->allow($group, 'controllers/Search/explore');

        $this->Acl->allow($group, 'controllers/Notifications/markAllRead');
        $this->Acl->allow($group, 'controllers/Notifications/deleteAll');

        $this->Acl->allow($group, 'controllers/Activities/getAll');

        $this->Acl->allow($group, 'controllers/Comments/commentOnPing');
        $this->Acl->allow($group, 'controllers/Comments/delete');


        // allow mentors to:
        $group->id = 2;
        $this->Acl->deny($group, 'controllers');

        $this->Acl->allow($group, 'controllers/Communities/index');
        $this->Acl->allow($group, 'controllers/Communities/view');
        $this->Acl->allow($group, 'controllers/Communities/edit');

        $this->Acl->allow($group, 'controllers/Projects/viewPing');
        $this->Acl->allow($group, 'controllers/Projects/myPings');
        $this->Acl->allow($group, 'controllers/Projects/addPing');
        $this->Acl->allow($group, 'controllers/Projects/editPing');
        $this->Acl->allow($group, 'controllers/Projects/searchPings');
        $this->Acl->allow($group, 'controllers/Projects/delete');
        $this->Acl->allow($group, 'controllers/Projects/community');
        $this->Acl->allow($group, 'controllers/Projects/viewTeamUp');
        $this->Acl->allow($group, 'controllers/Projects/myTeamUps');
        $this->Acl->allow($group, 'controllers/Projects/addTeamUp');
        $this->Acl->allow($group, 'controllers/Projects/editTeamUp');
        $this->Acl->allow($group, 'controllers/Projects/searchTeamUps');
        $this->Acl->allow($group, 'controllers/Projects/invitationResponse');

        $this->Acl->allow($group, 'controllers/Users/dashboard');
        $this->Acl->allow($group, 'controllers/Users/changePassword');
        $this->Acl->allow($group, 'controllers/Users/checkLoggedIn');
        $this->Acl->allow($group, 'controllers/Users/logout');
        $this->Acl->allow($group, 'controllers/Users/register');
        $this->Acl->allow($group, 'controllers/Users/search');

        $this->Acl->allow($group, 'controllers/UsersFollowers/follow');

        $this->Acl->allow($group, 'controllers/Search/explore');

        $this->Acl->allow($group, 'controllers/Activities/getAll');

        $this->Acl->allow($group, 'controllers/Notifications/markAllRead');
        $this->Acl->allow($group, 'controllers/Notifications/deleteAll');

        $this->Acl->allow($group, 'controllers/Comments/commentOnPing');
        $this->Acl->allow($group, 'controllers/Comments/delete');

        $this->Session->setFlash('ACL initialised', 'Flashes/success');
        $this->redirect(array('controller' => 'Users', 'action' => 'dashboard', 'admin' => false));
        return true;
    }

}
