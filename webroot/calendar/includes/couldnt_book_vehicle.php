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

function couldnt_book_vehicle()
{
	global $config, $phpc_script, $vars, $calendar_name, $noNavbar, $db, $VEHICLE_LABEL;

	if (!isset( $_SESSION['uid'])){
		redirect($phpc_script . "?action=login");
	}
	
	$noNavbar = true;
	
	if(isset($vars['submit'])){
		$uid = $_SESSION['uid'];
		$bookable = $vars['bookable'];
		$comment = $vars['couldntBookCarReason'];
		
		$query = "INSERT INTO ".SQL_PREFIX."couldnt_book_vehicle \n"
			."(uid, bookable, comment, creationtime) "
			."VALUES ( '$uid',$bookable, " . $db->qStr( $comment ) . ", NOW() )";
	
		$result = $db->Execute($query);		
		if(!$result) {
			db_error(_('Error processing event'), $query);
		}
	}
	
	$result = get_vehicles($calendar_name);
	$vehicles[-1] = "PLEASE SELECT A $VEHICLE_LABEL";
	if ($row1 = $result->FetchRow()) {
		for (; $row1; $row1 = $result->FetchRow()) {
			$vehicles[$row1['id']] = $row1['dropdownname'];
		}
	}		

	$vehicleFormControl = tag( "font", create_select('bookable', $vehicles, 0));

 	$frm = tag('form', attributes("action=\"$phpc_script\""), create_hidden('action', 'couldnt_book_vehicle'));
	$tbl = tag("table", attributes("class='phpc-main' border='0' cellpadding='0' cellspacing='0'"), tag('caption', "Couldn't Book $VEHICLE_LABEL"));

	$tbody = tag("tbody");
	$tr = tag("tr");
	$tr->add(tag("td", attributes("colspan=2"), "Please take a moment to let us know if you had a problem booking a $VEHICLE_LABEL. This helps us plan where $VEHICLE_LABEL s are placed.<br/><br/>"));
	$tbody->add($tr);

	$tr = tag("tr");
	$tr->add(tag("td", attributes("nowrap='true'"), "$VEHICLE_LABEL you wanted to book:"));
	$tr->add(tag("td", attributes("valign='left'"), $vehicleFormControl));

  $tbody->add($tr);
    
	$tr = tag("tr");
	$tr->add(tag("td", attributes("valign='right'"), "Comment:"));
	$tr->add(tag("td", attributes("valign='left'"), tag('textarea', attributes('rows="10"', 'cols="50"', 'name="couldntBookCarReason"', 'id="couldntBookCarReason"'),"")));

    $tbody->add($tr);    

    $submit_control = create_submit(_("Submit"));

	$tr = tag("tr");
	$tr->add(tag("td", attributes("align='center' colspan='2'"), $submit_control ));
	$tbody->add($tr);
	$tbl->add($tbody);
	$outTxt = tag("div", attributes("align='center'", 'style="width: 90%"'));
	$outTxt->add(get_javascript());
	$frm->add($tbl);
	$outTxt->add($frm);
	$outTxt->add(tag("br"));
	$outTxt->add(tag('p', attributes("align='center'"), tag("a",attributes("href='#' onClick='window.close();'"),"close")));
  return $outTxt;
}

function get_javascript(){
	global $config, $phpc_script, $vars, $calendar_name, $noNavbar, $db;
	if (isset($vars['submit'])){
		$javaText = 'window.close()';
		$myStr = tag("script", attributes('type="text/javascript"'), $javaText);
		return $myStr;
	} else {
		return '';
	}
}

?>
