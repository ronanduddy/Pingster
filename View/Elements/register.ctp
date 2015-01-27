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
    'action' => 'register',
));

// for users model:
// email 
echo $this->Form->input('User.email', array(
    'placeholder' => 'Your email',
));

// for User model:
// age
echo $this->Form->input('User.age', array(
    'placeholder' => 'Your age',
));

// for user model:
// username 
echo $this->Form->input('User.username', array(
    'placeholder' => 'Your username',
));

// for user model:
// user group_id 
echo $this->Form->input('User.group_id');

// for user model:
// password
echo $this->Form->input('User.password', array(
    'placeholder' => 'Your password',
    'type' => 'password',
));

// for user model:
// confirm password
echo $this->Form->input('User.password_confirm', array(
    'placeholder' => 'Confirm your password',
    'title' => 'Confirm password',
    'type' => 'password',
    'label' => 'Confirm password',
));

// submit
echo $this->Form->submit('Sign me up!', array(
    'class' => 'btn btn-lg btn-primary btn-block'
));

// end
echo $this->Form->end();

echo $this->Html->link('Already a member?', array('controller' => 'Users', 'action' => 'login'), array('title' => 'Login!'));