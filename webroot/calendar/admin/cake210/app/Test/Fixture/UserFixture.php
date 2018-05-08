<?php
/**
 * User Fixture
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'displayname' => array('type' => 'string', 'null' => false, 'length' => 100, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'username' => array('type' => 'string', 'null' => false, 'length' => 100, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'accountingname' => array('type' => 'string', 'null' => false, 'length' => 41, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'string', 'null' => false, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'permission' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'key' => 'index', 'comment' => '0=normal, 1=admin'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'address1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'address2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'city' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'province' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'postalcode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'disabled' => array('type' => 'boolean', 'null' => true, 'default' => null, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'activated' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true, 'key' => 'index'),
		'lastNoticeSentOn' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'licenseExpiresOn' => array('type' => 'date', 'null' => false, 'default' => '2000-01-01'),
		'acnt_code_customer' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'displayname' => array('column' => 'displayname', 'unique' => 1),
			'username' => array('column' => 'username', 'unique' => 1),
			'group_id' => array('column' => 'group_id', 'unique' => 0),
			'permission' => array('column' => 'permission', 'unique' => 0),
			'disabled' => array('column' => 'disabled', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'displayname' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'accountingname' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'permission' => 1,
			'email' => 'Lorem ipsum dolor sit amet',
			'phone' => 'Lorem ipsum dolor sit amet',
			'address1' => 'Lorem ipsum dolor sit amet',
			'address2' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postalcode' => 'Lorem ipsum d',
			'disabled' => 1,
			'created' => '2018-04-30 18:18:57',
			'modified' => '2018-04-30 18:18:57',
			'activated' => '2018-04-30 18:18:57',
			'group_id' => 1,
			'lastNoticeSentOn' => '2018-04-30 18:18:57',
			'licenseExpiresOn' => '2018-04-30',
			'acnt_code_customer' => 1
		),
	);

}
