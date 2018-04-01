<?php
class Announcementdate extends AppModel {
   var $name = 'Announcementdate';
   var $displayField = 'id';

   var $belongsTo = array('Announcement' =>
                           array('className'  => 'Announcement',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'announcement_id'
                           )
                     );
   
    
}
    
?>
