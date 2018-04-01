<?php

/* custom rules specific to certain carshares  */
function custom_get_threshold_time_stamp($curTimestamp){
	$curTime = getDate($curTimestamp);
	return mktime(0,0,0,$curTime['mon'],$curTime['mday'] + 2,$curTime['year']);
}

function custom_get_delete_warning($id){
	global $db;
	
	$tTime = time() + (48*60*60);
	$query = "select (" . $db->SQLDate('Y-m-d-H-i', 'starttime')." < DATE '" . date('Y-m-d', $tTime). "') AS isInTwoDayWindow from ".SQL_PREFIX."events where id='$id'";	
	$isInTwoDayWindow = quick_query($query, "isInTwoDayWindow");

	$twoDayWarning = "";
	if ($isInTwoDayWindow) {
		$twoDayWarning = " You are within the 2-day no refund period. You will be charged for time booked between now and midnight tomorow.";
	}
		
	return "Are you sure you want to delete this booking?$twoDayWarning";
}

function custom_remove_event($id){
	global $db, $CANCELED;
	//if (remove_event($id)){

		$tTime = time() + (48*60*60);
		$query = "select (" . $db->SQLDate('Y-m-d-H-i', 'starttime')." < DATE '" . date('Y-m-d', $tTime). "') AS isInTwoDayWindow from ".SQL_PREFIX."events where id='$id'";	
		$isInTwoDayWindow = quick_query($query, "isInTwoDayWindow");
	
		if ($isInTwoDayWindow){		
				$sql = "UPDATE ".SQL_PREFIX."events\n"
				."SET "
				."canceled='".$CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']."'\n"
				."WHERE id='$id'";
				
				$result = $db->Execute($sql)
					or db_error(_('Error while removing an event.'), $sql);
		}
	//}
}

function custom_get_users_for_event_form(){
	$users[-1] = "PLEASE SELECT A USER";
	$result = get_users();
	if ($row1 = $result->FetchRow()) {
		for (; $row1; $row1 = $result->FetchRow()) {
			if ($row1['displayname'] != 'nelsoncar'){ //TODO remove this after a few weeks.
				$users[$row1['id']] = $row1['displayname'];
			}
		}
	}	
	return $users;
}

function enable_disable_event_form_controls(&$controls, $modifying, $startstamp, $endstamp, $id){
	global $db;
	if ($modifying){
		$tTime = time() + (48*60*60);
		$query = "select (" . $db->SQLDate('Y-m-d-H-i', 'starttime')." < DATE '" . date('Y-m-d', $tTime). "') AS isInTwoDayWindow from ".SQL_PREFIX."events where id='$id'";	
		$isInTwoDayWindow = quick_query($query, "isInTwoDayWindow");
		
		// user and vehicle not editable if in 2 day window.
		$curTime = getdate();
		$curTimeStamp = mktime($curTime['hours'],$curTime['minutes'],0,$curTime['mon'],$curTime['mday'],$curTime['year']);

		if (($isInTwoDayWindow || $startstamp < $curTimeStamp) && !is_allowed_permission_checkpoint("EVENT_FORM.SET_PAST_TIME")){
			$controls['user'] = 'disabled';
			$controls['vehicle'] = 'disabled';
		}
		
		// start time not editable if it is in the past
		if (($startstamp < $curTimeStamp) && !is_allowed_permission_checkpoint("EVENT_FORM.SET_PAST_TIME")){
			$controls['starttime'] = 'disabled';
		} 

		if (($endstamp < ( $curTimeStamp - 60*60*24)) && !is_allowed_permission_checkpoint("EVENT_FORM.SET_PAST_TIME") ){
			$controls['endtime'] = 'disabled';
			$controls['subject'] = 'disabled';
			$controls['note'] = 'disabled';
			$controls['submit'] = 'disabled';
		}
	}
}

function custom_actions_on_login(){
	
}
?>