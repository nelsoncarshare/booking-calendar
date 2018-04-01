<?php

class Location extends AppModel
{
    var $name = 'Location';
    var $displayField = 'name';
    
    var $hasMany = array('Bookable' =>
                        array('className'    => 'Bookable',
                              'conditions'   => '',
                              'order'        => '',
                              'dependent'    =>  true,
                              'foreignKey'   => 'location_id'
                        )
                  );
}

?>