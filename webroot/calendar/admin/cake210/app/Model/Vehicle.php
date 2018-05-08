<?php

class Vehicle extends AppModel
{
    public $name = 'Vehicle';
    public $displayField = 'name';
    
    public $hasMany = array('Bookable' =>
                        array('className'    => 'Bookable',
                              'conditions'   => '',
                              'order'        => '',
                              'dependent'    =>  false,
                              'foreignKey'   => 'vehicle_id'
                        )
                  );

    public $hasOne = array( 'Vehicletype' =>
                        array('className'    => 'Vehicletype',
                              'fields'   => 'type',
                              'dependent'    =>  false,
                              'foreignKey' => 'id'
                        )					
                  );    
				  
	public function translateArrayOfAcntFields(&$data, $chartofaccounts) {
		foreach ($data as &$record) {
			$this->translateAcntFields($record,$chartofaccounts);
		}
	}
	
	static public function TryGetValue($chartofaccounts, $key)
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
		$data['Vehicle']['acnt_code_gas'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_gas']);
		$data['Vehicle']['acnt_code_admin'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_admin']);
		$data['Vehicle']['acnt_code_repair'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_repair']);
		$data['Vehicle']['acnt_code_insurance'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_insurance']);
		$data['Vehicle']['acnt_code_misc_1'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_fines']);
		$data['Vehicle']['acnt_code_misc_2'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_misc_2']);
		$data['Vehicle']['acnt_code_misc_3'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_misc_3']);
		$data['Vehicle']['acnt_code_misc_4'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_misc_4']);
		$data['Vehicle']['acnt_code_hours'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_hours']);
		$data['Vehicle']['acnt_code_blocked_time'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_blocked_time']);
		$data['Vehicle']['acnt_code_km'] = $this->TryGetValue($chartofaccounts, $data['Vehicle']['acnt_new_code_km']);
	}
}

?>