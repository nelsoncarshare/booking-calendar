<?php

class Billing extends AppModel
{
    var $name = 'Billing';
    var $displayField = 'month';
    
    var $validate = array(
      'dont_charge_interest_below' => "numeric",
      'late_payment_interest' => "numeric" 
    );
    
    var $hasMany = array('Invoiceextraitem' =>
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

    // var $hasOne = array( 'Chartofaccounts' =>
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
	
	function beforeValidate(){
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_pst'])){
			// $this->invalidate('acnt_code_pst');
		// }
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_gst'])){
			// $this->invalidate('acnt_code_pst');
		// }		
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['rental_tax_acnt_code'])){
			// $this->invalidate('rental_tax_acnt_code');
		// }
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_gas_surcharge'])){
			// $this->invalidate('acnt_code_gas_surcharge');
		// }
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_self_insurance'])){
			// $this->invalidate('acnt_code_self_insurance');
		// }
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_carbon_offset'])){
			// $this->invalidate('acnt_code_carbon_offset');
		// }
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_member_plan_low'])){
			// $this->invalidate('acnt_code_member_plan_low');
		// }
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_member_plan_med'])){
			// $this->invalidate('acnt_code_member_plan_med');
		// }
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_member_plan_high'])){
			// $this->invalidate('acnt_code_member_plan_high');
		// }							
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_member_plan_organization'])){
			// $this->invalidate('acnt_code_member_plan_organization');
		// }		
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_accounts_receivable'])){
			// $this->invalidate('acnt_code_accounts_receivable');
		// }
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_long_term_member_discount'])){
			// $this->invalidate('acnt_code_long_term_member_discount');
		// }
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_interest_charged'])){
			// $this->invalidate('acnt_code_interest_charged');
		// }														
		return true;
	}      
	    
}

?>