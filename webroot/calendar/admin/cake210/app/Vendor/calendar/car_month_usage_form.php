<?php

function car_month_usage_form() {
	global $vars, $day, $month, $year, $db, $config, $phpc_script, $month_names, $event_types, $calendar_name, $ANNOUNCE_TYPES;
	
	$error_msg = "";
	//====================== get data
	if (isset($vars['user'])){
		$userid = $vars['user'];	
	} else {
		$userid = -1;	
	}

	if (isset($vars['bookable'])){
		$bookableid = $vars['bookable'];	
	} else {
		$bookableid = -1;	
	}

	if (isset($vars['vehicle'])){
		$vehicleid = $vars['vehicle'];	
	} else {
		$vehicleid = -1;	
	}

	if (isset($vars['day'])){
		$day = $vars['day'];	
	} else {
		$day = date('j');	
	}	

	if (isset($vars['month'])){
		$month = $vars['month'];	
	} else {
		$month = date('n');	
	}	
	
	if (isset($vars['year'])){
		$year = $vars['year'];	
	} else {
		$year = date('Y');	
	}

	if (isset($vars['endday'])){
		$end_day = $vars['endday'];	
	} else {
		$end_day = date('j');	
	}	

	if (isset($vars['endmonth'])){
		$end_month = $vars['endmonth'];	
	} else {
		$end_month = date('n');	
	}	
	
	if (isset($vars['endyear'])){
		$end_year = $vars['endyear'];	
	} else {
		$end_year = date('Y');	
	}
	
	$endstamp =     mktime(0, 0, 0, $end_day, $end_month, $end_year);
	$startstamp =   mktime(0, 0, 0, $day, $month, $year);	

	// ================= prepare sequences for dropdown lists.
	$vehicles[-1] = "ANY BOOKABLE";
	$result = get_vehicles(-1);
	if ($row1 = $result->FetchRow()) {
		for (; $row1; $row1 = $result->FetchRow()) {
			$vehicles[$row1['id']] = $row1['dropdownname'];
		}
	}
	
	$vehicles2[-1] = "ANY VEHICLE";
	$result = get_vehicles2();
	if ($row1 = $result->FetchRow()) {
		for (; $row1; $row1 = $result->FetchRow()) {
			$vehicles2[$row1['id']] = $row1['name'];
		}
	}
		
	$users[-1] = "ANY USER";
	$result = get_users();
	if ($row1 = $result->FetchRow()) {
		for (; $row1; $row1 = $result->FetchRow()) {
			$users[$row1['id']] = $row1['displayname'];
		}
	}	
	
	$year_sequence = create_sequence(2007, 2037);

	$day_of_month_sequence = create_sequence(1, 31);
	
	//============= build form controls
	if (isset ($id))
		$input = create_hidden('id', $id);
	else
		$input = '';	

	$memberFormContol =   create_select('user', $users, $userid);
	$vehicleFormControl = create_select('bookable', $vehicles, $bookableid);		
	$vehicle2FormControl = create_select('vehicle', $vehicles2, $vehicleid);
	
	$day_selector = create_select('day', $day_of_month_sequence, $day);
	$month_selector = create_select('month', $month_names, $month);
	$year_selector = create_select('year', $year_sequence, $year);
	
	$end_day_selector = create_select('endday', $day_of_month_sequence, $end_day);
	$end_month_selector = create_select('endmonth', $month_names, $end_month);
	$end_year_selector = create_select('endyear', $year_sequence, $end_year);

	$submit_control = create_submit(_("Submit Query"));
			
	$retText = tag('div');
	
	if ($error_msg != "") {
		$retText->add(
					tag("div",
							attributes("style='border: 2px solid #000; background-color: #FFFFAA;'"),
							//tag("b", "Note:"),
							tag("b", tag("font",attributes("color='red' align='center'"),$error_msg)))		
					  );
	}
	
	$retText->add( tag('div',	
					 attributes(" align='center' "),
					 tag("h2","Select Events"),	
					 tag('form', attributes("action=\"$phpc_script\"", "method=\"post\""),
								tag('table', attributes("class='phpc-main'"), tag('tfoot', 
									tag('tr', tag('td', attributes("colspan='2' align='center'"), $input, $submit_control, create_hidden('action', 'car_month_usage_rpt'), create_hidden('subaction', 'submit')))), 
									tag('tbody',
										tag('tr', tag('th', _('Booking Is For Member')), tag('td', $memberFormContol   )), 
										tag('tr', tag('th', _('Bookable')), tag('td', $vehicleFormControl )),
										tag('tr', tag('th', _('Vehicle Used')), tag('td', $vehicle2FormControl )),  
										tag('tr', tag('th', _('Start Time Is After First Second Of')), tag('td', $day_selector,     $month_selector,     $year_selector), 
										tag('tr', tag('th', _('Start Time Is Before Last Second Of')),   tag('td', $end_day_selector, $end_month_selector, $end_year_selector)
										)))))
					));
	return $retText;
}

?>
