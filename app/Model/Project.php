<?php

App::uses('AppModel', 'Model');

/**
 * Project Model
 *
 * @property Activity $Activity
 * @property Comment $Comment
 * @property Tag $Tag
 * @property Todo $Todo
 * @property Asset $Asset
 * @property User $User
 */
class Project extends AppModel {
// for local uploads:
//    public $actsAs = array(
//        'Upload.Upload' => array(
//            'image' => array(
//                'fields' => array(
//                    'dir' => 'image_url'
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

    /**
     * Retrieve representations of status enum (public/private)
     *
     * @param int
     * @retval string
     */
    public static function statuses($value = null) {
        $statuses = array(
            self::STATUS_INVALID => __("[invalid status]"),
            self::STATUS_PUBLIC => __("Public"),
            self::STATUS_PRIVATE => __("Private")
        );

        return self::enum($statuses, $value, self::STATUS_INVALID);
    }

    const STATUS_INVALID = 0;
    const STATUS_PUBLIC = 1;
    const STATUS_PRIVATE = 2;

    /**
     * Retrieve representations of kind enum
     *
     * @param int
     * @retval string
     */
    public static function kinds($value = null) {
        $kinds = array(
            self::KIND_INVALID => __("[invalid kind]"),
            self::KIND_PING => __("Ping"),
            self::KIND_TEAM_UP => __("Team Up")
        );

        return self::enum($kinds, $value, self::KIND_INVALID);
    }

    const KIND_INVALID = 0;
    const KIND_PING = 1;
    const KIND_TEAM_UP = 2;

    /**
     * Display field 
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
// for local uploads:        
        // image
//        'image' => array(
//            'isValidMimeType' => array(
//                'rule' => array('isValidMimeType', array('image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/bmp'), false),
//                'message' => 'File is not a png, jpeg, gif or bmp file type'
//            ),
//            'isBelowMaxSize' => array(
//                'rule' => array('isBelowMaxSize', 5242880, false),
//                'message' => 'File is larger than the maximum filesize (5MB)'
//            ),
//            'isBelowMaxSize' => array(
//                'rule' => array('isValidExtension', array('png', 'jpeg', 'jpg', 'bmp'), false),
//                'message' => 'File does not have a png, jpeg, jpg or bmp extension'
//            ),
//        ),
        // title
        'title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Your project needs a title',
            ),
        ),
        // description
        'description' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Your project needs a description',
            ),
        ),
        // kind
        'kind' => array(
            'valid' => array(
                'rule' => array('range', array(1, 2)),
                'message' => 'Project must be a Ping or Team Up',
            )
        ),
        // status
        'status' => array(
            'valid' => array(
                'rule' => array('range', array(1, 2)),
                'message' => 'Status must be either public or private',
            )
        ),
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Activity' => array(
            'className' => 'Activity',
            'foreignKey' => 'entity_id',
            'dependent' => false,
            'conditions' => array("Activity.model" => "Project"),
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
            'foreignKey' => 'project_id',
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
            'foreignKey' => 'project_id',
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
        'ProjectsUser' => array(
            'className' => 'ProjectsUser',
            'foreignKey' => 'project_id'
        ),
        'CommunitiesProject',
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Asset' => array(
            'className' => 'Asset',
            'joinTable' => 'assets_projects',
            'foreignKey' => 'project_id',
            'associationForeignKey' => 'asset_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'User' => array(
            'className' => 'User',
            'joinTable' => 'projects_users',
            'foreignKey' => 'project_id',
            'associationForeignKey' => 'user_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Tag' => array(
            'className' => 'Tag',
            'joinTable' => 'projects_tags',
            'foreignKey' => 'project_id',
            'associationForeignKey' => 'tag_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Community' => array(
            'className' => 'Community',
            'joinTable' => 'communities_projects',
            'foreignKey' => 'project_id',
            'associationForeignKey' => 'community_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    public function getViews($id=null){

        $id = $id == null ? $this->id : $id;
        return $this->Activity->find('count', array(
            'conditions' => array('Activity.entity_id' => $id,
                'Activity.method' => 'View',
                'Activity.model' => 'Project')
        ));
    }

}
