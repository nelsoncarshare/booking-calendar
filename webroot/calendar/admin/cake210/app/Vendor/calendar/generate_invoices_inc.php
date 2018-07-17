<?php

if ( !defined('IN_PHPC') ) {
       die("Hacking attempt");
}

function get_chartofaccounts(){
	global $db;
	$query = "select * from " .SQL_PREFIX. "chartofaccounts";
	
	$result = $db->Execute($query)
                or db_error("error get_invoicable_name", $query);
	
	$res = Array();
	if ($row1 = $result->FetchRow()) {
		for (; $row1; $row1 = $result->FetchRow()) {
			$res[$row1['id']] = $row1['account'];
		}
	}
	return $res;
}

function get_invoicable_name($invoicable_id){
	global $db;
	$query= "SELECT ".SQL_PREFIX."invoicables.id ".
	             ", ".SQL_PREFIX."grouptypes.type as type".
	             ", ".SQL_PREFIX."users.displayname ".
	             ", ".SQL_PREFIX."groups.grp_displayname ".
	         "FROM ".SQL_PREFIX."invoicables ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."users on user_id=".SQL_PREFIX."users.id ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."groups on ".SQL_PREFIX."invoicables.group_id=".SQL_PREFIX."groups.id ".
	         "INNER JOIN ".SQL_PREFIX."grouptypes on ".SQL_PREFIX."invoicables.type=".SQL_PREFIX."grouptypes.id ".
	         "WHERE ".SQL_PREFIX."invoicables.id='$invoicable_id' ";
		$result = $db->Execute($query)
                or db_error("error get_invoicable_name", $query);
     $row = $result->FetchRow();
     if ($row['type'] == 'INDIVIDUAL'){
     	return $row['displayname'];
     } else {
    	return $row['grp_displayname'];
     }
}

function get_invoicable_info($invoicable_id){
	global $db; 
	$query= "SELECT ".SQL_PREFIX."invoicables.id ".
	             ", ".SQL_PREFIX."invoicables.user_id ".
	             ", ".SQL_PREFIX."invoicables.group_id ".
	             ", ".SQL_PREFIX."invoicables.force_user_member_plan ".
				 ", ".SQL_PREFIX."invoicables.is_member ".
	             ", ".SQL_PREFIX."grouptypes.type as type".
	             ", ".SQL_PREFIX."users.displayname ".
	             ", ".SQL_PREFIX."users.disabled ".
	             ", ".SQL_PREFIX."groups.grp_displayname ".
	             ", ".SQL_PREFIX."groups.disabled as grp_disabled ".
	             ", ".SQL_PREFIX."groups.email as grp_email ".
	             ", ".SQL_PREFIX."users.email as email ".	             
	         "FROM ".SQL_PREFIX."invoicables ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."users on user_id=".SQL_PREFIX."users.id ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."groups on ".SQL_PREFIX."invoicables.group_id=".SQL_PREFIX."groups.id ".
	         "INNER JOIN ".SQL_PREFIX."grouptypes on ".SQL_PREFIX."invoicables.type=".SQL_PREFIX."grouptypes.id ".
	         "WHERE ".SQL_PREFIX."invoicables.id='$invoicable_id'";	
	$result = $db->Execute($query)
             or db_error("error get_invoicable_info", $query);
    return $result->FetchRow($result);
}

