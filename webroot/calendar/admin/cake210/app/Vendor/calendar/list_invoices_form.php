<?php

if (!defined('IN_PHPC')) {
	die("Hacking attempt");
}

function list_invoices_form() {
	global $vars, $day, $month, $year, $db, $config, $phpc_script, $month_names, $event_types, $calendar_name, $ANNOUNCE_TYPES;
			
	$users = get_invoicables();
	//if ($row1 = $result->FetchRow()) {
	//	for (; $row1; $row1 = $result->FetchRow()) {
	//		$users[$row1['id']] = $row1['displayname'];
	//	}
	//}	
	
	$users['_ALL_USERS'] = "ALL USERS IFF FILES";
		
	$memberFormContol =   create_select('user', $users, 0);
	
	$submit_control = create_submit(_("Submit Query"));
			
	$retText = tag('div');
	
	
	$retText->add( tag('div',	
					 attributes(" align='center' "),
					 tag("h2","List Invoices For"),	
					 tag('form', attributes("method='post' action='$phpc_script'"), 
								tag('table', attributes("class='phpc-main'"), tag('tfoot', 
									tag('tr', tag('td', attributes("colspan='2' align='center'"), $submit_control, create_hidden('action', 'list_user_invoices_rpt'), create_hidden('subaction', 'submit')))), 
									tag('tbody',
										tag('tr', tag('th', _('List Invoices For Member')), tag('td',                    $memberFormContol   ))
										)))
					));
	return $retText;
}

?>
