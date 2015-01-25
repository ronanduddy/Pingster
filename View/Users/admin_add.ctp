<?php

echo $this->element('Admin/head', array(
    'adminTitle' => 'Add User',
    'icon' => 'fa-users',
));

// create form
echo $this->Form->create('User', array(
    'action' => 'add', array('admin' => true)
));

// for users model:
// email 
echo $this->Form->input('User.email', array(
    'placeholder' => 'Email',
));

// for User model:
// age
echo $this->Form->input('User.age', array(
    'placeholder' => 'Age',
));

// for user model:
// username 
echo $this->Form->input('User.username', array(
    'placeholder' => 'Username',
));

// for user model:
// user group_id 
echo $this->Form->input('User.group_id');

// for user model:
// password
echo $this->Form->input('User.password', array(
    'placeholder' => 'Password',
    'type' => 'password',
));

// for user model:
// confirm password
echo $this->Form->input('User.password_confirm', array(
    'placeholder' => 'Confirm password',
    'title' => 'Confirm password',
    'type' => 'password',
    'label' => 'Confirm password',
));


echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Users', array('controller' => 'Users', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->submit('Add User', array(
            'class' => 'btn btn-primary btn-flat',
            'div' => false,
        )),
        $this->Form->end()
    )
));
?>