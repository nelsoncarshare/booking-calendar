<?php
class Vehicletype extends AppModel {
   var $name = 'Vehicletype';
   var $displayField = 'type';

   var $hasMany = array('Vehicle' =>
                           array('className'  => 'Vehicle',
                                 'foreignKey' => 'vehicle_type'
                           )
                     );   
}
    
?>
