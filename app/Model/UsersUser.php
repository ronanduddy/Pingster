<?php

App::uses('AppModel', 'Model');

/**
 * UsersUser Model
 *
 * @property User $User
 * @property Friend $Friend
 */
class UsersUser extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'id';


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
        'Friend' => array(
            'className' => 'User',
            'foreignKey' => 'friend_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );

    /**
     * Retrieve representations of status enum (public/private)
     *
     * @param int
     * @retval string
     */
    public static function statuses($value = null) {
        $statuses = array(
            self::STATUS_INVALID => __("[invalid status]"),
            self::STATUS_PENDING => __("Pending"),
            self::STATUS_APPROVED => __("Approved")
        );

        return self::enum($statuses, $value, self::STATUS_INVALID);
    }

    const STATUS_INVALID = 0;
    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;

}
