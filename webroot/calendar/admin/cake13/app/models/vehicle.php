<?php

class Vehicle extends AppModel
{
    var $name = 'Vehicle';
    var $displayField = 'name';
    
    var $hasMany = array('Bookable' =>
                        array('className'    => 'Bookable',
                              'conditions'   => '',
                              'order'        => '',
                              'dependent'    =>  false,
                              'foreignKey'   => 'vehicle_id'
                        )
                  );

    var $hasOne = array( 'Vehicletype' =>
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
	
	public function translateAcntFields(&$data, $chartofaccounts) {
		$data['Vehicle']['acnt_code_gas'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_gas']];
		$data['Vehicle']['acnt_code_admin'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_admin']];
		$data['Vehicle']['acnt_code_repair'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_repair']];
		$data['Vehicle']['acnt_code_insurance'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_insurance']];
		$data['Vehicle']['acnt_code_misc_1'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_fines']];
		$data['Vehicle']['acnt_code_misc_2'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_misc_2']];
		$data['Vehicle']['acnt_code_misc_3'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_misc_3']];
		$data['Vehicle']['acnt_code_misc_4'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_misc_4']];
		$data['Vehicle']['acnt_code_hours'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_hours']];
		$data['Vehicle']['acnt_code_blocked_time'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_blocked_time']];
		$data['Vehicle']['acnt_code_km'] = $chartofaccounts[$data['Vehicle']['acnt_new_code_km']];
	}
}

?>