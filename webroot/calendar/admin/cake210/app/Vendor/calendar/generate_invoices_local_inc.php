<?php

if ( !defined('IN_PHPC') ) {
       die("Hacking attempt");
}

class GenerateInvoicesLocal{

	public $INVOICE_TEXT;

	function __construct() {
		$INVOICE_TEXT['hours_item_name'] = "hours";
		$INVOICE_TEXT['km_item_name'] = "kilometers";	
	}
	
	function createSummaryRow(){
		$r = Array();
		$r['value'] = 0; 
		$r['item'] = "";
		$r['comment'] = "";
		$r['acnt_code'] = "";
		$r['name'] = "";		
		return $r;
	}

	function generate_invoice_for_user_or_group($query_month, $query_year, $invoicable_id, $transID, $invoiceNumber, $previousOwing, $paymentsMade, $billing, $invoiceMemoText, &$outErrors){
		global $db, $CANCELED, $MEMBER_PLANS, $TAX_CODES, $vars, $LIGHT_ROW_COLOR, $DARK_ROW_COLOR;

		$startstamp = mktime( 0,   0, 0, $query_month,     1, $query_year);
		$endstamp =   mktime(23, 59, 59, $query_month + 1, 0, $query_year);

		$myMonthName = month_name($query_month);
		
		$outData = array();
				
		$totalDistance = get_total_distance($startstamp,$endstamp,$invoicable_id);
		
		$userrow = get_user_or_group($invoicable_id);
		$invoicableInfo = get_invoicable_info($invoicable_id);
		
		$plan = $this->get_plan($totalDistance, $billing, $invoicable_id);
		
		$outData['invoice_num'] = $invoiceNumber;
		$outData['transaction_id'] = $transID;
		$outData['memo'] = $invoiceMemoText;
		$outData['billing_info'] = $billing;
		$outData['invoice_for'] = $userrow;
				
		$iif_events = array();
		$summary_rows = array();
		$expenseRows = array();
		$eventsRows = array();
		
		//subtotals is an array of values that are updated as we add lines to the invoice
		$subtotals = array();
		$this->initializeSubtotals($subtotals);
			
		$result = get_user_car_month_usage($startstamp,$endstamp,$invoicable_id);
		
		while($row = $result->FetchRow($result)) {
			$eventsRows[] = $this->getBookingInvoiceRow($totalDistance, $billing, $row, $plan, $subtotals);
			
			if ($row['admin_ignore_this_booking'] == false){
				if ($row['expense_gas'] != 0){
					$subtotals['expenseTotal'] += round($row['expense_gas'], 2);
					$expenseRows[] = Array( "comment" => $row['admin_comment'], "value" => $row['expense_gas'], "acnt_code" => $row['acnt_new_code_gas'], "item" => "Gas" );
				}
				if ($row['expense_repair'] != 0){
					$subtotals['expenseTotal'] += round($row['expense_repair'], 2);
					$expenseRows[] = Array( "comment" => $row['admin_comment'], "value" => $row['expense_repair'], "acnt_code" => $row['acnt_new_code_repair'], "item" => "Repair" );
				}
				if ($row['expense_admin'] != 0){
					$subtotals['expenseTotal'] += round($row['expense_admin'], 2);
					$expenseRows[] = Array( "comment" => $row['admin_comment'], "value" => $row['expense_admin'], "acnt_code" => $row['acnt_new_code_admin'], "item" => "Administration" );
				}
				if ($row['expense_insurance'] != 0){
					$subtotals['expenseTotal'] += round($row['expense_insurance'], 2);
					$expenseRows[] = Array( "comment" => $row['admin_comment'], "value" => $row['expense_insurance'], "acnt_code" => $row['acnt_new_code_insurance'], "item" => "Insurance" );
				}		
				if ($row['expense_misc_1'] != 0){
					$subtotals['expenseTotal'] += round($row['expense_misc_1'], 2);
					$expenseRows[] = Array( "comment" => $row['admin_comment'], "value" => $row['expense_misc_1'], "acnt_code" => $row['acnt_new_code_fines'], "item" => "Fines" );			
				}		
				if ($row['expense_misc_2'] != 0){
					$subtotals['expenseTotal'] += round($row['expense_misc_2'], 2);
					$expenseRows[] = Array( "comment" => $row['admin_comment'], "value" => $row['expense_misc_2'], "acnt_code" => $row['acnt_new_code_misc_2'], "item" => "Misc 2" );			
				}
				if ($row['expense_misc_3'] != 0){
					$subtotals['expenseTotal'] += round($row['expense_misc_3'], 2);
					$expenseRows[] = Array( "comment" => $row['admin_comment'], "value" => $row['expense_misc_3'], "acnt_code" => $row['acnt_new_code_misc_3'], "item" => "Misc 3" );	
				}		
				if ($row['expense_misc_4'] != 0){
					$subtotals['expenseTotal'] += round($row['expense_misc_4'], 2);
					$expenseRows[] = Array( "comment" => $row['admin_comment'], "value" => $row['expense_misc_4'], "acnt_code" => $row['acnt_new_code_misc_4'], "item" => "Misc 4" );	
				}			
			}	
		}	
		
		$outData['events_rows'] = $eventsRows;
		
		$summary_rows[] = $this->getGasSurchargeInvoiceRow($totalDistance, $billing, $subtotals);
		
		//add extra rows that tax applys to
		$result = get_extra_invoice_rows($invoicable_id, $billing['id'], "taxcode=" . $TAX_CODES['PST_ONLY'] . " OR " . "taxcode=" . $TAX_CODES['PST_GST']);
		while($row = $result->FetchRow($result)) {
			$out = array();
			
			$out['value'] =  round($row['ammount'],2);
			$out['item'] = $row['item'];
			$out['comment'] = $row['comment'];
			$out['name'] = "";
			$out['acnt_code'] = $row['acnt_code_new'];
			
			$subtotals['pstGstSubtotal'] += $out['value'];
			
			$summary_rows[] = $out;
		}
		
		$outData['summary_rows'] = $summary_rows;
		
		$outData['member_plan_row'] = $this->getMemberPlanInvoiceRow($plan, $billing, $invoicableInfo, $subtotals);	

		$outData['subtotal_pst'] = $subtotals['pstGstSubtotal'];

		$pst_invoice_row = $this->getPSTInvoiceRow($totalDistance, $billing, $subtotals);
		$outData['pst_row'] = $pst_invoice_row;
		
		$rentalTaxRow = $this->getRentalTaxRow($eventsRows, $billing, $subtotals);
		$outData['rental_tax_row'] = $rentalTaxRow;
		
		$gst_invoice_row = $this->getGSTInvoiceRow($totalDistance, $billing, $subtotals);	
		$outData['gst_row'] = $gst_invoice_row;	

		$carbonOffsetRow = $this->getCarbonOffsetTaxInvoiceRow($totalDistance, $billing, $subtotals);
		$outData['carbon_offset_row'] = $carbonOffsetRow;
		
		$selfInsuranceRow = $this->getSelfInsuranceInvoiceRow($totalDistance, $billing, $subtotals);
		$outData['self_insurace_row'] = $selfInsuranceRow;
		
		$interestRow = $this->getInterestInvoiceRow($previousOwing, $paymentsMade, $billing, $subtotals);
		$outData['interest_row'] = $interestRow;
		
	//    $outData['long_term_discount_row'] = getLongTermDiscountRow($billing, $invoicableInfo, $userrow, $billing['long_term_discount_year'], $invoicable_id, $subtotals);
		
		$result = get_extra_invoice_rows($invoicable_id, $billing['id'], "taxcode=" . $TAX_CODES['EXEMPT']);
		while($row = $result->FetchRow($result)) {
			$out = array();
			
			$out['value'] =  $row['ammount'];
			$out['item'] = $row['item'];
			$out['comment'] = $row['comment'];
			$out['name'] = "";
			$out['acnt_code'] = $row['acnt_code_new'];
			
			$subtotals['expenseTotal'] += $out['value'];
			
			$expenseRows[] = $out;
		}
		
		$outData['expense_rows'] = $expenseRows;
		
		$invTotal = number_format($subtotals['pstGstSubtotal'] + $subtotals['pstTotal'] +  $subtotals['gstTotal'] + $subtotals['expenseTotal'],2,".","");
		
		$outData['invoice_total'] = $invTotal;
		
		$outData['previous_owing'] = $previousOwing;
		
		$outData['payments_made'] = $paymentsMade;
		
		$outData['amt_owing'] = $outData['invoice_total'] + $outData['previous_owing'] - $outData['payments_made'];
		
		return $outData;
	}

