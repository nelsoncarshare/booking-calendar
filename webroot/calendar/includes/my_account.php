<?php 

if(!defined('IN_PHPC')) {
       die("Hacking attempt");
}

function user_submit()
{
	global $db, $vars, $config, $phpc_script, $OPERATION;

        /* Validate input */

		if (!isset($vars['id'])){
			return "No id was given.";
		}
		$id = $vars['id'];
		$display_name = $vars['display_name'];
		$address1 = $vars['address1'];
		$address2 = $vars['address2'];
		$province = $vars['province'];
		$postal_code = $vars['postal_code'];
		$city = $vars['city'];
		$phone = $vars['phone'];
		$email = $vars['email'];

	if (strlen($display_name) > 100){
		return "Display name must be less than 100 characters";
	}

	if (strlen($display_name) < 2){
		return "Display name cannot be less than 2 characters";
	}

	if( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  return "Invalid email address";
	}
	
	$query = "select displayname, id from ".SQL_PREFIX."users where displayname=" . $db->qstr($display_name) . " AND id <> $id";
	$result = $db->Execute($query);
	while($row = $result->FetchRow()){
		return "A user named " . $display_name . " already exists.";
	}
	
	$query = "UPDATE " . SQL_PREFIX . "users\n"
		."SET "
		."displayname=" . $db->qstr($display_name) . ",\n"
		."address1=" . $db->qstr($address1) . ",\n"
		."address2=" . $db->qstr($address2) . ",\n"
		."city=" . $db->qstr($city) . ",\n"
		."province=" . $db->qstr($province) . ",\n"
		."postalcode=" . $db->qstr($postal_code) . ",\n"
		."phone=" . $db->qstr($phone) . ",\n"
		."email=" . $db->qstr($email) . ",\n"
		."modified=NOW()\n"
		."WHERE id='$id'";
	$result = $db->Execute($query);

	if(!$result) {
		db_error(_('Error processing user'), $query);
	}

	return "";
}

function get_user_by_id($user)
{
     global $calendar_name, $db;

	$query= "SELECT * FROM ".SQL_PREFIX."users\n"
		."WHERE id = '$user' ";


	$result = $db->Execute($query)
                or db_error("error getting user", $query);

	$row = $result->FetchRow();

        if(empty($row)) db_error("could not find user with this id.");

	return $row;
}

function my_account()
{
	global $vars, $day, $month, $year, $phpc_script, $db;


	if (!isset( $_SESSION['uid'])){
		redirect($phpc_script);
	}

    $info_msg = "";
	$error_msg = "";	
	
	//Check password and username
	if(isset($vars['password']) && isset( $_SESSION['uid'] )){		
			$newPassword = md5($vars['password']);
			//TODO put majic number somewhere
			if (strlen($newPassword) > 32){
				$error_msg = "Password is too long.";
			} else {
				$query = "update ".SQL_PREFIX."users set password=" . $db->qstr( $newPassword ) . " where id=" . $db->qstr($_SESSION['uid']);
				
				$result = $db->Execute($query);
	
				if(!$result) {
					db_error(_('Error setting password'), $query);
				}
			  	$info_msg = "Password is set.";
			}
	} else if ( isset ($vars['subaction']) && $vars['subaction'] == "event_submit"){
		$error_msg = user_submit();
		
		if ($error_msg == ""){
			$info_msg = " Updated contact information.<br/>";
		}
	}

	$html = tag('div');
	$html->add(page_text($error_msg,$info_msg));
	return $html;
}


function page_text($error_msg, $info_msg)
{
     global $vars, $phpc_script, $day, $year, $month;

	$formText = tag("div");
	
	if ($error_msg != "") {
		$formText->add(
					tag("div",
							attributes("class='error-msg-box'"),
							$error_msg)		
					  );
	}
	
	 $formText->add(tag('form', attributes("name='passwordForm' action=\"$phpc_script\"", 'method="post"'),
		tag('table', attributes('class="form-main"'),
			tag('caption', _('Set password')),
			tag('tbody',
				tag('tr',
					tag('th', _('Password').':'),
					tag('td', create_password('password'), create_submit(_('Set password')), create_hidden('action', 'my_account')))
					))));
	
	$formText->add(user_form($_SESSION['uid']));
	
	$invoiceableID = get_invoicable_id($_SESSION['uid']);
	
	$myInvoices = tag("ul");
	$lid = str_pad($invoiceableID, 15, 0, STR_PAD_LEFT);
	$pathStr = USER_HOME . "invoicables/" . $lid . "/invoices";
	if (file_exists($pathStr)){
		if ($handle = opendir($pathStr)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && strrpos( $file  , ".html") == strlen($file) - 5){
					$myInvoices->add(tag("li", attributes('style="background: #EEEEEE;"'),
									tag("a", attributes("href='fileWrapper.php?user=" . $_SESSION['uid'] . "&file=$file'"), "$file")
								));
				}
			}
			closedir($handle);
		}
	}	
	
	$formText->add(
		tag('table', attributes('class="form-main"'),
			tag('caption', _('Invoices')),
			tag('tbody',
				tag('tr',
					tag('td', $myInvoices)
					)
				)
			)
		);	
	return $formText;
}

