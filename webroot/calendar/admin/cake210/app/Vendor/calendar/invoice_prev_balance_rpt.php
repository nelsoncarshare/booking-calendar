<?php

if ( !defined('IN_PHPC') ) {
       die("Hacking attempt");
}


function invoice_prev_balance_rpt(){
    global $db, $CANCELED, $phpc_script, $vars;
		
	$billing_id = $vars['billing_id'];

	$amSubmitting = false;
	if (!empty($_POST["amsubmitting"])) {
		$amSubmitting = true;
	}
	
	$outStr = tag("font");
	
	//$outStr->add( tag('div', attributes('align="center"'), tag("a",attributes("href='index.php'"),"return to admin")));
	
	$outMsg = tag("div");
	
	$rowcount = 1;
	$html_events = tag('tbody');
	
	$invoicables = get_invoicable_users_and_groups();
	$tabindex = 1;
	$myBgcolor = "#FFFFFF";
	foreach( $invoicables as $inv_id => $displayname) {
		
		if ( $amSubmitting ){	
			if (prev_owing_submit($outMsg,$_POST["previous_owing_$rowcount"],$_POST["payment_made_$rowcount"],$inv_id,$billing_id) != 0) {
			}
	 		$prev_owing = $_POST["previous_owing_$rowcount"];
	 		$payment_made = $_POST["payment_made_$rowcount"];
		} else {
			$prev_owing = quick_query("select * from " . SQL_PREFIX . "invoices WHERE invoicable_id=" . $inv_id. " and billing_id=" . $billing_id, "previous_owing" );
			$payment_made = quick_query("select * from " . SQL_PREFIX . "invoices WHERE invoicable_id=" . $inv_id. " and billing_id=" . $billing_id, "payment_made" );
		}
		
		if ($prev_owing == "") $prev_owing = get_prev_owing($inv_id, $billing_id);
		if ($payment_made == "") $payment_made = 0.0;
		
		$tabindex += 2;
		$html_events->add(tag('tr', 
								tag('td', attributes("bgcolor='$myBgcolor'"), $rowcount),
								tag('td', attributes("bgcolor='$myBgcolor'"), $displayname),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='8'", "max_length='10'", 'name="previous_owing_' . $rowcount. '"', "value=\"" . $prev_owing . "\""))),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='8'", "max_length='10'", 'name="payment_made_' . $rowcount. '"', "value=\"" . $payment_made . "\"")))
								));
	$rowcount = $rowcount + 1;
	} 

	$outStr->add(
			   tag('form', attributes("action=\"$phpc_script\"", "method=\"post\""),	   	  
				  tag('table', attributes(" border='1' cellpadding='0' cellspacing='0'"), 
				  		//tag('thead',
				  			tag('tr',tag('td',attributes(" colspan='11'"),  $outMsg)),
					  		tag('tr', 
					  				attributes(" bgcolor='#AAAAAA' align='center'"),
					  				tag('td', ""),
					  				tag('td', "<b>User</b>"), 
					  				tag('td', "<b>Previous Owing</b>"),
					  				tag('td', "<b>Payment Made</b>")
					  				),
				  		$html_events,
				  		tag('tr',
				  				tag('td',attributes(" colspan='6'"),  create_submit(_("Submit")), create_hidden('action', 'invoice_prev_balance_rpt'), create_hidden('billing_id', $billing_id), create_hidden('amsubmitting', 'true') ),
				  				tag('td', "" )
				  				))
				  			)
				  		);
	return $outStr;
	
}

?>
