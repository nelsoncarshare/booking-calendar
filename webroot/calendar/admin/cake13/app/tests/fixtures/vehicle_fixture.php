<?php
/* Vehicle Fixture generated on: 2011-10-04 16:08:03 : 1317769683 */
class VehicleFixture extends CakeTestFixture {
	var $name = 'Vehicle';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => 'NULL'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'key' => 'index', 'collate' => 'latin1_swedish_ci'),
		'vehicle_number' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci'),
		'vehicle_type' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'collate' => 'NULL'),
		'acnt_code_gas' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'acnt_code_admin' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'acnt_code_repair' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'acnt_code_insurance' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'acnt_code_misc_1' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'acnt_code_misc_2' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'acnt_code_misc_3' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'acnt_code_misc_4' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'acnt_code_hours' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'acnt_code_blocked_time' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'acnt_code_km' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'collate' => 'NULL'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'collate' => 'NULL'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'id' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => 'name', 'unique' => 1), 'id_2' => array('column' => 'id', 'unique' => 0)),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'vehicle_number' => 'Lorem ipsum dolor sit amet',
			'vehicle_type' => 1,
			'acnt_code_gas' => 'Lorem ipsum dolor sit amet',
			'acnt_code_admin' => 'Lorem ipsum dolor sit amet',
			'acnt_code_repair' => 'Lorem ipsum dolor sit amet',
			'acnt_code_insurance' => 'Lorem ipsum dolor sit amet',
			'acnt_code_misc_1' => 'Lorem ipsum dolor sit amet',
			'acnt_code_misc_2' => 'Lorem ipsum dolor sit amet',
			'acnt_code_misc_3' => 'Lorem ipsum dolor sit amet',
			'acnt_code_misc_4' => 'Lorem ipsum dolor sit amet',
			'acnt_code_hours' => 'Lorem ipsum dolor sit amet',
			'acnt_code_blocked_time' => 'Lorem ipsum dolor sit amet',
			'acnt_code_km' => 'Lorem ipsum dolor sit amet',
			'modified' => '2011-10-04 16:08:03',
			'created' => '2011-10-04 16:08:03'
		),
	);
}
