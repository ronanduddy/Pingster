<?php
App::uses('Community', 'Model');

/**
 * Community Test Case
 *
 */
class CommunityTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.community',
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
		'app.communities_project'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Community = ClassRegistry::init('Community');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Community);

		parent::tearDown();
	}

}
