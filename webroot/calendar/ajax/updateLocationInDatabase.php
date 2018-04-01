<?php

define('IN_PHPC', true);
$phpc_root_path = '../';

require_once($phpc_root_path . 'includes/calendar.php');
require_once($phpc_root_path . 'includes/setup.php');
require_once($phpc_root_path . 'includes/globals.php');

$lt=$_GET["lt"];
$lg=$_GET["lg"];
$vid = $_GET["vid"];
$op = $_GET["op"];

if ( !is_numeric($lt) ){
	echo("latitude was not numeric");
	exit();
}

if ( !is_numeric($lg) ){
	echo("longitude was not numeric");
	exit();
}

if ( !is_numeric($vid) ){
	echo("vehicle number was not set for this vehicle");
	exit();
}

if ( $op == "ADMIN_SET_LOC" ){

	$query = "UPDATE ".SQL_PREFIX."locations\n"
			."SET "
			."GPS_coord_x='$lt',\n"
			."GPS_coord_y='$lg'\n"
			."WHERE id='$vid'";
	//echo($query);
	$result = $db->Execute($query);
	if (!$result){
		echo($db->ErrorNo().': '.$db->ErrorMsg() . ' ' . query);
	}
	exit();
} else {
	echo("Unknown operation");
	exit();	
}

?>