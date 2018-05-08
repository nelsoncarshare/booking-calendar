<?php

class User extends AppModel
{
    public $name = 'User';
    public $displayField = 'displayname'; 

    public $validate = array(
//		'group_id' => array('required' => true)
    );

    public $hasAndBelongsToMany = array( 'Permission' =>
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
                               
    public $hasOne = array('Invoicable' =>
					 array('className' => 'Invoicable',
							'conditions' => '',
							'order' => '',
							'dependent' => true,
							'foreignKey' => 'user_id'
							)
					);
        
      public $belongsTo = array('Group' =>
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
	
	public function TryGetValue($chartofaccounts, $key)
	{
		if (array_key_exists($key, $chartofaccounts))
		{
			return $chartofaccounts[$key];
		} else 
		{
			return "UNDEFINED";
		}
	}	
	
	public function translateAcntFields(&$data, $chartofaccounts) {
		$data['User']['acnt_code_customer'] = $this->TryGetValue($chartofaccounts, $data['User']['acnt_code_customer']);
	}
}

?>