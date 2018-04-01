<?php
class Grouptype extends AppModel {
   var $name = 'Grouptype';
   var $displayField = 'type';

   var $belongsTo = array('Group' =>
                           array('className'  => 'Group',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'type'
                           )
                     );   
}
    
?>