	function skin_invoice_html($outData, &$outErrors){
		global $LIGHT_ROW_COLOR, $DARK_ROW_COLOR;
		
		$outStr = tag("div", attributes("style='font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-style: normal'"));
											
		$outStr->add( $this->getHTMLLogoRow() );
		
		$outStr->add( $this->getHTMLInvoiceHeader($outData['invoice_for'], $outData['billing_info'], $outData['invoice_num']) );
					
		$invDateArray = explode("-", $outData['billing_info']["invoice_date"]);
		$invDueDateArray = explode("-", $outData['billing_info']["invoice_due_date"]);
		
		//done generating header, generate rows 
		$html_events = tag('tbody');
				
		$myRowColor = $LIGHT_ROW_COLOR;	
		foreach ($outData['events_rows'] as $i => $value) {
			$this->validate_events_row($value, $outErrors);
			$myRowColor = toggle_row_color($myRowColor);	
			$html_events->add(tag('tr', 
									tag('td', attributes("bgcolor='$myRowColor'"), $value['comment']), 
									tag('td', attributes("align='center' bgcolor='$myRowColor'"), $value['hours']),
									tag('td', attributes("align='center' bgcolor='$myRowColor'"), $value['distance'] ),
									tag('td', attributes("bgcolor='$myRowColor' align='right' nowrap='true'"), "$" . number_format($value['time_charge'],2, ".", "") ),
									tag('td', attributes("bgcolor='$myRowColor' align='right' nowrap='true'"), "$" . number_format($value['km_charge'], 2, ".", "") ),
									tag('td', attributes("bgcolor='$myRowColor' align='right' nowrap='true'"), "$" . number_format($value['km_charge'] + $value['time_charge'], 2, ".", "") )
									));   	
		}

		$html_summary = tag('tbody');
		foreach ($outData['summary_rows'] as $i => $r) {	
			$this->validate_summary_row($r, $outErrors);
			$myRowColor = toggle_row_color($myRowColor);
			$html_summary->add( get_formated_expense_row($myRowColor, $r['comment'], $r['value'] ));	
		}

		$myRowColor = toggle_row_color($myRowColor);
		$this->validate_summary_row($outData['member_plan_row'], $outErrors);
		$html_summary->add( get_formated_expense_row($myRowColor, $outData['member_plan_row']['comment'], $outData['member_plan_row']['value'] ));	
		
		$myRowColor = toggle_row_color($myRowColor);
		$html_summary->add( get_formated_expense_row($myRowColor, "<b>subtotal</b>", $outData['subtotal_pst'] ));

		$this->validate_summary_row($outData['pst_row'], $outErrors);
		$html_summary->add( get_formated_expense_row($myRowColor, $outData['pst_row']['comment'], $outData['pst_row']['value'] ));	

		$this->validate_summary_row($outData['rental_tax_row'], $outErrors);
		$html_summary->add( get_formated_expense_row($myRowColor, $outData['rental_tax_row']['comment'], $outData['rental_tax_row']['value'] ));	
		
		$myRowColor = toggle_row_color($myRowColor);
		$this->validate_summary_row($outData['gst_row'], $outErrors);
		$html_summary->add( get_formated_expense_row($myRowColor, $outData['gst_row']['comment'], $outData['gst_row']['value'] ));	

		$myRowColor = toggle_row_color($myRowColor);
		$this->validate_summary_row($outData['carbon_offset_row'], $outErrors);
		$html_summary->add( get_formated_expense_row($myRowColor, $outData['carbon_offset_row']['comment'], $outData['carbon_offset_row']['value'] ));	

		$myRowColor = toggle_row_color($myRowColor);
		$this->validate_summary_row($outData['self_insurace_row'], $outErrors);
		$html_summary->add( get_formated_expense_row($myRowColor, $outData['self_insurace_row']['comment'], $outData['self_insurace_row']['value'] ));	

		$myRowColor = toggle_row_color($myRowColor);
		$this->validate_summary_row($outData['interest_row'], $outErrors);
		$html_summary->add( get_formated_expense_row($myRowColor, $outData['interest_row']['comment'], $outData['interest_row']['value'] ));	
		
	//	if ($outData['long_term_discount_row']){
	//		validate_summary_row($outData['long_term_discount_row'], $outErrors);
	//		$html_summary->add( get_formated_expense_row($myRowColor, $outData['long_term_discount_row']['comment'], $outData['long_term_discount_row']['value'] ));	
	//	}
		
		$html_expenses = tag('tbody');
		foreach ($outData['expense_rows'] as $i => $r) {
			$this->validate_summary_row($r, $outErrors);
			$myRowColor = toggle_row_color($myRowColor);
			$html_expenses->add( get_formated_expense_row($myRowColor, $r['comment'], $r['value'] ));
		}				

		$outStr->add(tag("br"));
		
		$outStr->add(
				  tag('table', attributes("border='0' cellspacing='0' cellpadding='1' bgcolor='#000000' width='100%'"), tag("tr", tag("td",
					  tag('table', attributes("border='0' cellpadding='3' cellspacing='0' bgcolor='#FFFFFF' width='100%'"), 
							tag('caption', ''), 
							//tag('thead',
								tag('tr', 
										tag('td', attributes("bgcolor='#666666' width='75%' align='center'"), "<font color='#000000'><strong>Description</strong></font>"),  			  				
										tag('td', attributes("bgcolor='#666666' width='5%' align='center'"), "<font color='#000000'><strong>Hours</strong></font>"),
										tag('td', attributes("bgcolor='#666666' width='5%' align='center'"), "<font color='#000000'><strong>distance</strong></font>"),
										tag('td', attributes("bgcolor='#666666' width='5%' align='center'"), "<font color='#000000'><strong>time charge</strong></font>"),
										tag('td', attributes("bgcolor='#666666' width='5%' align='center'"), "<font color='#000000'><strong>km charge</strong></font>"),
										tag('td', attributes("bgcolor='#666666' width='5%' align='center'"), "<font color='#000000'><strong>total</strong></font>")			  								  								  								  				
										),					  								  								  				
							$html_events,
							$html_summary,
							$html_expenses,
							tag('tbody',
								tag('tr', tag('td', attributes("colspan='6' align='center'"), tag("hr"))),
								tag('tr', 
										tag('td', attributes("colspan='5'"), "<b>Invoice total</b>"),  			  				
										tag('td', "<b>$" . number_format($outData['invoice_total'] ,2, ".", "") . "</b>")			  								  								  								  				
										),	
								tag('tr', 
										tag('td', attributes("colspan='5'"), "<b>Total from previous invoice</b>"),  			  				
										tag('td', "$" . number_format($outData['previous_owing'] ,2, ".", "") . "")			  								  								  								  				
										),
								tag('tr', 
										tag('td', attributes("colspan='5'"), "<b>Payments made</b>"),  			  				
										tag('td', "$" . number_format($outData['payments_made'] ,2, ".", "") . "")			  								  								  								  				
										),					  				
								tag('tr', tag('td', attributes("colspan='6' align='center'"), tag("hr"))),		
								tag('tr', 
										tag('td', attributes("colspan='5'"), "<b>AMOUNT OWING</b>"),  			  				
										tag('td', "<b>$" . (number_format($outData['amt_owing'] ,2, ".", "")) . "</b>")			  								  								  								  				
										)					  									  						  		
							)
						)
					)))
				);	
		return $outStr;
	}

