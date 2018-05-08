<?php

class Permission extends AppModel
{
    public $name = 'Permission';
    public $displayField = 'permission'; 

    public $hasAndBelongsToMany = array( 'User' =>
	                               array('className'    => 'User',
	                                     'joinTable'    => 'users_permissions',
	                                     'foreignKey'   => 'permission_id',
	                                     'associationForeignKey'=> 'user_id',
	                                     'conditions'   => '',
	                                     'order'        => '',
	                                     'limit'        => '',
	                                     'unique'       => true,
	                                     'finderQuery'  => '',
	                                     'deleteQuery'  => '',
	                               )	                               
                               );
    
    public $hasMany = array('Invoiceextraitem' =>
            array('className'     => 'Invoiceextraitem',
                      'conditions'    => '',
                           'order'         => '',
                           'limit'         => '',
                           'foreignKey'    => 'user_id',
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