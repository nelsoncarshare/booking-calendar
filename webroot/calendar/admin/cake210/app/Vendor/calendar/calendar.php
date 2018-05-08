<?php

$urlmatch = new urlmatch;

// make sure that we have _ defined
if(!function_exists('_')) {
	function _($str) { return $str; }
	$no_gettext = 1;
}

// called when some error happens
function soft_error($str)
{
	echo '<html><head><title>'._('Error')."</title></head>\n"
		.'<body>'
        ."<blockquote><h3>"._('Error:'). " " . $str . "</h3>"
        ."<br/><br/> click back to return to the previous page.</blockquote>\n";
		/*
        if(version_compare(phpversion(), '4.3.0', '>=')) {
                echo "<h2>"._('Backtrace')."</h2>\n";
                echo "<ol>\n";
                foreach(debug_backtrace() as $bt) {
                        echo "<li>$bt[file]:$bt[line] - $bt[function]</li>\n";
                }
                echo "</ol>\n";
        }
        */
        echo "</body></html>\n";
	exit;
}

// called when there is an error involving the DB
function db_error($str, $query = "")
{
        global $db;

        $string = "$str<br />".$db->ErrorNo().': '.$db->ErrorMsg();
        if($query != "") {
                $string .= "<br />"._('SQL query').": $query";
        }
        soft_error($string);
}

// takes a number of the month, returns the name
function month_name($month)
{
        global $month_names;

	    $month = ($month - 1) % 12 + 1;
        return $month_names[$month];
}

//takes a day number of the week, returns a name (0 for the beginning)
function day_name($day)
{
	global $day_names;

	$day = $day % 7;

        return $day_names[$day];
}

function short_month_name($month)
{
        global $short_month_names;

	$month = ($month - 1) % 12 + 1;
        return $short_month_names[$month];
}

// checks global variables to see if the user is logged in.
// if so, returns the UID, otherwise returns 0
function check_user()
{
	if(empty($_SESSION['user']) || $_SESSION['user'] == 'anonymous') {
			return false;
        } else {
            return true;
        }
}

function get_uid($user)
{
        global $calendar_name, $db;

	$query= "SELECT id FROM ".SQL_PREFIX."users\n"
		."WHERE username = '$user' ";

	$result = $db->Execute($query)
                or db_error("error checking user", $query);

	$row = $result->FetchRow();

        if(empty($row)) return 0;

	return $row['id'];
}

function get_users()
{
	global $db;
	$query= "SELECT * FROM ".SQL_PREFIX."users WHERE disabled <> true ORDER BY displayname \n";

	$result = $db->Execute($query)
                or db_error("error checking user", $query);

	return $result;
}

//TODO is there another one of these in generate_invoices_inc?
function get_invoicables()
{
	global $db;
	$ret = array();
	
	$query= "SELECT ".SQL_PREFIX."invoicables.id, displayname, user_id, ".SQL_PREFIX."invoicables.group_id FROM ".SQL_PREFIX."invoicables "
				. "INNER JOIN ".SQL_PREFIX."grouptypes ON ".SQL_PREFIX."grouptypes.id=".SQL_PREFIX."invoicables.type \n"
				. "INNER JOIN ".SQL_PREFIX."users ON ".SQL_PREFIX."users.id=".SQL_PREFIX."invoicables.user_id \n"
				. "WHERE ".SQL_PREFIX."grouptypes.type='INDIVIDUAL' ORDER BY displayname";

	//echo( $query );
	$result = $db->Execute($query)
                or db_error("error get_invoicables", $query);

	while ( $row = $result->FetchRow() ){
		$ret[$row['id']] = $row['displayname'];
	}

	$query= "SELECT ".SQL_PREFIX."invoicables.id, grp_displayname, user_id, ".SQL_PREFIX."invoicables.group_id FROM ".SQL_PREFIX."invoicables "
				. "INNER JOIN ".SQL_PREFIX."grouptypes ON ".SQL_PREFIX."grouptypes.id=".SQL_PREFIX."invoicables.type \n"
				. "INNER JOIN ".SQL_PREFIX."groups ON ".SQL_PREFIX."groups.id=".SQL_PREFIX."invoicables.group_id \n"
				. "WHERE ".SQL_PREFIX."grouptypes.type<>'INDIVIDUAL' ORDER BY grp_displayname";

	//echo( $query );
	$result = $db->Execute($query)
                or db_error("error get_invoicables", $query);

	while ( $row = $result->FetchRow() ){
		$ret[$row['id']] = $row['grp_displayname'];
	}	
	return $ret;
}

function quick_query($query,$field){
	global $db;
//	echo($query);
	$result = $db->Execute($query)
                or db_error("error quick_query", $query);

	if ($row = $result->fetchRow()){
		return $row[$field];
	}
	return "";	
}

function verify_user($user, $password)
{
        global $calendar_name, $db;

        $passwd = md5($password);

	$query= "SELECT ".SQL_PREFIX."users.id as id, displayname, username, permission, group_id, ".SQL_PREFIX."grouptypes.type as type  FROM ".SQL_PREFIX."users\n"
				." INNER JOIN ".SQL_PREFIX."groups ON ".SQL_PREFIX."groups.id=".SQL_PREFIX."users.group_id \n"
				." INNER JOIN ".SQL_PREFIX."grouptypes ON ".SQL_PREFIX."groups.type=".SQL_PREFIX."grouptypes.id \n"
				."WHERE username='$user' "
                ."AND password='$passwd' ";
				//."AND calendar='$calendar_name'";

	$result = $db->Execute($query)
                or db_error("error checking user", $query);

    //    if($result->RecordCount() <= 0)
    //            return false;

	return $result->FetchRow();
}