	function get_plan($totalDistance, $billing, $invoicable_id){
		global $MEMBER_PLANS, $db;
		
		$query = "SELECT * from ".SQL_PREFIX."invoicables INNER JOIN ".SQL_PREFIX."grouptypes ON ".SQL_PREFIX."invoicables.type=".SQL_PREFIX."grouptypes.id WHERE ".SQL_PREFIX."invoicables.id=$invoicable_id";
		$result = $db->Execute($query)
			or db_error(_('Error in get_plan'), $query);
		$myrow = $result->FetchRow();
		
		if ($myrow['is_member'] == FALSE){
			echo "alpha";
			return $MEMBER_PLANS['HIGH'];
		} else if ($myrow['type'] == 'INDIVIDUAL' || $myrow['force_user_member_plan'] == true){
			echo "beta";
			return $MEMBER_PLANS['LOW'];
			/*
			if ($totalDistance < $billing['member_plan_low_cutoff']){
				return $MEMBER_PLANS['LOW'];
			} else if ($totalDistance < $billing['member_plan_med_cutoff']) {
				return $MEMBER_PLANS['MED'];
			} else {
				return $MEMBER_PLANS['HIGH'];
			}
			*/
		} else {
			return $MEMBER_PLANS['GROUP'];
		}
	}	
	
	function lookupInChartOfAccounts($coa,$acntID,$fldDesc, &$outErrors){
		if ($acntID == 0){
			$outErrors[] = _(" Acnt Code was not set for. " . $fldDesc);
			return "_Undefined";
		} else if (array_key_exists($acntID,$coa)) {
			return $coa[$acntID];
		} else {
			$outErrors[] = _(" Acnt Code for. " . $fldDesc . " was not in chart of accounts.");
			return "_Undefined";
		}
	}

