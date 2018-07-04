<?php
/*
   Copyright 2005 Sean Proctor

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
   
   Copyright 2012 Substantial modifications by Ian Deane
 */
if ( !defined('IN_PHPC') ) {
       die("Hacking attempt");
}

// picks which view to show based on what data is given
// returns the appropriate view
function display()
{
	global $vars, $day, $month, $year, $noNavbar, $calendar_name;
	//$noNavbar = true;

	if (!is_allowed_permission_checkpoint("DISPLAY")){
		redirect_permission_check_failed();
	}
	/*
	if(isset($vars['modal_id'])) return modal_id($vars['modal_id']);
	if(isset($vars['event_history'])) return event_history($vars['event_history']);
	if(isset($vars['id'])) return display_id($vars['id']);
	if(isset($vars['day'])) return display_day($day, $month, $year);
	if(isset($vars['month'])) return display_month($month, $year);
	if(isset($vars['week'])) return display_week($vars['number_of_week'], $month, $year);
	if(isset($vars['year'])) soft_error('year view not yet implemented');
	return display_month($month, $year);
	*/
	
	if(isset($vars['event_history']))
	{
		return event_history($vars['event_history']);
	}
	else if(isset($vars['day']))
	{
		return display_day($day, $month, $year);
	}
	else if(isset($vars['week_num']))
	{
		return display_week($vars['week_num'], $month, $year);
	}
	else
	{	
	if(isset($vars['modal_id'])) return modal_id($vars['modal_id']);
	return "<script type=\"text/javascript\">window.is_logged_in = ".(check_user() ? 'true' : 'false').";$( document ).ready(function() {Calendar.buildCalendarAjax('".$month."', '".$year."', '".$calendar_name."')});</script>";
	}
	//
}

// creates a menu to navigate the month/year
// returns XHTML data for the menu
function month_navbar($month, $year)
{
	$html = tag('div', attributes('class="phpc-navbar"'));
	//$html->add( "|&nbsp;&nbsp;") ;

	menu_item_append_as($html, _('<'), 'display', 'class="arrow"', false, $year, $month - 1);

	menu_item_append_as($html,  _('>'), 'display', 'class="arrow"', false, $year, $month + 1);

	return $html;
}

function day_name_html($day)
{
	$day_names_html = array(
	        _('Sunday') => "Sun<span>day</span>",
			_('Monday') => "Mon<span>day</span>",
			_('Tuesday') => "Tue<span>sday</span>",
			_('Wednesday') => "Wed<span>nesday</span>",
			_('Thursday') => "Thu<span>rsday</span>",
			_('Friday') => "Fri<span>day</span>",
			_('Saturday') => "Sat<span>urday</span>",
	);
	
	return $day_names_html[$day];
}

// creates a tables of the days in the month
// returns XHTML data for the month
function display_month($month, $year)
{
	global $config, $ANNOUNCE_TYPES, $calendar_name, $phpc_script, $db, $vars;

	if (!isset( $_SESSION['uid'])){
		redirect($phpc_script . "?action=login");
	}
	
	if(isset($vars['viewold']) && $vars['viewold'] == 'true'){
		$_SESSION['VIEW_OLD'] = true;
	}

	$days = tag('tr');
	for($i = 0; $i < 7; $i++) {
		if($config['start_monday'])
			$d = $i + 1 % 7;
		else
			$d = $i;
		$days->add(tag('th', day_name_html(day_name($d))));
	}

	$curTime = getdate();
	$curTimeStamp = mktime($curTime['hours'],$curTime['minutes'],0,$curTime['mon'],$curTime['mday'],$curTime['year']);
	$result = get_note_calendar( $calendar_name , $curTimeStamp );
	
	$iText = tag("font");
	$found = false;
	while($row = $result->FetchRow($result)) {
		$found = true;
		$iText->add(tag("a",attributes("onClick='openAnnouncement(\"display_announcement.php?id=".$row['id'] ."\", \"".$row['title']."\");'"),tag("h3", $row['title'])));
	}
	
	if ( $found ){
		$infoNoteText = tag('div', 
								attributes("style='margin: 8px 0px 8px 0px; padding: 4px 4px 4px 4px; border: 2px solid #000; background-color: #FFFFDD;'"),
								$iText
								);
	} else {
		$infoNoteText = "";
	}

	if ( $_SESSION['VIEW_OLD'] != true ){
		$displayOldLink =tag('div', attributes('class="phpc-navbar"'),
		    tag("a",attributes("href='$phpc_script?action=display&amp;year=$year&amp;month=$month&amp;viewold=true'"),"Older bookings are hidden for faster page load. Click to view."));
	} else {
		$displayOldLink = "";
	}
	
	$calText = tag('div', 
					tag('div',$infoNoteText),
					tag('div',
                        month_navbar($month, $year),
                        $displayOldLink,
                        tag('table', attributes('class="calendar"'),
                                tag('caption', $config['calendar_title'] . " / " . month_name($month)." $year"),
                                tag('thead', $days),
                                create_month($month, $year))),
                         month_navbar($month, $year)       
					);

    	
	return $calText;
}

