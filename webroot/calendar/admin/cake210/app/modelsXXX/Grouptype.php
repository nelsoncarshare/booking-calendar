<?php
class Grouptype extends AppModel {
   public $name = 'Grouptype';
   public $displayField = 'type';

   public $belongsTo = array('Group' =>
                           array('className'  => 'Group',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'type'
                           )
                     );   
}
    
?>
