<?php
App::uses('AppController', 'Controller');

require_once(APP . 'Vendor' . DS . 'adodb/adodb.inc.php');
		App::import('Vendor','adodb/adodbinc');
		App::import('Vendor','calendar/setup');
		App::import('Vendor','calendar/html');
		App::import('Vendor','calendar/url_match');
		App::import('Vendor','calendar/calendar');
		App::import('Vendor','calendar/car_month_usage_form');
		App::import('Vendor','calendar/car_month_usage_rpt');

class AdministerbookingsController extends AppController{

	public $uses = array('Bookable','Vehicle','User', 'Event');
	public $helpers = array('Html', 'Form' );

    function beforeFilter()
    {
        $this->checkSession();
    }
	
	function index() {
		global $vars;

		if (isset($this->request->data)){
			$vars = $this->request->data;
		}

		$this->set('usage_form',car_month_usage_form());
		$this->set('report_form',tag("div"));
		
		if (isset($this->request->data['Save']) || isset($this->request->data['submit']) ){
			$this->set('report_form',car_month_usage_rpt());
		}
	}
  
}
?>