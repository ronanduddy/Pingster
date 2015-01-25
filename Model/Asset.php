<?php

App::uses('AppModel', 'Model');

/**
 * Asset Model
 *
 * @property Activity $Activity
 * @property Comment $Comment
 * @property User $User
 * @property Project $Project
 */
class Asset extends AppModel {
    
// for local uploads:
//    public $actsAs = array(
//        'Upload.Upload' => array(
//            'asset' => array(
//                'fields' => array(
//                    'dir' => 'asset_url'
//                ),
//                'mimetypes' => array('image/jpeg', 'image/png', 'image/gif', 'image/bmp'),
//                'extensions' => array('jpg', 'gif', 'png', 'bmp'),
//                'maxSize' => '5242880',
//                // i.e. pathMethod ID/nn/nn/nn
//                'pathMethod' => 'randomCombined',
//                // Eg. path /var/www/html/pingster/app/webroot/files/project/image/
//                'path' => '{ROOT}webroot{DS}files{DS}{model}{DS}{field}{DS}',
//                'deleteOnUpdate' => true,
//                'deleteFolderOnDelete' => true
//            ),
//        ),
//    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasOne associations
     *
     * @var array
     */
    public $hasOne = array(
        'Activity' => array(
            'className' => 'Activity',
            'foreignKey' => 'asset_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'asset_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

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
        )
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Project' => array(
            'className' => 'Project',
            'joinTable' => 'assets_projects',
            'foreignKey' => 'asset_id',
            'associationForeignKey' => 'project_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

}