function get_invoicable_id($user_id){
	global $db;
	if ($user_id == "_ALL_USERS"){
		return "_ALL_USERS";
	}
	$myRetVal = -1;
	$query= "SELECT ".SQL_PREFIX."users.id as user_id, ".SQL_PREFIX."groups.id as group_id,".SQL_PREFIX."grouptypes.type as type  FROM ".SQL_PREFIX."users\n"
					." INNER JOIN ".SQL_PREFIX."groups ON ".SQL_PREFIX."groups.id=".SQL_PREFIX."users.group_id \n"
					." INNER JOIN ".SQL_PREFIX."grouptypes ON ".SQL_PREFIX."groups.type=".SQL_PREFIX."grouptypes.id \n"
					."WHERE ".SQL_PREFIX."users.id=$user_id";
					//."AND calendar='$calendar_name'";
	//echo $query;
	$result = $db->Execute($query)
                or db_error("error get_invoiceable_id", $query);
    if ($row = $result->FetchRow()){
    	if($row['type'] == 'INDIVIDUAL'){
    		$query = "SELECT id from ".SQL_PREFIX."invoicables where user_id=$user_id";
    		
    	} else {
    		$query = "SELECT id from ".SQL_PREFIX."invoicables where group_id=" . $row['group_id'];
    	}
    	//echo $query;
    	$result1 = $db->Execute($query)
               or db_error("error get_invoiceable_id", $query);
        $row1 = $result1->FetchRow($result1);
        return $row1['id'];
    }
          						
}

// takes a time string, and formats it according to type
// returns the formatted string
function formatted_time_string($time, $type)
{
	global $config;

	switch($type) {
		default:
			preg_match('/(\d+):(\d+)/', $time, $matches);
			$hour = $matches[1];
			$minute = $matches[2];

			if(!$config['hours_24']) {
				if($hour >= 12) 
				{
                	if($hour == 12 && $minute == 0) 
                	{
                    	$pm = ' noon';
                    } else if ($hour == 12) {
						$pm = 'pm';
                	} else {
                		$hour -= 12;
                		$pm = 'pm';
                	}
                 } else {
                    if($hour == 0 && $minute == 0) 
                    {
                         $hour = 12;
              			 $pm = ' midnight';	
                    } else if ($hour == 0){
                    	 $hour = 12;
                    	 $pm = 'am';
                    } else {
                    	$pm = 'am';
                    }
				}
			} else {
				$pm = '';
			}

			return sprintf('%d:%02d%s', $hour, $minute, $pm);
		//case 2:
		//	return _('FULL DAY');
		//case 3:
		//	return _('TBA');
        //        case 4:
        //                return '';
	}
}

// takes start and end dates and returns a nice display
function formatted_date_string($startyear, $startmonth, $startday, $endyear,
		$endmonth, $endday, $hour, $minute)
{
	//computer thinks midnight is the first second, people think it is the last second
	//need to subtract a minute to get the day to be right.
	$timestamp = mktime($hour,$minute, 0, $startmonth, $startday, $startyear);
	$timestamp = $timestamp - 60;
	$str = date("M",$timestamp) . " " . date('j',$timestamp);
	return $str;
}

// takes some xhtml data fragment and adds the calendar-wide menus, etc
// returns a string containing an XHTML document ready to be output
function create_xhtml($rest)
{
	global $config, $phpc_script, $lang;

	$output = tag("div",
				navbar(),
				$rest,
				navbar(),
				link_bar()
				);

	return $output->toString();
}

// returns XHTML data for a link for $lang
function lang_link($lang)
{
	global $phpc_script;

        $str = $_SERVER['QUERY_STRING'];
        $str = preg_replace("/&lang=\\w*/", '', $str);
        $str = preg_replace("/lang=\\w*&/", '', $str);
        $str = preg_replace("/lang=\\w*/", '', $str);
	if(!empty($str)) {
		$str = htmlentities($str) . '&amp;';
	}
	$str = "{$phpc_script}?{$str}lang=$lang";

	return tag('a', attributes("href=\"$str\""), $lang);
}

// returns XHTML data for the links at the bottom of the calendar
function link_bar()
{
	global $config, $phpc_url, $phpc_root_path, $languages;

	$html = tag('div', attributes('class="phpc-footer"'));

	/*
	if($config['translate']) {
		$lang_links = tag('p', '[', lang_link('en'), '] ');
                foreach($languages as $lang) {
                        if(file_exists("$phpc_root_path/locale/$lang/LC_MESSAGES/messages.mo")) {
                                $lang_links->add('[', lang_link($lang), '] ');
                        }
                }
                $html->add($lang_links);
	}
	*/
	/*
	$html->add(tag('p', '[',
			tag('a',
				attributes('href="http://validator.w3.org/'
					.'check?url='
					.rawurlencode($phpc_url)
					.'"'), 'Valid XHTML 1.0'),
			'] [',
			tag('a', attributes('href="http://jigsaw.w3.org/'
					.'css-validator/check/referer"'),
					'Valid CSS2'),
			']'));
	*/
	return $html;
}

