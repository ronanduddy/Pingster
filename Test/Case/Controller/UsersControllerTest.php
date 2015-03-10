<?php
App::uses('UsersController', 'Controller');

/**
 * UsersController Test Case
 *
 */
class UsersControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user',
		'app.group',
		'app.activity',
		'app.asset',
		'app.comment',
		'app.project',
		'app.todo',
		'app.projects_user',
		'app.communities_project',
		'app.community',
		'app.assets_project',
		'app.tag',
		'app.projects_tag',
		'app.users_user'
	);

/**
 * testAdminGetDatagridData method
 *
 * @return void
 */
	public function testAdminGetDatagridData() {
		$this->markTestIncomplete('testAdminGetDatagridData not implemented.');
	}

/**
 * testAdminIndex method
 *
 * @return void
 */
	public function testAdminIndex() {
		$this->markTestIncomplete('testAdminIndex not implemented.');
	}

/**
 * testAdminAdd method
 *
 * @return void
 */
	public function testAdminAdd() {
		$this->markTestIncomplete('testAdminAdd not implemented.');
	}

/**
 * testAdminEdit method
 *
 * @return void
 */
	public function testAdminEdit() {
		$this->markTestIncomplete('testAdminEdit not implemented.');
	}

/**
 * testAdminDelete method
 *
 * @return void
 */
	public function testAdminDelete() {
		$this->markTestIncomplete('testAdminDelete not implemented.');
	}

}
