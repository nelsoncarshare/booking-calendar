<?php
class Vehicletype extends AppModel {
   public $name = 'Vehicletype';
   public $displayField = 'type';

   public $hasMany = array('Vehicle' =>
                           array('className'  => 'Vehicle',
                                 'foreignKey' => 'vehicle_type'
                           )
                     );   
}
    
?>
