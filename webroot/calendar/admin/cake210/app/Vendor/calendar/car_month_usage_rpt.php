<?php



function get_car_month_usage($startstamp,$endstamp,$bookableid,$userid,$vehicleid)
{
	global $calendar_name, $db, $CANCELED;
    $dbstartdatetime = $db->SQLDate('Y-m-d-H-i', 'starttime');
    $mystartdatetime = "'" . date('Y-m-d-H-i', $startstamp). "'";
    $myenddatetime = "'" . date('Y-m-d-H-i', $endstamp). "'";
    
    $conditions = "";
    if ($bookableid != -1){
    	$conditions = $conditions . " AND bookableobject=$bookableid ";
    }

    if ($userid != -1){
    	$conditions = $conditions . " AND uid=$userid ";
    }    
    
    if ($vehicleid != -1){
    	$conditions = $conditions . " AND vehicle_used_id=$vehicleid ";
    }
    
    if ($startstamp != -1){
    	$conditions = $conditions . " AND ($mystartdatetime <= $dbstartdatetime) \n";
    }
    
    if ($endstamp != -1){
    	$conditions = $conditions . " AND ($myenddatetime >= $dbstartdatetime) \n";
    }    
    
    $events_table = SQL_PREFIX . 'events';
    
	$query = 'SELECT '.SQL_PREFIX.'events.id as id, username, displayname, endkm - startkm as distance, canceled,'.SQL_PREFIX.'vehicles.name as name, vehicle_used_id, starttime, endtime, startkm, endkm, expense_gas, expense_admin, expense_repair, expense_insurance, expense_misc_1, expense_misc_2, expense_misc_3, expense_misc_4, admin_comment, admin_ignore_this_booking, admin_ignore_km_hours, '
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
		."INNER JOIN ".SQL_PREFIX."vehicles ON ".SQL_PREFIX."vehicles.id = ".SQL_PREFIX."bookables.vehicle_id\n"
		."INNER JOIN ".SQL_PREFIX."users ON ".SQL_PREFIX."users.id = ".SQL_PREFIX."events.uid\n"
		."WHERE (canceled = '".$CANCELED['NORMAL']."' OR canceled = '".$CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']."')\n"
		.$conditions
		." ORDER BY starttime";
    //echo($query);
	$result = $db->Execute($query)
		or db_error(_('Error in get_events_for_bookable_in_interval'), $query);

	return $result;
}

 function km_gas_submit(&$outMsg){
	global $calendar_name, $db, $CANCELED, $vars;
	
 	$rowcount = 1;
 	
 	//echo("In km_gas_submit. " . $vars["eventid_$rowcount"]);
 	
 	if (!empty($vars["eventid_$rowcount"])){
 		$myId = $vars["eventid_$rowcount"];
 	} else {
 		$myId = -1;
 	}
 	
 	while ($myId != -1){
 		$start_km = $vars["start_km_$rowcount"];
 		$end_km = $vars["end_km_$rowcount"];
 		$expenses_gas = $vars["expense_gas_$rowcount"];
 		$expenses_admin = $vars["expense_admin_$rowcount"];
 		
 		$myExpensesRepair =    $vars["expense_repair_$rowcount"];
		$myExpensesInsurance = $vars["expense_insurance_$rowcount"];
		$myExpensesMisc1 =     $vars["expense_misc_1_$rowcount"];
		$myExpensesMisc2 =     $vars["expense_misc_2_$rowcount"];
		$myExpensesMisc3 =     $vars["expense_misc_3_$rowcount"];
		$myExpensesMisc4 =     $vars["expense_misc_4_$rowcount"];
 		
 		$admin_comment = $vars["admin_comment_$rowcount"];
 		$vehicle_used = $vars["vehicle_used_id_$rowcount"];

		$myAdminIgnoreThisBooking = 0;
		if (isset($vars["admin_ignore_this_booking_$rowcount"]) && $vars["admin_ignore_this_booking_$rowcount"] == '1'){
			$myAdminIgnoreThisBooking = 1;
		}

		$myAdminIgnoreKmHours = 0;
		if (isset($vars["admin_ignore_km_hours_$rowcount"]) && $vars["admin_ignore_km_hours_$rowcount"] == '1'){
			$myAdminIgnoreKmHours = 1;
		}
		 		
 		//echo("'$start_km', '$end_km', '$expenses_gas', '$expenses_admin', '$admin_comment'  test ");
 		if ($start_km != "" && !is_numeric($start_km)){
	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. Start km must be a number.")); 	
	       return 1;		
 		}
 		if ($end_km != "" && !is_numeric($end_km)){
	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. End km must be a number."));	
	       return 1;		
 		} 		
 		if (($start_km == "" && $end_km != "") || ($start_km != "" && $end_km == "") ){
 	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. Both start km and end km must be filled or both must be blank."));	
	       return 1;				
 		}
 		
 		if ($expenses_gas == ""){
 			$expenses_gas = 0;
 		}
 		if (!is_numeric($expenses_gas)){
	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. Gas expense must be a number."));
	       return 1; 			
 		}
 		if ($expenses_admin == ""){
 			$expenses_admin = 0;
 		}
 		if (!is_numeric($expenses_admin)){
	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. Admin expense must be a number."));
	       return 1; 			
 		}

 		if ($myExpensesRepair == ""){
 			$myExpensesRepair = 0;
 		}
 		if (!is_numeric($myExpensesRepair)){
	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. Repair expense must be a number."));
	       return 1; 			
 		}
 		
 		if ($myExpensesInsurance == ""){
 			$myExpensesInsurance = 0;
 		}
 		if (!is_numeric($myExpensesInsurance)){
	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. Insurance expense must be a number."));
	       return 1; 			
 		} 	

 		if ($myExpensesMisc1 == ""){
 			$myExpensesMisc1 = 0;
 		}
 		if (!is_numeric($myExpensesMisc1)){
	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. Misc 1 expense must be a number."));
	       return 1; 			
 		}

 		if ($myExpensesMisc2 == ""){
 			$myExpensesMisc2 = 0;
 		}
 		if (!is_numeric($myExpensesMisc2)){
	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. Misc 2 expense must be a number."));
	       return 1; 			
 		} 		

 		if ($myExpensesMisc3 == ""){
 			$myExpensesMisc3 = 0;
 		}
 		if (!is_numeric($myExpensesMisc3)){
	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. Misc 3 expense must be a number."));
	       return 1; 			
 		}

 		if ($myExpensesMisc4 == ""){
 			$myExpensesMisc4 = 0;
 		}
 		if (!is_numeric($myExpensesMisc4)){
	       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. Misc 4 expense must be a number."));
	       return 1; 			
 		} 	 			
 		
 		if (is_numeric($start_km)) {		
	 		if ($start_km > $end_km){
		       $outMsg = tag("strong",attributes('style="color:red"'),_("Error row $rowcount. End km must be greater than or equal to start km."));
		       return 1;			
	 		} 		
	 		$kmsql = " startkm=$start_km, endkm=$end_km, ";
 		} else {
 			$kmsql = "";
 		}
 		
 		$query = "UPDATE ". SQL_PREFIX . 'events'. " \n"
			."SET "
			."vehicle_used_id=$vehicle_used,\n"
			.$kmsql
			."expense_gas=$expenses_gas,\n"
			."expense_admin=$expenses_admin,\n"		
			."expense_repair=$myExpensesRepair,\n"
			."expense_insurance=$myExpensesInsurance,\n"
			."expense_misc_1=$myExpensesMisc1,\n"
			."expense_misc_2=$myExpensesMisc2,\n"
			."expense_misc_3=$myExpensesMisc3,\n"
			."expense_misc_4=$myExpensesMisc4,\n"		
			."admin_ignore_this_booking='$myAdminIgnoreThisBooking',\n"
			."admin_ignore_km_hours='$myAdminIgnoreKmHours',\n"
			."admin_comment='" . addslashes($admin_comment) . "'\n"
			."WHERE id='$myId'";
		//echo $query;

		$result = $db->Execute($query);
	
		if(!$result) {
			db_error(_('Error processing event'), $query);
		}		
 		
	  	$rowcount = $rowcount + 1;
	 	if (!empty($vars["eventid_$rowcount"])){
	 		$myId = $vars["eventid_$rowcount"];
	 	} else {
	 		$myId = -1;
	 	}		
 	}
 	$outMsg = tag("strong","Update sucessful.");
 	return 0;
 }