// returns all the events for a particular day
function get_events_by_date($day, $month, $year)
{
	global $calendar_name, $db, $CANCELED, $EVENT_TYPE_BOOKING;

		$curDate = getDate();

        $starttime = $db->SQLDate('Y-m-d-H-i-s', 'starttime');
        $endtime = $db->SQLDate('Y-m-d-H-i-s', 'endtime');
        $dateStart = "'" . date('Y-m-d-H-i-s', mktime(0, 0, 1, $month, $day, $year)) . "'";
        $dateEnd = "'" . date('Y-m-d-H-i-s', mktime(24, 0, 0, $month, $day, $year)) . "'";
        // day of week
        $dow_startdate = $db->SQLDate('w', 'starttime');
        $dow_date = $db->SQLDate('w', $dateStart);
        // day of month
        $dom_startdate = $db->SQLDate('d', 'starttime');
        $dom_date = $db->SQLDate('d', $dateStart);
        $events_table = SQL_PREFIX.'events';
	$query = 'SELECT '.SQL_PREFIX.'events.id as id,'
		.$db->SQLDate('Y', "$events_table.starttime")." AS year,\n"
		.$db->SQLDate('m', "$events_table.starttime")." AS month,\n"
		.$db->SQLDate('d', "$events_table.starttime")." AS day,\n"
		.$db->SQLDate('H', "$events_table.starttime")." AS hour,\n"
		.$db->SQLDate('i', "$events_table.starttime")." AS minute,\n"		
		.$db->SQLDate('Y', "$events_table.endtime")." AS end_year,\n"
		.$db->SQLDate('m', "$events_table.endtime")." AS end_month,\n"
		.$db->SQLDate('d', "$events_table.endtime")." AS end_day,\n"
		.$db->SQLDate('H', "$events_table.endtime")." AS end_hour,\n"
		.$db->SQLDate('i', "$events_table.endtime")." AS end_minute,\n"		
		.' subject, description, starttime, eventtype, endtime, '.SQL_PREFIX.'vehicles.name as name, color, displayname, grp_displayname FROM '.SQL_PREFIX."events\n"
		.'INNER JOIN '.SQL_PREFIX."bookables ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."events.bookableobject\n"
		."INNER JOIN ".SQL_PREFIX."bookables_calendars ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."bookables_calendars.bookable_id\n"
		."INNER JOIN ".SQL_PREFIX."calendars ON ".SQL_PREFIX."calendars.id = ".SQL_PREFIX."bookables_calendars.calendar_id\n"
		."INNER JOIN ".SQL_PREFIX."vehicles ON ".SQL_PREFIX."vehicles.id = ".SQL_PREFIX."bookables.vehicle_id\n"
		."INNER JOIN ".SQL_PREFIX."users ON ".SQL_PREFIX."users.id = ".SQL_PREFIX."events.uid\n"
		."INNER JOIN ".SQL_PREFIX."groups ON ".SQL_PREFIX."users.group_id = ".SQL_PREFIX."groups.id\n"
		."WHERE $dateEnd >= $starttime AND $dateStart <= $endtime\n"
 
		."AND ".SQL_PREFIX."calendars.calendar = '$calendar_name'\n"
		."AND ".SQL_PREFIX."events.canceled = '".$CANCELED['NORMAL']."'\n"
		
		."AND ( ".SQL_PREFIX."events.eventtype = '".$EVENT_TYPE_BOOKING."'\n"
		
		."ORDER BY starttime";
    
	$result = $db->Execute($query)
		or db_error(_('Error in get_events_by_date'), $query);

	return $result;
}

function get_events_for_month($month, $year)
{
	global $calendar_name, $db, $CANCELED, $EVENT_TYPE_BOOKING;

        $starttime = $db->SQLDate('Y-m-d-H-i-s', 'starttime');
        $endtime = $db->SQLDate('Y-m-d-H-i-s', 'endtime');
        $dateStart = "'" . date('Y-m-d-H-i-s', mktime(0, 0, 1, $month, 1, $year)) . "'";
        $dateEnd = "'" . date('Y-m-d-H-i-s', mktime(0, 0, 0, $month + 1, 1, $year)) . "'";

		$curDate = getDate();

		//echo $currentReservedCutoffTime . " " . $starttime;

        $events_table = SQL_PREFIX.'events';
	$query = 'SELECT '.SQL_PREFIX.'events.id as id,'
		.$db->SQLDate('Y', "$events_table.starttime")." AS year,\n"
		.$db->SQLDate('m', "$events_table.starttime")." AS month,\n"
		.$db->SQLDate('d', "$events_table.starttime")." AS day,\n"
		.$db->SQLDate('H', "$events_table.starttime")." AS hour,\n"
		.$db->SQLDate('i', "$events_table.starttime")." AS minute,\n"		
		.$db->SQLDate('Y', "$events_table.endtime")." AS end_year,\n"
		.$db->SQLDate('m', "$events_table.endtime")." AS end_month,\n"
		.$db->SQLDate('d', "$events_table.endtime")." AS end_day,\n"
		.$db->SQLDate('H', "$events_table.endtime")." AS end_hour,\n"
		.$db->SQLDate('i', "$events_table.endtime")." AS end_minute,\n"		
		.' subject, description, starttime, eventtype, endtime, '.SQL_PREFIX.'vehicles.name as name, color, displayname, grp_displayname FROM '.SQL_PREFIX."events\n"
		.'INNER JOIN '.SQL_PREFIX."bookables ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."events.bookableobject\n"
		."INNER JOIN ".SQL_PREFIX."bookables_calendars ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."bookables_calendars.bookable_id\n"
		."INNER JOIN ".SQL_PREFIX."calendars ON ".SQL_PREFIX."calendars.id = ".SQL_PREFIX."bookables_calendars.calendar_id\n"
		."INNER JOIN ".SQL_PREFIX."vehicles ON ".SQL_PREFIX."vehicles.id = ".SQL_PREFIX."bookables.vehicle_id\n"
		."INNER JOIN ".SQL_PREFIX."users ON ".SQL_PREFIX."users.id = ".SQL_PREFIX."events.uid\n"
		."INNER JOIN ".SQL_PREFIX."groups ON ".SQL_PREFIX."users.group_id = ".SQL_PREFIX."groups.id\n"
		."WHERE $dateEnd >= $starttime AND $dateStart <= $endtime\n" 
		."AND ".SQL_PREFIX."calendars.calendar = '$calendar_name'\n"
		."AND ".SQL_PREFIX."events.canceled = '".$CANCELED['NORMAL']."'\n"
		
		."AND ( ".SQL_PREFIX."events.eventtype = '".$EVENT_TYPE_BOOKING."'\n"
		
		."ORDER BY starttime";
    //echo ( $query );
    
    
	$result = $db->Execute($query)
		or db_error(_('Error in get_events_for_month'), $query);

	return $result;
}

