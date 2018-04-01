<?php
class AdministerbookingsController extends AppController{

	var $uses = array('Bookable','Vehicle','User', 'Event');
	var $helpers = array('Html', 'Form' );

    function beforeFilter()
    {
        $this->checkSession();
    }
	
	function index() {
		global $vars;
		App::import('Vendor','adodb/adodbinc');
		App::import('Vendor','calendar/setup');
		App::import('Vendor','calendar/html');
		App::import('Vendor','calendar/url_match');
		App::import('Vendor','calendar/calendar');
		App::import('Vendor','calendar/car_month_usage_form');
		App::import('Vendor','calendar/car_month_usage_rpt');

		if (isset($this->params['form'])){
			$vars = $this->params['form'];
		}

		$this->set('usage_form',car_month_usage_form());
		$this->set('report_form',tag("div"));
		
		if (isset($this->params['form']['Save']) || isset($this->params['form']['submit']) ){
			$this->set('report_form',car_month_usage_rpt());
		}
	}
  
}
?>