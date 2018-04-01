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
  echo("<li style='background: ".$row['color'].";'>");
  echo("<div class=\"car_dive_display\" id=\"".$row['id']."\">");
    $sdt = strtotime($row['starttime']);
    $edt = strtotime($row['endtime']);
    echo( $row['name'] . "<br/>");  
      
    
    echo( date( "g:i a", $sdt) . " to ");
    echo(  date( "g:i a", $edt) . "<br/>");   
    echo( $row['displayname'] . "<br/>"); 
    echo( '<a href="#" onclick="openDetailedCarShareRecord('.$id.', \''.$row['name'].' \'); return false;" style="color:black; font-weight: bold;">[more][edit]</a>');
    echo("</div>");
} else {
    echo("Could not find event details in database.");     
}

?>