function get_vehicles($calendar_name)
{
		global  $db;

	$query = 'SELECT '.SQL_PREFIX.'bookables.id AS id, '.SQL_PREFIX.'vehicles.name as dropdownname, '.SQL_PREFIX.'bookables.* FROM '.SQL_PREFIX."vehicles INNER JOIN ".SQL_PREFIX."bookables on ".SQL_PREFIX."bookables.vehicle_id = ".SQL_PREFIX."vehicles.id INNER JOIN ".SQL_PREFIX."bookables_calendars ON ".SQL_PREFIX."bookables_calendars.bookable_id = ".SQL_PREFIX."bookables.id INNER JOIN ".SQL_PREFIX."calendars ON ".SQL_PREFIX."bookables_calendars.calendar_id = ".SQL_PREFIX."calendars.id ";
	if ($calendar_name != -1){
		 $query = $query . " WHERE calendar=".$calendar_name." AND ".SQL_PREFIX."bookables.disabled <> true \n";
	}
	$result = $db->Execute($query)
		or db_error(_('Error in get_vehicles'), $query);

	return $result;
}

function get_vehicles2()
{
	global  $db;

	$query = 'SELECT id, name FROM '.SQL_PREFIX."vehicles";

	$result = $db->Execute($query)
		or db_error(_('Error in get_vehicles2'), $query);

	return $result;
}

// returns the event that corresponds to $id
function get_event_by_id($id)
{
	global $calendar_name, $db;

	$events_table = SQL_PREFIX . 'events';
	$users_table = SQL_PREFIX . 'users';

	$tTime = time() + (48*60*60);

	$query = "SELECT $events_table.*,\n"
		.$db->SQLDate('Y', "$events_table.starttime")." AS year,\n"
		.$db->SQLDate('m', "$events_table.starttime")." AS month,\n"
		.$db->SQLDate('d', "$events_table.starttime")." AS day,\n"
		.$db->SQLDate('H', "$events_table.starttime")." AS hour,\n"
		.$db->SQLDate('i', "$events_table.starttime")." AS minute,\n"
		.$db->SQLDate('Y', "$events_table.endtime")." AS end_year,\n"
		.$db->SQLDate('m', "$events_table.endtime")." AS end_month,\n"
		.$db->SQLDate('d', "$events_table.endtime")." AS end_day,\n"
		.$db->SQLDate('H', "$events_table.endtime")." AS end_hour,\n"
		.$db->SQLDate('i', "$events_table.endtime")." AS end_minute,\n"

		//."(" . $db->SQLDate('Y-m-d-H-i', 'starttime')." < DATE '" . date('Y-m-d', $tTime). "') AS isInTwoDayWindow ,\n"
						
		."$users_table.displayname AS displayname, ".SQL_PREFIX."vehicles.name as name\n"
		."FROM $events_table\n"

		.'INNER JOIN '.SQL_PREFIX."bookables ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."events.bookableobject\n"
		."INNER JOIN ".SQL_PREFIX."bookables_calendars ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."bookables_calendars.bookable_id\n"
		."INNER JOIN ".SQL_PREFIX."calendars ON ".SQL_PREFIX."calendars.id = ".SQL_PREFIX."bookables_calendars.calendar_id\n"
		."INNER JOIN ".SQL_PREFIX."vehicles ON ".SQL_PREFIX."vehicles.id = ".SQL_PREFIX."bookables.vehicle_id\n"
		."INNER JOIN ".SQL_PREFIX."users ON ".SQL_PREFIX."users.id = ".SQL_PREFIX."events.uid\n"

		."WHERE $events_table.id = '$id'\n";

	//echo ($db->SQLDate('Y-m-d-H-i', 'starttime'));

	$result = $db->Execute($query);

	if(!$result) {
		db_error(_('Error in get_event_by_id'), $query);
	}

	if($result->FieldCount() == 0) {
		soft_error("item doesn't exist!");
	}

	return $result->FetchRow();
}

// parses a description and adds the appropriate mark-up
function parse_desc($text)
{
	global $urlmatch;

	// get out the crap, put in breaks
        $text = strip_tags($text);
	// if you want to allow some tags, change the previous line to:
	// $text = strip_tags($text, "a"); // change "a" to the list of tags
        $text = htmlspecialchars($text, ENT_NOQUOTES);
	// then uncomment the following line
	// $text = preg_replace("/&lt;(.+?)&gt;/", "<$1>", $text);
        $text = nl2br($text);

	//urls
	$text = $urlmatch->match($text);

	// emails
	$text = preg_replace("/([a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*"
			."[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z])/",
			"<a href=\"mailto:$1\">$1</a>", $text );

	return $text;
}

// returns the day of week number corresponding to 1st of $month
function day_of_first($month, $year)
{
	return date('w', mktime(0, 0, 0, $month, 1, $year));
}

// returns the number of days in $month
function days_in_month($month, $year)
{
	return date('t', mktime(0, 0, 0, $month, 1, $year));
}

