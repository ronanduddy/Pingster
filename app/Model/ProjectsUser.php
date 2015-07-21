<?php

App::uses('AppModel', 'Model');

/**
 * ProjectsUser Model
 *
 * @property User $User
 * @property Project $Project
 */
class ProjectsUser extends AppModel {
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'project_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Retrieve representations of user role enum
     *
     * @param int
     * @retval string
     */
    public static function user_roles($value = null) {
        $user_roles = array(
            self::USER_ROLE_INVALID => __("[invalid role]"),
            self::USER_ROLE_OWNER => __("Owner"),
            self::USER_ROLE_MODERATOR => __("Moderator"),
            self::USER_ROLE_COLLABORATOR => __("Collaborator"),
            self::USER_ROLE_MENTOR => __("Mentor"),
            self::USER_ROLE_GUEST => __("Guest"),
        );

        return self::enum($user_roles, $value, self::USER_ROLE_INVALID);
    }

    const USER_ROLE_INVALID = 0;
    const USER_ROLE_OWNER = 1;
    const USER_ROLE_MODERATOR = 2;
    const USER_ROLE_COLLABORATOR = 3;
    const USER_ROLE_MENTOR = 4;
    const USER_ROLE_GUEST = 5;

}