// creates a display for a particular month
// return XHTML data for the month
function create_month($month, $year)
{
	$resultRows = get_events_for_month($month, $year);
	$result = $resultRows->GetRows();
	//print_r($result);
	return tag('tbody', create_weeks($result, 1, $month, $year));
}

function display_week($week_of_month, $month, $year)
{
	$resultRows = get_events_for_month($month, $year);
	$result = $resultRows->GetRows();
    $html_week = tag('tr', display_days($result, 1, $week_of_month, $month, $year));

    return $html_week;
}

// creates a display for a particular week and the rest of the weeks until the
// end of the month
// returns XHTML data for the weeks
function create_weeks($result, $week_of_month, $month, $year)
{
	if($week_of_month > weeks_in_month($month, $year)) return array();

        $html_week = tag('tr', display_days($result, 1, $week_of_month, $month, $year));

        return array_merge(array($html_week), create_weeks($result, $week_of_month + 1,
                                $month, $year));
}

// displays the day of the week and the following days of the week
// return XHTML data for the days
function display_days($result, $day_count, $week_of_month, $month, $year)
{
	global $db, $phpc_script, $config, $first_day_of_week, $calendar_name, $EVENT_TYPE_BOOKING;

	
	if($day_count > 7) return array();

	$day_of_month = ($week_of_month - 1) * 7 + $day_count
		- ((7 + day_of_first($month, $year) - $first_day_of_week) % 7);

	//echo "Day of month: ".$day_of_month."   ";
	//echo "day_of_month: ".$day_of_month.", week_of_month: ".$week_of_month.", day_count: ".$day_count.", first_day_of_week: ".$first_day_of_week.", month: ".$month.", year: ".$year."<br>";

	if($day_of_month <= 0 || $day_of_month > days_in_month($month, $year)) {
		$html_day = tag('td', attributes('class="prev-month"'), "&nbsp;");
	} else {
		
		/********EVENTS**********/
	    $have_events = false;
			$html_events = tag('ul', attributes("id=\"$day_of_month\""));
			foreach($result as $row) {
				$stStamp = strtotime($row['starttime']);
				$endStamp = strtotime($row['endtime']);
				$curDayStart = mktime(0,0,1,$month, $day_of_month, $year);
				$curDayEnd = mktime(0,0,0,$month, $day_of_month + 1, $year);
				
				//echo "curDayEnd: ".$curDayEnd .", stStamp: ". $stStamp .", curDayStart:". $curDayStart .", endStamp: ". $endStamp."<br>";
				
				if ( $curDayEnd >= $stStamp && $curDayStart <= $endStamp ){
					//echo "YES<br>";
					if ($row['eventtype'] == $EVENT_TYPE_BOOKING) {
						$backgrndImage = "";
					} else {
						$backgrndImage = "url(media/striped.gif); background-repeat:repeat-y";
					}

					$vis_text = get_formatted_event_date_time($row);

					$subject = htmlspecialchars(strip_tags(stripslashes($row['subject'])));

					if ($row['grp_displayname'] == 'INDIVIDUAL_DO_NOT_DELETE') {
						$displayname = $row['displayname'];
					} else {
						$displayname = $row['grp_displayname'] . " (". $row['displayname'] .")";
					}
					
					$car_text = tag('a',
			                            attributes( "href=\"$phpc_script"
			                                        ."?action=display&amp;"
			                                        ."id=".$row['id']."\" style='color:black; font-weight: bold;'"),
			                            $row['name'],
			                            " [edit]"
			                            );

			        $link_text = "";
			        if ($row['description'] != "" || $row['subject'] != ""){
			        	$link_text = "<b>Subject: ".$row['subject']."</b><br>";
			        }

					
					$div_car_name = $row['name'];
					$div_time = $vis_text;
					$username = substr($displayname, 0,12)."...";
				

					$event = tag('li', attributes("style=\"background: ".$row['color']." $backgrndImage;\""),
								$car_text = tag('div',
			                            attributes( 'class="car_dive_display" id="'.$row['id'].'"'),
										$div_car_name."<br>",
										$div_time."<br>",
										$username."<br>",
										$link_text,
										$edit_a = tag('a',
										                    attributes( "href=\"#\" onclick=\"openDetailedCarShareRecord(".$row['id'].", '".addslashes($div_car_name)."'); return false;\" style='color:black; font-weight: bold;'"),
										                    		"[more][edit]"
										                    )
			                            				)
												); 

		                        $html_events->add($event);
		                        $have_events = true; 
		        }
			}

		/*********END EVENTS ****/
		
		$currentday = date('j');
		$currentmonth = date('n');
		$currentyear = date('Y');

		// set whether the date is in the past or future/present
		if($currentyear > $year || $currentyear == $year
				&& ($currentmonth > $month
					|| $currentmonth == $month 
					&& $currentday > $day_of_month
				   )) {
			//$current_era = 'past day';
		} else {
				//$current_era = 'future day';
		}

/*
create_date_link( day_name($day_count-1) ." ". $day_of_month,
                                        'display', $year, $month,
                                        $day_of_month,
                                        array('class="date"') )
*/
        if(can_add_event()) {
        $html_day = tag('td', !$have_events ? attributes('id="td_'.$day_of_month.'"') : attributes('class="events" id="td_'.$day_of_month.'"'), tag('h3', attributes('class="day"'), 
												tag('span', attributes('class="num"'), 
														tag('a', attributes("href='#' onClick='showAvailabilityForDay($year, $month, $day_of_month)'"), $day_of_month),
														tag('span', attributes('class="suffix"'),"th"),
														'&nbsp;',
														create_date_link_dialog('+', 'event_form',
						                                        $year, $month,
						                                        $day_of_month,
						                                        array('')
						                                        )
													)
											)                                 		   
                                );
        } else {
        $html_day = tag('td', !$have_events ? "" : attributes('class="events"'),
                                create_date_link($day_of_month,
                                        'display', $year, $month,
                                        $day_of_month,
                                        array('class="date"')));
        }

		if ( $_SESSION['VIEW_OLD'] == true){
			$result1 = get_note_calendar( $calendar_name , mktime(1,1,0,$month,$day_of_month,$year), 1);
			while($row = $result1->FetchRow($result1)) {
				$html_day->add(tag("a",attributes("onClick='openAnnouncement(\"display_announcement.php?id=".$row['id'] ."\", \"".$row['title']."\");'"),tag("h3", $row['title'])));
			}
		}
    
//    if ($current_era == 'past' && $_SESSION['VIEW_OLD'] != true){
//    	$html_day->add(tag("br"),tag("br"));
//    	$html_day->add(tag("a",attributes("href='$phpc_script?action=display&amp;year=$year&amp;month=$month&amp;viewold=true'"),"Older bookings are hidden for faster page load. Click to view."));
//    }   

		if($have_events){
			$html_day->add($html_events);
		} else {
			//$html_day->add(tag("br"),tag("br"),tag("br"));
		}
	}

	return array_merge(array($html_day), display_days($result, $day_count + 1,
				$week_of_month, $month, $year));
	
}

