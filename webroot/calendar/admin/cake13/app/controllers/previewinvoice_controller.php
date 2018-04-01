<?php
class PreviewinvoiceController extends AppController{

	var $uses = array('Bookable','Vehicle','User', 'Event');
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
		App::import('Vendor','calendar/preview_invoice_form');
		App::import('Vendor','calendar/generate_invoices_inc');
		App::import('Vendor','calendar/generate_invoices_local_inc');
		App::import('Vendor','calendar/user_preview_invoice_rpt');
		
		if (isset($this->params['form'])){
			$vars = $this->params['form'];
		}
		
		$this->set('invoice_form',preview_invoice_form());
		
		$this->set('invoice_report',tag("div"));
		
		if (isset($this->params['form']['submit']) ){
			$this->set('invoice_report',user_preview_invoice_rpt());
		}
	}
  
}
?>