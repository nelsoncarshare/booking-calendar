<?php
class CouldntBookVehicle extends AppModel {
   var $name = 'couldnt_book_vehicle';
   var $useTable = 'couldnt_book_vehicle';
   var $displayField = 'id';

    function getDataForGrid($numrows = -1, $page = 1, $modified_by, $creation_a_dt, $creation_b_dt, $bookable) {
    	$whereclause = "WHERE true=true";
    	if ($modified_by != -1){
    	    $whereclause .= " AND U1.id=$modified_by ";   
    	} 
/*    		
    	if (strlen($creation_dt) > 0){
    	    $dt_stmp = strtotime($creation_dt);
    	    if ($dt_stmp != -1){
    	        $whereclause .= " AND starttime > DATE '" . date('Y-m-d-H-i-s', $dt_stmp) . "'";
    	    } else {
    	       $whereclause .=  " AND true=false " ;
    	    }
    	}
    */	    	    	
    	if ($bookable != -1){
    	    $whereclause .= " AND bookableobject=$bookable ";  
    	}

    	    	
    		$query= "SELECT ". 
    			 "SQL_CALC_FOUND_ROWS ".SQL_PREFIX."couldnt_book_vehicle.id ".
	             ", ".SQL_PREFIX."couldnt_book_vehicle.uid ".
	             ", ".SQL_PREFIX."couldnt_book_vehicle.creationtime ".
	             ", ".SQL_PREFIX."couldnt_book_vehicle.comment ".
				 ", U.displayname as displayname".
				 ", ".SQL_PREFIX."bookables.name ".
				 " from ".SQL_PREFIX."couldnt_book_vehicle ".
	         " LEFT OUTER JOIN ".SQL_PREFIX."users U on uid = U.id ".
	         " LEFT OUTER JOIN ".SQL_PREFIX."bookables on bookable=".SQL_PREFIX."bookables.id ".
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
			$out[] = array_merge(array_merge($row1[SQL_PREFIX.'couldnt_book_vehicle'],$row1['U']), $row1[SQL_PREFIX.'bookables']);			
		}

		$out = array("totalpages" => ceil($totalRows/$numrows), "data" => $out);
    	return $out;
	}
	   
    
}
    
?>