function get_invoicable_users_and_groups(){
	global $db;
	
	$query= "SELECT ".SQL_PREFIX."invoicables.id ".
	             ", ".SQL_PREFIX."invoicables.user_id ".
	             ", ".SQL_PREFIX."invoicables.group_id ".
	             ", ".SQL_PREFIX."grouptypes.type as type".
	             ", ".SQL_PREFIX."users.displayname ".
	             ", ".SQL_PREFIX."users.disabled ".
	             ", ".SQL_PREFIX."groups.grp_displayname ".
	             ", ".SQL_PREFIX."groups.disabled as grp_disabled ".
	         "FROM ".SQL_PREFIX."invoicables ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."users on user_id=".SQL_PREFIX."users.id ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."groups on ".SQL_PREFIX."invoicables.group_id=".SQL_PREFIX."groups.id ".
	         "INNER JOIN ".SQL_PREFIX."grouptypes on ".SQL_PREFIX."invoicables.type=".SQL_PREFIX."grouptypes.id ".
	         "WHERE ((".SQL_PREFIX."grouptypes.type='INDIVIDUAL' and ".SQL_PREFIX."users.disabled=0 and ".SQL_PREFIX."users.group_id=1) ".
	         "OR (".SQL_PREFIX."grouptypes.type<>'INDIVIDUAL' and ".SQL_PREFIX."groups.disabled=0 and ".SQL_PREFIX."groups.id<>1))".
	         "ORDER BY type, displayname, grp_displayname ";

	//echo($query);
	$result = $db->Execute($query)
                or db_error("error get_invoicable_users_and_groups", $query);

	$users = array();
	if ($row1 = $result->FetchRow()) {
		for (; $row1; $row1 = $result->FetchRow()) {
			if ($row1['type'] == 'INDIVIDUAL'){
				$users[$row1['id']] = $row1['displayname'];	
			} else {
				$users[$row1['id']] = $row1['grp_displayname'];
			}		
		}
	}	
	
	return $users;
}

function get_user_car_month_usage($startstamp,$endstamp,$invoicable_id)
{
	global $calendar_name, $db, $CANCELED;
	
	$query = "SELECT * from ".SQL_PREFIX."invoicables INNER JOIN ".SQL_PREFIX."grouptypes ON ".SQL_PREFIX."invoicables.type=".SQL_PREFIX."grouptypes.id WHERE ".SQL_PREFIX."invoicables.id=$invoicable_id";
	//echo($query);
	$result = $db->Execute($query)
		or db_error(_('Error in get_user_car_month_usage'), $query);
	$myrow = $result->FetchRow();	
	
    $dbstartdatetime = $db->SQLDate('Y-m-d-H-i', 'starttime');
    $mystartdatetime = "'" . date('Y-m-d-H-i', $startstamp). "'";
    $myenddatetime = "'" . date('Y-m-d-H-i', $endstamp). "'";
    
    $events_table = SQL_PREFIX . 'events';
    
    if ($myrow['type'] == 'INDIVIDUAL'){
		$query = 'SELECT '.SQL_PREFIX.'events.id as eventid, endkm-startkm as distance, '.SQL_PREFIX.'vehicles.name as name, '.SQL_PREFIX.'bookables.name as bookablename, '.SQL_PREFIX.'bookables.vehicle_id as bookablevehicle_id, '.SQL_PREFIX.'events.*, '.SQL_PREFIX.'bookables.*, '.SQL_PREFIX.'vehicles.*, '.SQL_PREFIX.'users.*, '	
			.$db->SQLDate('Y', "$events_table.starttime")." AS year,\n"
			.$db->SQLDate('m', "$events_table.starttime")." AS month,\n"
			.$db->SQLDate('d', "$events_table.starttime")." AS day,\n"
			.$db->SQLDate('H', "$events_table.starttime")." AS hour,\n"
			.$db->SQLDate('i', "$events_table.starttime")." AS minute,\n"
			.$db->SQLDate('Y', "$events_table.endtime")." AS end_year,\n"
			.$db->SQLDate('m', "$events_table.endtime")." AS end_month,\n"
			.$db->SQLDate('d', "$events_table.endtime")." AS end_day,\n"
			.$db->SQLDate('H', "$events_table.endtime")." AS end_hour,\n"
			.$db->SQLDate('i', "$events_table.endtime")." AS end_minute\n"
			.' FROM '.SQL_PREFIX."events\n"
			.'INNER JOIN '.SQL_PREFIX."bookables ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."events.bookableobject "
			."INNER JOIN ".SQL_PREFIX."vehicles ON ".SQL_PREFIX."vehicles.id = ".SQL_PREFIX."events.vehicle_used_id\n"
			."INNER JOIN ".SQL_PREFIX."users ON ".SQL_PREFIX."users.id = ".SQL_PREFIX."events.uid\n"
			."WHERE ($mystartdatetime <= $dbstartdatetime AND $myenddatetime >= $dbstartdatetime)\n"
			."AND ".SQL_PREFIX."users.id = '".$myrow['user_id']."'\n"
			."AND (canceled = '".$CANCELED['NORMAL']."' OR canceled = '".$CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']."')\n"
			//."AND ".SQL_PREFIX."events.admin_ignore_this_booking <> 1 \n"
			." ORDER BY starttime\n";
	} else {
		$query = 'SELECT '.SQL_PREFIX.'events.id as eventid, endkm-startkm as distance, '.SQL_PREFIX.'vehicles.name as name, '.SQL_PREFIX.'bookables.name as bookablename, '.SQL_PREFIX.'bookables.vehicle_id as bookablevehicle_id, '.SQL_PREFIX.'events.*, '.SQL_PREFIX.'bookables.*, '.SQL_PREFIX.'vehicles.*, '.SQL_PREFIX.'users.*, '	
			.$db->SQLDate('Y', "$events_table.starttime")." AS year,\n"
			.$db->SQLDate('m', "$events_table.starttime")." AS month,\n"
			.$db->SQLDate('d', "$events_table.starttime")." AS day,\n"
			.$db->SQLDate('H', "$events_table.starttime")." AS hour,\n"
			.$db->SQLDate('i', "$events_table.starttime")." AS minute,\n"
			.$db->SQLDate('Y', "$events_table.endtime")." AS end_year,\n"
			.$db->SQLDate('m', "$events_table.endtime")." AS end_month,\n"
			.$db->SQLDate('d', "$events_table.endtime")." AS end_day,\n"
			.$db->SQLDate('H', "$events_table.endtime")." AS end_hour,\n"
			.$db->SQLDate('i', "$events_table.endtime")." AS end_minute\n"
			.' FROM '.SQL_PREFIX."events\n"
			.'INNER JOIN '.SQL_PREFIX."bookables ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."events.bookableobject "
			."INNER JOIN ".SQL_PREFIX."vehicles ON ".SQL_PREFIX."vehicles.id = ".SQL_PREFIX."events.vehicle_used_id\n"
			."INNER JOIN ".SQL_PREFIX."users ON ".SQL_PREFIX."users.id = ".SQL_PREFIX."events.uid\n"
			."INNER JOIN ".SQL_PREFIX."groups ON ".SQL_PREFIX."groups.id = ".SQL_PREFIX."users.group_id\n"
			."WHERE ($mystartdatetime <= $dbstartdatetime AND $myenddatetime >= $dbstartdatetime)\n"
			."AND ".SQL_PREFIX."users.group_id = '".$myrow['group_id']."'\n"
			."AND (canceled = '".$CANCELED['NORMAL']."' OR canceled = '".$CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']."')\n"
			//."AND ".SQL_PREFIX."events.admin_ignore_this_booking <> 1 \n"
			." ORDER BY displayname, starttime\n";		
	}
    //echo($query);
	$result = $db->Execute($query)
		or db_error(_('Error in get_user_car_month_usage'), $query);

	return $result;
}