function car_month_usage_rpt(){
    global $db, $CANCELED, $phpc_script, $vars, $CALENDAR_ROOT;
		
	$startstamp = mktime(0, 0, 0, $vars['month'], $vars['day'], $vars['year']);
	$endstamp = mktime(23, 59, 59, $vars['endmonth'], $vars['endday'], $vars['endyear']);
	$bookableid  = $vars['bookable'];
	$userid      = $vars['user'];
	$vehicleid      = $vars['vehicle'];
	
	$amSubmitting = false;
	$outMsg = "";
	
	if (!empty($vars["eventid_1"])) {
		//echo ("submitting.");
		$amSubmitting = true;
		if (km_gas_submit($outMsg) != 0) {
			// was an error submitting
		}
	}
	
	if ($userid == -1){
		$username = "ANY USER";
	} else {
		$username = quick_query( "select displayname from ".SQL_PREFIX."users where id=".$userid, "displayname");
	}

	if ($bookableid == -1){
		$bookablename = "ANY BOOKABLE";
	} else {
		$bookablename = quick_query( "select ".SQL_PREFIX."vehicles.name as name from ".SQL_PREFIX."bookables INNER JOIN ".SQL_PREFIX."vehicles on ".SQL_PREFIX."bookables.vehicle_id = ".SQL_PREFIX."vehicles.id where ".SQL_PREFIX."bookables.id=".$bookableid, "name");
	}

	if ($vehicleid == -1){
		$vehiclename = "ANY VEHICLE";
	} else {
		$vehiclename = quick_query( "select ".SQL_PREFIX."vehicles.name as name from ".SQL_PREFIX."vehicles where id=".$vehicleid, "name");
	}
	
	$result = get_vehicles2(-1);
	if ($row1 = $result->FetchRow()) {
		for (; $row1; $row1 = $result->FetchRow()) {
			$vehicles[$row1['id']] = $row1['name'];
		}
	}
	
	$outStr = tag("font");
		
	$outStr->add(
		tag("div", 
				tag("h2","Search Criteria"),
				tag("blockquote",
					"<b>Bookings with start time after and including:</b> " . date("M d, Y H:i:s", $startstamp) . "<br/>\n",
					"<b>Bookings with start time before and including:</b> " . date("M d, Y H:i:s", $endstamp) . "<br/>\n",
					"<b>Bookings for user:</b> " . $username . "<br/>\n",
					"<b>Bookings using bookable:</b> " . $bookablename . "<br/>\n",
					"<b>Bookings using vehicle:</b> " . $vehiclename . "<br/>\n"
				)
			)
		);
	
	$result = get_car_month_usage($startstamp,$endstamp,$bookableid,$userid,$vehicleid);

	$hoursTotal = 0.0;
	$distanceTotal = 0.0;
	$gasTotal = 0.0;
	$adminTotal = 0.0;
	$repairTotal = 0.0;
	$insuranceTotal = 0.0;
	
	$html_events = tag('tbody');
	$rowcount = 1;
	$tabindex = 1;
	while($row = $result->FetchRow($result)) {
		
		$numHalfHourIntervals  = 0;
		
		$myState = "false";
		if ($row['canceled'] == $CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']){
			$myState = "true";
		}
		if ( $amSubmitting ){
			
			//echo("one");
	 		$myStartKm = $vars["start_km_$rowcount"];
	 		$myEndKm = $vars["end_km_$rowcount"];
	 		$myExpensesGas   = $vars["expense_gas_$rowcount"];
	 		$myExpensesAdmin = $vars["expense_admin_$rowcount"];
	 		
			$myExpensesRepair =    $vars["expense_repair_$rowcount"];
			$myExpensesInsurance = $vars["expense_insurance_$rowcount"];
			$myExpensesMisc1 =     $vars["expense_misc_1_$rowcount"];
			$myExpensesMisc2 =     $vars["expense_misc_2_$rowcount"];
			$myExpensesMisc3 =     $vars["expense_misc_3_$rowcount"];
			$myExpensesMisc4 =     $vars["expense_misc_4_$rowcount"];	 		

			$myAdminIgnoreThisBooking = "";
			if (isset($vars["admin_ignore_this_booking_$rowcount"]) && $vars["admin_ignore_this_booking_$rowcount"] == '1'){
				$myAdminIgnoreThisBooking = " CHECKED='true' ";
			}

			$myAdminIgnoreKmHours = "";
			if (isset($vars["admin_ignore_km_hours_$rowcount"]) && $vars["admin_ignore_km_hours_$rowcount"] == '1'){
				$myAdminIgnoreKmHours = " CHECKED='true' ";
			}
				 		
	 		$myVehicleUsedId = $vars["vehicle_used_id_$rowcount"];		
	 		$myAdminComment =  $vars["admin_comment_$rowcount"];
		} else {
			$myStartKm = $row['startkm'];
			$myEndKm = $row['endkm'];
			$myExpensesGas   = $row['expense_gas'];
			$myExpensesAdmin = $row['expense_admin'];
			
			$myExpensesRepair =    $row['expense_repair'];
			$myExpensesInsurance = $row['expense_insurance'];
			$myExpensesMisc1 =     $row['expense_misc_1'];
			$myExpensesMisc2 =     $row['expense_misc_2'];
			$myExpensesMisc3 =     $row['expense_misc_3'];
			$myExpensesMisc4 =     $row['expense_misc_4'];
			
			$myAdminIgnoreThisBooking = "";
			if ($row['admin_ignore_this_booking'] == 1){
				$myAdminIgnoreThisBooking = " CHECKED='true' ";
			}
			$myAdminIgnoreKmHours = "";
			if ($row['admin_ignore_km_hours'] == 1){
				$myAdminIgnoreKmHours = " CHECKED='true' ";
			}
						
			$myVehicleUsedId = $row['vehicle_used_id'];
			$myAdminComment = $row['admin_comment'];
		}
		
		$startstamp = strtotime($row['starttime']);
		$endstamp = strtotime($row['endtime']);
		if ($row['canceled'] == $CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']){
			$numQuarterHourIntervals = 0;
		} else {
			$numQuarterHourIntervals = ($endstamp - $startstamp)/(60*15);
		}
		$numExtraQuarterHoursFromCancelAndMod = getNumExtraQuarterHourIntervalsFromCancelAndModifications($row['id'], $row['canceled'], $startstamp, $endstamp, 7, 20);
		
		$hoursDisplay = $numQuarterHourIntervals/4;
		if ($numExtraQuarterHoursFromCancelAndMod['total'] > 0){
			$hoursDisplay .= " + " . $numExtraQuarterHoursFromCancelAndMod['total'] / 4;
		}
		$hoursTotal += ($numQuarterHourIntervals + $numExtraQuarterHoursFromCancelAndMod['total']) / 4;
		$distanceTotal += $row['distance'];
		$gasTotal += $row['expense_gas'];
		$adminTotal += $row['expense_admin'];
		$repairTotal += $row['expense_repair'];
		$insuranceTotal += $row['expense_insurance'];
			
		$myBgcolor = "#FFFFFF";
		if ($rowcount % 2 == 0){
			$myBgcolor = "#DDDDDD";
		}
		$tabindex += 2;
		$html_events->add(tag('tr', 
								tag('td', attributes("bgcolor='$myBgcolor'"), $rowcount),
								tag('td', attributes("bgcolor='$myBgcolor'"), tag("a",attributes("href='" . $CALENDAR_ROOT . "index.php?action=display&id=" . $row['id'] . "'"),$row['name']), create_hidden('eventid_' .$rowcount , $row['id'])),
								tag('td', attributes("bgcolor='$myBgcolor'"), $row['displayname']), 
								tag('td', attributes("bgcolor='$myBgcolor'"), $row['starttime'] ), 
								tag('td', attributes("bgcolor='$myBgcolor'"), $row['endtime'] ),
								tag('td', attributes("bgcolor='$myBgcolor'"), $myState ),
								tag('td', attributes("bgcolor='$myBgcolor'"), $hoursDisplay ),
								tag('td', attributes("bgcolor='$myBgcolor'"), $row['distance'] ),
								tag('td', attributes("bgcolor='$myBgcolor'"), create_select("vehicle_used_id_" . $rowcount, $vehicles, $myVehicleUsedId) ),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "tabindex='$tabindex'", "onBlur='tabToNext(\"start_km_$rowcount\",\"end_km_$rowcount\");'", "size='6'", "max_length='7'", 'name="start_km_' . $rowcount . '"', "value=\"" . $myStartKm . "\""))),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "tabindex='" . ($tabindex + 1) . "'", "onBlur='tabToNext(\"end_km_$rowcount\", \"start_km_" . ($rowcount + 1) . "\");'", "size='6'", "max_length='7'", 'name="end_km_'   . $rowcount . '"', "value=\"" . $myEndKm . "\""))),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='20'", "max_length='255'", 'name="admin_comment_' . $rowcount. '"', "value=\"" . $myAdminComment . "\""))),
								
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="checkbox"', 'name="admin_ignore_this_booking_' . $rowcount. '"', 'value="1"', $myAdminIgnoreThisBooking))),

								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="checkbox"', 'name="admin_ignore_km_hours_' . $rowcount. '"', 'value="1"', $myAdminIgnoreKmHours))),
																
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='8'", "max_length='10'", 'name="expense_gas_' . $rowcount. '"', "value=\"" . $myExpensesGas . "\""))),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='8'", "max_length='10'", 'name="expense_admin_' . $rowcount. '"', "value=\"" . $myExpensesAdmin . "\""))),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='8'", "max_length='10'", 'name="expense_repair_' . $rowcount. '"', "value=\"" . $myExpensesRepair     . "\""))),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='8'", "max_length='10'", 'name="expense_insurance_' . $rowcount. '"', "value=\"" . $myExpensesInsurance  . "\""))),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='8'", "max_length='10'", 'name="expense_misc_1_' . $rowcount. '"', "value=\"" . $myExpensesMisc1      . "\""))),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='8'", "max_length='10'", 'name="expense_misc_2_' . $rowcount. '"', "value=\"" . $myExpensesMisc2      . "\""))),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='8'", "max_length='10'", 'name="expense_misc_3_' . $rowcount. '"', "value=\"" . $myExpensesMisc3      . "\""))),
								tag('td', attributes("bgcolor='$myBgcolor'"),  tag('input', attributes('type="text"', "size='8'", "max_length='10'", 'name="expense_misc_4_' . $rowcount. '"', "value=\"" . $myExpensesMisc4      . "\"")))
								));
								//tag('input', attributes('type="text"', "size=\"{$config['subject_max']}\"", "maxlength=\"{$config['subject_max']}\"", 'name="subject"', "value=\"$subject\"")
	$rowcount = $rowcount + 1;
	} 

	$outStr->add(
					tag('script',
						attributes("language=JavaScript"),
						"\nfunction tabToNext(thisFld,nxtFld){\n",
						"    //alert(nxtFld);\n",
						"    var nxtInput = document.getElementsByName(nxtFld);\n",
						"    var myInput =  document.getElementsByName(thisFld);\n",
						"    if (nxtInput.length > 0 && myInput.length > 0){\n",
						"         if (nxtInput.item(0).value.length == 0){\n",
						"             nxtInput.item(0).value = myInput.item(0).value;\n",						
						"         }\n",
						"    }\n",
						"}\n"
					)
				);

	$outStr->add(
			   tag('form', attributes("action=\"$phpc_script\"", "method=\"post\""),
			   	  create_hidden("user", $vars['user']),
			   	  create_hidden("bookable", $vars['bookable']),
			   	  create_hidden("vehicle", $vars['vehicle']),
			   	  create_hidden("year", $vars['year']),
			   	  create_hidden("month", $vars['month']),
			   	  create_hidden("day", $vars['day']),
			   	  create_hidden("endyear", $vars['endyear']),
			   	  create_hidden("endmonth", $vars['endmonth']),
			   	  create_hidden("endday", $vars['endday']),		   	  
				  tag('table', attributes(" border='1' cellpadding='0' cellspacing='0'"), 
				  		//tag('thead',
				  			tag('tr',tag('td',attributes(" colspan='11'"),  $outMsg)),
					  		tag('tr', 
					  				attributes(" bgcolor='#AAAAAA' align='center'"),
					  				tag('td', ""),
					  				tag('td', "<b>Car Booked</b>"), 
					  				tag('td', "<b>Member</b>"), 
					  				tag('td', "<b>Start Time</b>"), 
					  				tag('td', "<b>End Time</b>"), 
					  				tag('td', "<b>was canceled within 48hrs</b>"), 
					  				tag('td', "<b>Hours</b>"), 
					  				tag('td', "<b>Distance</b>"),
					  				tag('td', "<b>vehicle used</b>"),
					  				tag('td', attributes("width='85' nowrap='true'"), "<b>start km</b>"), 
					  				tag('td', attributes("width='85' nowrap='true'"), "<b>end km</b>"), 
					  				tag('td', "<b>comment</b>"),
					  				tag('td', "<b>discount entire trip</b>"),
					  				tag('td', "<b>discount hours and km</b>"),
					  				tag('td', "<b>gas expense</b>"),
					  				tag('td', "<b>admin expense</b>"),
					  				tag('td', "<b>repair expense</b>"),
					  				tag('td', "<b>insurance expense</b>"),
					  				tag('td', "<b>fines expense</b>"),
					  				tag('td', "<b>misc 2 expense</b>"),
					  				tag('td', "<b>misc 3 expense</b>"),
					  				tag('td', "<b>misc 4 expense</b>")
					  				),
				  		$html_events,
				  		tag('tr',
				  				tag('td',attributes(" colspan='6'"),  create_submit("Save", "Save"), create_hidden('action', 'car_month_usage_rpt')),
				  				tag('td', $hoursTotal ),
				  				tag('td', $distanceTotal),
				  				tag('td', attributes(" colspan='6'"), ""),
				  				tag('td', $gasTotal),
				  				tag('td', $adminTotal),
				  				tag('td', $repairTotal),
				  				tag('td', $insuranceTotal)
				  				))
				  			)
				  		);
	return $outStr;
	
}

?>
