<?php
App::uses('AppController', 'Controller');

		require_once(App::path('Vendor')[0] . 'adodb/adodb.inc.php');
		App::import('Vendor','calendar/setup');
		App::import('Vendor','calendar/html');
		App::import('Vendor','calendar/url_match');
		App::import('Vendor','calendar/calendar');
		App::import('Vendor','calendar/preview_invoice_form');
		App::import('Vendor','calendar/generate_invoices_inc');
		App::import('Vendor','calendar/generate_invoices_local_inc');
		App::import('Vendor','calendar/user_preview_invoice_rpt');
		
class PreviewinvoiceController extends AppController{

	public $uses = array('Bookable','Vehicle','User', 'Event');
	public $helpers = array('Html', 'Form' );

	function beforeFilter(){
        $this->checkSession();	
	}
	
	function index() {
		global $vars;

		if (isset($this->request->data)){
			$vars = $this->request->data;
		}
		
		$this->set('invoice_form',preview_invoice_form());
		
		$this->set('invoice_report',tag("div"));
		
		if (isset($this->request->data['submit']) ){
			$this->set('invoice_report',user_preview_invoice_rpt());
		}
	}
  
}
?>