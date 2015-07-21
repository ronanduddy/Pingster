<?php

App::uses('AclComponent', 'Controller/Component');
App::uses('ComponentCollection', 'Controller');

/**
 * Set up a default admin user and the permissions for
 * the groups that must be available at start-up
 */
class UserSeeder
{
  /**
   * Initial password for the administrative user
   *
   * @access private
   * @var string
   */
  private $initialAdminPassword;

  /**
   * ACL object for assigning permissions
   *
   * @access private
   * @var Acl
   */
  private $Acl;

  /**
   * User model
   *
   * @access private
   * @var User
   */
  private $User;

  /**
   * group model
   *
   * @access private
   * @var group
   */
  private $group;

  /**
   * Seed shall
   *
   * @access private
   * @var BasicSeedShell
   */
  private $SeedShell;

  /**
   * Constructor
   */
  public function __construct($SeedShell)
  {
    /* For mollifying fractious Components expecting a Controller present... */
    $ComponentCollection = new ComponentCollection;

    $this->initialAdminPassword = getenv('PINGSTER_INITIAL_ADMIN_PASSWORD');

    if ($this->initialAdminPassword === false)
      throw new Exception("Initial admin password should be available in env PINGSTER_INITIAL_ADMIN_PASSWORD");

    $this->User = ClassRegistry::init('User');
    $this->Group = ClassRegistry::init('Group');
    $this->Acl = new AclComponent($ComponentCollection);
    $this->SeedShell = $SeedShell;
  }

  /**
   * Execute the seeder
   */
  public function run()
  {
    $this->init_admins();
    $this->init_pingsters();
  }

  /**
   * Initialize the admin group and user, and set access
   */
  private function init_admins()
  {
    $groupRecord = $this->SeedShell->firstOrCreate(
      $this->Group,
      array(
        'name' => 'admins'
      )
    );

    $group = $this->Group->findByName('admins', array('fields' => 'Group.id'));

    $adminUser = $this->SeedShell->firstOrCreate(
      $this->User,
      array(
        'username' => 'administrator'
      ),
      array(
        'password' => $this->initialAdminPassword,
        'email' => 'info@example.net',
        'age' => '29',
        'group_id' => intval($group['Group']['id'])
      )
    );

    // allow admins to everything
    $this->Acl->allow($group, 'controllers');
  }

  /**
   * Initialize the pingsters group and set access
   */
  private function init_pingsters() {
    $groupRecord = $this->SeedShell->firstOrCreate(
      $this->Group,
      array(
        'name' => 'pingsters'
      )
    );

    $group = $this->Group->findByName('pingsters', array('fields' => 'Group.id'));

    // allow pingsters to:
    $this->Acl->deny($group, 'controllers');

    $this->Acl->allow($group, 'controllers/Communities/index');
    $this->Acl->allow($group, 'controllers/Communities/view');

    $this->Acl->allow($group, 'controllers/Projects/viewPing');
    $this->Acl->allow($group, 'controllers/Projects/myPings');
    $this->Acl->allow($group, 'controllers/Projects/addPing');
    $this->Acl->allow($group, 'controllers/Projects/editPing');
    $this->Acl->allow($group, 'controllers/Projects/searchPings');
    $this->Acl->allow($group, 'controllers/Projects/delete');
    $this->Acl->allow($group, 'controllers/Projects/community');
    $this->Acl->allow($group, 'controllers/Projects/viewTeamUp');
    $this->Acl->allow($group, 'controllers/Projects/myTeamUps');
    $this->Acl->allow($group, 'controllers/Projects/addTeamUp');
    $this->Acl->allow($group, 'controllers/Projects/editTeamUp');
    $this->Acl->allow($group, 'controllers/Projects/searchTeamUps');
    $this->Acl->allow($group, 'controllers/Projects/invitationResponse');

    $this->Acl->allow($group, 'controllers/Users/dashboard');
    $this->Acl->allow($group, 'controllers/Users/changePassword');
    $this->Acl->allow($group, 'controllers/Users/checkLoggedIn');
    $this->Acl->allow($group, 'controllers/Users/logout');
    $this->Acl->allow($group, 'controllers/Users/register');
    $this->Acl->allow($group, 'controllers/Users/search');

    $this->Acl->allow($group, 'controllers/Search/explore');

    $this->Acl->allow($group, 'controllers/Notifications/markAllRead');
    $this->Acl->allow($group, 'controllers/Notifications/deleteAll');

    $this->Acl->allow($group, 'controllers/Comments/commentOnPing');
    $this->Acl->allow($group, 'controllers/Comments/delete');
  }
}
