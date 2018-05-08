<?php
/* Vehicles Test cases generated on: 2011-10-04 16:08:25 : 1317769705*/
App::import('Controller', 'Vehicles');

class TestVehiclesController extends VehiclesController {
	public $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class VehiclesControllerTestCase extends CakeTestCase {
	public $fixtures = array('app.vehicle', 'app.bookable');

	function startTest() {
		$this->Vehicles =& new TestVehiclesController();
		$this->Vehicles->constructClasses();
	}

	function endTest() {
		unset($this->Vehicles);
		ClassRegistry::flush();
	}

}
