<?php //debug($communities);  ?>
<div class="col-lg-6 col-lg-offset-3">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($this->params['action']))); ?></h3>
        </div>
        <div class="box-body">
            <?php
            // create form
            echo $this->Form->create('Project', array(
                'action' => 'editPing',
                'type' => 'file'
            ));

            // user.id required for model update (is hidden)
            //echo $this->Form->input('User.id');
            // Project.id required for model update (is hidden)
            echo $this->Form->input('Project.id');

            echo $this->Form->input('Project.kind', array('value' => 'ping', 'type' => 'hidden'));
            echo $this->Form->input('Project.title', array(
                'label' => 'Give your Ping a groovie name',
                'placeholder' => 'Bebop'
            ));
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
                        'maxlength' => '140',
                        'placeholder' => 'What\'s it all about?'
                    ));
                    ?>  
                </div>
            </div>
            <?php
            echo $this->Form->input('Project.status', array(
                'options' => array(
                    'private' => 'Private',
                    'public' => 'Public'
                ),
                'label' => 'Visibility',
            ));
            
            echo $this->Form->input('Project.community', array(
                'label' => 'Community',
                'type' => 'select',
                'options' => $communities,
                'empty'=> 'Choose a community',
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
            echo $this->Form->input('Project.image', array(
                'type' => 'file',
                'label' => 'Image',
                'class' => '',
                'required' => false,
                'label' => 'Upload a new pic',
            ));
            echo $this->Form->input('Project.image_url', array('type' => 'hidden'));
            ?>
        </div>
        <div class="box-footer" style="text-align: right">
            <div class="btn-group">
                <?php
                // submit
                echo $this->Form->submit('Edit Ping', array(
                    'class' => 'btn btn-primary',
                    'div' => false,
                ));
                echo $this->Html->link('Back', array('controller' => 'Projects', 'action' => 'viewPing', $this->params['pass'][0]), array('title' => 'Go back to the Ping page', 'class' => 'btn btn-default'));
                // end
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>

    <div class="alert alert-info alert-dismissable">
        <i class="fa fa-info"></i>
        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
        <b>Did you know</b>
        <p>
            To showcase your Ping, set it's visibility to public. That way it can be seen in the community by everyone.
        </p>
    </div>

</div>