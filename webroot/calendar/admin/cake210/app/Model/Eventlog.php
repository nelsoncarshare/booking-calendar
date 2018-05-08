<?php
class Eventlog extends AppModel {
   public $name = 'event_log';
   public $useTable = 'event_log';
   public $displayField = 'id';

    function getDataForGrid($numrows = -1, $page = 1, $modified_by, $event_is_for, $start_aft_date, $start_bef_date, $end_aft_date, $end_bef_date, $cre_aft_date, $cre_bef_date, $bookable, $ev_type) {
    	$whereclause = "WHERE true=true";
    	if ($modified_by != -1){
    	    $whereclause .= " AND U1.id=$modified_by ";   
    	}
    	if ($event_is_for != -1){
    	    $whereclause .= " AND U2.id=$event_is_for ";   
    	}    
    		
    	if (strlen($start_aft_date) > 0){
    	    $dt_stmp = strtotime($start_aft_date);
    	    if ($dt_stmp != -1){
    	        $whereclause .= " AND starttime > DATE '" . date('Y-m-d-H-i-s', $dt_stmp) . "'";
    	    } else {
    	       $whereclause .=  " AND true=false " ;
    	    }
    	}

    	if (strlen($start_bef_date) > 0){
    	    $dt_stmp = strtotime($start_bef_date);
    	    if ($dt_stmp != -1){
    	        $whereclause .= " AND starttime < DATE '" . date('Y-m-d-H-i-s', $dt_stmp) . "'";
    	    } else {
    	       $whereclause .=  " AND true=false " ;
    	    }
    	}

    	if (strlen($end_aft_date) > 0){
    	    $dt_stmp = strtotime($end_aft_date);
    	    if ($dt_stmp != -1){
    	        $whereclause .= " AND endtime > DATE '" . date('Y-m-d-H-i-s', $dt_stmp) . "'";
    	    } else {
    	       $whereclause .=  " AND true=false " ;
    	    }
    	}

    	if (strlen($end_bef_date) > 0){
    	    $dt_stmp = strtotime($end_bef_date);
    	    if ($dt_stmp != -1){
    	        $whereclause .= " AND endtime < DATE '" . date('Y-m-d-H-i-s', $dt_stmp) . "'";
    	    } else {
    	       $whereclause .=  " AND true=false " ;
    	    }
    	}

    	if (strlen($cre_aft_date) > 0){
    	    $dt_stmp = strtotime($cre_aft_date);
    	    if ($dt_stmp != -1){
    	        $whereclause .= " AND ".SQL_PREFIX."event_log.created > DATE '" . date('Y-m-d-H-i-s', $dt_stmp) . "'";
    	    } else {
    	       $whereclause .=  " AND true=false " ;
    	    }
    	}

    	if (strlen($cre_bef_date) > 0){
    	    $dt_stmp = strtotime($cre_bef_date);
    	    if ($dt_stmp != -1){
    	        $whereclause .= " AND ".SQL_PREFIX."event_log.created < DATE '" . date('Y-m-d-H-i-s', $dt_stmp) . "'";
    	    } else {
    	       $whereclause .=  " AND true=false " ;
    	    }
    	}
    	    	    	
    	if ($bookable != -1){
    	    $whereclause .= " AND bookableobject=$bookable ";  
    	}
    	if ($ev_type != -1){
    	    $whereclause .= " AND operation=$ev_type ";
    	}
    	    	
    		$query= "SELECT ". 
    					 "SQL_CALC_FOUND_ROWS ".SQL_PREFIX."event_log.id ".
	             ", ".SQL_PREFIX."event_log.eventid ".
	             ", ".SQL_PREFIX."event_log.starttime ".
	             ", ".SQL_PREFIX."event_log.endtime ".
	             ", ".SQL_PREFIX."event_log.subject".
	             ", ".SQL_PREFIX."event_log.note ".
	             ", ".SQL_PREFIX."bookables.name ".
	             ", ".SQL_PREFIX."event_log.canceled ".
	             ", ".SQL_PREFIX."event_log.modifiedByUid ".
	             ", ".SQL_PREFIX."event_log.bookingIsForUid ".	             
	             ", ".SQL_PREFIX."event_log.amntTagged ".
	             ", ".SQL_PREFIX."event_log.operation ".
	             ", ".SQL_PREFIX."event_log.created ".
	             ", U1.displayname as displaynameMod".
	             ", U2.displayname as displaynameFor".	             
	         " FROM ".SQL_PREFIX."event_log ".
	         " LEFT OUTER JOIN ".SQL_PREFIX."users U1 on modifiedByUid = U1.id ".
	         " LEFT OUTER JOIN ".SQL_PREFIX."users U2 on bookingIsForUid=U2.id ".
	         " LEFT OUTER JOIN ".SQL_PREFIX."bookables on bookableobject=".SQL_PREFIX."bookables.id ".
	         $whereclause;
				if ($numrows > 0){
					$query .= " LIMIT " . ($numrows * ($page -1)) . ", " . ($numrows * $page);
				}
//		echo($query);
    	$res = $this->query( $query );
    	$totalRowsArr = $this->query( "select found_rows()" );
    	$totalRows = $totalRowsArr[0][0]['found_rows()'];
    	
    	$out = array();

		foreach ($res as $row1) {
			$out[] = array_merge(array_merge(array_merge($row1[SQL_PREFIX.'event_log'],$row1['U1']),$row1['U2']), $row1[SQL_PREFIX.'bookables']);			
		}

		$out = array("totalpages" => ceil($totalRows/$numrows), "data" => $out);
    	return $out;
	}
	   
    
}
    
?>
