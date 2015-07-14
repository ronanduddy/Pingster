<?php
App::uses('Security', 'Utility', 'UsersController', 'Controller');

$User = ClassRegister::init('User');
$Group = ClassRegister::init('Group');
//FIXME: would be much better not using the controller
$UserController = ClassRegister::init('UserController');

/* Group */

$adminsGroup = $this->firstOrCreate(
  $Group,
  array(
    'name' => 'admins'
  )
);

$this->firstOrCreate(
  $Group,
  array(
    'name' => 'pingsters'
  )
);

/* User */

$adminUser = $this->firstOrCreate(
  $User,
  array(
    'username' => 'admin'
  ),
  array(
    'email' => 'info@example.net',
    'age' => '29',
    'group_id' => $adminsGroup->id
  )
);

$UserController->User = $User;
$UserController->admin_ACLinit();
