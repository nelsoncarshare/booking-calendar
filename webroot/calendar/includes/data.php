<?php
/*
function get_vehicle_locations_ajax($cal_name)
{
	global $db;
	$query = "select ".SQL_PREFIX."bookables.name as description, GPS_coord_x as lat, GPS_coord_y as lng, imagefile as icon from ".
		SQL_PREFIX."bookables inner join ".SQL_PREFIX."locations on ".SQL_PREFIX."bookables.location_id=".
		SQL_PREFIX."locations.id inner join ".SQL_PREFIX."vehicles on ".SQL_PREFIX."bookables.vehicle_id=".SQL_PREFIX."vehicles.id left outer join ".
		SQL_PREFIX."vehicletypes on ".SQL_PREFIX."vehicletypes.id=".SQL_PREFIX."vehicles.vehicle_type inner join ".
		SQL_PREFIX."bookables_calendars on ".SQL_PREFIX."bookables_calendars.bookable_id=".SQL_PREFIX."bookables.id inner join ".
		SQL_PREFIX."calendars on ".SQL_PREFIX."bookables_calendars.calendar_id=".SQL_PREFIX."calendars.id ".
		" where disabled='0' and calendar=".$cal_name;
	
	$result = $db->Execute($query)
		or db_error(_('Error in get_locations'), $query);
	$jsonData = array();
	while($row = $result->FetchRow($result)) {
	    $jsonData[] = $row;
	}
	return json_encode($jsonData);
}
*/

function data()
{
	
	header('Content-Type: application/javascript');
	
	if(isset($_GET['vehicle_locations'])) {
		echo get_vehicle_locations_ajax($_GET['calendar_name']);
		return;
	}
	
	if(isset($_GET['calendars'])) {
		echo get_calendars();
		return;
	}
	
	if (!check_user()){
	   	$jsonData = array();
		echo json_encode($jsonData);	
	} else {	
		if(isset($_GET['note_calendar'])) 	echo get_note_calendar_ajax($_GET['calendar_name'], $_GET['year'], $_GET['month']);
		else if(isset($_GET['events'])) 		echo get_events_for_month_ajax($_GET['month'], $_GET['year'], $_GET['calendar_name'], $_GET['get_old']);
 	}
}

?>