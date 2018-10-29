<?php
 
if (!defined('IN_PHPC')) {
	die("Hacking attempt");
}
global $noNavbar;
$noNavbar = true;

require_once($phpc_root_path . 'includes/event_form.php');
require_once($phpc_root_path . 'admin/cake210/app/Vendor/calendar/generate_invoices_inc.php');
require_once($phpc_root_path . 'admin/cake210/app/Vendor/calendar/generate_invoices_local_inc.php');

function trip_estimate_submit(){
	global $calendar_name, $day, $month, $year, $db, $vars, $config,
	       $phpc_script, $CANCELED, $OPERATION, $EVENT_TYPE_BOOKING, $MEMBER_PLANS, $VEHICLE_LABEL;
    
    $error = Array();           

	if(empty($vars['day'])) $error[] =  (_('No day was given.'));

	if(empty($vars['month'])) $error[] =  (_('No month was given.'));

	if(empty($vars['year'])) $error[] = (_('No year was given'));

	if(isset($vars['starthour'])) {
              $hour = $vars['starthour'];
	} else {
              $error[] = (_('No hour was given.'));
    }
    
	if(isset($vars['endhour'])) {
              $endhour = $vars['endhour'];
	} else {
              $error[] = (_('No end hour was given.'));
    }

	if(isset($vars['num_km_estimate'])){
		$num_km_estimate = $vars['num_km_estimate'];
        if (is_numeric($num_km_estimate)){
            if ($num_km_estimate <= 1){
                $error[] = (_('Number of km must be greater than 1.'));
            }
        } else {
            $error[] = (_('Number of km must be a number.'));
        }
	}else $error[] = (_('Must estimate number of km.'));

	if(isset($vars['bookable']))
		$bookable = $vars['bookable'];
	else $error[] = (_("No $VEHICLE_LABEL was given."));
	if ($bookable == 0 || $bookable == -1){
		$error[] = (_("No $VEHICLE_LABEL was selected."));
	}
	
	if(isset($vars['endday']))
		$end_day = $vars['endday'];
	else $error[] = (_('No end day was given'));
    
	if(isset($vars['endmonth']))
		$end_month = $vars['endmonth'];
	else $error[] = (_('No end month was given'));

	if(isset($vars['endyear']))
		$end_year = $vars['endyear'];
	else $error[] = (_('No end year was given'));
	
	$startArray = explode(":", $hour );
	$endArray = explode(":", $endhour );
	
	$startstamp = mktime($startArray[0], $startArray[1], 0, $month, $day, $year);

	$endstamp = mktime($endArray[0], $endArray[1], 0, $end_month, $end_day, $end_year);
    if($endstamp < $startstamp) {
       $error[] = (_('The start of the event cannot be after the end of the event.'));
    }    

    if (count($error) > 0){
        return Array('error' => true, 'out' => $error);
    } 
    
	$query= "select * from ".SQL_PREFIX."billings order by year desc, month desc limit 1";

	$result = $db->Execute($query)
                or db_error("error getting billing", $query);
    $billing = $result->FetchRow();    

    $plan = $MEMBER_PLANS['LOW'];    

	$subtotals = Array();
	$invoiceGenerator = new GenerateInvoicesLocal();
	$invoiceGenerator->initializeSubtotals($subtotals);
	
	$query= "select * from ".SQL_PREFIX."bookables where id=" . $bookable;
	$result = $db->Execute($query)
                or db_error("error getting bookable", $query);
    $bookableRow = $result->FetchRow();
	
    $row = array('distance' => $num_km_estimate,
        'name' => $bookableRow['name'],
        'starttime' => $year . '-' . $month . '-' . $day . ' ' . $hour,
        'endtime' => $end_year . '-' . $end_month . '-' . $end_day . ' ' . $endhour,
        'eventtype' => 1,
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'end_year' => $end_year,
        'end_month' => $end_month,
        'end_day' => $end_day,
        'hour' => $startArray[0],
        'minute' => $startArray[1],
        'end_hour' => $endArray[0],
        'end_minute' => $endArray[1],
		'canceled' => false,
		'eventid' => 1,
		'bookablevehicle_id' => 1,
		'vehicle_used_id' => 1,
		'admin_ignore_this_booking' => "",
		'admin_ignore_km_hours' => "",
		'acnt_new_code_hours' => "",	
		'acnt_new_code_km' => "",
		'charge_bc_rental_tax' => ""
        );

	set_bookable_row_values($row, $bookableRow);
    $invRow = $invoiceGenerator->getBookingInvoiceRow($num_km_estimate, $billing, $row, $plan, $subtotals);
	$invRow['name'] = $row['name'];
    $outArray = Array('error' => false, 'out' => $invRow);
	
	// get an economy estimate
	$query = "select * from ".SQL_PREFIX."bookables" . 
			" inner join ".SQL_PREFIX."vehicles on ".SQL_PREFIX."bookables.vehicle_id = ".SQL_PREFIX."vehicles.id" .
			" inner join ".SQL_PREFIX."vehicletypes on ".SQL_PREFIX."vehicles.vehicle_type = ".SQL_PREFIX."vehicletypes.id" .
			" inner join ".SQL_PREFIX."bookables_calendars on ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."bookables_calendars.bookable_id " .
			" where ".SQL_PREFIX."vehicletypes.type in ('car economy','van economy','truck economy') AND " . SQL_PREFIX . "bookables.disabled <> true limit 1";
	$result = $db->Execute($query)
                or db_error("error getting bookable", $query);
    $bookableRow = $result->FetchRow();
	if ($bookableRow){
		set_bookable_row_values($row, $bookableRow);
		$invRow = $invoiceGenerator->getBookingInvoiceRow($num_km_estimate, $billing, $row, $plan, $subtotals);
		$invRow['name'] = $bookableRow['name'];
		$outArray['outEconomy'] = $invRow;
	}
	
	// get a midsize estimate
	$query = "select * from ".SQL_PREFIX."bookables" . 
			" inner join ".SQL_PREFIX."vehicles on ".SQL_PREFIX."bookables.vehicle_id = ".SQL_PREFIX."vehicles.id" .
			" inner join ".SQL_PREFIX."vehicletypes on ".SQL_PREFIX."vehicles.vehicle_type = ".SQL_PREFIX."vehicletypes.id" .
			" inner join ".SQL_PREFIX."bookables_calendars on ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."bookables_calendars.bookable_id " .
			" where ".SQL_PREFIX."vehicletypes.type in ('car midsize','van midsize','truck midsize') AND " . SQL_PREFIX . "bookables.disabled <> true limit 1";

	$result = $db->Execute($query)
                or db_error("error getting bookable", $query);
    $bookableRow = $result->FetchRow();
	if ($bookableRow){
		set_bookable_row_values($row, $bookableRow);
		$invRow = $invoiceGenerator->getBookingInvoiceRow($num_km_estimate, $billing, $row, $plan, $subtotals);
		$invRow['name'] = $bookableRow['name'];
		$outArray['outMedium'] = $invRow;
	}
	
	// get a large estimate
	$query = "select * from ".SQL_PREFIX."bookables" . 
			" inner join ".SQL_PREFIX."vehicles on ".SQL_PREFIX."bookables.vehicle_id = ".SQL_PREFIX."vehicles.id" .
			" inner join ".SQL_PREFIX."vehicletypes on ".SQL_PREFIX."vehicles.vehicle_type = ".SQL_PREFIX."vehicletypes.id" .
			" inner join ".SQL_PREFIX."bookables_calendars on ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."bookables_calendars.bookable_id " .
			" where ".SQL_PREFIX."vehicletypes.type in ('car large','van large','truck large')  AND " . SQL_PREFIX . "bookables.disabled <> true limit 1";
	$result = $db->Execute($query)
                or db_error("error getting bookable", $query);
    $bookableRow = $result->FetchRow();
	if ($bookableRow){
		set_bookable_row_values($row, $bookableRow);
		$invRow = $invoiceGenerator->getBookingInvoiceRow($num_km_estimate, $billing, $row, $plan, $subtotals);
		$invRow['name'] = $bookableRow['name'];
		$outArray['outLarge'] = $invRow;
	}
	
	return $outArray;
}

