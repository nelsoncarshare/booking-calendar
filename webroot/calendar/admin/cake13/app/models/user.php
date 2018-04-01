<?php

class User extends AppModel
{
    var $name = 'User';
    var $displayField = 'displayname'; 

    var $validate = array(
//		'group_id' => array('required' => true)
    );

    var $hasAndBelongsToMany = array( 'Permission' =>
	                               array('className'    => 'Permission',
	                                     'joinTable'    => 'users_permissions',
	                                     'foreignKey'   => 'user_id',
	                                     'associationForeignKey'=> 'permission_id',
	                                     'conditions'   => '',
	                                     'order'        => '',
	                                     'limit'        => '',
	                                     'unique'       => true,
	                                     'finderQuery'  => '',
	                                     'deleteQuery'  => '',
	                               )	                               
                               );
                               
    var $hasOne = array('Invoicable' =>
					 array('className' => 'Invoicable',
							'conditions' => '',
							'order' => '',
							'dependent' => true,
							'foreignKey' => 'user_id'
							)
					);
        
      var $belongsTo = array('Group' =>
                           array('className'  => 'Group',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'group_id'
                           )                          
                     );
					 
	public function translateArrayOfAcntFields(&$data, $chartofaccounts) {
		foreach ($data as &$record) {
			$this->translateAcntFields($record,$chartofaccounts);
		}
	}
	
	public function translateAcntFields(&$data, $chartofaccounts) {
		$data['User']['acnt_code_customer'] = $chartofaccounts[$data['User']['acnt_code_customer']];
	}
}

?>