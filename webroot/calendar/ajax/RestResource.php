<?php

if ( !defined('IN_PHPC') ) {
       die("Hacking attempt");
}

require_once('RestUtils.php'); 

class RestResource{
	
	public function processRequest(){
		global $calendar_name;
		
		session_start();
		if (isset($_SESSION['calendar'])){
			$calendar_name = $_SESSION['calendar'];
		} else {
			$calendar_name = 0;
		}
		$data = RestUtils::processRequest();
		
		switch($data->getMethod())
		{
			case 'get':
					 $d = Array();
					 $errors = Array();
					 $success = true;
					 $this->doGet($success,$d,$errors);
		       $out = Array('status' => $success, 'data' => $d, 'errors' => $errors);
		       RestUtils::sendResponse(200, json_encode($out), 'application/json');        
					 break;
			case 'post':
					 $d = Array();
					 $errors = Array();
					 $success = true;
					 $this->doPost($success,$d,$errors);
		       $out = Array('status' => $success, 'data' => $d, 'errors' => $errors);
		       RestUtils::sendResponse(200, json_encode($out), 'application/json');        	
		       break;
		  case 'delete':
					 $errors = Array();
					 $success = true;
					 $this->doDelete($success,$errors);
		       $out = Array('status' => $success, 'data' => Array(), 'errors' => $errors);
		       RestUtils::sendResponse(200, json_encode($out), 'application/json'); 		  
		       break;
		}
	}

	public function doGet(&$success, &$data, &$errors){
		$success = false;
		$errors[] = "not implemented";
	}

	public function doPost(&$success, &$errors){
		$success = false;
		$errors[] = "not implemented";
	}

	public function doDelete(&$success, &$errors){
		$success = false;
		$errors[] = "not implemented";
	}		
}

?>