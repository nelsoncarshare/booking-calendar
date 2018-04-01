<?php

$phpc_root_path = './';
define('IN_PHPC', true);

session_start();
$calendar_name = '0';
if (isset($_GET['cal'])){
	$calendar_name = $_GET['cal'];
	$_SESSION['calendar'] = $calendar_name;
} else if (isset($_SESSION['calendar'])){
	$calendar_name = $_SESSION['calendar'];
}

if (isset($_GET['action']) && $_GET['action'] == 'data')
{
	require_once($phpc_root_path . 'includes/calendar.php');
	require_once($phpc_root_path . 'includes/setup.php');
	require_once($phpc_root_path . 'includes/data.php');//for clean json transfer between the browser and the server
	data();
}
else
{
require_once($phpc_root_path . 'includes/calendar_cont.php');
}
?>