//returns the number of weeks in $month
function weeks_in_month($month, $year)
{
	global $first_day_of_week;

	return ceil((days_in_month($month, $year) + (7 + day_of_first($month, $year) - $first_day_of_week) % 7) / 7);
}

// creates a link with text $text and GET attributes corresponding to the rest
// of the arguments.
// returns XHTML data for the link
function create_id_link($text, $action, $id = false, $attribs = false)
{
	global $phpc_script;

	$url = "href=\"$phpc_script?action=$action";
	if($id !== false) $url .= "&amp;id=$id";
	$url .= '"';

        if($attribs !== false) {
                $as = attributes($url, $attribs);
        } else {
                $as = attributes($url);
        }
	return tag('a', $as, $text);
}

function create_date_link($text, $action, $year = false, $month = false,
                $day = false, $attribs = false, $lastaction = false)
{
        global $phpc_script;

	$url = "href=\"$phpc_script?action=$action";
	if($year !== false) $url .= "&amp;year=$year";
	if($month !== false) $url .= "&amp;month=$month";
	if($day !== false) $url .= "&amp;day=$day";
        if($lastaction !== false) $url .= "&amp;lastaction=$lastaction";
	$url .= '"';

        if($attribs !== false) {
                $as = attributes($url, $attribs);
        } else {
                $as = attributes($url);
        }
	return tag('a', $as, $text);
}

// takes a menu $html and appends an entry
function menu_item_append(&$html, $name, $action, $year = false, $month = false,
		$day = false, $lastaction = false)
{
        if(!is_object($html)) {
                soft_error('Html is not a valid Html class.');
        }
	$html->add(create_date_link($name, $action, $year, $month,
                                        $day, false, $lastaction));
        $html->add(" &nbsp;|&nbsp;\n");
}

// same as above, but prepends the entry
function menu_item_prepend(&$html, $name, $action, $year = false,
		$month = false, $day = false, $lastaction = false)
{
        $html->prepend("\n");
	$html->prepend(create_date_link($name, $action, $year, $month,
                                $day, false, $lastaction));
}

// creates a hidden input for a form
// returns XHTML data for the input
function create_hidden($name, $value)
{
	return tag('input', attributes("name=\"$name\"", "value=\"$value\"",
				'type="hidden"'));
}

// creates a submit button for a form
// return XHTML data for the button
function create_submit($value, $name='submit', $javascript="")
{
	return tag('input', attributes("name='$name'", "value=\"$value\"",
                                'type="submit"', $javascript));
}

// creates a text entry for a form
// returns XHTML data for the entry
function create_text($name, $value = false)
{
	$attributes = attributes("name=\"$name\"", 'type="text"');
	if($value !== false) {
		$attributes->add("value=\"$value\"");
	}
	return tag('input', $attributes);
}

// creates a password entry for a form
// returns XHTML data for the entry
function create_password($name)
{
	return tag('input', attributes("name=\"$name\"", 'type="password"'));
}

// creates a checkbox for a form
// returns XHTML data for the checkbox
function create_checkbox($name, $value = false, $checked = false)
{
	$attributes = attributes("name=\"$name\"", 'type="checkbox"');
	if($value !== false) $attributes->add("value=\"$value\"");
	if(!empty($checked)) $attributes->add('checked="checked"');
	return tag('input', $attributes);
}

function can_add_event()
{
        global $config;

        return $config['anon_permission'] || check_user();
}

// creates the navbar for the top of the calendar
// returns XHTML data for the navbar
function navbar()
{
	global $vars, $action, $config, $year, $month, $day;

	$html = tag('div', attributes('class="phpc-navbar"'));

	$html->add(_("|&nbsp;"));

	if(can_add_event() && $action != 'add') { 
		menu_item_append($html, _('book a vehicle'), 'event_form', $year,
				$month, $day);
	}

	add_list_of_calendars_to_nav($html);
	
	if($action != 'list_members') {
		menu_item_append($html, _('list members'), 'list_users');
	}

	if(!empty($vars['day']) || !empty($vars['id']) || $action != 'display') {
		menu_item_append($html, _('back to calendar'), 'display',
				$year, $month);
	}

	//if($action != 'display' || !empty($vars['id'])) {
	//	menu_item_append($html, _('View date'), 'display', $year,
	//			$month, $day);
	//}

	menu_item_append($html, _('user guide'), 'redirect&page=../wiki/index.php');
	
	if(check_user()) {
		menu_item_append($html, _('log out'), 'logout',
                                empty($vars['year']) ? false : $year,
                                empty($vars['month']) ? false : $month,
				empty($vars['day']) ? false : $day,
				$action);
		menu_item_append($html, _('my account'), 'my_account');				
	} else {
		menu_item_append($html, _('log in'), 'login',
                                empty($vars['year']) ? false : $year,
                                empty($vars['month']) ? false : $month,
				empty($vars['day']) ? false : $day,
                                $action);
	}

	if(is_allowed_permission_checkpoint("DISPLAY_ADMIN_LINK")) {
		menu_item_append($html, _('admin'), 'redirect&page=admin/index.php');
	}

	if(is_allowed_permission_checkpoint("DISPLAY_ADMIN_BOOKINGS_L")) {
		menu_item_append($html, _('administer bookings'), 'redirect&page=admin/index.php?action=car_month_usage_form');
	}	

	if(isset($var['display']) && $var['display'] == 'day') {
		$monthname = month_name($month);

		$lasttime = mktime(0, 0, 0, $month, $day - 1, $year);
		$lastday = date('j', $lasttime);
		$lastmonth = date('n', $lasttime);
		$lastyear = date('Y', $lasttime);
		$lastmonthname = month_name($lastmonth);

		$nexttime = mktime(0, 0, 0, $month, $day + 1, $year);
		$nextday = date('j', $nexttime);
		$nextmonth = date('n', $nexttime);
		$nextyear = date('Y', $nexttime);
		$nextmonthname = month_name($nextmonth);

		menu_item_prepend($html, "$lastmonthname $lastday",
					'display', $lastyear, $lastmonth,
					$lastday);
		menu_item_append($html, "$nextmonthname $nextday",
				'display', $nextyear, $nextmonth, $nextday);
	}

	$mytbl = tag("table",tag("tr",tag("td", attributes("nowrap='true'"),$html)));

	return $mytbl;
}

