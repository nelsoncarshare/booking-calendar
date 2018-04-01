<?php
class ListInvoicesController extends AppController{

	var $uses = array();
	var $helpers = array('Html', 'Form' );

	function beforeFilter(){
        $this->checkSession();	
	}
	
	function index() {
		global $vars;
		App::import('Vendor', 'adodb/adodbinc');
		App::import('Vendor', 'calendar/setup');
		App::import('Vendor', 'calendar/html');
		App::import('Vendor', 'calendar/url_match');
		App::import('Vendor', 'calendar/calendar');
		App::import('Vendor', 'calendar/list_invoices_form');
		App::import('Vendor', 'calendar/list_user_invoices_rpt');
		
		if (isset($this->params['form'])){
			$vars = $this->params['form'];
		}
		//print_r($this);
		$this->set('list_invoices_form',list_invoices_form());
		$this->set('list_invoice_report',tag("div"));
		if (isset($this->params['form']['submit']) ){
			$this->set('list_invoice_report',list_user_invoices_rpt());
		}
	}
  
}
?>