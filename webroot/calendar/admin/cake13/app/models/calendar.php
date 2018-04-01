<?php

class Calendar extends AppModel
{
    var $name = 'Calendar';
    var $displayField = 'calendar_title';
    
    var $hasAndBelongsToMany = array('Bookable' =>
	                               array('className'    => 'Bookable',
	                                     'joinTable'    => 'bookables_calendars',
	                                     'foreignKey'   => 'calendar_id',
	                                     'associationForeignKey'=> 'bookable_id',
	                                     'conditions'   => '',
	                                     'order'        => '',
	                                     'limit'        => '',
	                                     'unique'       => true,
	                                     'finderQuery'  => '',
	                                     'deleteQuery'  => '',
	                               ),
	                               'Announcement' =>
	                               array('className'    => 'Announcement',
	                                     'joinTable'    => 'announcements_calendars',
	                                     'foreignKey'   => 'calendar_id',
	                                     'associationForeignKey'=> 'announcement_id',
	                                     'conditions'   => '',
	                                     'order'        => '',
	                                     'limit'        => '',
	                                     'unique'       => true,
	                                     'finderQuery'  => '',
	                                     'deleteQuery'  => '',
	                               )	                               
                               );
    
}

?>