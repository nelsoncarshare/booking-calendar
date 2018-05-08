<?php

class Billing extends AppModel
{
    public $name = 'Billing';
    public $displayField = 'month';
    
    public $validate = array(
      'dont_charge_interest_below' => "numeric",
      'late_payment_interest' => "numeric" 
    );
    
    public $hasMany = array('Invoiceextraitem' =>
            array('className'     => 'Invoiceextraitem',
                      'conditions'    => '',
                           'order'         => '',
                           'limit'         => '',
                           'foreignKey'    => 'billing_id',
                           'dependent'     => true,
                           'exclusive'     => false,
                           'finderQuery'   => '',
                           'fields'        => '',
                           'offset'        => '',
                           'counterQuery'  => ''
                     )
              );

    // public $hasOne = array( 'Chartofaccounts' =>
                        // array('className'    => 'Chartofaccounts',
							  // 'foreignKey'    => 'id',
                             //'fields'   => 'account',
                              // 'dependent'    =>  false,
                        // )
                  // ); 

    function getDataForSelectList() {
    	$res = $this->find('all', null,null,null,0,0,0);
    	$out = array();
    	foreach ($res as $r){
    		$mname = date("F", mktime(0,0,0,$r['Billing']['month'],1));
    		$out[ $r['Billing']['id'] ] = $mname . " " . $r['Billing']['year'];
    	}
    	return $out;
	}

	public function translateArrayOfAcntFields(&$data, $chartofaccounts) {
		foreach ($data as &$record) {
			$this->translateAcntFields($record,$chartofaccounts);
		}
	}
	
	public function translateAcntFields(&$data, $chartofaccounts) {
		$data['Billing']['acnt_code_pst'] = $chartofaccounts[$data['Billing']['acnt_new_code_pst']];
		$data['Billing']['acnt_code_gst'] = $chartofaccounts[$data['Billing']['acnt_new_code_gst']];
		$data['Billing']['rental_tax_acnt_code'] = $chartofaccounts[$data['Billing']['acnt_new_rental_tax']];
		$data['Billing']['acnt_code_gas_surcharge'] = $chartofaccounts[$data['Billing']['acnt_new_gas_surcharge']];
		$data['Billing']['acnt_code_self_insurance'] = $chartofaccounts[$data['Billing']['acnt_new_self_insurance']];
		$data['Billing']['acnt_code_carbon_offset'] = $chartofaccounts[$data['Billing']['acnt_new_carbon_offset']];
		$data['Billing']['acnt_code_member_plan_low'] = $chartofaccounts[$data['Billing']['acnt_new_member_plan_low']];
		$data['Billing']['acnt_code_member_plan_med'] = $chartofaccounts[$data['Billing']['acnt_new_member_plan_med']];
		$data['Billing']['acnt_code_member_plan_high'] = $chartofaccounts[$data['Billing']['acnt_new_member_plan_high']];
		$data['Billing']['acnt_code_member_plan_organization'] = $chartofaccounts[$data['Billing']['acnt_new_member_plan_organization']];
		$data['Billing']['acnt_code_accounts_receivable'] = $chartofaccounts[$data['Billing']['acnt_new_accounts_receivable']];
		$data['Billing']['acnt_code_long_term_member_discount'] = $chartofaccounts[$data['Billing']['acnt_new_long_term_member_discount']];
		$data['Billing']['acnt_code_interest_charged'] = $chartofaccounts[$data['Billing']['acnt_new_interest_charged']];
	}
    
}

?>