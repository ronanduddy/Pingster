<?php

App::uses('User', 'Model');

/**
 * User Test Case
 *
 */
class UserTest extends CakeTestCase {

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.user',
//      'app.profile',
//		'app.activity',
//		'app.asset',
//		'app.comment',
//		'app.project',
//		'app.todo',
//		'app.assets_project',
//		'app.projects_user',
//		'app.tag',
//		'app.projects_tag',
//		'app.users_user'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->User = ClassRegistry::init('User');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->User);

        parent::tearDown();
    }

    /**
     * testIsUniqueUsername method
     *
     * @return void
     */
    public function testIsUniqueUsername() {
        $check = array('username' => 'example1');
        $result = $this->User->isUniqueUsername($check);
        $expected = true;

        $this->assertEquals($expected, $result);
        //$this->markTestIncomplete('testIsUniqueUsername not implemented.');
    }

    /**
     * testIsUniqueEmail method
     *
     * @return void
     */
    public function testIsUniqueEmail() {
        $this->markTestIncomplete('testIsUniqueEmail not implemented.');
    }

    /**
     * testAlphaNumericDashUnderscore method
     *
     * @return void
     */
    public function testAlphaNumericDashUnderscore() {
        $this->markTestIncomplete('testAlphaNumericDashUnderscore not implemented.');
    }

    /**
     * testEqualtofield method
     *
     * @return void
     */
    public function testEqualtofield() {
        $this->markTestIncomplete('testEqualtofield not implemented.');
    }

}
