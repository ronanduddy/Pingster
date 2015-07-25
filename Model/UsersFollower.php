<?php

App::uses('AppModel', 'Model');

/**
 * UsersUser Model
 *
 * @property User $User
 * @property Friend $Friend
 */
class UsersFollower extends AppModel {

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
            'foreignKey' => 'follower_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );

    public function follow($follower_id, $user_id){

        $existingRow = $this->find('first', array("conditions" => array("follower_id" => $follower_id, "user_id" => $user_id), "recursive" => -1 ));

        if($existingRow){
            $this->delete($existingRow['UsersFollower']['id']);
            return 1;
        }
        else{
            if($this->save(array("UsersFollower" => array("follower_id" => $follower_id, "user_id" => $user_id) ))){
                return 2;
            };
        }
    }

    public function getFollowers($user_id){

        return $this->find('list', array("conditions" => array("follower_id" => $user_id), "fields" => array("UsersFollower.user_id")));
    }
}