function get_extra_invoice_rows($invoicable_id, $billingid, $whereClause){
	global $db;
	
	$query = "Select * from " . SQL_PREFIX . "invoiceextraitems where billing_id=" . $billingid . " and invoicable_id=" . $invoicable_id . " and (" . $whereClause . ")";
		
	$result = $db->Execute($query)
		or db_error(_('Error in get_extra_invoice_rows'), $query);

	return $result;
}



function get_user_or_group($invoicableid){
	global $db;
	
	$query = "SELECT * from ".SQL_PREFIX."invoicables INNER JOIN ".SQL_PREFIX."grouptypes ON ".SQL_PREFIX."invoicables.type=".SQL_PREFIX."grouptypes.id WHERE ".SQL_PREFIX."invoicables.id=$invoicableid";
	$result = $db->Execute($query)
		or db_error(_('Error in get_user'), $query);
	$myrow = $result->FetchRow();
	
	if ($myrow['type'] == 'INDIVIDUAL'){
		$query = "Select * from " . SQL_PREFIX . "users where id=" . $myrow['user_id'];
	} else {
		$query = "Select acnt_code_group_customer as acnt_code_customer, grp_displayname as displayname, " . SQL_PREFIX . "groups.* from " . SQL_PREFIX . "groups where id=" . $myrow['group_id'];
	}
	
	$result = $db->Execute($query)
		or db_error(_('Error in get_user'), $query);

	return $result->FetchRow($result);
}

 function get_total_distance($startstamp,$endstamp,$invoicable_id)
{
	global $calendar_name, $db, $CANCELED;
	
	$query = "SELECT * from ".SQL_PREFIX."invoicables INNER JOIN ".SQL_PREFIX."grouptypes ON ".SQL_PREFIX."invoicables.type=".SQL_PREFIX."grouptypes.id WHERE ".SQL_PREFIX."invoicables.id=$invoicable_id";
	//echo($query);
	$result = $db->Execute($query)
		or db_error(_('Error in get_total_distance'), $query);
	$myrow = $result->FetchRow();
	
    $dbstartdatetime = $db->SQLDate('Y-m-d-H-i', 'starttime');
    $mystartdatetime = "'" . date('Y-m-d-H-i', $startstamp). "'";
    $myenddatetime = "'" . date('Y-m-d-H-i', $endstamp). "'";
    
    $events_table = SQL_PREFIX . 'events';
    
    if ($myrow['type'] == 'INDIVIDUAL'){
		$query = 'SELECT sum(endkm - startkm) AS totalDistance'	
			.' FROM '.SQL_PREFIX."events\n"
			."INNER JOIN ".SQL_PREFIX."users ON ".SQL_PREFIX."users.id = ".SQL_PREFIX."events.uid\n"
			."WHERE ($mystartdatetime <= $dbstartdatetime AND $myenddatetime >= $dbstartdatetime)\n"
			."AND ".SQL_PREFIX."users.id = '".$myrow['user_id']."'\n"
			."AND (canceled = '".$CANCELED['NORMAL']."' OR canceled = '".$CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']."')\n"
			."AND (".SQL_PREFIX."events.admin_ignore_this_booking = 0 AND ".SQL_PREFIX."events.admin_ignore_km_hours = 0)\n"
			."GROUP BY ".SQL_PREFIX."users.id \n";
	} else { //query by group
		$query = 'SELECT sum(endkm - startkm) AS totalDistance'	
			.' FROM '.SQL_PREFIX."events\n"
			."INNER JOIN ".SQL_PREFIX."users ON ".SQL_PREFIX."users.id = ".SQL_PREFIX."events.uid\n"
			."INNER JOIN ".SQL_PREFIX."groups ON ".SQL_PREFIX."groups.id = ".SQL_PREFIX."users.group_id\n"
			."WHERE ($mystartdatetime <= $dbstartdatetime AND $myenddatetime >= $dbstartdatetime)\n"
			."AND ".SQL_PREFIX."groups.id = '".$myrow['group_id']."'\n"
			."AND (canceled = '".$CANCELED['NORMAL']."' OR canceled = '".$CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']."')\n"
			."AND (".SQL_PREFIX."events.admin_ignore_this_booking = 0 AND ".SQL_PREFIX."events.admin_ignore_km_hours = 0)\n"
			."GROUP BY ".SQL_PREFIX."groups.id \n";		
	}
    //echo($query);
	$result = $db->Execute($query)
		or db_error(_('Error in get_total_distance'), $query);

	$myrow = $result->FetchRow();
	return $myrow['totalDistance'];
}

