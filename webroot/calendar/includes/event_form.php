<?php
 
if (!defined('IN_PHPC')) {
	die("Hacking attempt");
}

//require_once($phpc_root_path . 'includes/show_available.php');

function event_submit(&$outID)
{
	global $calendar_name, $day, $month, $year, $db, $vars, $config,
	       $phpc_script, $CANCELED, $OPERATION, $EVENT_TYPE_BOOKING;

	$outID = -1;
	$typeofevent = $EVENT_TYPE_BOOKING;
	
	if(isset($vars['id'])) {
		$id = $vars['id'];
		$modify = 1;
	} else {
		$modify = 0;
	}

	if(isset($vars['description'])) {
		$description = mysql_escape_string($vars['description']);
	} else {
		$description = '';
	}

	if(isset($vars['subject'])) {
		$subject = mysql_escape_string($vars['subject']);
	} else {
		$subject = '';
	}

	if(empty($vars['day'])) return (_('No day was given.'));

	if(empty($vars['month'])) return (_('No month was given.'));

	if(empty($vars['year'])) return (_('No year was given'));

	if(isset($vars['starthour'])) {
              $hour = $vars['starthour'];
	} else {
              return (_('No hour was given.'));
    }
    
	if(isset($vars['endhour'])) {
              $endhour = $vars['endhour'];
	} else {
              return (_('No end hour was given.'));
    }

	if(isset($vars['user']))
		$uid = $vars['user'];
	else return (_('No user was given.'));
	if($uid == 0 || $uid == -1){
		return (_('A valid user must be selected.'));
	}

	if(isset($vars['bookable']))
		$bookable = $vars['bookable'];
	else return (_('No vehicle was given.'));
	if ($bookable == 0 || $bookable == -1){
		return (_('No vehicle was selected.'));
	}
	
	if(isset($vars['endday']))
		$end_day = $vars['endday'];
	else return (_('No end day was given'));

	if(isset($vars['endmonth']))
		$end_month = $vars['endmonth'];
	else return (_('No end month was given'));

	if(isset($vars['endyear']))
		$end_year = $vars['endyear'];
	else return (_('No end year was given'));

	if(strlen($subject) > 255) {
		return (_('Your subject was too long')
				.". $config[subject_max] "._('characters max')
				.".");
	}
		
	$curTime = getdate();
	$curTimeStamp = mktime($curTime['hours'],$curTime['minutes'],0,$curTime['mon'],$curTime['mday'],$curTime['year']);
	
	$startArray = split(":", $hour );
	$endArray = split(":", $endhour );
	
	$startstamp = mktime($startArray[0], $startArray[1], 0, $month, $day, $year);

	$endstamp = mktime($endArray[0], $endArray[1], 0, $end_month, $end_day, $end_year);
    if($endstamp < $startstamp) {
       return (_('The start of the event cannot be after the end of the event.'));
    }
    
    if($startstamp < $curTimeStamp && !is_allowed_permission_checkpoint("EVENT_FORM.SET_PAST_TIME") && $modify == 0){
       return (_('Cannot set start time of a booking to a time in the past.'));    	
    }
    
    if ($endstamp < $curTimeStamp){
    	if ($modify == 0 && !is_allowed_permission_checkpoint("EVENT_FORM.SET_PAST_TIME")){
    		return (_('Cannot set end time of a booking to a time in the past.'));
    	}
    	if ($modify == 1 && !is_allowed_permission_checkpoint("EVENT_FORM.SET_PAST_TIME")){//cannot shorten booking in the past
    		$dbendtime = quick_query("select endtime from " . SQL_PREFIX . "events where id=" . $id, "endtime");
    		$dbendstamp = strtotime($dbendtime);
    		if ($endstamp < $dbendstamp){
    			return (_('Cannot shorten a booking with an end time in the past.'));
    		}
    	}
    }

	$myCheck = "";
	if ($modify == 1){
		$myCheck = check_if_booking_overlaps($startstamp,$endstamp,$bookable,$uid, $typeofevent, $id);
	} else {
		$myCheck = check_if_booking_overlaps($startstamp,$endstamp,$bookable,$uid, $typeofevent);
	}
	if ($myCheck != ""){
		return $myCheck;
	}
	
	//done validation
	//set cookies so form will default to last user and bookable for a few weeks 
	setcookie("User", $uid, time()+3600*24*48);
	setcookie("Bookable", $bookable, time()+3600*24*48);
	
	$vehicleUsed = quick_query("SELECT vehicle_id FROM ".SQL_PREFIX."bookables WHERE id=" . $bookable ,"vehicle_id");
	
	$starttime = $db->DBDate(date("Y-m-d H:i:s", $startstamp));

	$endtime = $db->DBDate(date("Y-m-d H:i:s", $endstamp));
	
	$table = SQL_PREFIX . 'events';

	if($modify) {
		$operation = $OPERATION['MODIFY'];
		$amt_tagged = tag_time($id, $startstamp, $endstamp, $bookable);
		$query = "UPDATE $table\n"
			."SET "
			."uid=$uid,\n"
			."starttime=$starttime,\n"
			."endtime=$endtime,\n"
			."subject='$subject',\n"
			."description='$description',\n"
			."bookableobject='$bookable',\n"
			."vehicle_used_id='$vehicleUsed',"
			."modifytime=NOW()\n"
			."WHERE id='$id'";
		$result = $db->Execute($query);
	} else {
		$operation = $OPERATION['CREATE'];
		
		$query = "INSERT INTO $table\n"
			."(uid, starttime, endtime,"
			." subject, description, eventtype, bookableobject, vehicle_used_id, modifytime, creationtime)\n"
			."VALUES ( '$uid',"
			."$starttime, $endtime, '$subject',"
			."'$description', '$typeofevent', '$bookable', '$vehicleUsed', NOW(), NOW())";

		$result = $db->Execute($query);
		$id = quick_query("SELECT LAST_INSERT_ID() AS lid", "lid");
		$amt_tagged = tag_time($id, $startstamp, $endstamp, $bookable);
	}

	if(!$result) {
		db_error(_('Error processing event'), $query);
	}

	insert_to_event_log($id,$_SESSION['uid'],$operation,$uid,$starttime,$endtime,$subject,$description,$bookable,$CANCELED['NORMAL'], $amt_tagged);
	$outID = $id;
	return "";
}

