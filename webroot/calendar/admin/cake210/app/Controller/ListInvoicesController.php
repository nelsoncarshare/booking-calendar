<?php
App::uses('AppController', 'Controller');
require_once(App::path('Vendor')[0] . 'adodb/adodb.inc.php');
		App::import('Vendor', 'calendar/setup');
		App::import('Vendor', 'calendar/html');
		App::import('Vendor', 'calendar/url_match');
		App::import('Vendor', 'calendar/calendar');
		App::import('Vendor', 'calendar/list_invoices_form');
		App::import('Vendor', 'calendar/list_user_invoices_rpt');
		
class ListinvoicesController extends AppController{

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
		$this->set('list_invoices_form',list_invoices_form());
		$this->set('list_invoice_report',tag("div"));
		if (isset($this->request->data['submit']) ){
			$this->set('list_invoice_report',list_user_invoices_rpt());
		}
	}
  
}
?>