function get_billing_object($year,$month){
	global $db;
	
	$query = 'SELECT * '	
		.' FROM '.SQL_PREFIX."billings\n"
		."WHERE year='$year'\n"
		."AND month='$month'\n";

	$result = $db->Execute($query)
		or db_error(_('Error in get_billing_object'), $query);

	if ($row = $result->FetchRow($result)){
		return $row;
	}	
	return NULL;	
}
//TODO remove $userid once all instances of this function have been updated
function get_invoice($userid,$invoicable_id,$billing_id){
	global $db;
	
	$query = 'SELECT * '	
		.' FROM '.SQL_PREFIX."invoices\n"
		."WHERE invoicable_id='$invoicable_id'\n"
		."AND billing_id='$billing_id'\n";
    //echo($query);
	$result = $db->Execute($query)
		or db_error(_('Error in get_invoice'), $query);

	if ($row = $result->FetchRow($result)){
		return $row;
	} else {
		return NULL;
	}
}

function get_invoice_file_name( $month, $year, $username){
	$new_string = preg_replace("/[^a-zA-Z0-9s]/", "-", $username);

	return "invoice-" . $new_string . "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . $year;

}	

function get_IIF_header_rows(){
	$myText = "!TRNS	TRNSID	TRNSTYPE	DATE	ACCNT	NAME	AMOUNT	DOCNUM	MEMO	ADDR1	ADDR2	ADDR3	ADDR4	DUEDATE	INVTITLE	INVMEMO\n";
	$myText .= "!SPL	SPLID	TRNSTYPE	ACCNT	NAME	AMOUNT	MEMO	QNTY	PRICE	INVITEM\n";
	$myText .= "!ENDTRNS\t\t\t\t\t\t\t\t\t\n";
	return $myText;
}