// displays a single day in a verbose way to be shown singly
// returns the XHTML data for the day
function display_day($day, $month, $year)
{
	global $db, $config, $phpc_script, $EVENT_TYPE_BOOKING;

	if (!isset( $_SESSION['uid'])){
		redirect($phpc_script . "?action=login");
	}
	
	$tablename = date('Fy', mktime(0, 0, 0, $month, 1, $year));
	$monthname = month_name($month);

	$privileged = check_user() || $config['anon_permission'] >= 2;

	$result = get_events_by_date($day, $month, $year);

	$today_epoch = mktime(0, 0, 0, $month, $day, $year);

	if($row = $result->FetchRow()) {


				
		$html_table = tag('table', attributes('class="phpc-main"'),
				tag('caption', "$day $monthname $year"),
				tag('thead',
					tag('tr',
						tag('th', attributes('colspan="4"'), _('Booking'))/*,
						tag('th', _('Note'))*/
					     )));
		if($privileged) {
			$html_table->add(tag('tfoot',
                                    tag('tr',
                                            tag('td',
                                                    attributes('colspan="4"')
                                       			))));
            }

		$html_body = tag('tbody');

		for(; $row; $row = $result->FetchRow()) {
			if ($row['eventtype'] == $EVENT_TYPE_BOOKING) {
				$backgrndImage = "";
			} else {
				$backgrndImage = "url(media/striped.gif)";
			}
			
			$subject = htmlspecialchars(strip_tags(stripslashes(
							$row['subject'])));
			if(empty($subject)) $subject = _('(No subject)');
			$time_str = $row['displayname'] . " " . $row['name'] . " " . formatted_time_string($row['starttime'], $row['eventtype']) . " to " . formatted_time_string($row['endtime'], $row['eventtype']);
			
			/*$html_subject = tag('td',attributes('class="phpc-list"'));

			$html_subject->add(create_id_link(tag('strong', $subject),
                                                'display', $row['id']));

			
			$html_subject->add(' (');
			$html_subject->add(create_id_link(_('Modify'),
                                                'event_form', $row['id']));
			$html_subject->add(')');*/
			
			$link_text = "";
	        if ($row['description'] != "" || $row['subject'] != ""){
	        	$link_text = "<b>Subject: ".$row['subject']."</b><br>";
	        }

			$div_car_name = $row['name'];
                 
			$car_text = tag('div',
                    attributes( 'class="car_dive_display" id="'.$row['id'].'"'),
					str_replace(', ', ',<div>',$div_car_name)."<br><br>",
					formatted_time_string($row['starttime'], $row['eventtype']) . " to " . formatted_time_string($row['endtime'], $row['eventtype'])."<br>",
					/*$row['displayname']."<br>",*/
					$link_text,
					$edit_a = tag('a',attributes( "href=\"#\" onclick=\"openDetailedCarShareRecord(".$row['id'].", '".addslashes($div_car_name)."'); return false;\" style='color:black; font-weight: bold;'"), "[more][edit]")
				);

			$html_body->add(tag('tr',
									attributes('class="car_id_"'+$row['id']),
                                        tag('td',
	                                    attributes('class="phpc-list"'),
	                                    $car_text
										)
								)						
		         );
		}

		$html_table->add($html_body);

		if($privileged) $output = tag('form',
			attributes("action=\"$phpc_script\""),
                        $html_table);
		else $output = $html_table;

	} else {
		$output = tag('h2', _('No events on this day.'));
	}

	return $output;
}
function event_history($id)
{
	global $noNavbar, $db, $year, $month, $day, $config, $phpc_script, $EVENT_TYPE_BOOKING;
	$noNavbar = false;

	if (!isset( $_SESSION['uid'])){
		redirect($phpc_script . "?action=login");
	}
	
	

	$retVal = tag('div');
      
                	
    $retVal->add(get_event_history($id));     
    return $retVal;
}
function modal_id($id)
{
	global $noNavbar, $db, $year, $month, $day, $config, $phpc_script, $EVENT_TYPE_BOOKING, $VEHICLE_LABEL;
	$noNavbar = true;

	if (!isset( $_SESSION['uid'])){
		redirect($phpc_script . "?action=login");
	}
	
	$row = get_event_by_id($id);

	$year = $row['year'];
	$month = $row['month'];
	$day = $row['day'];

	$time_str = formatted_time_string($row['starttime'], $row['eventtype']);
	$date_str = formatted_date_string($row['year'], $row['month'],
			$row['day'], $row['end_year'], $row['end_month'],
			$row['end_day'], $row['hour'], $row['minute']);

	$end_time_str = formatted_time_string($row['endtime'], $row['eventtype']);
	$end_date_str = formatted_date_string($row['end_year'], $row['end_month'],
			$row['end_day'], $row['end_year'], $row['end_month'],
			$row['end_day'], $row['end_hour'], $row['end_minute']);			
			
	$dur_str = ""; //get_duration($row['duration'], $row['eventtype']);
	$subject = htmlspecialchars(strip_tags(stripslashes($row['subject'])));
	
	if(empty($subject)) $subject = _('');
	$name = stripslashes($row['displayname']);
	$vehicle = stripslashes($row['name']);
	$desc = parse_desc($row['description']);

	if ($row['eventtype'] == $EVENT_TYPE_BOOKING){
		$modifyDeleteLinks = tag('div', create_id_link(_('Modify'), 'event_form', $id ), 
                                           "&nbsp;&nbsp;|&nbsp;&nbsp;", 
                                          // create_id_link(_('Delete'), 'event_delete', $id, "onclick=\"return confirm('" . custom_get_delete_warning($id) . "');\"")
                                              tag('a',attributes('href="javascript:void(0);" onClick="event_delete(\''.custom_get_delete_warning($id).'\','.$id.')"'),'','Delete' )
                                           );
    } else {
    	$modifyDeleteLinks = tag('div');
    }

	$retVal = tag('div');
        //if(check_user() || $config['anon_permission'] >= 2) {
                $retVal->add( tag('div', attributes('class="phpc-main"'),
                                $modifyDeleteLinks,                               
                                tag('div', 'User: ', tag('cite', $name)),
                                tag('div', "$VEHICLE_LABEL: ", tag('cite', $vehicle)),

                                tag('div',
					tag('div', _('Start Time').": $time_str $date_str"),
					tag('div', _('End Time').": $end_time_str $end_date_str")),
                    tag('h3', $subject),
                                tag('p', $desc)),tag('a', attributes("href='javascript:void(0);' onClick=\"showEventHistory($id,'Modification History')\""),'Modification History'));

                	
    //$retVal->add(get_event_history($id));    
    return $retVal;
}