// creates an array from $start to $end, with an $interval
function create_sequence($start, $end, $interval = 1, $display = NULL)
{
        $arr = array();
        for ($i = $start; $i <= $end; $i += $interval){
                if($display) {
                        $arr[$i] = call_user_func($display, $i);
                } else {
                        $arr[$i] = $i;
                }
        }
        return $arr;
}

function minute_pad($minute)
{
        return sprintf('%02d', $minute);
}

function get_day_of_month_sequence($month, $year)
{
        $end = date('t', mktime(0, 0, 0, $month, 1, $year, 0));
        return create_sequence(0, $end);
}

// creates a select element for a form of pre-defined $type
// returns XHTML data for the element
function create_select($name, $type, $select, $myattributes="")
{
	$html = tag('select', attributes('size="1"', "name=\"$name\"", $myattributes));

        foreach($type as $value => $text) {
		$attributes = attributes("value=\"$value\"");
		if ($select == $value) {
                        $attributes->add('selected="selected"');
                }
		$html->add(tag('option', $attributes, $text));
	}

	return $html;
}

function redirect($page) {
	global $phpc_script, $phpc_server, $phpc_protocol;

	if($page{0} == "/") {
		$dir = '';
	} else {
		$dir = dirname($phpc_script) . "/";
	}

	header("Location: $phpc_protocol://$phpc_server$dir$page");
}

function add_list_of_calendars_to_nav(&$html){
	global $year, $month, $day, $db;

	$query = 'SELECT * FROM '.SQL_PREFIX.'calendars';
	$result = $db->Execute($query)
		or db_error(_('Error in add_list_of_calendars_to_nav'), $query);
	
	while($row = $result->FetchRow($result)) {
			menu_item_append($html, _($row['calendar_title']), "redirect&page=" . $row['calendar_file_name']);
	}
}


function get_events_for_bookable_in_interval($startstamp,$endstamp,$bookableid)
{
		global $calendar_name, $db, $CANCELED, $EVENT_TYPE_BOOKING;
		
		$curDate = getDate();

        $dbstartdatetime = $db->SQLDate('Y-m-d-H-i', 'starttime');
        $dbenddatetime = $db->SQLDate('Y-m-d-H-i', 'endtime');
        $mystartdatetime = "'" . date('Y-m-d-H-i', $startstamp). "'";
        $myenddatetime = "'" . date('Y-m-d-H-i', $endstamp). "'";
        
	$query = 'SELECT '.SQL_PREFIX.'events.id as id, uid, bookableobject, subject, starttime, eventtype, endtime, '.SQL_PREFIX. 'vehicles.name AS name, color FROM '.SQL_PREFIX."events\n"
		.'INNER JOIN '.SQL_PREFIX."bookables ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."events.bookableobject "
		."INNER JOIN ".SQL_PREFIX."vehicles ON ".SQL_PREFIX."vehicles.id = ".SQL_PREFIX."bookables.vehicle_id\n"
		."WHERE (($mystartdatetime > $dbstartdatetime AND $mystartdatetime < $dbenddatetime)\n"
		."OR    ($myenddatetime > $dbstartdatetime AND $myenddatetime < $dbenddatetime)\n"
		."OR    ($mystartdatetime < $dbenddatetime AND  $myenddatetime > $dbstartdatetime))\n"
		."AND bookableobject = '$bookableid'\n"
		."AND canceled = '".$CANCELED['NORMAL']."'\n"
		
		."AND ( ".SQL_PREFIX."events.eventtype = '".$EVENT_TYPE_BOOKING."')\n"

		."ORDER BY starttime";
    //echo($query);
	$result = $db->Execute($query)
		or db_error(_('Error in get_events_for_bookable_in_interval'), $query);

	return $result;
}

function getNumQuarterHourIntervalsFromTime($smin, $shour, $sday, $smonth, $syear, $emin, $ehour, $eday, $emonth, $eyear){
		$myendstamp = mktime($ehour, $emin, 0, $emonth, $eday, $eyear);
		$mystartstamp = mktime($shour, $smin, 0, $smonth, $sday, $syear);
		$duration = ($myendstamp - $mystartstamp)/60;
		$numQuarterHourIntervals = round( $duration / 15, 0 );
		
		return $numQuarterHourIntervals;
}

