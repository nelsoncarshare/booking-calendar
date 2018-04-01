<?php

define('IN_PHPC', true);
$phpc_root_path = '../';

require_once('RestResource.php'); 
require_once($phpc_root_path . 'includes/calendar.php');
require_once($phpc_root_path . 'includes/setup.php');
require_once($phpc_root_path . 'includes/globals.php');

class EventsResource extends RestResource{
	
	public function __construct()
	{
       $this->legal_actions = array('day', 'month', 'interval', 'showavailable', 'singleevent');
  }
	
	public function doGet(&$success, &$data, &$errors){
			$this->doGetOrPost($success, $data, $errors);
	}
	
	public function doPost(&$success, &$data, &$errors){
			$this->doGetOrPost($success, $data, $errors);
	}
	
	public function doGetOrPost(&$success, &$data, &$errors){
			 global $vars;
			 if (!check_user()){
					$success = false;
					$errors[] = "not logged in.";
			 } else if (!isset($vars)){
					$success = false;
					$errors[] = "no arguments";
			 } else if (!array_key_exists('action',$vars) || !in_array($vars['action'], $this->legal_actions, true)){
					$success = false;
					$errors[] = "no action or bad action";
			 } else if ($vars['action'] == "singleevent"){
					if (!array_key_exists('id', $vars) ){		 
						$success = false;
						$errors[] = "no id";			
					} else {
						$data = resultset_to_array(get_event_by_id($vars['id']));
					}
			 } else if ($vars['action'] == "day") {

          //todo get day
          $data = resultset_to_array(get_events_by_date($day,$month,$year));
			 } else if ($vars['action'] == "month") {

          //todo get month and year
          $data = resultset_to_array(get_events_for_month($day,$month));	 
			 } else if ($vars['action'] == "interval" || $vars['action'] == "showavailable") {
					if (!array_key_exists('starttime', $vars) ){		 
						$success = false;
						$errors[] = "no starttime";					
					} else if (!array_key_exists('endtime', $vars)) {
						$success = false;
						$errors[] = "no endtime";					 	
					}	else {
						$starttime = $this->getTimeFromParam($vars['starttime']);
						$endtime = $this->getTimeFromParam($vars['endtime']);
						if ($starttime == FALSE){
							$success = false;
							$errors[] = "bad starttime";								
						} else if ($endtime == FALSE){
							$success = false;
							$errors[] = "bad endtime";	
						} else {
							if ($vars['action'] == "interval"){
								//todo optional bookableID parameter
	          		$data = resultset_to_array(get_events_for_interval($starttime,$endtime));	
							} else if ($vars['action'] == "showavailable"){
	          		$data = $this->show_available($starttime,$endtime);	
	          	}
						}
					}
			 }
	}	
	
	function getTimeFromParam($paramVal){
		$starttimeDetail = strtotime($paramVal);
		
		if ($starttimeDetail == FALSE) return FALSE;
			
		$fifteenMinutes = 60*15; //in seconds
	
		//force start time and end time to be on 15 minute increments	
		$starttime = strtotime(date('Y-m-d H:00:00', $starttimeDetail));
		
		$starttimeDetail = floor(($starttimeDetail - $starttime) / $fifteenMinutes) * $fifteenMinutes + $starttime;
		
		return $starttimeDetail;
	}
	


