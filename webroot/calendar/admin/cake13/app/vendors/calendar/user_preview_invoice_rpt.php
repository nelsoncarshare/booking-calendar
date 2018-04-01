<?php
 
if ( !defined('IN_PHPC') ) {
       die("Hacking attempt");
}

function user_preview_invoice_rpt(){
 	
	global $vars;
	
	$query_month = $vars['month'];
	$query_year  = $vars['year'];
	
	$invoicableid = $vars['user'];		
	
	$billing = get_billing_object($query_year,$query_month);
	$invRow = get_invoice("",$invoicableid,$billing['id']);

	if (! $invRow ) {
		$invErrors = tag('div');
		$previousOwing = get_prev_owing($invoicableid, $billing['id']);
		$paymentMade = 0.0;
		prev_owing_submit($invErrors,$previousOwing,$paymentMade,$invoicableid,$billing['id']);
		$invRow = get_invoice("",$invoicableid,$billing['id']);
		$invoiceNumber = 1;
	} else {

		$paymentMade = $invRow['payment_made'];
		$previousOwing = $invRow['previous_owing'];
		if ($invRow['invoice_num'] != -1){
			$invoiceNumber = $invRow['invoice_num'];
		} else {
			$invoiceNumber = 1;
		}
	}
	
	$invErrors = Array();
	$outData = generate_invoice_for_user_or_group($query_month,$query_year,$invoicableid, 1, $invoiceNumber, $previousOwing, $paymentMade, $billing, "", $errors);
	$outStr = skin_invoice_html($outData, $invErrors);

	$errors = tag("div");
	foreach($invErrors as $err){
		$errors->add($err);
		$errors->add(tag("br"));
	}
	
	$errors->add($outStr);
 	return $errors;
 } 
 
?>
