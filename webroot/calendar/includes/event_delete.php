<?php
/*
   Copyright 2002 - 2005 Sean Proctor, Nathan Poiro

   This file is part of PHP-Calendar.

   PHP-Calendar is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   PHP-Calendar is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with PHP-Calendar; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if ( !defined('IN_PHPC') ) {
       die("Hacking attempt");
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
    
	return ($db->Affected_Rows($result) > 0);
}

function event_delete()
{
	global $config, $phpc_script;

	if (!isset( $_SESSION['uid'])){
		redirect($phpc_script . "?action=login");
	}
	if ($_SESSION['uid'] == 0 || $_SESSION['uid'] == Null){
	    sendDelMessage();  
	    redirect($phpc_script . "?action=login");
	}
	
	if (!is_allowed_permission_checkpoint("EVENT_DELETE")){
		redirect($phpc_script); //TODO Decide what to do.
	}
		
	$del_array = explode('&', $_SERVER['QUERY_STRING']);

	$html = tag('div', attributes('class="info-msg-box"', 'style="width: 50%"'));

    $ids = 0;

	foreach($del_array as $del_value) {
		list($drop, $id) = explode("=", $del_value);

		if(preg_match('/^id$/', $drop) == 0) continue;
                $ids++;

		custom_remove_event($id);
		
		$html->add(tag('p', attributes("align='center'"), tag("h3",_('Removed booking') . ": $id")));

	}

	if($ids == 0) {
		$html->add(tag('p', attributes("align='center'"), tag("h3",_('No items selected.'))));
	}

	$outTxt = tag("div", attributes("align='center'", 'style="width: 90%"'));
	$outTxt->add($html);
	$outTxt->add(tag("br"));
	$outTxt->add(tag('p', attributes("align='center'"), tag("a",attributes("href='$phpc_script'"),"return to calendar")));
    return $outTxt;
}
?>
