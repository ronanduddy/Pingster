<style>
    form .required label:after {
        color: #e32;
        content: '*';
        display:inline;
    }
</style>

<?php
// create form
echo $this->Form->create('User', array(
    'action' => 'login',
));

// username 
echo $this->Form->input('username', array(
    'placeholder' => 'Your username',
));

// password
echo $this->Form->input('password', array(
    'placeholder' => 'Your password',
));

// submit
echo $this->Form->submit('Sign me in', array(
    'class' => 'btn btn-lg btn-primary btn-block'
));

// end
echo $this->Form->end();
?>

<?php echo $this->Html->link('Register a new membership', array('controller' => 'Users', 'action' => 'register'), array('title' => 'Register!')); ?>