// displays a particular event to be show singly
// returns XHTML data for the event
function display_id($id)
{
	global $db, $year, $month, $day, $config, $phpc_script, $EVENT_TYPE_BOOKING, $VEHICLE_LABEL;

	if (!isset( $_SESSION['uid'])){
		redirect($phpc_script . "?action=login");
	}
	
	$row = get_event_by_id($id);

	$year = $row['year'];
	$month = $row['month'];
	$day = $row['day'];

	$time_str = formatted_time_string($row['starttime'], $row['eventtype']);
	$date_str = formatted_date_string($row['year'], $row['month'],
			$row['day'], $row['end_year'], $row['end_month'],
			$row['end_day'], $row['hour'], $row['minute']);

	$end_time_str = formatted_time_string($row['endtime'], $row['eventtype']);
	$end_date_str = formatted_date_string($row['end_year'], $row['end_month'],
			$row['end_day'], $row['end_year'], $row['end_month'],
			$row['end_day'], $row['end_hour'], $row['end_minute']);			
			
	$dur_str = ""; //get_duration($row['duration'], $row['eventtype']);
	$subject = htmlspecialchars(strip_tags(stripslashes($row['subject'])));
	
	if(empty($subject)) $subject = _('');
	$name = stripslashes($row['displayname']);
	$vehicle = stripslashes($row['name']);
	$desc = parse_desc($row['description']);

	if ($row['eventtype'] == $EVENT_TYPE_BOOKING){
		$modifyDeleteLinks = tag('div', create_id_link(_('Modify'), 'event_form', $id ), 
                                           "&nbsp;&nbsp;|&nbsp;&nbsp;", 
                                          tag('a',attributes('href="javascript:void(0);" onClick="event_delete(\''.custom_get_delete_warning($id).'\','.$id.')"'),'','Delete' )
                                           //   create_id_link(_('Delete'), 'event_delete', $id, "onclick=\"return confirm('" . custom_get_delete_warning($id) . "');\"")
                                           );
    } else {
    	$modifyDeleteLinks = tag('div');
    }

	$retVal = tag('div');
        //if(check_user() || $config['anon_permission'] >= 2) {
                $retVal->add( tag('div', attributes('class="phpc-main"'),
                                $modifyDeleteLinks,                               
                                tag('div', 'User: ', tag('cite', $name)),
                                tag('div', "$VEHICLE_LABEL: ", tag('cite', $vehicle)),

                                tag('div',
					tag('div', _('Start Time').": $time_str $date_str"),
					tag('div', _('End Time').": $end_time_str $end_date_str")),
                    tag('h3', $subject),
                                tag('p', $desc)));

    $retVal->add(get_event_history($id));    
    return $retVal;
}

