<?php

class Bookable extends AppModel
{
    var $name = 'Bookable';
	var $displayField = 'name';
	
    var $belongsTo = array('Vehicle' =>
                           array('className'  => 'Vehicle',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'vehicle_id'
                           ),
                           'Location' =>
                           array('className'  => 'Location',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'location_id'
                           )                           
                     );     
                     
    var $hasAndBelongsToMany = array('Calendar' =>
	                               array('className'    => 'Calendar',
	                                     'joinTable'    => 'bookables_calendars',
	                                     'foreignKey'   => 'bookable_id',
	                                     'associationForeignKey'=> 'calendar_id',
	                                     'conditions'   => '',
	                                     'order'        => '',
	                                     'limit'        => '',
	                                     'unique'       => true,
	                                     'finderQuery'  => '',
	                                     'deleteQuery'  => '',
	                               ), 'Announcement' =>
	                               array('className'    => 'Announcement',
	                                     'joinTable'    => 'announcements_bookables',
	                                     'foreignKey'   => 'bookable_id',
	                                     'associationForeignKey'=> 'announcement_id',
	                                     'conditions'   => '',
	                                     'order'        => '',
	                                     'limit'        => '',
	                                     'unique'       => true,
	                                     'finderQuery'  => '',
	                                     'deleteQuery'  => '',
	                               )
                               );                          
	/*
    var $hasMany = array('Event' =>
                           array('className'  => 'Event',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'bookableobject'
                           )                          
                     );
    */
                     
    function getBookablesForSelectBox()
    {
    	global $SQL_PREFIX;
    	$ret = $this->find('all');

	    for($i = 0; $i < sizeOf($ret); $i++){
			$ret2[$ret[$i]['Bookable']['id']] = $ret[$i]["Vehicle"]['name'];
	    }

        return $ret2;
    }
                                         
    function getVehicles()
    {
    	global $SQL_PREFIX;
    	$ret = $this->query("SELECT id, name FROM " . $SQL_PREFIX . "vehicles WHERE disabled='false'");
    	
	    for($i = 0; $i < sizeOf($ret); $i++){
			$ret2[$ret[$i][$SQL_PREFIX . "vehicles"]['id']] = $ret[$i][$SQL_PREFIX . "vehicles"]['name'];
	    }

        return $ret2;
    }

    function getLocations()
    {
    	global $SQL_PREFIX;
    	$ret = $this->query("SELECT id, name FROM " . $SQL_PREFIX . "locations");
	    for($i = 0; $i < sizeOf($ret); $i++){
			$ret2[$ret[$i][$SQL_PREFIX . "locations"]['id']] = $ret[$i][$SQL_PREFIX . "locations"]['name'];
	    }    	
        return $ret2;
    }    
    
    function beforeValidate(){
    	
    	$vehicle_id = $this->data['Bookable']['vehicle_id'];
    	$found = $this->find("list", array('conditions'=>"vehicle_id=$vehicle_id"));
    	$foundanother = false;
    	if (is_array($found)){
	    	// foreach (array_keys($found) as $i) {
	    		// if ($i != $this->data['Bookable']['id']){
	    			// $foundanother = true;
	    		// }
	    	// }
	    }
    	if ($foundanother){
    		$this->invalidate('vehicle_id');
    	}
    }
    	
}

?>