<?php

App::uses('AppModel', 'Model');

/**
 * Comment Model
 *
 * @property User $User
 * @property Project $Project
 */
class Comment extends AppModel {

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
        'comment' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Must not be empty',
            ),
        ),
    );
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
        ),
        'Asset' => array(
            'className' => 'Asset',
            'foreignKey' => 'asset_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
