<?php
class EditvehiclelocationsController extends AppController{

	var $uses = array();
	var $helpers = array('Html', 'Form' );

	function beforeFilter(){
        $this->checkSession();	
	}
	
	function index() {
		global $vars;
		App::import('Vendor','adodb/adodbinc');
		App::import('Vendor','calendar/setup');
		App::import('Vendor','calendar/html');
		App::import('Vendor','calendar/url_match');
		App::import('Vendor','calendar/calendar');
		//App::import('Vendor','calendar/edit_vehicle_locations');
		
		if (isset($this->params['form'])){
			$vars = $this->params['form'];
		}
		//print_r($this);
		//$this->set('edit_locations',edit_vehicle_locations($this->html));
		
		//$this->set('invoice_report',tag("div"));
		
		//if (isset($this->params['form']['submit']) ){
		//	$this->set('invoice_report',user_preview_invoice_rpt());
		//}
	}
  
}
?>