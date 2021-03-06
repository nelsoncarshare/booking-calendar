<?php

if (!defined('IN_PHPC')) {
	die("Hacking attempt");
}

function preview_invoice_form() {
	global $vars, $day, $month, $year, $db, $config, $phpc_script, $month_names, $event_types, $calendar_name, $ANNOUNCE_TYPES;
	
	$error_msg = "";
	
    if (isset($vars['month'])){
        $month     = $vars['month'];
        $year      = $vars['year'];
        $uid =         $vars['user'];
    } else {
        $month = 1;
        $year = 2010;
        $uid = -1;
    }
    
			
	$startstamp =   mktime(0, 0, 0, 0, $month, $year);
		
	//$users[-1] = "ANY USER";
	$users = get_invoicable_users_and_groups();	
	
	$year_sequence = create_sequence(2007, 2037);
	
	//============= build form controls
	if (isset ($id))
		$input = create_hidden('id', $id);
	else
		$input = '';	

	$memberFormContol =   create_select('user', $users, $uid);
	$month_selector = create_select('month', $month_names, $month);
	$year_selector = create_select('year', $year_sequence, $year);
	
	$submit_control = create_submit(_("Submit Query"));
			
	$retText = tag('div');

	if ($error_msg != "") {
		$retText->add(
					tag("div",
							attributes("style='border: 2px solid #000; background-color: #FFFFAA;'"),
							//tag("b", "Note:"),
							tag("b", tag("font",attributes("color='red' align='center'"),$error_msg)))		
					  );
	}
	
	$retText->add( tag('div',	
					 attributes(" align='center' "),
					 tag("h2","Preview Invoices"),	
					 tag('form', attributes("method='post' action='$phpc_script'"), 
								tag('table', attributes("class='phpc-main'"), tag('tfoot', 
									tag('tr', tag('td', attributes("colspan='2' align='center'"), $input, $submit_control, create_hidden('action', 'user_preview_invoice_rpt'), create_hidden('subaction', 'submit')))), 
									tag('tbody',
										tag('tr', tag('th', _('Preview Invoice For Member')), tag('td',                    $memberFormContol   )), 
										tag('tr', tag('th', _('Use Billing Info For')), tag('td',     $month_selector,     $year_selector)) 
										)))
					));
	return $retText;
}

?>
