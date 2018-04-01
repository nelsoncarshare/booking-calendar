<?php

define('IN_PHPC', true);
$phpc_root_path = '../';

require_once($phpc_root_path . 'includes/calendar.php');
require_once($phpc_root_path . 'includes/setup.php');
require_once($phpc_root_path . 'includes/globals.php');
session_start();

$id=$_GET["id"];

$row = get_event_by_id($id);

if (!check_user()){
    echo("Not logged in.");
    exit();
}

if ($row){
    $sdt = strtotime($row['starttime']);
    $edt = strtotime($row['endtime']);
    echo("<b>User:</b> " . $row['displayname'] . "<br/>");   
    echo("<b>User:</b> " . $row['name'] . "<br/>");  
    echo("<b>Start time:</b> " . date( "g:i a, l F d, Y", $sdt) . "<br/>");
    echo("<b>End time:</b> " .   date( "g:i a, l F d, Y", $edt) . "<br/>");   
} else {
    echo("Could not find event details in database.");     
}

?>