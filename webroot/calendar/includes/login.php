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
 */

if(!defined('IN_PHPC')) {
       die("Hacking attempt");
}

// Initialise the framework sessions 
require_once $phpc_root_path . '../calendar/admin/cake13/app/config/session_import.php'; 

function get_permissions($id){
	global $db;
	
	$query = "select permission from ".SQL_PREFIX."users_permissions ".
	         "INNER JOIN ".SQL_PREFIX."permissions ON ".SQL_PREFIX."users_permissions.permission_id=".SQL_PREFIX."permissions.id ".	
	         "where user_id='$id' ";

	$result = $db->Execute($query);
	if(!$result) {
		db_error(_('Error in get_permissions'), $query);
	}
	
	$perms = "NAMED_USER";
	while($row = $result->FetchRow($result)) {
		$perms .= "," . $row['permission'];
	}	
	return $perms;
}

function login()
{
	global $calendar_name, $vars, $day, $month, $year, $phpc_script, $db, $OPERATION;

	$html = tag('div');

	custom_actions_on_login();
	
	//Check password and username
	if(isset($vars['username'])){
		$user = $vars['username'];
		$password = $vars['password'];

		//echo $user.":".$password;
		$row = verify_user($user, $password);

		if($row){
                    $_SESSION['user'] = $user;
                    $_SESSION['uid'] = $row['id'];
                    $_SESSION['permission'] = get_permissions($row['id']);
                    $_SESSION['group_type'] = $row['type'];
                    $_SESSION['group_id'] = $row['group_id'];
					
					$_SESSION['calendar'] = $vars['calendar'];
                    
                    $_SESSION['PHPC_USER'] = $user;
                    $_SESSION['PHPC_UID'] = $row['id'];
                    $_SESSION['PHPC_PERM'] = $row['permission'];
                    
                    session_write_close();                  
					if (is_allowed_permission_checkpoint('CAKE_LOGIN')){
						cake_login($_SESSION);
					}

					insert_to_event_log(-1,$_SESSION['uid'],$OPERATION['LOGIN'],-1,$db->DBDate(date("Y-m-d H:i:s", time())),$db->DBDate(date("Y-m-d H:i:s", time())),"","",-1,$CANCELED['NORMAL'], "");

                    $selCal = $vars['calendar'];
                    setcookie("calendar", $selCal, time()+3600*24*48);
                    $string = dirname($phpc_script) . "/index.php?cal=" . $selCal;
                    $arguments = array();
                    if(!empty($vars['lastaction']))
                            $arguments[] = "action=$vars[lastaction]";
                    if(!empty($vars['year']))
                            $arguments[] = "year=$year";
                    if(!empty($vars['month']))
                            $arguments[] = "month=$month";
                         
                    redirect($string . "&" . implode('&', $arguments));
                      
			return tag('h2', _('Logged in.'));
		}

		$html->add(tag('h2', _('Sorry, Invalid Login')));

	}

	$html->add(login_form());
	return $html;
}


function login_form()
{
        global $vars, $phpc_script, $day, $year, $month, $db;

        $lastaction = empty($vars['lastaction']) ? '' : $vars['lastaction'];

        if ( isset($_COOKIE['calendar']) ){
            $selCal = $_COOKIE['calendar'];
        } else {
            $selCal = "";
        }
        
        $query = 'SELECT * FROM '.SQL_PREFIX.'calendars';
        $result = $db->Execute($query)
            or db_error(_('Error in login_form'), $query);
        
        $cals = array();
        while($row = $result->FetchRow($result)) {
            $cals[$row['calendar']] = $row['calendar_title'];
        }
        
        $submit_data = tag('td', attributes('colspan="2"'),
                                create_hidden('action', 'login'),
                                create_submit(_('Submit')));

        if(!empty($vars['lastaction']))
                $submit_data->prepend(create_hidden('lastaction',
                                        $vars['lastaction']));

        if(!empty($vars['day']))
                $submit_data->prepend(create_hidden('day', $day));

        if(!empty($vars['month']))
                $submit_data->prepend(create_hidden('month', $month));

        if(!empty($vars['year']))
                $submit_data->prepend(create_hidden('year', $year));

	return tag('form', attributes("action=\"$phpc_script\"",
				'method="post"'),
		tag('table', attributes('class="phpc-mobile"'),
			tag('caption', _('Log in')),
                        tag('thead',
                                tag('tr',
                                        tag('th', attributes('colspan="2"'),
                                                _('You must have cookies enabled to login.')))),
			tag('tfoot',
				tag('tr', $submit_data)),
			tag('tbody',
				tag('tr',
					tag('th', _('Community').':'),
					tag('td', create_select('calendar', $cals, $selCal))),            
				tag('tr',
					tag('th', _('Username (email address)').':'),
					tag('td', create_text('username'))),
				tag('tr',
					tag('th', _('Password').':'),
					tag('td', create_password('password'))),
				tag('tr',
					tag('th', "&nbsp;"),
					tag('td', tag("a", attributes("href='#'", 'onclick="Calendar.buildForgetPassword(); return false;"'), "forgot your password?")))					
				)));
}
?>