function user_form($id) {
	global $vars, $day, $month, $year, $db, $config, $phpc_script, $month_names, $event_types, $calendar_name, $ANNOUNCE_TYPES;
	
	$error_msg = "";
	//====================== get data
	if ( isset ($vars['subaction']) && $vars['subaction'] == "event_submit"){

		$display_name = $vars['display_name'];
		$address1 =    $vars['address1'];
		$address2 =    $vars['address2'];
		$city =    $vars['city'];
		$province =    $vars['province'];
		$postal_code =    $vars['postal_code'];
		$phone =    $vars['phone'];
		$email =    $vars['email'];
		
	} else {
		// modifying

		$row = get_user_by_id($id);

		//$uid = $row['uid'];
		$display_name = htmlspecialchars(stripslashes($row['displayname']));
		$address1 =    htmlspecialchars(stripslashes($row['address1']));
		$address2 =    htmlspecialchars(stripslashes($row['address2']));
		$city =    htmlspecialchars(stripslashes($row['city']));
		$province =    htmlspecialchars(stripslashes($row['province']));
		$postal_code =    htmlspecialchars(stripslashes($row['postalcode']));
		$phone =    htmlspecialchars(stripslashes($row['phone']));
		$email = 	htmlspecialchars(stripslashes($row['email']));
	} 
		
	//============= build form controls

	$input = create_hidden('id', $id);
	
	$display_name_control = 	tag('input', attributes('type="text"', "size=\"100\"", "maxlength=\"100\"", 'name="display_name"', "value=\"$display_name\""));
	$address1_control = 		tag('input', attributes('type="text"', "size=\"100\"", "maxlength=\"200\"", 'name="address1"', "value=\"$address1\""));
	$address2_control = 		tag('input', attributes('type="text"', "size=\"100\"", "maxlength=\"200\"", 'name="address2"', "value=\"$address2\""));
	$city_control = 			tag('input', attributes('type="text"', "size=\"100\"", "maxlength=\"100\"", 'name="city"', "value=\"$city\""));
	$province_control = 		tag('input', attributes('type="text"', "size=\"100\"", "maxlength=\"100\"", 'name="province"', "value=\"$province\""));
	$postal_code_control = 		tag('input', attributes('type="text"', "size=\"15\"", "maxlength=\"15\"", 'name="postal_code"', "value=\"$postal_code\""));
	$phone_control = 			tag('input', attributes('type="text"', "size=\"100\"", "maxlength=\"100\"", 'name="phone"', "value=\"$phone\""));
	$email_control = 			tag('input', attributes('type="text"', "size=\"100\"", "maxlength=\"100\"", 'name="email"', "value=\"$email\""));

	$submit_control = create_submit(_("Submit Changes"));
	
	
	$retText = tag('div');
	
	$retText->add( tag('div',		
					 tag('form', attributes("name='userForm' action=\"$phpc_script\""), 
								tag('table', attributes('class="form-main"'), tag('caption', "Contact Information"), tag('tfoot', 
									tag('tr', tag('td', attributes('colspan="2"'), $input, $submit_control, create_hidden('action', 'my_account'), create_hidden('subaction', 'event_submit')))), 
									tag('tbody',
										tag('tr', tag('th', _('Display name:')), tag('td',                    $display_name_control   )), 
										tag('tr', tag('th', _('Address 1:')), tag('td', $address1_control )), 
										tag('tr', tag('th', _('Address 2:')), tag('td', $address2_control )), 
										tag('tr', tag('th', _('City:')), tag('td', 	$city_control)), 
										tag('tr', tag('th', _('Province:')),   tag('td', $province_control)), 
										tag('tr', tag('th', _('Postal code:')), tag('td',$postal_code_control)), 
										tag('tr', tag('th', _('Phone:')), tag('td', $phone_control)),
										tag('tr', tag('th', _('Email:')), tag('td', $email_control))
										)))
					));
					
	return $retText;
}

?>
