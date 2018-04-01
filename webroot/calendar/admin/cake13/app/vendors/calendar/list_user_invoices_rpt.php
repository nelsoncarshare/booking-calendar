<?php

if (!defined('IN_PHPC')) {
	die("Hacking attempt");
}

function list_user_invoices_rpt() {
	global $CALENDAR_ROOT, $vars, $day, $month, $year, $db, $config, $phpc_script, $month_names, $event_types, $calendar_name, $ANNOUNCE_TYPES;
							
	$retText = tag('div');
		
	$list = tag("ul");
	if ($vars['user'] == "_ALL_USERS"){
		$lid = "_ALL_USERS";
	} else {
		$lid = str_pad($vars['user'], 15, 0, STR_PAD_LEFT);
	}
	
	$filesList = Array();
	if ($handle = opendir(USER_HOME . "invoicables/" . $lid . "/invoices")) {
	    while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".."){
				$fileList[] = $file;
			}
		}
	    closedir($handle);
	}
	sort($fileList);
	foreach ($fileList as $file) {
		if ($file != "." && $file != ".."){
			if ($vars['user'] == "_ALL_USERS") {
				$list->add(tag("li", 
								tag("a", attributes("href='" . $CALENDAR_ROOT . "fileWrapper.php?user=" . $vars['user'] . "&file=$file'"), "$file")
							));
			} else {
				$list->add(tag("li", 
								tag("a", attributes("href='" . $CALENDAR_ROOT . "fileWrapper.php?inv=" . $vars['user'] . "&file=$file'"), "$file")
							));					
			}
		}
	}
	
	$retText->add($list);
	return $retText;
}

?>
