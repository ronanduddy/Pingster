<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

/**
 * User Model
 *
 * @property Profile $Profile
 * @property Activity $Activity
 * @property Asset $Asset
 * @property Comment $Comment
 * @property Todo $Todo
 * @property Project $Project
 * @property User $User
 */
class User extends AppModel {
//    public function beforeValidate($options = array()) {
//        debug($this->data);
//        exit();
//    }

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'id';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        // email
        'email' => array(
            'isNotEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Email cannot be empty',
            ),
            'isEmail' => array(
                'rule' => array('email'),
                'message' => 'Please provide a valid email address',
            ),
            'isBetween' => array(
                'rule' => array('between', 6, 64),
                'message' => 'Usernames can be between 6 to 64 characters long'
            )
        ),
        // username
        'username' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Username cannot be empty',
            ),
            'between' => array(
                'rule' => array('between', 6, 16),
                'message' => 'Username can be between 6 to 16 characters'
            ),
            'isUnique' => array(
                'rule' => array('isUniqueUsername'),
                'message' => 'Your username must be between unique',
            )
        ),
        // password
        'password' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required',
            ),
            'isBetween' => array(
                'rule' => array('between', 6, 16),
                'message' => 'Password must be between 6 to 16 characters long'
            ),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
                'message' => 'Password can have letters and numbers'
            )
        ),
        // password confirm
        'password_confirm' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please confirm your password'
            ),
            'equaltofield' => array(
                'rule' => array('equaltofield', 'password'),
                'message' => 'Both passwords must match.'
            )
        ),
        // role
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array(
                        'admin' => 'Admin',
                        'mentor' => 'Mentor',
                        'parent' => 'Parent',
                        'pingster' => 'Pingster')
                ),
            )
        ),
        // age
        'age' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'You must enter your age',
            ),
            'isNum' => array(
                'rule' => 'naturalNumber',
                'message' => 'Please enter your correct age',
            ),
            'inRange' => array(
                'rule' => array('range', 6, 100),
                'message' => 'You cannot use Pingster if you are younger than 7'
            )
        ),
        // password update
        'password_update' => array(
            'isBetween' => array(
                'rule' => array('between', 6, 16),
                'message' => 'Password must be between 6 to 16 characters long'
            ),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
                'message' => 'Password can have letters and numbers'
            )
        ),
        // password update confirm
        'password_confirm_update' => array(
            'equaltofield' => array(
                'rule' => array('equaltofield', 'password_update'),
                'message' => 'Your passwords don\'t match',
            )
        ),
        'group_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
    );

    ///////////////////////////////////////////////////////////////////////////////////
    // custom rules from 
    // http://miftyisbored.com/a-complete-login-and-authentication-application-tutorial-for-cakephp-2-3/
    ///////////////////////////////////////////////////////////////////////////////////

    function isUniqueUsername($check) {

        $username = $this->find('first', array(
            'fields' => array('User.id', 'User.username'),
            'conditions' => array('User.username' => $check['username'])
        ));

        if (!empty($username)) {
            if ($this->id == $username['User']['id']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function isUniqueEmail($check) {

        $email = $this->find('first', array(
            'fields' => array('User.id'),
            'conditions' => array('User.email' => $check['email'])
        ));

        if (!empty($email)) {
            if ($this->id == $email['User']['id']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];

        return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
    }

    public function equaltofield($check, $otherfield) {
        //get name of field
        $fname = '';
        foreach ($check as $key => $value) {
            $fname = $key;
            break;
        }
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname];
    }

    ///////////////////////////////////////////////////////////////////////////////////
    // callbacks
    ///////////////////////////////////////////////////////////////////////////////////
    // This callback is executed before the model validation
    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        // trim white space        
        foreach ($this->data as $table_key => $table_value) {
            foreach ($table_value as $key => $value) {
                if ($key == 'username' || $key == 'first_name' || $key == 'last_name') {
                    $this->data[$table_key][$key] = trim($value);
                }
            }
        }
    }

    // This callback is executed before the model save
    public function beforeSave($options = array()) {

//        if (isset($this->data[$this->alias]['password'])) {
//            $passwordHasher = new SimplePasswordHasher();
//            $this->data[$this->alias]['password'] = $passwordHasher->hash(
//                    $this->data[$this->alias]['password']
//            );
//        }
//        return true;
        // hash our password
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                    $this->data[$this->alias]['password']
            );
        }

        // for password update
        if (isset($this->data[$this->alias]['password_update']) && !empty($this->data[$this->alias]['password_update'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                    $this->data[$this->alias]['password_update']
            );
        }


        // fallback to our parent
        return parent::beforeSave($options);
    }

    ///////////////////////////////////////////////////////////////////////////////////
    //The Associations below have been created with all possible keys, 
    //those that are not needed can be removed
    ///////////////////////////////////////////////////////////////////////////////////

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Activity' => array(
            'className' => 'Activity',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Assets' => array(
            'className' => 'Asset',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Todo' => array(
            'className' => 'Todo',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'ProjectsUser'
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Project' => array(
            'className' => 'Project',
            'joinTable' => 'projects_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'project_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Friend' => array(
            'className' => 'User',
            'joinTable' => 'users_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'friend_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'with' => 'UsersUser'
        )
    );
    public $belongsTo = array(
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }

}
