<?php

define('IN_PHPC', true);
$phpc_root_path = '../';

require_once('RestResource.php'); 
require_once($phpc_root_path . 'includes/calendar.php');
require_once($phpc_root_path . 'includes/setup.php');
require_once($phpc_root_path . 'includes/globals.php');

$v = new VehicleResource();
$v->processRequest();

class VehicleResource extends RestResource{
	public function doGet(&$success, &$data, &$errors){
			global $vars;
			 if (!check_user()){
					$success = false;
					$errors[] = "not logged in.";			 	 
       } else if (!array_key_exists('calendarID',$vars)){
					$success = false;
					$errors[] = "no calendarID parameter";
			 } else {
          $calendar_name = $vars['calendarID'];
          $data = resultset_to_array(get_vehicles($calendar_name));
       }		
	}	
}

?>