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

}
