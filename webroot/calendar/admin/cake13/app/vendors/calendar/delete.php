<?php

	function deleteEvent($evid){
		global $db;

		$query= "DELETE FROM ".SQL_PREFIX."tagged_event_slots where eventid='$evid'\n";
		//echo($query . "<br/>");
		$result = $db->Execute($query)
	                or db_error("deleting tagged_event_slots", $query);	

		$query= "DELETE FROM ".SQL_PREFIX."event_log where eventid='$evid'\n";
		//echo($query . "<br/>");
		$result = $db->Execute($query)
	                or db_error("deleting event_log", $query);

		$query= "DELETE FROM ".SQL_PREFIX."events where id='$evid'\n";
		//echo($query . "<br/>");
		$result = $db->Execute($query)
	                or db_error("deleting event", $query);	                
	}
	
	function deleteEventsForBookable($bookableid){
		global $db;
		
		$query= "SELECT id from ".SQL_PREFIX."events where bookableobject='$bookableid'\n";
		$result = $db->Execute($query)
	                or db_error("deleting tagged_event_slots", $query);	
	    while($row = $result->FetchRow()){
	    	deleteEvent($row['id']);
	    	echo ("deleting event with id " . $row['id'] . "<br/>");
	    }
	}

	function deleteEventsForUser($userid){
		global $db;
		
		$query= "SELECT id from ".SQL_PREFIX."events where uid='$userid'\n";
		$result = $db->Execute($query)
	                or db_error("deleting tagged_event_slots", $query);	
	    while($row = $result->FetchRow()){
	    	deleteEvent($row['id']);
	    	echo ("deleting event with id " . $row['id'] . "<br/>");
	    }
	}

?>