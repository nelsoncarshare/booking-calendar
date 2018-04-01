<?php

if (!defined('IN_PHPC')) {
	die("Hacking attempt");
}

function list_users() {
	global $vars, $day, $month, $year, $db, $config, $phpc_script, $month_names, $event_types, $calendar_name, $ANNOUNCE_TYPES;

	if (!isset( $_SESSION['uid'])){
		redirect($phpc_script . "?action=login");
	}
	
	if (!is_allowed_permission_checkpoint("LIST_USERS")){
		redirect_permission_check_failed();
	}
	// ================= prepare sequences for dropdown lists.
	
	$tbody = tag('tbody');
	$result = get_users();
	if ($row1 = $result->FetchRow()) {
		for (; $row1; $row1 = $result->FetchRow()) {
			$tbody->add(
							tag("tr", tag("td",
										tag("b",$row1['displayname']),
										tag("br"),
										tag("blockquote",
											_(" " . $row1['username'] . "<br/>" ),
											_(" " . $row1['address1'] . "<br/>"),
											_(" " . $row1['address2'] . "<br/>"),
											_(" " . $row1['city'] . " " . $row1['province'] . " " . $row1['postalcode'] . "<br/>"),
											_(" " . $row1['phone'] . " " . $row1['email'] . "<br/>")
										)
									)
							)
						);
		}
	}	
	
	$title = "Members";
	$retText = tag('div');

	$retText->add( tag('div',		
					 tag('form', attributes("action=\"$phpc_script\""), 
								tag('table', attributes('class="phpc-main"'), 
									tag('caption', $title) ,
									$tbody
					))));
	return $retText;
}

?>
