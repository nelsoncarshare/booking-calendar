<?php

define('IN_PHPC', true);
$phpc_root_path = './';
require_once($phpc_root_path . 'custom/config.php');
require_once($phpc_root_path . 'includes/calendar.php');
require_once($phpc_root_path . 'includes/setup.php');
require_once($phpc_root_path . 'includes/globals.php');
session_start();
if(isset($_GET['inv'])){
	$type = quick_query("select type from ".SQL_PREFIX."invoicables where id=".$_GET['inv'], "type");
	if ($type == $GROUP_FOR_INDIVIDUALS){
		$userid = quick_query("select user_id from ".SQL_PREFIX."invoicables where id=".$_GET['inv'], "user_id");
	} else {
		$userid = quick_query("select group_id from ".SQL_PREFIX."invoicables where id=".$_GET['inv'], "group_id");		
	}
	$invoiceableID = $_GET['inv'];
} else {
	$userid = $_GET['user'];
	$invoiceableID = get_invoicable_id($userid);
}
$filename = $_GET['file'];


if ((check_user() && $_SESSION['uid'] == $userid) || is_allowed_permission_checkpoint("VIEW_ALL_INVOICES")) {
	
	if ($vars['user'] == "_ALL_USERS"){
		$lid = "_ALL_USERS";
	} else {
		$lid = str_pad($invoiceableID, 15, 0, STR_PAD_LEFT);
	}
	
	$myFile = USER_HOME . "invoicables/" . $lid . "/invoices/" . $filename;
	$theData = "";
	if ($handle = fopen($myFile, 'r') ){
	    while (!feof($handle)) {
        	$theData .= fgets($handle, 4096);
        	//echo $buffer;
	    }
	    fclose($handle);
    }
	echo $theData;
} else {
	print_r($_SESSION);
	echo "'" . $_SESSION['uid'] . "' '" . $userid . "'";
	echo "'" . is_allowed_permission_checkpoint("VIEW_ALL_INVOICES") . "'";
	echo "<h2>Please login</h2>";
}
?>