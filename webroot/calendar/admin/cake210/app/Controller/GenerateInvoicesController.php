<?php
App::uses('AppController', 'Controller');

require_once(App::path('Vendor')[0] . 'adodb/adodb.inc.php');
		App::import('Vendor','calendar/setup');
		App::import('Vendor','calendar/html');
		App::import('Vendor','calendar/url_match');
		App::import('Vendor','calendar/calendar');
		App::import('Vendor','calendar/generate_invoices_inc');
		App::import('Vendor','calendar/generate_invoices_local_inc');
		App::import('Vendor','calendar/generate_invoices_form');
		App::import('Vendor','calendar/generate_invoices_rpt');	
		
class GenerateinvoicesController extends AppController{

	public $uses = array('Invoices');
	public $helpers = array('Html', 'Form' );
	//public $components = array('json');
	
	function beforeFilter(){
        $this->checkSession();	
	}
	
	function clearAllUsersiifFile($month=0, $year=1901, $validating='true'){
	    $this->layout = "json";	
		global $vars;
		
		if ($validating == 'true'){
		    $validating = true;
		} else {
		    $validating = false;
		}   
		$success = true;
		$message = "About to clear old iif file";
		
		if ($validating == false){
			if (!is_dir(USER_HOME)) {
				if (!is_dir(USER_HOME . "invoicables/")) {
					mkdir(USER_HOME . "invoicables/");
				}			
			}

    		write_text_to_file(USER_HOME . "invoicables/", "_ALL_USERS" , get_invoice_file_name( $month, $year, "ALL") . ".iif", "");	    
            $success = true;
            $message = "Cleared old 'all_users.iif' file";
        } else {
            $success = true;
            $message = "Validating - did not clear old 'all_users.iif' file";
        }
		$billing = get_billing_object($year,$month);
		if ($billing == null){
		    $success = false;
		    $message = "Error: could not find billing for this month and year";
		}
		
		$out = Array("success" => $success, "message"=>$message, "errors" => Array(), "billing" => $billing);
		
		$this->set("myArr", json_encode($out)  );
	}

	function sendmailforuser($invoicable_id, $year=1901, $month=-1){
    	    $this->layout = "json";	

			$invoicableInfo = get_invoicable_info($invoicable_id);
            $billing = get_billing_object($year,$month);
            $billing_id = $billing['id'];
		    $invRow = get_invoice("", $invoicable_id,$billing_id);
					
			if ($invoicableInfo['type'] == "INDIVIDUAL"){
				$displayName = $invoicableInfo['displayname'];
				$email =       $invoicableInfo['email'];
			} else {
				$displayName = $invoicableInfo['grp_displayname'];
				$email =       $invoicableInfo['grp_email'];					
			}				

			$lid = str_pad($invoicable_id, 15, 0, STR_PAD_LEFT);
			$invText = read_text_from_file(USER_HOME . "invoicables/", $lid,  $invRow['file_stem'] . ".html");				

			$headers = 'From: Kootenay Carshare <info@carsharecoop.ca>' . "\r\n" .
			    'Reply-To: Kootenay Carshare <info@carsharecoop.ca>' . "\r\n" . 
			    'Content-type: text/html; charset=us-ascii';

			if (mail($email, "Invoice from Kootenay Carshare for " . month_name($month) . " " . $year, $invText, $headers)) {
			  $success = true;
			  $message = "invoice sent to $email";
			} else {
			  $success = true;
			  $message = $displayName . " invoice failed to send.";
			}
			
		    $out = Array("success" => $success, "message"=>$message);
		    $this->set("myArr", json_encode($out)  );			
	}
		
