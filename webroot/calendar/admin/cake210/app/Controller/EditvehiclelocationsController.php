<?php
App::uses('AppController', 'Controller');

require_once(APP . 'Vendor' . DS . 'adodb/adodb.inc.php');
		App::import('Vendor','adodb/adodbinc');
		App::import('Vendor','calendar/setup');
		App::import('Vendor','calendar/html');
		App::import('Vendor','calendar/url_match');
		App::import('Vendor','calendar/calendar');
		//App::import('Vendor','calendar/edit_vehicle_locations');

class EditvehiclelocationsController extends AppController{

	public $uses = array();
	public $helpers = array('Html', 'Form' );

	function beforeFilter(){
        $this->checkSession();	
	}
	
	function index() {
		global $vars;
		
		if (isset($this->request->data)){
			$vars = $this->request->data;
		}
		//print_r($this);
		//$this->set('edit_locations',edit_vehicle_locations($this->html));
		
		//$this->set('invoice_report',tag("div"));
		
		//if (isset($this->request->data['submit']) ){
		//	$this->set('invoice_report',user_preview_invoice_rpt());
		//}
	}
  
}
?>