function getNumExtraQuarterHourIntervalsFromCancelAndModifications($eventid, $canceled, $mystartstamp, $myendstamp, $startDayRateHour, $endDayRateHour){
		global $db, $CANCELED;

		$slottime = $db->SQLDate('Y-m-d-H-i', 'slot');
        $starttime = "'" . date('Y-m-d-H-i', $mystartstamp) . "'";
        $endtime = "'" . date('Y-m-d-H-i', $myendstamp) . "'";
		
		//$query= "SELECT COUNT(*) AS cnt, MAX(slot) AS maxend, MIN(slot) AS minstart FROM ".SQL_PREFIX."tagged_event_slots\n"
		//		. " WHERE eventid='" . $eventid . "'";
		
		$query= "SELECT COUNT(*) AS cnt, (TIME_FORMAT(slot,'%H') >= " . $startDayRateHour . " AND TIME_FORMAT(slot, '%H') < ".$endDayRateHour.") AS dayNightSlots
				FROM phpc_tagged_event_slots WHERE eventid = '" . $eventid . "'";
		
		
		
		if ($canceled != $CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']){
				$query .= " AND ($slottime < $starttime OR $endtime <= $slottime)";
		}
		
		$query .= " GROUP BY dayNightSlots";
	
		$result = $db->Execute($query)
	                or db_error("error getNumExtraQuarterHourIntervalsFromCancelAndModifications", $query);
	
		$numExtraDayQuarterHoursFromCancelAndMod = 0;
		$numExtraNightQuarterHoursFromCancelAndMod = 0;
		while($row = $result->FetchRow($result)) {
			if ($row['dayNightSlots'] == 1)  $numExtraDayQuarterHoursFromCancelAndMod = $row['cnt'];
			if ($row['dayNightSlots'] == 0)  $numExtraNightQuarterHoursFromCancelAndMod = $row['cnt'];
		}
		return array("total" => $numExtraDayQuarterHoursFromCancelAndMod + $numExtraNightQuarterHoursFromCancelAndMod,
					 "day" => $numExtraDayQuarterHoursFromCancelAndMod,
					 "night" => $numExtraNightQuarterHoursFromCancelAndMod);
}

function get_note_calendar($applies_to, $current_date_time, $display_in_squares=0){
	global $ANNOUNCE_TYPES, $calendar_name, $db;

    $dbstartdatetime =  $db->SQLDate('Y-m-d-H-i', 'startdate');
    $dbenddatetime =    $db->SQLDate('Y-m-d-H-i', 'enddate');
    $mydatetime = "'" . date('Y-m-d-H-i', $current_date_time). "'";

	$query= "SELECT ".SQL_PREFIX."announcements.id as id, ".SQL_PREFIX."announcements.* FROM ".SQL_PREFIX."announcements "
			."INNER JOIN ".SQL_PREFIX."announcementdates ON ".SQL_PREFIX."announcements.id=".SQL_PREFIX."announcementdates.announcement_id\n"	
			."INNER JOIN ".SQL_PREFIX."announcements_calendars ON ".SQL_PREFIX."announcements.id=".SQL_PREFIX."announcements_calendars.announcement_id\n"
			."INNER JOIN ".SQL_PREFIX."calendars ON ".SQL_PREFIX."calendars.id=".SQL_PREFIX."announcements_calendars.calendar_id\n"
			. " WHERE calendar='" . $applies_to . "'"
			. " AND disabled='false'"
			. " AND ($mydatetime > $dbstartdatetime AND $mydatetime < $dbenddatetime)\n";

	if ($display_in_squares == 1){ 
		$query .= " AND display_on_day = '1'\n";
	} else {
		$query .= " AND display_on_day <> '1'\n";
	}
	//echo $query;
	$result = $db->Execute($query)
                or db_error("error get_note", $query);

	return $result;
}

function get_notes_event_form($current_date_time, $bookable){
	global $ANNOUNCE_TYPES, $calendar_name, $db;

    $dbstartdatetime =  $db->SQLDate('Y-m-d-H-i', 'startdate');
    $dbenddatetime =    $db->SQLDate('Y-m-d-H-i', 'enddate');

	$query= "SELECT * FROM ".SQL_PREFIX."announcements "
			."INNER JOIN ".SQL_PREFIX."announcementdates ON ".SQL_PREFIX."announcements.id=".SQL_PREFIX."announcementdates.announcement_id\n"	
			."INNER JOIN ".SQL_PREFIX."announcements_bookables ON ".SQL_PREFIX."announcements.id=".SQL_PREFIX."announcements_bookables.announcement_id\n"
			."INNER JOIN ".SQL_PREFIX."bookables ON ".SQL_PREFIX."bookables.id=".SQL_PREFIX."announcements_bookables.bookable_id\n"
			. " WHERE " .SQL_PREFIX. "announcements.disabled='false'"
			. " AND (NOW() > $dbstartdatetime AND NOW() < $dbenddatetime)\n"
			. " AND ".SQL_PREFIX."bookables.id=$bookable\n"
			. " ORDER BY " .SQL_PREFIX. "bookables.id";

	//echo $query;
	
	$result = $db->Execute($query)
                or db_error("error get_note", $query);

	$returnText = "";
	while($row = $result->FetchRow($result)) {
		$returnText = $returnText . "<h3>" . $row['title'] . "</h3>";
		$returnText = $returnText . $row['text'];
		$returnText = $returnText . "<br/><br/>";
	}

	return $returnText;
}

