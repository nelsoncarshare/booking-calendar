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


function show_available()
{
	$tbl = show_available_table();

	$outTxt = tag("div", attributes("align='center'", 'style="width: 90%"'));
	
	$outTxt->add(
			tag("div",
					attributes("class='error-msg-box' hidden='true'"),"")		
	);
	
	$outTxt->add($tbl);
	$outTxt->add(tag("br"));
	$outTxt->add(tag('p', attributes("align='center'"), tag("a",attributes("href='#' onClick='window.close();'"),"close")));
	return $outTxt;		
}

function show_available_table()
{
	global $config, $phpc_script, $vars, $calendar_name, $noNavbar;

	if (!isset( $_SESSION['uid'])){
		redirect($phpc_script . "?action=login");
	}
	
	$noNavbar = true;
	
	//render results
	$tbl = tag("table", attributes("border='1' cellpadding='0' cellspacing='0'"));

  //days legend
	$tr = tag("tr");
	$tr->add(tag("td", attributes("nowrap='true' align='left'"), "Date:"));
	$tr->add(tag("td", attributes("nowrap='true' id='days'"), ""));
//	if ( 24 - date('H', $starttimePadded) > 0 ){
//		$tr->add(tag("td", attributes("colspan='" . (24 - date('H', $starttimePadded))*4 . "'"), ""));
//	}
//	
//	$style='';
//	for ($i = $starttimePadded; $i < $endtimePadded; $i += $fifteenMinutes){
//		  $style = '';
//			if (date('H:i', $i) == "00:00"){
//				$cont = date('D j', $i);
//				$style .= " border-left: 1px solid #000000; ";
//		    $tr->add(tag("td", attributes("colspan='" . (4*24) . "' nowrap='true' style='$style'"), $cont));
//			}
//	}
		$tbl->add($tr);
//	
  //hours legend
	$tr = tag("tr");
	$tr->add(tag("td", attributes("nowrap='true' align='left'"), "Hour:"));
	$tr->add(tag("td", attributes("nowrap='true' id='hours'"), ""));
//	for ($i = $starttimePadded; $i < $endtimePadded; $i +=  ($fifteenMinutes * 4 * $step)){
//		if(date('i', $i) != 0) echo date('i', $i);
//		$cont = date('ga', $i);
//		$style = " border-left: 1px solid #000000; ";
//		$tr->add(tag("td", attributes("class='sa' colspan='" . 4 * $step . "' nowrap='true' style='$style'"), $cont));
//	}
	$tbl->add($tr);

	//now do events
	$result = get_vehicles($calendar_name);

	$row1 = $result->FetchRow();
	for (; $row1; $row1 = $result->FetchRow()) {	
			$tr = tag("tr");
			$tr->add(tag("td", attributes("class='sa' style='background-color: ".$row1['color']."' nowrap='true'"), $row1['name']));
			$tr->add(tag("td", attributes("nowrap='true' vid='".$row1['id']."'"), ""));
			$tbl->add($tr);
	}

  $tbl->add(tag("script", attributes('src="js/show_available.js"'), " "));
  return $tbl;
}

?>