function get_event_history($id){
	global $db, $OPERATION, $VEHICLE_LABEL;
	$histTable = tag("table", attributes("class='phpc-main'"),
						tag('caption', "Modification History"),
							tag("thead",
								tag("tr",
									tag("th",
											"Date"
										),
									tag("th",
											"Action"
										),										
									tag("th",
											"By"
										),	
									tag("th",
											"Is For"
										),
									tag("th",
											"$VEHICLE_LABEL"
										),			
									tag("th",
											"Start Time"
										),
									tag("th",
											"End Time"
										),	
									tag("th",
											"Hours In 2 Day Window"
										)																																									
									)
								)
							);	
	
	$query = "select operation, modifiedByUid, bookingIsForUid, ".SQL_PREFIX."event_log.created AS created, ".SQL_PREFIX."vehicles.name AS name, starttime, endtime, amntTagged, subject, note from ".SQL_PREFIX."event_log "
		.'LEFT OUTER JOIN '.SQL_PREFIX."bookables ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."event_log.bookableobject\n"
		."LEFT OUTER JOIN ".SQL_PREFIX."vehicles ON ".SQL_PREFIX."vehicles.id = ".SQL_PREFIX."bookables.vehicle_id\n"	
		. " WHERE eventid = '$id' ORDER BY ".SQL_PREFIX."event_log.created";
	
	//echo($query);
	$result = $db->Execute($query)
        or db_error("error get_event_history", $query);

	$tbody = tag("tbody");
	while($row = $result->fetchRow($result)){
		$modBy = quick_query("SELECT displayname FROM ".SQL_PREFIX."users WHERE id='".$row['modifiedByUid']."'","displayname");
		$bookingIsFor = quick_query("SELECT displayname FROM ".SQL_PREFIX."users WHERE id='".$row['bookingIsForUid']."'","displayname");
		if ($row['operation'] == $OPERATION['CREATE']){
			$operation = "create";
		} else if ($row['operation'] == $OPERATION['MODIFY']) {
			$operation = "modify";
		} else if ($row['operation'] == $OPERATION['CANCEL']) {
			$operation = "cancel";
		} else if ($row['operation'] == $OPERATION['CANCEL_WITHIN_TWO_DAYS']) {
			$operation = "cancel in window";
		} else {
			$operation = "unknown";
		}
		
		$tbody->add(
			tag("tr", 
					tag("td", attributes('class="phpc-list"'), $row['created']),
					tag("td", attributes('class="phpc-list"'), $operation),
					tag("td", attributes('class="phpc-list"'), $modBy),
					tag("td", attributes('class="phpc-list"'), $bookingIsFor),
					tag("td", attributes('class="phpc-list"'), $row['name']),
					tag("td", attributes('class="phpc-list"'), $row['starttime']),
					tag("td", attributes('class="phpc-list"'), $row['endtime']),
					tag("td", attributes('class="phpc-list"'), $row['amntTagged'])
			)
		);
	}
	$histTable->add($tbody);
	
	return $histTable;
}
?>