function tag_time($id, $startstamp, $endstamp, $bookable){
	global $db;	
	$amnt_tagged = "";
	$row = get_event_by_id($id);
	$dbstartstamp = mktime($row['hour'], $row['minute'], 0, $row['month'], $row['day'], $row['year']);
	$dbendstamp =   mktime($row['end_hour'], $row['end_minute'], 0, $row['end_month'], $row['end_day'], $row['end_year']);
	
	$curTime = getdate();
	$curTime['minutes'] = floor($curTime['minutes']/15) * 15; //round minutes to nearest 15
	$currentTimeStamp = mktime($curTime['hours'],$curTime['minutes'],0,$curTime['mon'],$curTime['mday'],$curTime['year']);
	
	$thresholdTimeStamp = custom_get_threshold_time_stamp( time() );
	//$thresholdTimeStamp = mktime(0,0,0,$curTime['mon'],$curTime['mday'] + 2,$curTime['year']);

	$tagStart = max( $dbstartstamp, $currentTimeStamp );
	$tagEnd =   min( $dbendstamp, $thresholdTimeStamp);
	
	//echo($tagStart . " " . $tagEnd);
	//tag what was in the database
	if ($tagStart < $tagEnd){
		tag_time_db_call($tagStart, $tagEnd, $id, $bookable);
		$amnt_tagged = "(" . date("Y-m-d H:i:s", $tagStart) ." to " . date("Y-m-d H:i:s", $tagEnd) . ")";
		//echo(" (" . date("Y-m-d H:i:s", $tagStart) ." to " . date("Y-m-d H:i:s", $tagEnd) . ")<br/>");
	}
	
	//tag what was in the form
	if ($startstamp != -1){
		$tagStart = max( $startstamp, $currentTimeStamp );
		$tagEnd =   min( $endstamp, $thresholdTimeStamp);
		if ($tagStart < $tagEnd){
			tag_time_db_call($tagStart, $tagEnd, $id, $bookable);
			$amnt_tagged = $amnt_tagged . " and " . " (" . date("Y-m-d H:i:s", $tagStart) ." to " . date("Y-m-d H:i:s", $tagEnd) . ")";
			//echo(((float)$amnt_tagged/(60*60) ) . " (" . date("Y-m-d H:i:s", $tagStart) ." to " . date("Y-m-d H:i:s", $tagEnd) . ")");
		}
	}
	
	//there may be slots tagged previously that are now outside the window that are in this interval
	//these should be owned by this eventid
	$slotStartStr = $db->DBDate(date("Y-m-d H:i", $startstamp));
	$slotEndStr   = $db->DBDate(date("Y-m-d H:i", $endstamp));
	$query = "UPDATE ".SQL_PREFIX."tagged_event_slots\n"
				."SET "
				."eventid=$id\n"
				."WHERE bookableid='$bookable' AND slot>=$slotStartStr AND slot<$slotEndStr";
	//echo($query);
	$result = $db->Execute($query);

	if(!$result) {
		db_error(_('Error processing event'), $query);
	}
			
	return $amnt_tagged;
}

function tag_time_db_call($tagStart, $tagEnd, $id, $bookable){
	global $db;	

	//echo($tagStart . " = " . $tagEnd);
	$increment = 15*60;
	$stmpVal = $tagStart;
	$amnt_tagged = 0;
	for($stmpVal = $tagStart; $stmpVal < $tagEnd; $stmpVal += $increment){
		$amnt_tagged += $increment;
		//echo(" [".$stmpVal. "]<br/>");
		$slotStr = $db->DBDate(date("Y-m-d H:i", $stmpVal));
		$query = "SELECT * FROM ".SQL_PREFIX."tagged_event_slots WHERE bookableid=$bookable AND slot=$slotStr";
		$result = $db->Execute($query);
		if(!$result) {
			db_error(_('Error processing event'), $query);
		}
					
		if ($result->FetchRow($result)){
			$query = "UPDATE ".SQL_PREFIX."tagged_event_slots\n"
				."SET "
				."eventid=$id\n"
				."WHERE bookableid='$bookable' AND slot=$slotStr";
		} else {		
			$query = "INSERT INTO ".SQL_PREFIX."tagged_event_slots\n"
				."(eventid, slot, bookableid)"
				."VALUES ($id, $slotStr, $bookable)";
		}
		$result = $db->Execute($query);
	
		if(!$result) {
			db_error(_('Error processing event'), $query);
		}
	}
	return $amnt_tagged;
}

function insert_to_event_log($eventid,$modifedBy,$operation,$bookingIsFor,$starttime,$endtime,$subject,$note,$bookable,$state, $tagged_time){
		global $db;
		
		$query = "INSERT INTO ".SQL_PREFIX."event_log\n"
			."( eventid, operation, modifiedByUid, bookingIsForUid, starttime, endtime,"
			." subject, note, bookableobject, canceled, amntTagged, created)\n"
			."VALUES ($eventid, $operation, '$modifedBy', '$bookingIsFor', "
			."$starttime, $endtime, '" . addslashes($subject) . "',"
			."'" . addslashes($note) . "', '$bookable', '$state', '$tagged_time', NOW())";
		$result = $db->Execute($query);
		if(!$result) {
			db_error(_('Error in insert_to_event_log'), $query);
		}		
}

function is_allowed_permission_checkpoint($checkpoint){
	global $db;
	
	$mywhere = "permission='WORLD'";
	$myperms = split(",", $_SESSION['permission']);
	
	foreach ($myperms as $value){
		$mywhere .= " OR permission='$value'";
	}
	
	$query = "select * from ".SQL_PREFIX."checkpoints ".
	         "INNER JOIN ".SQL_PREFIX."permissions_checkpoints ON ".SQL_PREFIX."permissions_checkpoints.checkpoint_id=".SQL_PREFIX."checkpoints.id ".
	         "INNER JOIN ".SQL_PREFIX."permissions ON ".SQL_PREFIX."permissions_checkpoints.permission_id=".SQL_PREFIX."permissions.id ".
	         "where checkpoint='$checkpoint' ".
	         "AND ($mywhere)";

	

	$result = $db->Execute($query);
	if(!$result) {
		db_error(_('Error in permission_checkpoint'), $query);
	}
		
	if($row = $result->FetchRow($result)) {
		return true;
	} else {
		return false;
	}
}

function redirect_permission_check_failed(){
	global $vars,$phpc_script;
	if (isset($_SESSION['permission'])){
		redirect($phpc_script);	
	} else {
		redirect($phpc_script . "?action=login&lastaction=" . $vars['action']);	
	}
}
?>