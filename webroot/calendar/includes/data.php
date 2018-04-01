<?php

function data()
{
	header('Content-Type: application/javascript');
	if (!check_user()){
	   	$jsonData = array();
			echo json_encode($jsonData);	
	} else {	
		if(isset($_GET['calendars'])) 			echo get_calendars();
		else if(isset($_GET['note_calendar'])) 	echo get_note_calendar_ajax($_GET['calendar_name'], $_GET['year'], $_GET['month']);
		else if(isset($_GET['events'])) 		echo get_events_for_month_ajax($_GET['month'], $_GET['year'], $_GET['calendar_name'], $_GET['get_old']);
	}
}

?>