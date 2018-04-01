<?php

define('IN_PHPC', true);
$phpc_root_path = '../';

require_once($phpc_root_path . 'includes/calendar.php');
require_once($phpc_root_path . 'includes/setup.php');
require_once($phpc_root_path . 'includes/globals.php');
require_once($phpc_root_path . 'custom/rules.php');
session_start();

$id=$_GET["id"];

$row = remove_event($id);

if (!check_user()){
    echo("Not logged in.");
    exit();
}





function remove_event($id)
{
	global $db,$CANCELED,$OPERATION;
	
	$row = get_event_by_id($id);
	
	$myState = $CANCELED['CANCELED'];
	$operation = $OPERATION['CANCEL'];
	
	$curTime = getdate();
	$curTimeStamp = mktime($curTime['hours'],$curTime['minutes'],0,$curTime['mon'],$curTime['mday'],$curTime['year']);
	$endTimeStamp = strtotime( $row['endtime'] );
	if ($endTimeStamp < $curTimeStamp){
		soft_error("Cannot delete an event that is in the past.");
	}

	$sql = "UPDATE ".SQL_PREFIX."events\n"
			."SET "
			."canceled='".$myState."',\n"
			."canceledtime=NOW(),\n"
			."modifytime=NOW()\n"
			."WHERE id='$id'";
			
	$result = $db->Execute($sql)
		or db_error(_('Error while removing an event.'), $sql);

	$amt_tagged = tag_time($id, -1, -1, $row['bookableobject']);
	$mystartdatetime = "'" . date('Y-m-d-H-i', strtotime( $row['starttime'])). "'";
	$myenddatetime = "'" . date('Y-m-d-H-i', strtotime( $row['endtime'])). "'";
	insert_to_event_log($id,$_SESSION['uid'],$operation,$row['uid'],$mystartdatetime,$myenddatetime,$row['subject'],$row['description'],$row['bookable'],$myState, $amt_tagged);	
   
  $res = $db->Affected_Rows($result) > 0;
  if ($res){
  	//echo("custom remove event");
  	custom_remove_event($id);
  }  
	return ($res);
}

// function event_delete($id)
// {
// 	global $config, $phpc_script;

// 	if (!isset( $_SESSION['uid'])){
// 		redirect($phpc_script . "?action=login");
// 	}
// 	if ($_SESSION['uid'] == 0 || $_SESSION['uid'] == Null){
// 	    sendDelMessage();  
// 	    redirect($phpc_script . "?action=login");
// 	}
	
// 	if (!is_allowed_permission_checkpoint("EVENT_DELETE")){
// 		redirect($phpc_script); //TODO Decide what to do.
// 	}
		
// 	$del_array = $id;

// 	$html = tag('div', attributes('class="info-msg-box"', 'style="width: 50%"'));

//     $ids = 0;

// 	foreach($del_array as $del_value) {
// 		list($drop, $id) = explode("=", $del_value);

// 		if(preg_match('/^id$/', $drop) == 0) continue;
//                 $ids++;

// 		custom_remove_event($id);
		
// 		$html->add(tag('p', attributes("align='center'"), tag("h3",_('Removed booking..') . ": $id")));

// 	}

// 	if($ids == 0) {
// 		$html->add(tag('p', attributes("align='center'"), tag("h3",_('No items selected.'))));
// 	}

// 	$outTxt = tag("div", attributes("align='center'", 'style="width: 90%"'));
// 	$outTxt->add($html);
// 	$outTxt->add(tag("br"));
// 	$outTxt->add(tag('p', attributes("align='center'"), tag("a",attributes("href='$phpc_script'"),"return to calendar")));
// 	return 'NODISP';
//     //return $outTxt;
// }



?>