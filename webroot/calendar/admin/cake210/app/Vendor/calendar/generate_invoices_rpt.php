<?php

if (!defined('IN_PHPC')) {
	die("Hacking attempt");
}

function add_html_wrapper($inv, $title){
	$output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
		."<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n"
		."\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";
	$html = tag('html', attributes("xmlns=\"http://www.w3.org/1999/xhtml\""),
			tag('head',
				tag('title', $title)
				),
			tag('body',
				$inv));
	return $output . $html->toString();
}

function write_text_to_file($user_root, $user_dir, $file_name, $invText, $mode='w'){
		if (!file_exists( $user_root )){
			soft_error("User root does not exist: "  . $user_root);
		}
		
		if (!file_exists  ( $user_root . "/" . $user_dir  )){
			mkdir( $user_root . "/" . $user_dir );	
		}

		if (!file_exists  ( $user_root . "/" . $user_dir . "/invoices" )){
			mkdir( $user_root . "/" . $user_dir . "/invoices" );	
		}		
		
		$ourFileName = $user_root . "/" . $user_dir . "/invoices/". $file_name;
		$ourFileHandle = fopen($ourFileName, $mode) or die("can't open file");
		fwrite($ourFileHandle, $invText);
		fclose($ourFileHandle);
}

function read_text_from_file($user_root, $user_dir, $file_name){
		$retText = "";
		if (!file_exists( $user_root . "/" . $user_dir . "/invoices/". $file_name )){
			soft_error("File does not exist " . $user_root . "/" . $user_dir . "/invoices/". $file_name);
		}
					
		$ourFileName = $user_root . "/" . $user_dir . "/invoices/". $file_name;
		$ourFileHandle = fopen($ourFileName, 'r') or die("can't open file");
		$retText = fread($ourFileHandle, filesize($ourFileName));
		fclose($ourFileHandle);
		return $retText;
}