	function skin_invoice_iif($outData, &$outErrors){
		$chartofaccounts = get_chartofaccounts();
		$outIff = get_IIF_header_rows();
		validate_IIF_header_rows( lookupInChartOfAccounts($chartofaccounts, $outData['invoice_for']['acnt_code_customer'], "acnt_code_customer", $outErrors), $outData['billing_info'], $outErrors);
		$invDateArray = explode("-", $outData['billing_info']["invoice_date"]);
		$invDueDateArray = explode("-", $outData['billing_info']["invoice_due_date"]);
		
		$invType = "";
		if($outData['invoice_total'] >= 0){
			$invType = "INVOICE";
			$outIff .= "TRNS\t" . $outData['transaction_id'] . "\t$invType\t" . $invDateArray[1] . "/" . $invDateArray[2] . "/" . $invDateArray[0] . "\t" . lookupInChartOfAccounts($chartofaccounts, $outData['billing_info']["acnt_new_accounts_receivable"], "acnt_new_accounts_receivable", $outErrors) . "\t" . lookupInChartOfAccounts($chartofaccounts, $outData['invoice_for']['acnt_code_customer'], 'acnt_code_customer', $outErrors) . "\t" . number_format($outData['invoice_total'] ,2, ".", "") . "\t" . $outData['invoice_num'] . "\t" . $outData['memo'] . "\t". $outData['invoice_for']['address1'] ."\t" . $outData['invoice_for']['address2'] . "\t" . $outData['invoice_for']['city'] . " " . $outData['invoice_for']['province'] . "\t\t" . $invDueDateArray[1] . "/" . $invDueDateArray[2] . "/" . $invDueDateArray[0] . "\tVehicle Usage " . month_name($outData['billing_info']['month']) . " " . $outData['billing_info']['year'] . "\t" . $outData['memo'] . "\n";
		} else {
			$invType = "CREDIT MEMO";
			$outIff .= "TRNS\t" . $outData['transaction_id'] . "\t$invType\t" . $invDateArray[1] . "/" . $invDateArray[2] . "/" . $invDateArray[0] . "\t" . lookupInChartOfAccounts($chartofaccounts, $outData['billing_info']["acnt_new_accounts_receivable"], "acnt_new_accounts_receivable", $outErrors) . "\t" . lookupInChartOfAccounts($chartofaccounts, $outData['invoice_for']['acnt_code_customer'], 'acnt_code_customer', $outErrors) . "\t" . number_format($outData['invoice_total'] ,2, ".", "") . "\t" . $outData['invoice_num'] . "\t" . $outData['memo'] . "\t". $outData['invoice_for']['address1'] ."\t" . $outData['invoice_for']['address2'] . "\t" . $outData['invoice_for']['city'] . " " . $outData['invoice_for']['province'] . "\t\t" . $invDueDateArray[1] . "/" . $invDueDateArray[2] . "/" . $invDueDateArray[0] . "\tVehicle Usage " . month_name($outData['billing_info']['month']) . " " . $outData['billing_info']['year'] . "\t" . $outData['memo'] . "\n";
		}
		//done generating header, generate rows 

		$spl = 1;
		foreach ($outData['events_rows'] as $i => $value) {
			//print_r($value);
			if ($value['time_charge'] != 0 || $value['km_charge'] != 0){
				$this->validate_events_row($value, $outErrors);
				/*
				echo "SPL " .$spl;
				echo "adb " .$invType;
				echo lookupInChartOfAccounts($chartofaccounts,$value['acnt_new_code_hours'], 'acnt_new_code_hours', $outErrors);
				echo "num " . number_format($value['time_charge'],2, ".", "");
				echo "aabb " . $value['comment'];
				echo "ccdd " . -$value['hours'];
				echo "eeff " . $value['hour_rate'];
				echo "gghh " . $value['hours_item_name'];
				*/
				$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts,$value['acnt_new_code_hours'], 'acnt_new_code_hours', $outErrors) . "\t\t-" . number_format($value['time_charge'],2, ".", "") . "\t" . $value['comment'] . "\t-" . $value['hours'] . "\t" . $value['hour_rate'] . "\t" . $value['hours_item_name'] . "\n";
				$outIff .= "SPL\t" . ($spl + 1) . "\t$invType\t" . lookupInChartOfAccounts($chartofaccounts,$value['acnt_new_name_km'], 'acnt_new_name_km', $outErrors)   .  "\t\t-" . number_format($value['km_charge'],2, ".", "") .   "\t" . $value['comment'] . "\t-" . $value['distance'] . "\t" . $value['km_rate'] . "\t" . $value['km_item_name'] . "\n";    	
				$spl += 2;
			}
		}