	//---------
	function show_available($starttimeDetail, $endtimeDetail)
	{
		global $config, $phpc_script, $vars, $calendar_name, $noNavbar;
	
		$fifteenMinutes = 60*15; //in seconds

		//TODO Oops Red lines are being rounded to hours not to 15 mins
		//force start time and end time to be on 15 minute increments	
		//$startTimeFull = strtotime(date('Y-m-d H:00:00', $starttimeDetail));
		//$endTimeFull = strtotime(date('Y-m-d H:00:00', $starttimeDetail));
		
		$starttime = strtotime(date('Y-m-d H:00:00', $starttimeDetail));
		$endtime = strtotime(date('Y-m-d H:00:00', $endtimeDetail));
		
		$starttimeDetail = floor(($starttimeDetail - $starttime) / $fifteenMinutes) * $fifteenMinutes + $starttime;
		$endtimeDetail   = floor(($endtimeDetail   - $endtime) / $fifteenMinutes) *   $fifteenMinutes + $endtime;
		
		$interval = ($endtime - $starttime) / ($fifteenMinutes); //interval is in blocks
		if ($interval < 4){ //min interval is one hour
			$interval = 4;
			$endtime = $starttime + $interval * $fifteenMinutes;
		} else if ($interval > 24 * 40 * 4){ //don't try to fetch more than 40 days data
			$interval = 24 * 40 * 4;
			$endtime = $starttime + $interval * $fifteenMinutes;
		}
		
		//$step = ceil(($interval/4)/20); //convert the interval to hours and divide by twenty
		
		//$starttimePadded = $starttime - ceil($interval * .025) * $fifteenMinutes * 4;
		//$endtimePadded = $endtime + ceil($interval * .025) * $fifteenMinutes * 4;	
		$starttimePadded = $starttime;
		$endtimePadded = $endtime;
		
		$interval = ($endtimePadded - $starttimePadded) / ($fifteenMinutes); //interval is in blocks
		
		$result = get_events_for_show_available($starttimePadded, $endtimePadded);
		$bookableID = -1;
		
		//group array into events per vehicle
		$events = resultset_to_array($result);//$result->GetAll();
		$eventsPerVehicle = Array();
		$i = 0;
		while ($i < count($events)){
			if ($bookableID != $events[$i]['bookableid']){
				$bookableID = $events[$i]['bookableid'];
				$eventsOnlyOneVehicle = new ArrayObject();
				$eventsPerVehicle[] = $eventsOnlyOneVehicle;
			}
			$eventsOnlyOneVehicle->Append( $events[$i] );
			$i++;
		}
		
		//adjust the start and end times of first and last event
		foreach ($eventsPerVehicle as $i => $events){
			$eventsPerVehicle[$i]['length'] = Count($events);
			foreach ($events as $j => $event){
				//don't know why this null check is necessary but there is an error if I don't have it.
				if ($event['starttimestamp'] != null){
					//don't trust the start and end stamp because we don't know what timezone offset it is using
					//recalculate these from the hours,minutes etc...
					$tm = mktime($event['hour'],$event['minute'],0,$event['month'],$event['day'],$event['year']);
					$eventsPerVehicle[$i][$j]['starttimestamp'] = $tm;
					$eventsPerVehicle[$i][$j]['endtimestamp'] = mktime($event['end_hour'],$event['end_minute'],0,$event['end_month'],$event['end_day'],$event['end_year']);
					
					if ($event['starttimestamp'] < $starttimePadded){
						$eventsPerVehicle[$i][$j]['starttimestamp'] = $starttimePadded;
						//echo("adjusted start " . $eventsPerVehicle[$i][0]['name'] . " " . $events[0]['name'] . " lrn" .  Count($events) . " start" . $eventsPerVehicle[$i][0]['starttimestamp'] . "\n");
					}
					if ($event['endtimestamp'] > $endtimePadded){
						//echo("adjusted ");
						$eventsPerVehicle[$i][$j]['endtimestamp'] = $endtimePadded;
					}
				}
			}
		}
		
		//calculate startblock and numblocks for each event
		foreach ($eventsPerVehicle as $i => $events){
			foreach ($events as $j => $event){
				if ($event['starttimestamp'] != null){
						$start = $starttimePadded;
						$end = $event['starttimestamp'];
						$startBlock = ($end - $start) / $fifteenMinutes;
						$numblocks = ($event['endtimestamp'] - $event['starttimestamp']) / $fifteenMinutes;
						$eventsPerVehicle[$i][$j]['startblock'] = $startBlock;
						$eventsPerVehicle[$i][$j]['numblocks'] = $numblocks;
				}			
			}
		}
		
		$out = array($eventsPerVehicle);
		$out['eventsPerVehicle'] = $eventsPerVehicle;
		$out['interval'] = $interval;
		$out['startTime'] = date("Y-n-d H:00:00", $starttimePadded);
		$out['starttimepadded'] = $starttimePadded;
		$out['endtimepadded'] = $endtimePadded;
		$out['endTime'] = date("Y-n-d H:00:00", $endtimePadded);
		$out['startDay'] = date("d", $starttimePadded);
		return $out;
	}
	//---------	
}

$v = new EventsResource();
$v->processRequest();
?>