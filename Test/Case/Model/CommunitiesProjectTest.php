<?php
App::uses('CommunitiesProject', 'Model');

/**
 * CommunitiesProject Test Case
 *
 */
class CommunitiesProjectTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.communities_project',
		'app.project',
		'app.activity',
		'app.comment',
		'app.user',
		'app.group',
		'app.asset',
		'app.assets_project',
		'app.todo',
		'app.projects_user',
		'app.users_user',
		'app.tag',
		'app.projects_tag',
		'app.community'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CommunitiesProject = ClassRegistry::init('CommunitiesProject');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CommunitiesProject);

		parent::tearDown();
	}

}
