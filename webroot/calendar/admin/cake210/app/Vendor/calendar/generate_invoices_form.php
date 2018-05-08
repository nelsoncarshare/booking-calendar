<?php

if (!defined('IN_PHPC')) {
	die("Hacking attempt");
}


function generate_invoices_form() {
	global $vars, $day, $month, $year, $db, $config, $phpc_script, $month_names, $event_types, $calendar_name, $ANNOUNCE_TYPES;
	
	$error_msg = "";
	//====================== get data
	
	$month == date('n');
	$year == date('Y');
		
	$startstamp =   mktime(0, 0, 0, 0, $month, $year);	
		
	$tbody = tag("tbody");
	$invoicables = get_invoicable_users_and_groups();
	//print_r($invoicables);
	foreach ($invoicables as $key => $value){
			$checked = false;
			
			$tbody->add(
						tag("tr",
							tag("td", 
									create_checkbox($key, $key, $checked),
									$value
							)
						)
					);
	}	
						
	$year_sequence = create_sequence(2007, 2037);
	
	//============= build form controls

	$month_selector = create_select('month', $month_names, $month);
	$year_selector = create_select('year', $year_sequence, $year);

	$tbody->add(
				tag("tr",
					tag("td",
							"Invoice for: ", 
							$month_selector,
							$year_selector
					)
				)
			);
	
	$submit_control = create_submit(_(" generate invoices "));
			
	$retText = tag('div');

	$retText->add( tag( "script", attributes("type='text/javascript'"),
		"function checkAll(frm){
		  for (var i = 0; i < frm.elements.length; i++) {
    		var e = frm.elements[i];
    		if (e.type == 'checkbox') {
				e.checked = true;
    		}
  		}}
		")
	);
	

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
					 tag("h2","Generate Invoices"),	
					 tag('form', attributes("method='post' name='myform' action='$phpc_script'"), 
								tag('table', attributes("class='phpc-main'"), tag('tfoot', 
									tag('tr', tag('td', attributes("colspan='2' align='center'"), 
												$submit_control, 
												create_hidden('action', 'generate_invoices_rpt'), 
												create_hidden('subaction', 'submit'),
												tag("input", attributes("type='button' name='CheckAll' value='Check All' onClick='checkAll(document.myform);'"))
										))), 
									$tbody
					))));
	return $retText;
}

?>
