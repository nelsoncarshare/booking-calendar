<?php
/* Vehicle Test cases generated on: 2011-10-04 16:08:03 : 1317769683*/
App::import('Model', 'Vehicle');

class VehicleTestCase extends CakeTestCase {
	var $fixtures = array('app.vehicle', 'app.bookable');

	function startTest() {
		$this->Vehicle =& ClassRegistry::init('Vehicle');
	}

	function endTest() {
		unset($this->Vehicle);
		ClassRegistry::flush();
	}

}