//set the $ignoreid field to -1 if we expect no records
function check_if_booking_overlaps($startstamp,$endstamp,$bookable,$userID,$eventtype, $ignoreid=-1){
	global $EVENT_TYPE_BOOKING;
	$result = get_events_for_bookable_in_interval($startstamp,$endstamp,$bookable);
	while($row = $result->FetchRow()){
		if ($ignoreid == -1){
			return (_('Your booking overlaps with another booking for this vehicle.'));		
		} else if ($row['id'] != $ignoreid){
			return (_('Your booking overlaps with another booking for this vehicle.'));					
		}
	}
	return "";
}

function get_hour_sequence(){
	$hour_sequence['00:15'] = "12:15 am";
	$hour_sequence['00:30'] = "12:30 am";
	$hour_sequence['00:45'] = "12:45 am";
	$hour_sequence['01:00'] = "1:00 am";
	$hour_sequence['01:15'] = "1:15 am";
	$hour_sequence['01:30'] = "1:30 am";
	$hour_sequence['01:45'] = "1:45 am";
	$hour_sequence['02:00'] = "2:00 am";
	$hour_sequence['02:15'] = "2:15 am";
	$hour_sequence['02:30'] = "2:30 am";
	$hour_sequence['02:45'] = "2:45 am";
	$hour_sequence['03:00'] = "3:00 am";
	$hour_sequence['03:15'] = "3:15 am";
	$hour_sequence['03:30'] = "3:30 am";
	$hour_sequence['03:45'] = "3:45 am";
	$hour_sequence['04:00'] = "4:00 am";
	$hour_sequence['04:15'] = "4:15 am";
	$hour_sequence['04:30'] = "4:30 am";
	$hour_sequence['04:45'] = "4:45 am";
	$hour_sequence['05:00'] = "5:00 am";
	$hour_sequence['05:15'] = "5:15 am";
	$hour_sequence['05:30'] = "5:30 am";
	$hour_sequence['05:45'] = "5:45 am";
	$hour_sequence['06:00'] = "6:00 am";
	$hour_sequence['06:15'] = "6:15 am";
	$hour_sequence['06:30'] = "6:30 am";
	$hour_sequence['06:45'] = "6:45 am";
	$hour_sequence['07:00'] = "7:00 am";
	$hour_sequence['07:15'] = "7:15 am";
	$hour_sequence['07:30'] = "7:30 am";
	$hour_sequence['07:45'] = "7:45 am";
	$hour_sequence['08:00'] = "8:00 am";
	$hour_sequence['08:15'] = "8:15 am";
	$hour_sequence['08:30'] = "8:30 am";
	$hour_sequence['08:45'] = "8:45 am";
	$hour_sequence['09:00'] = "9:00 am";
	$hour_sequence['09:15'] = "9:15 am";
	$hour_sequence['09:30'] = "9:30 am";
	$hour_sequence['09:45'] = "9:45 am";
	$hour_sequence['10:00'] = "10:00 am";
	$hour_sequence['10:15'] = "10:15 am";
	$hour_sequence['10:30'] = "10:30 am";
	$hour_sequence['10:45'] = "10:45 am";
	$hour_sequence['11:00'] = "11:00 am";
	$hour_sequence['11:15'] = "11:15 am";
	$hour_sequence['11:30'] = "11:30 am";
	$hour_sequence['11:45'] = "11:45 am";
	$hour_sequence['12:00'] = "12:00 noon";
	$hour_sequence['12:15'] = "12:15 pm";
	$hour_sequence['12:30'] = "12:30 pm";
	$hour_sequence['12:45'] = "12:45 pm";
	$hour_sequence['13:00'] = "1:00 pm";
	$hour_sequence['13:15'] = "1:15 pm";
	$hour_sequence['13:30'] = "1:30 pm";
	$hour_sequence['13:45'] = "1:45 pm";
	$hour_sequence['14:00'] = "2:00 pm";
	$hour_sequence['14:15'] = "2:15 pm";
	$hour_sequence['14:30'] = "2:30 pm";
	$hour_sequence['14:45'] = "2:45 pm";
	$hour_sequence['15:00'] = "3:00 pm";
	$hour_sequence['15:15'] = "3:15 pm";
	$hour_sequence['15:30'] = "3:30 pm";
	$hour_sequence['15:45'] = "3:45 pm";
	$hour_sequence['16:00'] = "4:00 pm";
	$hour_sequence['16:15'] = "4:15 pm";
	$hour_sequence['16:30'] = "4:30 pm";
	$hour_sequence['16:45'] = "4:45 pm";
	$hour_sequence['17:00'] = "5:00 pm";
	$hour_sequence['17:15'] = "5:15 pm";
	$hour_sequence['17:30'] = "5:30 pm";
	$hour_sequence['17:45'] = "5:45 pm";
	$hour_sequence['18:00'] = "6:00 pm";
	$hour_sequence['18:15'] = "6:15 pm";
	$hour_sequence['18:30'] = "6:30 pm";
	$hour_sequence['18:45'] = "6:45 pm";
	$hour_sequence['19:00'] = "7:00 pm";
	$hour_sequence['19:15'] = "7:15 pm";
	$hour_sequence['19:30'] = "7:30 pm";
	$hour_sequence['19:45'] = "7:45 pm";
	$hour_sequence['20:00'] = "8:00 pm";
	$hour_sequence['20:15'] = "8:15 pm";
	$hour_sequence['20:30'] = "8:30 pm";
	$hour_sequence['20:45'] = "8:45 pm";
	$hour_sequence['21:00'] = "9:00 pm";
	$hour_sequence['21:15'] = "9:15 pm";
	$hour_sequence['21:30'] = "9:30 pm";
	$hour_sequence['21:45'] = "9:45 pm";
	$hour_sequence['22:00'] = "10:00 pm";
	$hour_sequence['22:15'] = "10:15 pm";
	$hour_sequence['22:30'] = "10:30 pm";
	$hour_sequence['22:45'] = "10:45 pm";
	$hour_sequence['23:00'] = "11:00 pm";
	$hour_sequence['23:15'] = "11:15 pm";
	$hour_sequence['23:30'] = "11:30 pm";
	$hour_sequence['23:45'] = "11:45 pm";
	$hour_sequence['24:00'] = "12:00 midnight";
	return $hour_sequence;
}

