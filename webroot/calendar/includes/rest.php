<?php

function calendars()
{
	global $vars, $phpc_script, $day, $year, $month, $db, $noNavbar;
	
	$noNavbar = true;
	
	$query = 'SELECT * FROM '.SQL_PREFIX.'calendars';
    $result = $db->Execute($query)
        or db_error(_('Error in login_form'), $query);
    
    $cals = array();
    while($row = $result->FetchRow($result)) {
        $cals[$row['calendar']] = $row['calendar_title'];
    }

	echo json_encode($cals);
}

if(isset($_REQUEST['method']))
{
	$_REQUEST['method']();
}

?>