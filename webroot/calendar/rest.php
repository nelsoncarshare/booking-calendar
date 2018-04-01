<?php

require_once($phpc_root_path . 'includes/setup.php');

function calendars()
{
	global $db;
	
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