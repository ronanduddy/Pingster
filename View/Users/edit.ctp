<div class="col-lg-6 col-lg-offset-3">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($this->params['action']))); ?></h3>
        </div>
        <div class="box-body">
            <?php
            // create form
            echo $this->Form->create('User', array(
                'action' => 'edit',
                'type' => 'file'
            ));

            // user.id required for model update (is hidden)
            echo $this->Form->input('User.id');

            // for user model:
            // email 
            echo $this->Form->input('User.email', array(
                'placeholder' => 'Your email',
            ));

            // for User model:
            // age
            echo $this->Form->input('User.age', array(
                'placeholder' => 'Your age'
            ));

            // for user model:
            // username 
            echo $this->Form->input('User.username', array(
                'label' => 'Username'
            ));
            
            // for user model:
            // user group
            // don't want pingsters to change groups
            if($current_user['Group']['id'] == 1) {
                echo $this->Form->input('User.group_id', array(
                    'label' => 'You are a member of',
                ));
            }

            // for user model:
            // school 
            echo $this->Form->input('User.school', array(
                'label' => 'What dojo do you attend?',
            ));

            // for User model:
            // image_url
//            echo $this->Form->input('Profile.avatar', array(
//                'type' => 'file',
//                'label' => 'Profile Pic',
//                'class' => ''
//            ));
//            echo $this->Form->input('User.avatar_dir', array('type' => 'hidden'));
            ?>
        </div>
        <div class="box-footer" style="text-align: right">
            <p class="pull-left">
                <?php
                echo $this->Html->link('I want to change my password instead', array('controller' => 'Users', 'action' => 'changePassword', $current_user['id']), array('title' => 'Click to change your password'));
                ?> 
            </p>
            <div class="btn-group" >
                <?php
                // submit
                echo $this->Form->submit('Update profile', array(
                    'class' => 'btn btn-primary',
                    'div' => false,
                ));
                echo $this->Html->link('I don\'t want to change my details', array('controller' => 'Users', 'action' => 'view', $current_user['id']), array('title' => 'Back to your profile page', 'class' => 'btn btn-default'));

                // end
                echo $this->Form->end();
                ?>

            </div>
        </div>
    </div>
</div>