<?php

class Announcement extends AppModel
{
    public $name = 'Announcement';
    public $displayField = 'title';
    
    public $hasAndBelongsToMany = array('Calendar' =>
	                               array('className'    => 'Calendar',
	                                     'joinTable'    => 'announcements_calendars',
	                                     'foreignKey'   => 'announcement_id',
	                                     'associationForeignKey'=> 'calendar_id',
	                                     'conditions'   => '',
	                                     'order'        => '',
	                                     'limit'        => '',
	                                     'unique'       => true,
	                                     'finderQuery'  => '',
	                                     'deleteQuery'  => '',
	                               ),
	                               'Bookable' =>
	                               array('className'    => 'Bookable',
	                                     'joinTable'    => 'announcements_bookables',
	                                     'foreignKey'   => 'announcement_id',
	                                     'associationForeignKey'=> 'bookable_id',
	                                     'conditions'   => '',
	                                     'order'        => '',
	                                     'limit'        => '',
	                                     'unique'       => true,
	                                     'finderQuery'  => '',
	                                     'deleteQuery'  => '',
	                               )
                               );
    
        public $hasMany = array('Announcementdate' =>
                         array('className'     => 'Announcementdate',
                               'conditions'    => '',
                               'order'         => '',
                               'limit'         => '',
                               'foreignKey'    => 'announcement_id',
                               'dependent'     => true,
                               'exclusive'     => false,
                               'finderQuery'   => '',
                               'fields'        => '',
                               'offset'        => '',
                               'counterQuery'  => ''
                         )
                  );
}

?>