<?php

class Location extends AppModel
{
    public $name = 'Location';
    public $displayField = 'name';
    
    public $hasMany = array('Bookable' =>
                        array('className'    => 'Bookable',
                              'conditions'   => '',
                              'order'        => '',
                              'dependent'    =>  true,
                              'foreignKey'   => 'location_id'
                        )
                  );
}

?>