function generate_invoices_rpt() {
	global $vars, $day, $month, $year, $db, $config, $phpc_script, $month_names, $event_types, $calendar_name, $ANNOUNCE_TYPES;
	
	set_time_limit  ( 3600  );
	
	$retText = tag("div");
	
	echo("<div>");
	
	if ($vars["subaction"] == "generate_invoices" || $vars["subaction"] == "submit"){
		if ($vars["subaction"] == "submit"){
			$titleText = "Validating";
			$formAction = "generate_invoices";
			$formSubmitText = "Yes, I Am Sure, Generate The Invoices.";
			$validating = true;
		} else if ($vars["subaction"] == "generate_invoices") {	
			$titleText = "Generated Invoices";		
			$formAction = "send_email";
			$formSubmitText = "Email the invoices to these members";
			$validating = false;
		} else {
			soft_error("unknown action.");
		}
		
		echo("<div><h2>$titleText</h2></div>");

		$month     = $vars['month'];
		$year      = $vars['year'];	

		$formTag = tag("form", attributes("method='post' action='$phpc_script'"));		
		$formTag->add(create_hidden('action', 'generate_invoices_rpt'));	 
		$formTag->add(create_hidden('subaction', $formAction));
		$formTag->add(create_hidden('month', $month));
		$formTag->add(create_hidden('year', $year));
		$formTag->add(create_submit($formSubmitText));
													
		$max_invoicable_id = quick_query("select max(id) as maxid from ".SQL_PREFIX."invoicables", "maxid");
		
		$billing = get_billing_object($year,$month);
		
		$transId = 1;
		
		$newInvoiceNumber = quick_query("select max( invoice_num ) as max_inv_num from " . SQL_PREFIX . "invoices where billing_id=" . $billing['id'], "max_inv_num");
		
		//echo("mx inv num $newInvoiceNumber");
		if ($newInvoiceNumber == "" || $newInvoiceNumber == -1) {
			$newInvoiceNumber = $billing['invoice_num_to_start_at'];
		} else {
			$newInvoiceNumber += 1;
		}
		//echo(" aft $newInvoiceNumber");
		
		//TODO more validation on billing
		if (!is_numeric($newInvoiceNumber)){
			$temp = tag("blockquote", tag("b", tag("font", attributes("color='red'"), "Invoice number is not set." )), tag("br") );
			echo($temp->toString());
		}	
		$invMemo = "";
		
		$allInvoicesIff = "";
		
		for ($i = 0; $i <= $max_invoicable_id; $i++){
			if (isset($vars[ $i])){
				
				$formTag->add(create_hidden( $i, $vars[ $i]));
 
 				$displayName = get_invoicable_name($vars[ $i]);
 				 
				$invRow = get_invoice("", $vars[ $i],$billing['id']);
				$invErrors = tag('div');
				if (! $invRow ) {	
					$previousOwing = get_prev_owing($vars[ $i], $billing['id']);
					$paymentsMade = 0.0;
					prev_owing_submit($invErrors,$previousOwing,$paymentsMade,$vars[ $i],$billing['id']);
					$invRow = get_invoice("", $vars[ $i],$billing['id']);
				}
				
				$previousOwing = $invRow['previous_owing'];
				$paymentsMade =  $invRow['payment_made'];
				if ($invRow['invoice_num'] != -1){
					$invoiceNumber = $invRow['invoice_num'];
				} else {
					$invoiceNumber = $newInvoiceNumber;
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
				$invErrors = tag("div");
				
				$invoiceGenerator = new GenerateInvoicesLocal()
				$outData = $invoiceGenerator->generate_invoice_for_user_or_group($month, $year, $vars[ $i], $transId, $invoiceNumber, $previousOwing, $paymentsMade, $billing, $invMemo, $invErrors);
				$invText = $invoiceGenerator->skin_invoice_html($outData, $invErrors);
				$invIff	 = $invoiceGenerator->skin_invoice_iif($outData, $invErrors);
				
				$invText = add_html_wrapper( $invText, "Invoice $displayName " . month_name( $month ) . " $year" );
				
				$allInvoicesIff .= $invIff;

				if (!is_dir(USER_HOME)) {
					if (!is_dir(USER_HOME . "invoicables/")) {
						mkdir(USER_HOME . "invoicables/");
					}			
				}				
				
				if (!$validating){				
					update_invoice($invRow['id'], "inv_total",   $outData["invoice_total"]);
					update_invoice($invRow['id'], "amt_owing",   $outData["amt_owing"]);
					
					$lid = str_pad($vars[ $i], 15, 0, STR_PAD_LEFT);	
					
					write_text_to_file(USER_HOME . "invoicables/", $lid, $fileStem . ".html", $invText);
					write_text_to_file(USER_HOME . "invoicables/", $lid, $fileStem . ".iif",  $invIff);
				}
				
				//$retText->add($displayName . "<br/>");
				//$retText->add(tag("blockquote", $invErrors));
				
				$newInvoiceNumber ++;
				$transId ++;
				echo("Processed $displayName...<br/>");
				echo( $invErrors->toString() . "<br/>" );
				flush();
			}
			if (!$validating){	
				write_text_to_file(USER_HOME . "invoicables/", "_ALL_USERS" , get_invoice_file_name( $month, $year, "ALL") . ".iif", $allInvoicesIff);
			}
		}		
	    $retText->add( tag("strong","Done $titleText") );
		$retText->add($formTag);
		echo( $retText->toString() );
	} else if ($vars["subaction"] == "send_email"){
		$temp = tag('div', "Mailing Invoices<br/>");
		echo( $temp->toString() );		
		$month     = $vars['month'];
		$year      = $vars['year'];														
		$max_user_id = quick_query("select max(id) as maxid from ".SQL_PREFIX."users", "maxid");
		
		for ($i = 0; $i <= $max_user_id; $i++){
			if (isset($vars[ $i])){	
				//$displayName = get_invoicable_name($vars[ $i]);		
				$invoicableInfo = get_invoicable_info($vars[ $i]);
				
				if ($invoicableInfo['type'] == "INDIVIDUAL"){
					$displayName = $invoicableInfo['displayname'];
					$email =       $invoicableInfo['email'];
				} else {
					$displayName = $invoicableInfo['grp_displayname'];
					$email =       $invoicableInfo['grp_email'];					
				}				
				
				//$email = quick_query("select email from ".SQL_PREFIX."users where id=" . $vars[$i], "email");
				$lid = str_pad($vars[ $i], 15, 0, STR_PAD_LEFT);
				$invText = read_text_from_file(USER_HOME . "invoicables/", $lid, get_invoice_file_name($month, $year, $displayName) . ".html");				

				$headers = 'From: Kootenay Carshare Coop <info@carsharecoop.ca>' . "\r\n" .
				    'Reply-To: Kootenay Carshare Coop <info@carsharecoop.ca>' . "\r\n" . 
				    'Content-type: text/html; charset=us-ascii';

				if (mail($email, "Invoice from Kootenay Carshare Coop for " . month_name($month) . " " . $year, $invText, $headers)) {
				  //$retText->add($displayName . " invoice sent.<br/>");
				  echo ($displayName . " invoice sent to $email <br/>");
				} else {
				  //$retText->add($displayName . " invoice failed to send.<br/>");
				  echo ("<font color='red'>" . $displayName . " invoice failed to send.</font><br/>");
				}
				flush();
			}
		}

		$retText->add(tag("font", "Done<br/><br/>"));
	} else {
		redirect("index.php");
	}
	
	echo("</div>");
	return $retText;
}

?>
