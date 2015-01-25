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
//        'app.profile',
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
     * testIndex method
     *
     * @return void
     */
    public function testIndex() {
        $result = $this->testAction('/users/index');
        $expected = true;

        $this->assertEquals($expected, $result);

        //$this->markTestIncomplete('testIndex not implemented.');
    }

    /**
     * testView method
     *
     * @return void
     */
    public function testView() {
        $this->markTestIncomplete('testView not implemented.');
    }

    /**
     * testAdd method
     *
     * @return void
     */
    public function testAdd() {
        $this->markTestIncomplete('testAdd not implemented.');
    }

    /**
     * testEdit method
     *
     * @return void
     */
    public function testEdit() {
        $this->markTestIncomplete('testEdit not implemented.');
    }

    /**
     * testDelete method
     *
     * @return void
     */
    public function testDelete() {
        $this->markTestIncomplete('testDelete not implemented.');
    }

    /**
     * testSaveUser method
     *
     * @return void
     */
    public function testSaveUser() {
        $this->markTestIncomplete('testSaveUser not implemented.');
    }

    /**
     * testRegister method
     *
     * @return void
     */
    public function testRegister() {
        $this->markTestIncomplete('testRegister not implemented.');
    }

    /**
     * testLogin method
     *
     * @return void
     */
    public function testLogin() {
        $this->markTestIncomplete('testLogin not implemented.');
    }

    /**
     * testDashboard method
     *
     * @return void
     */
    public function testDashboard() {
        $this->markTestIncomplete('testDashboard not implemented.');
    }

    /**
     * testProfile method
     *
     * @return void
     */
    public function testProfile() {
        $this->markTestIncomplete('testProfile not implemented.');
    }

    /**
     * testEditProfile method
     *
     * @return void
     */
    public function testEditProfile() {
        $this->markTestIncomplete('testEditProfile not implemented.');
    }

    /**
     * testChangePassword method
     *
     * @return void
     */
    public function testChangePassword() {
        $this->markTestIncomplete('testChangePassword not implemented.');
    }

    /**
     * testCheckLoggedIn method
     *
     * @return void
     */
    public function testCheckLoggedIn() {
        $this->markTestIncomplete('testCheckLoggedIn not implemented.');
    }

    /**
     * testLogout method
     *
     * @return void
     */
    public function testLogout() {
        $this->markTestIncomplete('testLogout not implemented.');
    }

}
