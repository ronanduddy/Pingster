<?php

App::uses('AppModel', 'Model');

class Activity extends AppModel {

    public $actsAs = array('Containable');

    public $name = 'Activity';
    public $belongsTo = array(
        'User',
        'Project' => array(
            'conditions' => array('Activity.model' => 'Project'),
            'foreignKey' => 'entity_id'
            ),
         'Comment'  => array(
            'conditions' => array('Activity.model' => 'Comment'),
            'foreignKey' => 'entity_id'
            ),);

    public function store($activity){

        //Check if it's already been stored recently
        $new_time = date_create($activity['time']);
        $new_time->modify('-15 second');

        if($this->find('count',
            array("conditions" =>
                array("time >" => $new_time->format('Y-m-d H:i:s'), "method" => $activity["method"], "entity_id" => $activity["entity_id"]
                )
            )) == 0
        )
        {
            $this->save($activity);
        };
    }

    public function get($user=null, $user_ids = array()){
        if($user){
        
            $sql = "

                SELECT Activity.id as activity_id, Activity.time as time, Activity.method as method, Project.id as id, Project.title as title, Project.kind as kind, Project.description as description,
                Project.image_url as image_url, Comment.id as id, Comment.comment as comment, User.id as id, User.username as username, User.email as email from activities Activity

                LEFT JOIN (SELECT Project.id as id, Project.kind as kind, Project.description as description, Project.image_url as image_url, Project.title as title
                from projects Project, projects_users ProjectsUser, users User
                where User.id = ProjectsUser.user_id and ProjectsUser.project_id = Project.id and (User.id = ". $user["id"] . " OR Project.status like 'public')) Project ON (Activity.entity_id = Project.id and Activity.model like 'Project')

                LEFT JOIN (SELECT Comment.id as id, Comment.comment as comment, Project.id as project_id
                from comments Comment, projects Project, projects_users ProjectsUser
                where Comment.project_id = Project.id and ProjectsUser.project_id = Project.id and (ProjectsUser.user_id = ". $user["id"] . " OR Project.status like 'public'))
                Comment ON (Activity.entity_id = Comment.id and Activity.model like 'Comment')

                LEFT JOIN users User on (User.id = Activity.user_id)

                WHERE (Comment.id is NOT NULL OR Project.id is NOT NULL) and (Activity.method like 'Update' OR Activity.method like 'Create')";


                if(!empty($user_ids)){
                    $sql .= "AND Activity.user_id in"  . implode(",",$user_ids);
                }

                $sql .= "ORDER BY TIME LIMIT 10";

                return $this->query($sql);
        }

    }
}