function set_bookable_row_values(&$invInputRow, $bookableRow){
		$invInputRow['hourly_rate_low'] = $bookableRow['hourly_rate_low'];
        $invInputRow['hourly_rate_high'] = $bookableRow['hourly_rate_high'];
        $invInputRow['is_flat_daily_rate'] = $bookableRow['is_flat_daily_rate'];
        $invInputRow['daily_rate_low'] = $bookableRow['daily_rate_low'];
        $invInputRow['daily_rate'] = $bookableRow['daily_rate'];
        $invInputRow['rate_cutoff'] = $bookableRow['rate_cutoff'];
        $invInputRow['km_rate_low'] = $bookableRow['km_rate_low'];
        $invInputRow['km_rate_med'] = $bookableRow['km_rate_med'];
        $invInputRow['km_rate_high'] = $bookableRow['km_rate_high'];
}

function trip_estimate() {
    global $vars;
    $result = null;
    if ( isset ($vars['subaction']) && $vars['subaction'] == "trip_estimate_submit"){
        $ret = trip_estimate_submit();
        if ($ret['error']){
            $l = tag("ul");
            foreach($ret['out'] as $e){
                $l->add( tag('p',$e) );
            }
            $result = tag("div", $l);
        } else {
			$resultsTable = tag("table");
			$resultsTable->add(tag("th",tag("td","total cost"),tag("td","time charge"),tag("td","km charge")));
            $invRow = $ret['out'];
			$tr = tag("tr");
			$tr->add( tag("td", $invRow['name']) );
			$tr->add( tag("td", number_format($invRow['time_charge'] + $invRow['km_charge'], 2)));
			$tr->add( tag("td", number_format($invRow['time_charge'], 2)));
			$tr->add( tag("td", number_format($invRow['km_charge'], 2)));
			$resultsTable->add($tr);
			$comment = $invRow['comment'];
			if (array_key_exists("outEconomy", $ret)){
				$invRow = $ret['outEconomy'];
				$tr = tag("tr");
				$tr->add( tag("td", "Economy Vehicle ") );
				$tr->add( tag("td", number_format($invRow['time_charge'] + $invRow['km_charge'], 2)));
				$tr->add( tag("td", number_format($invRow['time_charge'], 2)));
				$tr->add( tag("td", number_format($invRow['km_charge'], 2)));
				$resultsTable->add($tr);
			}

			if (array_key_exists("outMedium", $ret)){
				$invRow = $ret['outMedium'];
				$tr = tag("tr");
				$tr->add( tag("td", "Midsize Vehicle ") );
				$tr->add( tag("td", number_format($invRow['time_charge'] + $invRow['km_charge'], 2)));
				$tr->add( tag("td", number_format($invRow['time_charge'], 2)));
				$tr->add( tag("td", number_format($invRow['km_charge'], 2)));
				$resultsTable->add($tr);
			}

			if (array_key_exists("outLarge", $ret)){
				$invRow = $ret['outLarge'];
				$tr = tag("tr");
				$tr->add( tag("td", "Large Vehicle ") );
				$tr->add( tag("td", number_format($invRow['time_charge'] + $invRow['km_charge'], 2)));
				$tr->add( tag("td", number_format($invRow['time_charge'], 2)));
				$tr->add( tag("td", number_format($invRow['km_charge'], 2)));
				$resultsTable->add($tr);
			}			
			
            $result = tag("div", "<h2>Results</h2><br>" . $resultsTable->toString());
        }
    }
    if ($result != null){
        $out = tag("div", $result, event_form());
    } else {
        $out = tag("div", event_form());
    }
    return $out;
}

?>