		foreach ($outData['summary_rows'] as $i => $r) {
			if ($r['value'] != 0){
				validate_summary_row($r, $outErrors);
				$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts,$r['acnt_code'], $r['name'], $outErrors) . "\t" . $r['name'] . "\t" . number_format(- $r['value'],2, ".", "") . "\t" . $r['comment'] . "\t\t\t" . $r['item'] . "\n";
				$spl ++;
			}
		}

		validate_summary_row($outData['member_plan_row'], $outErrors);
		$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts,$outData['member_plan_row']['acnt_code'], "member_plan_row", $outErrors) . "\t" . $outData['member_plan_row']['name'] . "\t" . number_format(- $outData['member_plan_row']['value'],2, ".", "") . "\t" . $outData['member_plan_row']['comment'] . "\t\t\t" . $outData['member_plan_row']['item'] . "\n";
		$spl ++;
		
		if ($outData['pst_row']['value'] != 0){
			validate_summary_row($outData['pst_row'], $outErrors);
			$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts,$outData['pst_row']['acnt_code'], "PST row", $outErrors) . "\t" . $outData['pst_row']['name'] . "\t" . number_format(- $outData['pst_row']['value'],2, ".", "") . "\t" . $outData['pst_row']['comment'] . "\t\t\t" . $outData['pst_row']['item'] . "\n";
			$spl ++;
		}

		if ($outData['rental_tax_row']['value'] != 0){
			validate_summary_row($outData['rental_tax_row'], $outErrors);
			$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts,$outData['rental_tax_row']['acnt_code'], "rental tax", $outErrors) . "\t" . $outData['rental_tax_row']['name'] . "\t" . number_format(- $outData['rental_tax_row']['value'],2, ".", "") . "\t" . $outData['rental_tax_row']['comment'] . "\t\t\t" . $outData['rental_tax_row']['item'] . "\n";
			$spl ++;
		}	
		
		if ($outData['gst_row']['value'] != 0){
			validate_summary_row($outData['gst_row'], $outErrors);
			$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts,$outData['gst_row']['acnt_code'], "GST row", $outErrors) . "\t" . $outData['gst_row']['name'] . "\t" . number_format(- $outData['gst_row']['value'],2, ".", "") . "\t" . $outData['gst_row']['comment'] . "\t\t\t" . $outData['gst_row']['item'] . "\n";
			$spl ++;
		}
		
		if ($outData['carbon_offset_row']['value'] != 0){
			validate_summary_row($outData['carbon_offset_row'], $outErrors);
			$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts,$outData['carbon_offset_row']['acnt_code'], "carbon offset", $outErrors) . "\t" . $outData['carbon_offset_row']['name'] . "\t" . number_format(- $outData['carbon_offset_row']['value'],2, ".", "") . "\t" . $outData['carbon_offset_row']['comment'] . "\t\t\t" . $outData['carbon_offset_row']['item'] . "\n";
			$spl ++;
		}

		if ($outData['self_insurace_row']['value'] != 0){
			validate_summary_row($outData['self_insurace_row'], $outErrors);
			$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts, $outData['self_insurace_row']['acnt_code'], "self insurance", $outErrors) . "\t" . $outData['self_insurace_row']['name'] . "\t" . number_format(- $outData['self_insurace_row']['value'],2, ".", "") . "\t" . $outData['self_insurace_row']['comment'] . "\t\t\t" . $outData['self_insurace_row']['item'] . "\n";
			$spl ++;
		}
		
		if ($outData['interest_row']['value'] != 0){
			validate_summary_row($outData['interest_row'], $outErrors);
			$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts, $outData['interest_row']['acnt_code'], "interest", $outErrors) . "\t" . $outData['interest_row']['name'] . "\t" . number_format(- $outData['interest_row']['value'],2, ".", "") . "\t" . $outData['interest_row']['comment'] . "\t\t\t" . $outData['interest_row']['item'] . "\n";
			$spl ++;
		}

	//	if ($outData['long_term_discount_row'] && $outData['long_term_discount_row'] != 0){
	//		validate_summary_row($outData['long_term_discount_row'], $outErrors);
	//		$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts,$outData['long_term_discount_row']['acnt_code'], "long term discount", $outErrors) . "\t" . $outData['long_term_discount_row']['name'] . "\t" . number_format(- $outData['long_term_discount_row']['value'],2, ".", "") . "\t" . $outData['long_term_discount_row']['comment'] . "\t\t\t" . $outData['long_term_discount_row']['item'] . "\n";
	//	    $spl ++;
	//	}

		foreach ($outData['expense_rows'] as $i => $r) {
			validate_summary_row($r, $outErrors);
			$outIff .= "SPL\t$spl\t$invType\t" . lookupInChartOfAccounts($chartofaccounts,$r['acnt_code'], $r["item"], $outErrors) . "\t\t" . number_format(- $r['value'],2, ".", "") . "\t" . $r['comment'] . "\t\t\t" . $r['item'] . "\n";
			$spl ++;
		}				
					
		$outIff .= "ENDTRNS\t\t\t\t\t\t\t\t\t\n";
		
		return $outIff;
	}

	function get_time_charge(
				$plan,
				$numQuarterHoursDay,$numQuarterHoursNight, 
				$numQuarterHoursCancelModDay, $numQuarterHoursCancelModNight, 
				$rateLow, 
				$rateLowCasual,
				$rateHigh, 
				$rateHighCasual,
				$isFlatDailyRate, 
				$dailyRateLow, 
				$dailyRateHigh, 
				$hours_cutoff){
		global $MEMBER_PLANS;
		if ($isFlatDailyRate != 0){
			
			$numdays = ceil($numQuarterHoursDay / 96);
			//echo($numdays);
			$CUTOFF = $hours_cutoff / 24; //number of days until cutoff
			$highDays = (float) ((float) min($numdays, $CUTOFF));
			$lowDays = (float) ((float) max($numdays-$highDays, 0.0));
			$highRateCharge = $highDays * $dailyRateHigh;
			$lowRateCharge = $lowDays * $dailyRateLow;
			//$timeCharge = 0;
			return array( "charge" => round($highRateCharge + $lowRateCharge, 2), "highSlots" => 0, "lowSlots" => 0,
							"highSlotsFromCancel" => 0, "lowSlotsFromCancel" => 0,
							"highDays" => $highDays, "lowDays" => $lowDays);
			//return round($highRateCharge + $lowRateCharge, 2);
		} else {
			$CUTOFF = $hours_cutoff * 4.0; //number of quarter hours until cutoff

			//Only the first $cutoff slots are charged at highRate redistribute high and low slots
			$highSlotsEvnt = min($numQuarterHoursDay, $CUTOFF);
			$lowSlotsEvnt = $numQuarterHoursDay + $numQuarterHoursNight - $highSlotsEvnt;
			
			//do same for cancel and mod slots
			$highSlotsCancelMod = min($CUTOFF - $highSlotsEvnt, $numQuarterHoursCancelModDay);
			$lowSlotsCancelMod = $numQuarterHoursCancelModDay + $numQuarterHoursCancelModNight - $highSlotsCancelMod;
			
			$rh = $rateHigh;
			if ($plan == $MEMBER_PLANS['HIGH']){
				$rh = $rateHighCasual;
			}
			
			$rl = $rateLow;
			if ($plan == $MEMBER_PLANS['HIGH']){
				$rl = $rateHighCasual;
			}
			
			$highRateCharge = (float) ($highSlotsEvnt + $highSlotsCancelMod) * $rh/4.0;
			$lowRateCharge =  (float) ($lowSlotsEvnt + $lowSlotsCancelMod) * $rl /4.0;

			return array( "charge" => round($highRateCharge + $lowRateCharge, 2), 
							"highSlots" => $highSlotsEvnt, 
							"lowSlots" => $lowSlotsEvnt,
							"highSlotsFromCancel" => $highSlotsCancelMod,
							"lowSlotsFromCancel" => $lowSlotsCancelMod,
							"highDays" => 0, "lowDays" => 0);
		}
	} 	
	
	function getMemberPlanInvoiceRow($plan, $billing, $invoicableInfo, &$subtotals){
		global $MEMBER_PLANS;
		$out = $this->createSummaryRow();
		
		if ($invoicableInfo['type'] == 'INDIVIDUAL' || $invoicableInfo['force_user_member_plan']){
			if ($plan == $MEMBER_PLANS['LOW']){
				$out['value'] = $billing['member_plan_low_rate'];
				$out['item'] = "Member plan low usage";
				$out['comment'] = "Member plan low usage";
				$out['acnt_code'] = $billing["acnt_new_member_plan_low"];
			} else if ($plan == $MEMBER_PLANS['MED']) {
				$out['value'] = $billing['member_plan_med_rate'];
				$out['item'] = "Member plan medium usage";
				$out['comment'] = "Member plan medium usage";
				$out['acnt_code'] = $billing["acnt_new_member_plan_med"];
			} else {
				$out['value'] = $billing['member_plan_high_rate'];
				$out['item'] = "Non-member plan usage";
				$out['comment'] = "Non-member plan usage";
				$out['acnt_code'] = $billing["acnt_new_member_plan_high"];
			}	
		} else {
			$out['value'] = $billing['member_plan_organization_rate']; 
			$out['item'] = "Organization usage plan";
			$out['comment'] = "Organization usage plan";
			$out['acnt_code'] = $billing["acnt_new_member_plan_organization"];		
		}
		$out['value'] = round($out['value'], 2);
		$subtotals['pstGstSubtotal'] += $out['value'];
		##$subtotals['expenseTotal'] += $out['value'];
		
		return $out;
	}

	function getCarbonOffsetTaxInvoiceRow($totalDistance, $billing, &$subtotals){
		$out = $this->createSummaryRow();
		$out['value'] =  round( $totalDistance * $billing['carbon_offset_per_km_rate'], 2);
		$out['item'] = "Carbon offset donation";
		$out['comment'] = "Carbon Offset Donation $" . $billing['carbon_offset_per_km_rate'] . " per km";
		$out['acnt_code'] = $billing['acnt_new_carbon_offset'];
		
		//$subtotals['pstGstSubtotal'] += $out['value'];
		$subtotals['expenseTotal'] += $out['value'];

		return $out;	
	}

	function getSelfInsuranceInvoiceRow($totalDistance, $billing, &$subtotals){
		$out = $this->createSummaryRow();
		$out['value'] =  round( $totalDistance * $billing['self_insurance_per_km_rate'], 2);
		$out['item'] = "Self Insurance";
		$out['comment'] = "Self Insurance Donation $" . $billing['self_insurance_per_km_rate'] . " per km";
		$out['acnt_code'] = $billing['acnt_new_self_insurance'];
		
		//$subtotals['pstGstSubtotal'] += $out['value'];
		$subtotals['expenseTotal'] += $out['value'];
		
		return $out;	
	}

	function getGasSurchargeInvoiceRow($totalDistance, $billing, &$subtotals){
		$out = $this->createSummaryRow();
		$out['value'] =  round( $totalDistance * $billing['gas_surcharge_per_km_rate'], 2);
		$out['item'] = "Gas Surcharge";
		$out['comment'] = "Gas Surcharge $" . $billing['gas_surcharge_per_km_rate'] . " per km";
		$out['acnt_code'] = $billing['acnt_new_gas_surcharge'];
		
		$subtotals['pstGstSubtotal'] += $out['value'];
		//$subtotals['gstSubtotal'] += $out['value'];
		
		return $out;	
	}

	function getPSTInvoiceRow($totalDistance, $billing, &$subtotals){
		$out = $this->createSummaryRow();
		$out['value'] =  round($subtotals['pstGstSubtotal'] * $billing['pst'],2);
		$out['item'] = "PST (BC)";
		$out['comment'] = "PST (BC)";
		$out['name'] = "Ministry of Finance (BC)";
		$out['acnt_code'] = $billing['acnt_new_code_pst'];
		
		$subtotals['pstTotal'] = $out['value'];
		
		return $out;	
	}

	function getGSTInvoiceRow($totalDistance, $billing, &$subtotals){
		$out = $this->createSummaryRow();
		$out['value'] =  round($subtotals['pstGstSubtotal'] * $billing['gst'],2);
		$out['item'] = "GST";
		$out['comment'] = "GST";
		$out['name'] = "Receiver General";
		$out['acnt_code'] = $billing['acnt_new_code_gst'];
		
		$subtotals['gstTotal'] = $out['value'];
		
		return $out;	
	}

	function getInterestInvoiceRow($previousOwing, $paymentsMade, $billing, &$subtotals){
		$interest_owed = 0.0;
		
		if ($previousOwing - $paymentsMade > $billing['dont_charge_interest_below']){
			$interest_owed = round(($previousOwing - $paymentsMade) * ($billing['late_payment_interest']), 2); 
		}
		$out = $this->createSummaryRow();
		$out['value'] =  $interest_owed;
		$out['item'] = "interest";
		$out['comment'] = "Interest on previous owing over $" . $billing['dont_charge_interest_below'] . " (previous owing=$" . $previousOwing . " - payments=$" . $paymentsMade . ") x " . $billing['late_payment_interest'];
		$out['name'] = "";
		$out['acnt_code'] = $billing['acnt_new_interest_charged'];
		
		$subtotals['expenseTotal'] += $out['value'];
		
		return $out;		
	}

	function getLongTermDiscountRow($billing, $invoicableInfo, $userrow, $query_year, $invoicable_id, &$subtotals){ 
	  $joinedStamp = strtotime($userrow['activated']);
	  $eoyStamp = mktime( 0,   0, 0, 1,     1, $query_year+1);
	  $out = 0;
	  if ($billing['long_term_discount_year'] != 0 && $invoicableInfo['type'] == 'INDIVIDUAL'){
		  if ($eoyStamp - $joinedStamp > 60*60*24*730){
			  $tempsubtotals = Array();
				initializeSubtotals($tempsubtotals);
				for($i = 1; $i <= 12; $i++){
					$query_month = $i;
					$month_billing = get_billing_object($query_year,$query_month);
					$startstamp = mktime( 0,   0, 0, $query_month,     1, $query_year);
					$endstamp =   mktime(23, 59, 59, $query_month + 1, 0, $query_year);
					$totalDistance = get_total_distance($startstamp,$endstamp,$invoicable_id);		
					$plan = $this->get_plan($totalDistance, $billing, $invoicable_id);
					$result = get_user_car_month_usage($startstamp,$endstamp,$invoicable_id);
			
					$eventsRows = Array();
					while($row = $result->FetchRow($result)) {
						$eventsRows[] = $this->getBookingInvoiceRow($totalDistance, $month_billing, $row, $plan, $tempsubtotals);
					}
				}
				$dis = $tempsubtotals['pstGstSubtotal'] * $billing['long_time_member_discount_percent'];
				if  ($dis > $billing['long_time_member_discount_max']){
					$dis = $billing['long_time_member_discount_max'];
				}
				$out = $this->createSummaryRow();
				$out['value'] =  -round($dis,2);
				$out['item'] = "Long Term Member Discount";
				$out['comment'] = "Discount for long term members in co-op for more than 2 years (less of " . $billing['long_time_member_discount_percent'] . " annual usage or " . $billing['long_time_member_discount_max'] . ")";
				$out['name'] = "";
				$out['acnt_code'] = $billing['acnt_new_long_term_member_discount'];
				
				$subtotals['expenseTotal'] += $out['value'];
			}
		}
		return $out;
	}	

	function getRentalTaxRow($eventsRows, $billing, &$subtotals){
		global $CANCELED;
		$numDays = 0;
		foreach ($eventsRows as $i => $value){
			if ($value['admin_ignore_this_booking'] == 0 && $value['admin_ignore_km_hours'] == 0 && $value['canceled'] == $CANCELED['NORMAL']){		
				//Note that midnight is considerd by the comuper to be the FIRST second of the next day
				//We subtract one second from the time stamp so that midnight gets bumped to the correct day. 
				$startstamp = strtotime($value['start_time']) - 1; 
				$endstamp = strtotime($value['end_time']) - 1;
				$numHours = ($endstamp - $startstamp)/(60 * 60); //don't use the hours because they may include hours canceled in window
				
				if ($numHours > 8 && $value['charge_bc_rental_tax'] != 0){
					$start_parse = getdate($startstamp);
					$end_parse = getdate($endstamp);
					//echo ( $end_parse['mday'] . " " . $start_parse['mday'] . " ");
					$numDays += ceil((mktime(0, 0, 0, $end_parse['mon'], $end_parse['mday'], $end_parse['year']) - mktime(0, 0, 0, $start_parse['mon'], $start_parse['mday'], $start_parse['year'])) / 86400);
					//echo("'" . $numDays . "'<br/><br/>");
					$numDays += 1; //number of days that tax applies to.
				}
			}	
		}
		
		$taxVal = round($billing['rental_tax_per_day'] * ($numDays), 2);
		
		$out = $this->createSummaryRow();
		$out['value'] =  $taxVal;
		$out['item'] = "BC Rental Tax";
		$out['comment'] = "BC Rental Tax \$" . $billing['rental_tax_per_day'] . "/day ($numDays days with bookings longer than 8 hours)";
		$out['name'] = "Ministry of Finance (BC)";
		$out['acnt_code'] = $billing['acnt_new_rental_tax'];
		
		$subtotals['pstGstSubtotal'] += $out['value'];
		
		return $out;		
	}

	function getBookingInvoiceRow($totalDistance, $billing, $row, $plan, &$subtotals){
			global $CANCELED, $INVOICE_TEXT;	
			$startStr = "";
			$endStr = "";

			$startStr = formatted_time_string($row['starttime'], $row['eventtype']);
			$date_str = formatted_date_string($row['year'], $row['month'],
					$row['day'], $row['end_year'], $row['end_month'],
					$row['end_day'], $row['hour'], $row['minute']);
		
			$endStr = formatted_time_string($row['endtime'], $row['eventtype']);
			$end_date_str = formatted_date_string($row['end_year'], $row['end_month'],
					$row['end_day'], $row['end_year'], $row['end_month'],
					$row['end_day'], $row['end_hour'], $row['end_minute']);
					
			$startStr .= " " . $date_str;
			$endStr .= " " . $end_date_str;

			$startstamp = strtotime($row['starttime']);
			$endstamp = strtotime($row['endtime']);		
			if ($row['canceled'] == $CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']){
				$numQuarterHourIntervals = 0;			
			} else {			
				$numQuarterHourIntervals = ($endstamp - $startstamp)/(60*15);
			}
			
			$dayRateStartsHour = $billing['day_rate_start_hour'];
			$dayRateEndsHour = $billing['day_rate_end_hour'];
			$firstSlot = $row['hour'] * 4 + $row['minute'] / 15;
			$switchToNightRateSlot = $dayRateEndsHour * 4;
			$switchToDayRateSlot = $dayRateStartsHour * 4;
			$nightRateDurationInSlots = ($dayRateEndsHour - $dayRateStartsHour) * 4;
			$numDaySlots = 0;
			$numNightSlots = 0;
			for ($i = 0; $i < $numQuarterHourIntervals; $i++){
				$ss = ($firstSlot + $i) % (24 * 4);
				if ($ss < $switchToDayRateSlot)
				{
					$numNightSlots++;
				}
				else if ($ss >= $switchToNightRateSlot)
				{
					$numNightSlots++;
				} else
				{
					$numDaySlots++;
				}
			}
			
			$numExtraQuarterHoursFromCancelAndMod = getNumExtraQuarterHourIntervalsFromCancelAndModifications($row['eventid'], $row['canceled'], $startstamp, $endstamp, $dayRateStartsHour, $dayRateEndsHour);
			//$numDaySlots += $numExtraQuarterHoursFromCancelAndMod['day'];
			//$numNightSlots += $numExtraQuarterHoursFromCancelAndMod['night'];
			$myState = "";
			if ($row['admin_ignore_this_booking'] == 1){
				$timeCharge = array( "charge" => 0, "highSlots" => 0, "lowSlots" => 0 , "highSlotsFromCancel" => 0, "lowSlotsFromCancel" => 0, "highDays" => 0, "lowDays" => 0);
				$kmCharge = 0;
				$kmRate = 0;
				$myState .= " TRIP DISCOUNTED " . $row['admin_comment'];
				
			} else if ($row['admin_ignore_km_hours'] == 1){
				$timeCharge = array( "charge" => 0, "highSlots" => 0, "lowSlots" => 0 , "highSlotsFromCancel" => 0, "lowSlotsFromCancel" => 0, "highDays" => 0, "lowDays" => 0);
				$kmCharge = 0;
				$kmRate = 0;
				$myState .= " HOURS & KM DISCOUNTED " . $row['admin_comment'];			 
			} else {
				//note that user is charged a max of $cutoff at high rate. This will redistribute the slots so only a max of 8 is charged at high
			
				$timeCharge = $this->get_time_charge($plan,
											$numDaySlots, $numNightSlots, 
											$numExtraQuarterHoursFromCancelAndMod['day'], 
											$numExtraQuarterHoursFromCancelAndMod['night'],
											$row['hourly_rate_low'], 
											$row['hourly_rate_low_casual'],
											$row['hourly_rate_high'],
											$row['hourly_rate_high_casual'],
											$row['is_flat_daily_rate'], 
											$row['daily_rate_low'], 
											$row['daily_rate'], 
											$row['rate_cutoff']);
				$kmRate = get_km_rate($plan, $row['km_rate_low'], $row['km_rate_med'], $row['km_rate_high']);		
				$kmCharge = round( $kmRate * $row['distance'], 2);
			}	
			
			
			if ($row['canceled'] == $CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']){
				$myState = " (was canceled within 2 day window)";
			}
			
			if ($row['bookablevehicle_id'] == $row['vehicle_used_id']){
				$event_note = $row['name'];
			} else {
				
				$bookableVehicleName = quick_query("select name from " . SQL_PREFIX . "vehicles where id=" . $row['bookablevehicle_id'], "name");
				$event_note = $row['name'] . " (booked as $bookableVehicleName) ";
			}
			

			$event_note .= " from " . $startStr . " to " . $endStr . $myState;
			
			if ($row['is_flat_daily_rate'] == 0){
				$timeHighTotal = ($timeCharge['highSlots'] + $timeCharge['highSlotsFromCancel'])/4;
				$timeLowTotal = ($timeCharge['lowSlots'] + $timeCharge['lowSlotsFromCancel'])/4;
				$timeHigh = ($timeCharge['highSlots']/4);
				$timeLow = ($timeCharge['lowSlots']/4);
				$event_hours = " high " . number_format($timeHighTotal,2,'.','') . "h low " . 
									number_format($timeLowTotal,2,'.','') . "h ";
				$event_note .= " high-rate " . number_format($timeHigh,2,'.','') . "h low-rate " . number_format($timeLow,2,'.','') . "h ";
			} else {
				$event_note .= " " . number_format($timeCharge['highDays'],2,'.','') . " high days, " . number_format($timeCharge['lowDays'],2,'.','') . " low days";
				$event_hours = " high " . number_format($timeCharge['highDays'],2,'.','') . "d low " . number_format($timeCharge['lowDays'],2,'.','') . "d";
			}
			
			if ($numExtraQuarterHoursFromCancelAndMod['total'] > 0) {
				
				$event_note .= " canceled-high " . $timeCharge['highSlotsFromCancel']/4 . "h canceled-low-rate " . $timeCharge['lowSlotsFromCancel']/4 . "h";
			}
			$accntNameHours = $row['acnt_new_code_hours'];
			
			$accntNameKM =    $row['acnt_new_code_km'];
			
			$subtotals['pstGstSubtotal'] += $kmCharge + $timeCharge['charge'];
			//$subtotals['gstSubtotal'] += $kmCharge + $timeCharge;
			
			if (array_key_exists('uid',$row)){
				$userDisplayName = quick_query("select displayname from " . SQL_PREFIX . "users where id=" . $row['uid'], "displayname");
			} else {
				$userDisplayName = "";
			}
			
			$event_note  = $userDisplayName . " " . $event_note;

			$out = Array( 		   "displayname" => $userDisplayName,
								   "comment" => $event_note,
								   "acnt_new_code_hours" => $accntNameHours,
								   "acnt_new_name_km" => $accntNameKM,
								   "time_charge" => $timeCharge['charge'],
								   "km_charge" => $kmCharge,
								   "hours" => $event_hours,
								   "distance" => $row['distance'],
								   "canceled" => $row['canceled'],
								   "hours_item_name" => $INVOICE_TEXT['hours_item_name'],
								   "km_item_name" =>    $INVOICE_TEXT['km_item_name'],
								   "hour_rate" =>    $row['hourly_rate_high'], // . " (" . $row['hourly_rate_low'] . ")"
								   "km_rate" => $kmRate,
								   "start_time" => $row['starttime'],
								   "end_time" => $row['endtime'],
								   "admin_ignore_this_booking" => $row['admin_ignore_this_booking'],
								   "admin_ignore_km_hours" => $row['admin_ignore_km_hours'],
								   "charge_bc_rental_tax" => $row['charge_bc_rental_tax'],
								   "name" => "");
			return $out;	
	}

	function initializeSubtotals(&$subtotals){
		$subtotals['pstGstSubtotal'] = 0.0;
		$subtotals['pstTotal'] = 0.0;
		
		//$subtotals['gstSubtotal'] = 0.0;
		$subtotals['gstTotal'] = 0.0;
		
		$subtotals['expenseTotal'] = 0.0;
	}

	function getHTMLLogoRow(){
		global $ORGANIZATION_NAME, $INVOICE_ADDRESS, $ADMIN_EMAIL;
		return tag("div", attributes("align='center'"),
				tag( "font", attributes("size='+2'"), "<b>$ORGANIZATION_NAME</b><br/>"),
				"$INVOICE_ADDRESS &nbsp;&nbsp; $ADMIN_EMAIL<br/><br/>"
			);
	}


	function getHTMLInvoiceHeader($userrow, $billing, $invoiceNumber){
			$timestamp = strtotime( $billing['invoice_date'] );
			$invoiceDateStr = date("M j, Y",$timestamp);

			$dueDateTimestamp = strtotime( $billing['invoice_due_date'] );
			$dueDateStr = date("M j, Y",$dueDateTimestamp);
			$out = 	tag('table', attributes("border='0' cellpadding='0' cellspacing='0' width='100%'"),
						tag("tr",
							tag("td",
								  tag('table', attributes("border='0' cellspacing='0' cellpadding='1' bgcolor='#000000'"), tag("tr", tag("td",
									  tag('table', attributes("border='0' cellpadding='3' cellspacing='0' bgcolor='#FFFFFF'"), 
												tag('tr',
													tag('td', attributes("bgcolor='#666666' width='70%'"), "<font color='#000000' align='center'><b>Invoice To</b></font>")	
												),
												tag('tr',
													tag('td', 
														$userrow['displayname'] . "<br/>",
														$userrow['address1'] . "<br/>",
														$userrow['address2'] . "<br/>",
														$userrow['city'] . " " . $userrow['province'] . "<br/>",
														$userrow['postalcode']
													)	
												)				  			
										)
									)))
							),
							tag("td",attributes("align='right' valign='top' width='15%'"),
							
									tag('table', attributes("border='0' cellspacing='0' cellpadding='1' bgcolor='#000000'"), tag("tr", tag("td",
									  tag('table', attributes("border='0' cellpadding='3' cellspacing='0' bgcolor='#000000'"), 
												tag('tr',
													tag('td', attributes("bgcolor='#666666'"), "<font color='#FFFFFF'><b>Invoice Number</b></font>")	
												),
												tag('tr',
													tag('td', 
														$invoiceNumber
													)	
												)				  			
										)
									))),
							tag("td",attributes("align='right' valign='top' width='15%'"),	  	
									tag('table', attributes("border='0' cellspacing='0' cellpadding='1' bgcolor='#FFFFFF'"), tag("tr", tag("td",
													  tag('table', attributes("border='0' cellpadding='3' cellspacing='0' bgcolor='#FFFFFF'"), 
																tag('tr',
																	tag('td', attributes("bgcolor='#666666'"), "<font color='#000000'><b>Invoice Date</b></font>")	
																),
																tag('tr',
																	tag('td', 
																		$invoiceDateStr
																	)	
																),
																tag('tr',
																	tag('td', attributes("bgcolor='#666666'"), "<font color='#000000'><b>Invoice Due By</b></font>")	
																),
																tag('tr',
																	tag('td', 
																		$dueDateStr
																	)	
																)												  							  			
														)
													)))							  	
								)
							)
						)
					);
		return $out;
	}

	function validate_IIF_header_rows($accountingName, $billing, &$outErrors){
		if ($billing["invoice_date"] == ""){
			$outErrors[] = _(" Invoice Date cannot be blank.");
		}	

		if ($accountingName == ""){
			$outErrors[] = _(" Accounting Name cannot be blank.");
		}	
	}

	function validate_events_row($value, &$outErrors){
		if ($value['acnt_new_code_hours'] == "" || strpos($value['acnt_new_code_hours'], 'Undefined') !== FALSE){
			$outErrors[] = _(" Acnt Code Hours cannot be blank.");
		}
		if ($value['acnt_new_name_km'] == ""){
			$outErrors[] = _(" Acnt Code Km cannot be blank.");
		}
	}

	function validate_summary_row($r, &$outErrors){
		//if (!isset($r['name'])){
		//	$outErrors[] = " No name field in summary ros. " )), tag("br") );				
		//}
		if ($r['acnt_code'] == "" || strpos($r['acnt_code'], 'Undefined') !== FALSE ){  
			$outErrors[] = _(" Acnt Code in summary row cannot be blank. " . $r['comment']);		
		}

		if ($r['item'] == ""){ 
			$outErrors[] = _(" Item in summary row cannot be blank. " . $r['comment']);				
		}
	}
}
?>
