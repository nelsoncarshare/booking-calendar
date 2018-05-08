<?php
class Announcementdate extends AppModel {
   public $name = 'Announcementdate';
   public $displayField = 'id';

   public $belongsTo = array('Announcement' =>
                           array('className'  => 'Announcement',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'announcement_id'
                           )
                     );
   
    
}
    
?>
