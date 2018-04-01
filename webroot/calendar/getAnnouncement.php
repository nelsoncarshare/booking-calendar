<?php

define('IN_PHPC', true);
$phpc_root_path = './';

require_once($phpc_root_path . 'includes/calendar.php');
require_once($phpc_root_path . 'includes/setup.php');
require_once($phpc_root_path . 'includes/globals.php');

$q=$_GET["q"];

echo (get_notes_event_form(date('Y-m-d H:i:s'),$q ));

?>