function update_invoice($invid, $fieldName, $value){
	global $db;
	
 	$query = "UPDATE ". SQL_PREFIX . 'invoices'. " \n"
			."SET "
			."$fieldName='$value'\n"
			."WHERE id='$invid'";

	$result = $db->Execute($query);

	if(!$result) {
		db_error(_('Error processing event'), $query);
	}		
	 
	return 0;
}

function get_prev_owing($invoicable_id, $billing_id){
	//get the year month from the current billing
	$year = quick_query("select year from " . SQL_PREFIX . "billings where id=".$billing_id, "year");
	$month = quick_query("select month from " . SQL_PREFIX . "billings where id=".$billing_id, "month");
	if ($month == 1) {
		$month = 12;
		$year -= 1;
	} else {
		$month -= 1;
		$year  -= 1;
	}
	$old_billing_id = quick_query("select id from " . SQL_PREFIX . "billings where year=".$year." and month=".$month, "id");
	if ($old_billing_id == ""){
		$prev_owing = "";
	} else {
		$prev_owing = quick_query("select amt_owing from " . SQL_PREFIX . "invoices where invoicable_id=".$invoicable_id." and billing_id=".$old_billing_id, "amt_owing");
	}
	if ($prev_owing == ""){
		return 0.0;
	} else {
		return $prev_owing;
	}
}

function prev_owing_submit(&$outMsg,$prev_owing,$payment_made,$invoicable_id,$billing_id){
		global $db;
	 	
  		if (!is_numeric($prev_owing)){
	       $outMsg->add( tag("strong",attributes('style="color:red"'),_("Previous owing must be a number.")));
	       return 1; 			
 		}
 		
 		if ("" == quick_query("select * from " . SQL_PREFIX . "invoices WHERE invoicable_id=" . $invoicable_id . " and billing_id=" . $billing_id, "id" )){
	 		$query = "insert into ". SQL_PREFIX . 'invoices'. " \n"
				."(billing_id, invoicable_id, previous_owing, payment_made) VALUES ($billing_id, $invoicable_id, $prev_owing, $payment_made)";					
 		} else {
	 		$query = "UPDATE ". SQL_PREFIX . 'invoices'. " \n"
				."SET "
				."previous_owing='$prev_owing', \n"
				."payment_made='$payment_made'\n"
				."WHERE billing_id='$billing_id' AND invoicable_id='$invoicable_id'";
		}

		$result = $db->Execute($query);
	
		if(!$result) {
			db_error(_('Error processing event'), $query);
		}		
 		 
 	return 0;
 }

function get_formated_expense_row($color, $admin_comment,$expense){
	return tag('tr',
				tag('td', attributes("colspan='5' bgcolor='$color'"), $admin_comment ),
				tag('td', attributes("bgcolor='$color' align='right' nowrap='true'"), "$" . number_format(round($expense,2),2, ".", "") )
			);	
}

function get_km_rate($plan, $rateLow, $rateMed, $rateHigh){
	global $MEMBER_PLANS;
	if ($plan == $MEMBER_PLANS['LOW']){
		return $rateLow;
	} else if ($plan == $MEMBER_PLANS['MED']) {
		return $rateMed;
	} else if ($plan == $MEMBER_PLANS['HIGH']) {
		return $rateHigh;
	} else {
		soft_error("Unknown member plan " . $plan);
	}
	return 0;
}

function toggle_row_color($old){
	global $LIGHT_ROW_COLOR, $DARK_ROW_COLOR;
	if ($old == $LIGHT_ROW_COLOR){
		return $DARK_ROW_COLOR;
	} else {
		return $LIGHT_ROW_COLOR;
	}
}
?>