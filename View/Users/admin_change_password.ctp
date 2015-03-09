<div class="col-lg-6 col-lg-offset-3">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($this->params['action']))); ?></h3>
        </div>
        <div class="box-body">
            <?php
            // create form
            echo $this->Form->create('User', array(
                'action' => 'changePassword',
            ));

            // user.id required for model update (is hidden)
            echo $this->Form->input('User.id');

            // for user model:
            // update password
            echo $this->Form->input('User.password_update', array(
                'label' => 'New Password',
                'maxLength' => 16,
                'type' => 'password',
                'required' => true,
            ));

            // for user model:
            // confirm update password
            echo $this->Form->input('User.password_confirm_update', array(
                'label' => 'Confirm New Password',
                'title' => 'Confirm New password',
                'type' => 'password',
                'required' => true,
            ));
            ?>
        </div>
        <div class="box-footer" style="text-align: right">
            <div class="btn-group">
                <?php
                // submit
                echo $this->Form->submit('Change password', array(
                    'class' => 'btn btn-primary btn-flat',
                    'div' => false,
                ));
                echo $this->Html->link('Back to users', array('controller' => 'Users', 'action' => 'index', 'admin' => true), array('title' => 'Back to users page', 'class' => 'btn btn-default btn-flat'));

                // end
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>
