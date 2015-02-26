<?php

echo $this->element('Admin/head', array(
    'adminTitle' => 'Edit User',
    'icon' => 'fa-users',
));

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
echo $this->Form->input('User.group_id', array(
    'label' => 'You are a member of',
));

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
// for user model:
// update password
// submit

echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Users', array('controller' => 'Users', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->submit('Edit Profile', array(
            'class' => 'btn btn-primary btn-flat',
            'div' => false,
        )),
        $this->Form->end(),
    )
));