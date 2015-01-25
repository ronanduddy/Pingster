<div class="col-lg-6 col-lg-offset-3">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($this->params['action']))); ?></h3>
        </div>
        <div class="box-body">
            <?php
            // create form to add ping
            echo $this->Form->create('Project', array(
                'action' => 'addPing',
                'type' => 'file'
            ));

//            echo $this->Form->input('Project.kind', array(
//                'options' => array(
//                    'ping' => 'Ping',
//                    'team_up' => 'Team Up'
//                ),
//                'label' => 'Project kind',
//            ));
            // for User model:
            // for hidden input to contain user.id for user-project join/link table
            echo $this->Form->input('User.id', array('value' => $user['id']));

            // for project model:            
            // hidden input to contain project type/kind
            echo $this->Form->input('Project.kind', array('value' => 'ping', 'type' => 'hidden'));

            // for project model:
            // title
            echo $this->Form->input('Project.title');
            ?>
            <div class="form-group required">
                <label class="control-label col-lg-4" for="ProjectDescription">Description</label>
                <div class="col-lg-8">
                    <?php
                    // for Project model:
                    // description 
                    echo $this->Form->textarea('Project.description', array(
                        'class' => 'form-control',
                        'style' => 'resize: vertical;',
                        'rows' => '5',
                        'maxlength' => '140'
                    ));
                    ?>  
                </div>
            </div>
            <?php
            // for Project model:
            // status
            echo $this->Form->input('Project.status', array(
                'options' => array(
                    'private' => 'Private',
                    'public' => 'Public'
                ),
                'label' => 'Project status',
            ));

//            echo $this->Form->input('Tag.tag_content', array(
//                'label' => 'Tag',
//            ));
//        echo $this->Form->input('Asset');
//
//        echo $this->Form->input('ProjectsUser.user_role', array(
//            'options' => array(
//                'owner' => 'Owner',
//                'moderator' => 'Moderator',
//                'collaborator' => 'Collaborator',
//                'mentor' => 'Mentor',
//            ),
//            'label' => 'Role w/project',
//        ));
            // for Project model:
            // image
            echo $this->Form->input('Project.image', array(
                'type' => 'file',
                'label' => 'Image',
                'class' => '',
                'required' => true,
            ));

            // for Project model:
            // image_url
            echo $this->Form->input('Project.image_url', array('type' => 'hidden', 'required' => true,));
            ?>
        </div>
        
        <div class="box-footer" style="text-align: right">
            <div class="btn-group">
                <?php
                // submit
                echo $this->Form->submit('Create Ping', array(
                    'class' => 'btn btn-primary',
                    'div' => false,
                ));
                echo $this->Html->link('Back', array('controller' => 'Projects', 'action' => 'myPings'), array('title' => 'Go back to the Ping page', 'class' => 'btn btn-default'));

                // end
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>