<?php
App::uses('UsersController', 'Controller');

/**
 * UsersController Test Case
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
		'app.grouptype',
		'app.invoicable',
		'app.permission',
		'app.invoiceextraitem',
		'app.billing',
		'app.users_permission'
	);

}
