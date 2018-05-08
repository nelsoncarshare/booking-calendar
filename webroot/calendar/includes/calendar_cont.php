<?php 


if(!defined('IN_PHPC')) {
       die("Hacking attempt");
}

if(!empty($_GET['action']) && $_GET['action'] == 'style') {
	require_once($phpc_root_path . 'includes/style.php');
	exit;
}

require_once($phpc_root_path . 'includes/calendar.php');
require_once($phpc_root_path . 'includes/setup.php');
require_once($phpc_root_path . 'includes/globals.php');
require_once($phpc_root_path . 'custom/globals.php');
require_once($phpc_root_path . 'custom/rules.php');


$legal_actions = array('event_form', 'event_delete', 'display', 'event_submit',
		        'login', 'logout',  'redirect', 'list_users', 'new_password',
		        'my_account', 'show_available', 'couldnt_book_vehicle', 'trip_estimate', 'rest', 'data');

if(!in_array($action, $legal_actions, true)) {
	soft_error(_('Invalid action'));
}



if($action=='redirect'){
	redirect($_GET['page']);
}


require_once($phpc_root_path . "includes/$action.php");

eval("\$output = $action();");

echo( "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
	."<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n"
	."\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">"
	."<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='$lang' lang='$lang'>"
			."<head>"
			."<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>"
				."<title>".$config['calendar_title'] . "</title>"
				.'<link rel="stylesheet" type="text/css" href="custom/calendar.css">'
				.'<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">'
        .'<script src="js/jquery-1.8.3.js?ver=1.125"></script>'
				.'<script src="js/jquery-ui.js?ver=1.125"></script>'
				.'<script src="js/calendar.js?ver=1.125"></script>'
				.'<script src="js/jquery.cookie.js?ver=1.125"></script>'
				.'<script src="js/jquery.collapsible.js?ver=1.125"></script>'
				.'<script src="js/jquery.blockUI.js?ver=1.125"></script>'
                ."<script type='text/javascript' src='js/jquery.form.js?ver=1.125'></script>" 
			    ."<body>"
				."<div id=\"modal_window_div\" style=\"display: none;\"></div>");
echo( create_xhtml($output));
//write_log();
echo( "<script src=\"js/base_functions.js?ver=1.125\"></script>" );
echo( "<script src=\"js/data.js?ver=1.125\"></script>" );
echo( "<script src=\"js/responsivemenu.js?ver=1.125\"></script>" );
echo( "<script src=\"js/ui/calendar.js?ver=1.125\"></script></body></html>" );

?>