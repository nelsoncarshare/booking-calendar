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

function generatePassword ($length = 6)
{

  // start with a blank password
  $password = "";

  // define possible characters
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  return $password;

}

function new_password()
{
	global $vars, $day, $month, $year, $phpc_script, $db, $noNavbar, $ORGANIZATION_NAME, $ADMIN_EMAIL;
	$noNavbar = true;

	$html = tag('div');

	//Check password and username
	if(isset($vars['username'])){
		$user = $vars['username'];
	
		$email = quick_query("select email from ".SQL_PREFIX."users where username=" . $db->qstr($user), "email");
		if (strlen($email) < 3){
			$html->add(tag("center",tag("h2", "Invalid username")));
		} else {
			$newPassword = generatePassword();
			
			$query = "update ".SQL_PREFIX."users set password=" . $db->qstr( md5($newPassword) ) . " where username=" . $db->qstr($user);
			
			$result = $db->Execute($query);

			if(!$result) {
				db_error(_('Error setting password'), $query);
			}
				
			$mailText = "Your new password is:<br/><br/><b>$newPassword</b><br/><br/><a href='http://www.nelsoncar.com/members/calendar/nelson.php?action=my_account'>Login and change your password.</a>";
			$headers = 'From: ' . $ORGANIZATION_NAME .' <' . $ADMIN_EMAIL . '>' . "\r\n" .
			    'Reply-To: ' . $ORGANIZATION_NAME .' <' . $ADMIN_EMAIL . '>' . "\r\n" . 
			    'Content-type: text/html; charset=us-ascii';
				
			//$message = "New password sent.<br/>";
			if (mail($email, "New password from $ORGANIZATION_NAME", $mailText, $headers)) {
			  $html->add( tag("h2"," New password sent.<br/>"));
			} else {
			  //$message = "Email failed, please contact your administrator";
			  $html->add( tag("h2","Email failed, please contact your administrator"));
			}	
		}
	}
	else
	{
		$html->add(login_form());
	}
	return $html;
}


function login_form()
{
     global $vars, $phpc_script, $day, $year, $month;

     $submit_data = tag('td', attributes('colspan="2"'),
                            create_hidden('action', 'new_password'),
                            create_submit(_('Email me a new password')));

	 $formText = tag('form', attributes("action=\"$phpc_script\"",
				'method="post"'),
		tag('table', attributes('class="phpc-mobile"'),
			tag('caption', _('Forgot my password')),
			tag('tfoot',
				tag('tr', $submit_data)),
			tag('tbody',
				tag('tr',
					tag('th', _('Your email address').':'),
					tag('td', create_text('username')))
					)));
				
	return $formText;
}

?>
