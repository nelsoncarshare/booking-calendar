<?php

class Calendar extends AppModel
{
    public $name = 'Calendar';
    public $displayField = 'calendar_title';
    
    public $hasAndBelongsToMany = array('Bookable' =>
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