function get_javascript(){
		$myStr = tag("script", attributes('src="js/event_form.js?ver=1.125"'), " ");

	return $myStr;
}
function get_javascript_validation($path){
		$myStr = tag("script", attributes('src="'.$path.'"'), " ");

	return $myStr;
}


function event_form() {
	global $noNavbar, $vars, $day, $month, $year, $db, $config, $phpc_script, $month_names, $event_types, $calendar_name, $action, $ANNOUNCE_TYPES;

	$noNavbar = false;

	if ($action != 'trip_estimate'){
		if (!isset( $_SESSION['uid'])){
			redirect($phpc_script . "?action=login");
		}
			
		if (!is_allowed_permission_checkpoint("EVENT_FORM")){
			redirect_permission_check_failed();
		}
	}
	
	$error_msg = "";
	//====================== get data

	if ( isset ($vars['subaction']) && $vars['subaction'] == "event_submit"){
		$outID = -1;
		
        
        $error_msg = event_submit($outID);
        
		if ($error_msg == ""){
            redirect( "index.php?action=display&year=" . $vars['year'] . "&month=" . $vars['month'] . "&id=" . $outID . "&page=" . $phpc_script );
		}
		$subject = $vars['subject'];
		$desc =    $vars['description'];
    $uid =     $vars['user'];
		$id = 		 $vars['id'];	

    $starthour = $vars['starthour'];
		$day       = $vars['day'];
		$month     = $vars['month'];
		$year      = $vars['year'];
		
		$endhour   =   $vars['endhour'];
		$end_day =     $vars['endday'];
		$end_month =   $vars['endmonth'];
		$end_year =    $vars['endyear'];
		
		$bookable =    $vars['bookable'];
        
		$startArray = split(":", $starthour);
		$endArray = split(":", $endhour);
		
		$startstamp =   mktime($startArray[0], $startArray[1], 0, $day, $month, $year);
		$endstamp =     mktime($endArray[0],$endArray[1], 0, $end_day, $end_month, $end_year);
		
		$username = quick_query("SELECT displayname FROM ".SQL_PREFIX."users WHERE id='$uid'","displayname");
		$name =     quick_query("SELECT ".SQL_PREFIX."vehicles.name AS name FROM " .SQL_PREFIX. "bookables INNER JOIN ".SQL_PREFIX."vehicles ON ".SQL_PREFIX."vehicles.id = ".SQL_PREFIX."bookables.vehicle_id\n","name");	
    } else if (isset ($vars['id'])) {
		// modifying
		$id = $vars['id'];

		$title = sprintf(_('Edit Booking #%d'), $id);

		$row = get_event_by_id($id);

		$uid = $row['uid'];

		$subject = htmlspecialchars(stripslashes($row['subject']));
		$desc = htmlspecialchars(stripslashes($row['description']));

		$username = $row['displayname'];
		$name =$row['name'];
		$startstamp = strtotime($row['starttime']);
		$endstamp =   strtotime($row['endtime']);
		
		//computer thinks midnight is the first second, people think it is the last second
		//need to subtract a minute to get the day to be right.
		$timestamp = strtotime($row['starttime']);
		$timestamp = $timestamp - 60;
		$year =  date("Y", $timestamp);
		$month = date("m", $timestamp);
		$day =   date("d", $timestamp);

		$hr = date('H', $startstamp);
		if (date('H', $startstamp) == 0 && date('i', $startstamp) == 0) $hr = 24;
		$starthour = $hr . ":" . date('i', $startstamp);

		$hr = date('H', $endstamp);
		if (date('H', $endstamp) == 0 && date('i', $endstamp) == 0) $hr = 24;
		$endhour = $hr . ":" . date('i', $endstamp);

		$timestamp = strtotime($row['endtime']);
		$timestamp = $timestamp - 60;
		$end_year =  date("Y", $timestamp);
		$end_month = date("m", $timestamp);
		$end_day =   date("d", $timestamp);

		//$typeofevent = $row['eventtype'];
		$bookable = $row['bookableobject'];
		
	} else {
		// case "add":
		$title = _('Create New Booking');

        if (isset ($vars['bookable'])){
            $starthour = $vars['starthour'];
            $day       = $vars['day'];
            $month     = $vars['month'];
            $year      = $vars['year'];
            
            $endhour   =   $vars['endhour'];
            $end_day =     $vars['endday'];
            $end_month =   $vars['endmonth'];
            $end_year =    $vars['endyear'];
            
            $bookable =    $vars['bookable'];
        } else {
            $day == date('j');
            $month == date('n');
            $year == date('Y');        
            $end_day = $day;
            $end_month = $month;
            $end_year = $year;
            $starthour = "13:00";
            $endhour =   "13:00";            
            if (!isset($_COOKIE['Bookable'])){
                $bookable = -1;
            } else {
                $bookable = $_COOKIE['Bookable'];
            }
        }
		$subject = '';
		$desc = '';

		$username = "";
		$name = "";

		$typeofevent = 1;

		if (!isset($_COOKIE['User'])){
			$uid = -1;
		} else {
			$uid = $_COOKIE['User'];
		}		

		$startArray = split(":", $starthour);
		$endArray = split(":", $endhour);
		
		$endstamp =     mktime($endArray[0],$endArray[1],      0, $end_day, $end_month, $end_year);
		$startstamp =   mktime($startArray[0], $startArray[1], 0, $day, $month, $year);	
	}
	
	// ================= prepare sequences for dropdown lists.
	$result = get_vehicles($calendar_name);
	$vehicles[-1] = "PLEASE SELECT A VEHICLE";
	if ($row1 = $result->FetchRow()) {
		for (; $row1; $row1 = $result->FetchRow()) {
			$vehicles[$row1['id']] = $row1['dropdownname'];
		}
	}

	$mykeys = array_keys($vehicles);
	$firstVehicle = $mykeys[0];
	if ($firstVehicle == ""){
		$firstVehicle = "0";
	}
	
	if ($bookable == -1){
		$bookable = current(array_keys($vehicles));	
	}
	
	$infoNoteText = get_notes_event_form(date('Y-m-d H:i:s'), $bookable );
	
	$users = custom_get_users_for_event_form();
	
	$year_sequence = create_sequence(2007, 2037);
		
	$hour_sequence = get_hour_sequence();

	$day_of_month_sequence = create_sequence(1, 31);
	
	//============= build form controls
	if (isset ($id))
		$input = create_hidden('id', $id);
	else
		$input = '';	

	$controls['user'] = 'enabled';
	$controls['vehicle'] = 'enabled';
	$controls['starttime'] = 'enabled';
	$controls['endtime'] = 'enabled';
	$controls['subject'] = 'enabled';
	$controls['note'] = 'enabled';
	$controls['submit'] = 'enabled';
	$controls['check_couldnt_book_car'] = 'enabled';
	
	enable_disable_event_form_controls($controls, isset($id), $startstamp, $endstamp, $id);

	if ($controls['user'] == 'enabled'){
		$memberFormContol =   create_select('user', $users, $uid);
	} else {
		$memberFormContol =   tag( "b", "&nbsp;&nbsp;" . $username, create_hidden('user', $uid));
	}
	
	if ($controls['vehicle'] == 'enabled'){
		$vehicleFormControl = tag( "font", create_select('bookable', $vehicles, $bookable, " onchange='showUser(this.value)'"));
	} else {
		$vehicleFormControl = tag( "b", "&nbsp;&nbsp;" . $name,     create_hidden('bookable', $bookable));
	}
	
	if ($controls['starttime'] == 'enabled'){		
		$date_selector= tag("input",attributes("type='text' name='date_selector' value='$month/$day/$year' id='date_selector'"));
		$day_selector = tag("input", attributes("type='hidden' name='day' id='day' value='$day'"));
		$month_selector = tag("input", attributes("type='hidden' name='month' id='month' value='$month'"));
		$year_selector = tag("input", attributes("type='hidden' name='year' id='year' value='$year'"));

		$html_time = tag('font', create_select('starthour', $hour_sequence, $starthour));
	} else {
    $date_selector = "";
		$day_selector = tag("font",$day,tag("input", attributes("type='hidden' name='day' id='day' value='$day'")));
		$month_selector = tag("font",month_name($month),tag("input", attributes("type='hidden' name='month' id='month' value='$month'")));
		$year_selector = tag("font",$year,tag("input", attributes("type='hidden' name='year' id='year' value='$year'")));
		$html_time = tag('font',formatted_time_string($starthour, 1),tag("input", attributes("type='hidden' name='starthour' value='$starthour'")));		
	}

	if ($controls['endtime'] == 'enabled'){	
		
		$end_date_selector= tag("input",attributes("type='text' name='end_date_selector' value='$month/$day/$year' id='end_date_selector'"));
		$end_day_selector = tag("input", attributes("type='hidden' name='endday' id='endday' value='$end_day'"));
		$end_month_selector = tag("input", attributes("type='hidden' name='endmonth' id='endmonth' value='$end_month'"));
		$end_year_selector = tag("input", attributes("type='hidden' name='endyear' id='endyear' value='$end_year'"));
		$html_end_time = tag('font', create_select('endhour', $hour_sequence, $endhour));
	} else {
		$end_date_selector;
		$end_day_selector = tag("font",$end_day);
		$end_month_selector = tag("font",month_name($end_month));
		$end_year_selector = tag("font",$end_year);
		$html_end_time = tag('font',formatted_time_string($endhour,1) );		
	}

	if ($controls['subject'] == 'enabled'){
		$subject_control = tag('input', attributes('type="text"', "size=\"65\"", "maxlength=\"255\"", 'name="subject"','id="subject"', "value=\"$subject\""));
	} else {
		$subject_control = tag('font', $subject);
	}
	
	if ($controls['note'] == 'enabled'){
		$desc_control = tag('textarea', attributes('rows="10"', 'cols="50"', 'name="description" id="description"'), $desc);
	} else {
		$desc_control = tag('font', $desc);
	}
	
	if ($controls['submit'] == 'enabled'){
		if (isset ($vars['id'])){
			$submit_control = create_submit(_("Modify Booking"));
		} else {
			$submit_control = create_submit(_("Create Booking"));
		}
	} else {
		$submit_control = "";
	}	

	if ($controls['check_couldnt_book_car'] == 'enabled'){
		$check_couldnt_book_car = tag("font",
		                            tag("input", attributes("type='checkbox' onclick='showHideCouldntBookCar()'")), tag("br"),
		                            tag("div", attributes('id="couldntBookCarReasonDiv"', 'class="phpc-hidediv"'),
		                                'Car you wanted', create_select('couldntBookBookable', $vehicles, $bookable),
		                                '<br/>Comment (optional)<br/>',
		                                tag('textarea', attributes('rows="2"', 'cols="50"', 'name="couldntBookCarReason"', 'id="couldntBookCarReason"'),$desc)
		                                )
		                            );
	} else {
		$check_couldnt_book_car = "";
	}
	
    $num_km_estimate = create_text('num_km_estimate');
    $estimate_submit = create_submit("Estimate trip cost", 'tripestimate');
    
	$show_available = tag('a', attributes("href='#' id='openShowAvailability'"), "show availability");
	$trip_estimate = tag('a', attributes("href='#' onclick='openTripEstimateWindow()'"),  "trip estimate");
	
	if ( $infoNoteText == ""){
		$infoVis = "hidden";
	} else {
		$infoVis = "visible";
	}
	
	$retText = tag('div');
	

    $retText->add(get_javascript());
	
	

	if ($action != "trip_estimate"){
		$retText->add(
					tag("div",
							attributes("id='infoText' class='info-msg-box' style='visibility: $infoVis'"),
							$infoNoteText)
					 );
	}

	$hasInfo = false;
	$infoBox = tag('div');
	if ($error_msg != "") {
		$infoBox->add(
					tag("div",
							attributes("class='error-msg-box'"),
							$error_msg)		
					  );
		$hasInfo = true;
	}
	
	$h3info = '';
	if($hasInfo == false)
	{
		$h3info = '';
		$infoBox = '';
	}

    if ($action == "trip_estimate"){
        $LIST_COST_ESTIMATE = true;
    }else{
        $TABLE_FORM = true;
        $LIST_FORM = false;
    }
    
	if ($TABLE_FORM){
        $retText->add( tag('div',	
                         tag('form', attributes("action=\"$phpc_script\" name='event_form' id='event_form' method='post'" ), 
                                    tag('table', attributes('class="phpc-main" border="0"'), tag('caption', $title), tag('tfoot', 
                                        tag('tr', tag('td', attributes('colspan="2"'), $input, create_hidden('action', 'event_form'), create_hidden('subaction', 'event_submit')))), 
                                        tag('tbody',
                                            tag('tr', 
												tag('td', attributes("colspan='2'"), 
																$h3info,
																$infoBox,												
													tag('div',attributes("id='accordion'"),

																tag('h3', 'Event Form'),
																tag('div',
																	tag('table',
                                            tag('tr', tag('th', _('For Member')), tag('td', $memberFormContol ) ), 
                                            tag('tr', tag('th', _('Vehicle')), tag('td', $vehicleFormControl, tag('a', attributes("id='openCouldntBookCarLink' href='#'"), "Couldn't get what you wanted?") )), 

											tag('tr', tag('th', _('&nbsp;')), tag('td',  $show_available)),

                                            tag('tr', tag('th', _('Start Date')), tag('td', $date_selector, $day_selector,$month_selector,$year_selector, tag("b"," Start Time"),   $html_time)), 
                                            tag('tr', tag('th', _('End Date')),   tag('td', $end_date_selector, $end_day_selector, $end_month_selector, $end_year_selector, tag("b"," End Time"), $html_end_time)), 									  				    
                                            tag('tr', tag('th', _('&nbsp;')), tag('td',  $trip_estimate)),
                                            tag('tr', tag('th', _('Subject') . ''), tag('td',$subject_control)), 
                                            tag('tr',attributes('class="description"'), tag('th', _('Note')), tag('td', $desc_control)),
									                                            tag('tr', tag('td',attributes("colspan='2' align='center'"), $submit_control))
																		)
																),
															/*															
																tag('h3', 'Availability'),
																
																tag('div',attributes("id='show_availability_div'"), show_available_table() , 
																	tag("br") , 
																	tag('a', attributes("href='#' id='refreshShowAvailability'"), "refresh show availability")
																),
*/
																tag('h3', 'Vehicle Locations'),
																tag('div','<iframe src="../../show_vehicle_locations.php?cal='.$calendar_name.'" width="402" height="402" marginheight="0" marginwidth="0" scrolling="no"></iframe>')	
														),
														'<script type="text/javascript">
															$(function() {
																$( "#accordion" ).accordion({ header: "h3", collapsible: true });
															});
														</script>'
											   		)
												)
										)
                        	)
													)		
                        ));
         $noNavbar = false; //calling show availale sets the flag so need to set it  back to false               
	} else if ($LIST_FORM) {
        $retText->add(
                        tag('div', '<iframe src="../../show_vehicle_locations.php?cal='.$calendar_name.'" width="402" height="402" marginheight="0"     marginwidth="0" scrolling="no"></iframe>' ), 
                        tag('div',		
                             tag('form', attributes("action=\"$phpc_script\"","method=\"post\""), 
                                tag('ul', attributes('class="phpc-main" border="0"'),
                                    tag('li', 'For Member', $memberFormContol),
                                    tag('li', 'Vehicle', $vehicleFormControl, tag('a', attributes("id='openCouldntBookCarLink' href='#'"), "Couldn't get what you wanted?")),
                                    tag('li', 'Start Date', $day_selector, $month_selector, $year_selector, "Start Time", $html_time),
                                    tag('li', 'End Date',   $end_day_selector, $end_month_selector, $end_year_selector, " End Time", $html_end_time),
                                    tag('li', 'Subject',  $subject_control),
                                    tag('li', 'Note', $desc_control),
                                    tag('li', $submit_control, $show_available, create_hidden('action', 'event_form'), create_hidden('subaction', 'event_submit'))
                                    )
                             )
                        )
                     );
    } else if ($LIST_COST_ESTIMATE) {
         $retText->add(
//                        tag('div', '<iframe src="../../show_vehicle_locations.php?cal='.$calendar_name.'" width="402" height="402" marginheight="0"     marginwidth="0" scrolling="no"></iframe>' ), 
                        tag('div',
                             tag('form', attributes("id='trip_estimate' action=\"$phpc_script\"", "method=\"post\""), 
                                tag('ul', attributes('class="phpc-main" border="0"'),
                                    tag('li class="estimate"', 'Your Vehicle: ', $vehicleFormControl),
                                    tag('li class="estimate"', 'Start Date: ', $date_selector, $day_selector,$month_selector,$year_selector),
                                    tag('li class="estimate"', 'Start Time: ', $html_time),
                                    tag('li class="estimate"', 'End Date: ',   $end_date_selector, $end_day_selector, $end_month_selector, $end_year_selector),
                                    tag('li class="estimate"', 'End Time: ', $html_end_time),
                                    tag('li class="estimate"', 'Estimated number of km: ', $num_km_estimate),
                                    tag('li', $estimate_submit, create_hidden('action', 'trip_estimate'), create_hidden('subaction', 'trip_estimate_submit'))
                                    )
                             )
                        )
                     );       
    }
    
	return $retText;
}


?>
