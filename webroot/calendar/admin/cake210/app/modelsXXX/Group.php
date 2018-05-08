<?php

class Group extends AppModel
{
    public $name = 'Group';
    public $displayField = 'grp_displayname';
    
    public $hasMany = array('User' =>
                        array('className'    => 'User',
                              'conditions'   => '',
                              'order'        => '',
                              'dependent'    =>  true,
                              'foreignKey'   => 'group_id'
                        )
                  );

    public $hasOne = array('Grouptype' =>
                        	array('className'    => 'Grouptype',
                              'conditions'   => '',
                              'order'        => '',
                              'dependent'    =>  true,
                              'foreignKey'   => 'id'
                        ),
                        'Invoicable' =>
					 		array('className' => 'Invoicable',
							'conditions' => '',
							'order' => '',
							'dependent' => true,
							'foreignKey' => 'user_id'
							)
                  );   

	public function translateArrayOfAcntFields(&$data, $chartofaccounts) {
		foreach ($data as &$record) {
			$this->translateAcntFields($record,$chartofaccounts);
		}
	}
	
	public function translateAcntFields(&$data, $chartofaccounts) {
		$data['Group']['acnt_code_group_customer'] = $chartofaccounts[$data['Group']['acnt_code_group_customer']];
	}
				  
	function beforeValidate(){
		if ( $this->data['Group']['type'] == 1 ){
			$this->invalidate('type');
		}			
	}
	 
}

?>