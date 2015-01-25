<?php

/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
        'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'email_UNIQUE' => array('column' => 'email', 'unique' => 1),
            'username_UNIQUE' => array('column' => 'username', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );

    /**
     * Records
     *
     * @var array
     */
    public function init() {
        $this->records = array(
            array(
                'id' => '1',
                'email' => 'example1@email.com',
                'username' => 'example1',
                'password' => 'Lorem ipsum dolor sit amet',
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ),
            array(
                'id' => '2',
                'email' => 'example2@email.com',
                'username' => 'example2',
                'password' => 'Lorem ipsum dolor sit amet',
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ),
            array(
                'id' => '3',
                'email' => 'example3@email.com',
                'username' => 'example3',
                'password' => 'Lorem ipsum dolor sit amet',
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ),
        );
        parent::init();
    }

}