	function geninvoice($invoicable_id, $year=1901, $month=-1, $newInvoiceNumber=-1, $transId=-1, $validating='true'){               
	    $this->layout = "json";	

		if ($validating == 'true'){
		    $validating = true;
		} else {
		    $validating = false;
		} 
		
        $invMemo = "";
        $billing = get_billing_object($year,$month);
        
        $billing_id = $billing['id'];

		$displayName = get_invoicable_name($invoicable_id);
		 
		$invRow = get_invoice("", $invoicable_id,$billing_id);
		$invErrors = Array();
		if (! $invRow ) {	
			$previousOwing = get_prev_owing($invoicable_id, $billing_id);
			$paymentsMade = 0.0;
			prev_owing_submit($invErrors,$previousOwing,$paymentsMade,$invoicable_id,$billing_id);
			$invRow = get_invoice("", $invoicable_id,$billing_id);
		}
		
		$previousOwing = $invRow['previous_owing'];
		$paymentsMade =  $invRow['payment_made'];
		if ($invRow['invoice_num'] != -1){
			$invoiceNumber = $invRow['invoice_num'];
		} else {
			$invoiceNumber = $invRow['id'];//get_next_available_invoice_num($newInvoiceNumber);
			if (!$validating) update_invoice($invRow['id'], "invoice_num", $invoiceNumber);
		}
		
		if ($invRow['file_stem'] != ""){
			$fileStem = $invRow['file_stem'];
		} else { 
			$fileStem = get_invoice_file_name($month, $year, $displayName);
			if (!$validating) update_invoice($invRow['id'], "file_stem",   $fileStem);
		}
		
		$invText = tag("div");
		$invIff = "";
		
		invoiceGenerator$ = new GenerateInvoicesLocal();
		$outData = invoiceGenerator$->generate_invoice_for_user_or_group($month, $year, $invoicable_id, $transId, $invoiceNumber, $previousOwing, $paymentsMade, $billing, $invMemo, $invErrors);
		$invText = invoiceGenerator$->skin_invoice_html($outData, $invErrors);
		$invIff	 = invoiceGenerator$->skin_invoice_iif($outData, $invErrors);
		
		$invText = add_html_wrapper( $invText, "Invoice $displayName " . month_name( $month ) . " $year" );

		if (!$validating){				
			update_invoice($invRow['id'], "inv_total",   $outData["invoice_total"]);
			update_invoice($invRow['id'], "amt_owing",   $outData["amt_owing"]);
			
			$lid = str_pad($invoicable_id, 15, 0, STR_PAD_LEFT);	
			
			if (!is_dir(USER_HOME)) {
				if (!is_dir(USER_HOME . "invoicables/")) {
					mkdir(USER_HOME . "invoicables/");
				}			
			}
			
			write_text_to_file(USER_HOME . "invoicables/", $lid, $fileStem . ".html", $invText);
			write_text_to_file(USER_HOME . "invoicables/", $lid, $fileStem . ".iif",  $invIff);
			write_text_to_file(USER_HOME . "invoicables/", "_ALL_USERS" , get_invoice_file_name( $month, $year, "ALL") . ".iif", $invIff, 'a');	    

		}
						
		$newInvoiceNumber ++;
		$transId ++;

		$invErrors;
		if (count($invErrors) == 0){
		    $message = "Successfully created invoice for this user";
		    $success = true;   
		} else {
		    $message = "Failed to create invoice for this user";
		    $success = false;   		    
		}
		$out = Array("success" => $success, "message"=>$message, "invoicable_id" => $invoicable_id, "errors" => $invErrors);
		$this->set("myArr", json_encode($out)  );		
	}

	function get_next_available_invoice_num($new_invoice_num){
		
	}
	
    function inv_list(){
		global $vars;

        $invoicables = get_invoicable_users_and_groups();
        $this->set("invoicables", $invoicables);     
    }
	/*
	function index() {
		$this->layout = 'blank';
		global $vars;
		App::import('Vendor','adodb/adodbinc');
		App::import('Vendor','calendar/setup');
		App::import('Vendor','calendar/html');
		App::import('Vendor','calendar/url_match');
		App::import('Vendor','calendar/calendar');
		App::import('Vendor','calendar/generate_invoices_inc');
		App::import('Vendor','calendar/generate_invoices_local_inc');
		App::import('Vendor','calendar/generate_invoices_form');
		App::import('Vendor','calendar/generate_invoices_rpt');
		
		if (isset($this->request->data)){
			$vars = $this->request->data;
		}
		
		echo("<html><head></head><body>");
		
		//echo("<div align='center'/><a href='/members/calendar/admin/cake/staticpages/'>[Back To Admin]</a></div>");
		$this->set('generate_invoices_form',tag("div"));
		$this->set('generate_invoices_report',tag("div"));
		if (isset($this->request->data['submit']) ){
			// This script flushes output to the browser
			generate_invoices_rpt();
		} else {
			//$this->set('generate_invoices_form',generate_invoices_form());
			$outTxt = generate_invoices_form();
			echo( $outTxt->toString() );
		}
		echo("</body>");
	}
	*/
}
?>