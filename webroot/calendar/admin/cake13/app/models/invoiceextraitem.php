<?php
class Invoiceextraitem extends AppModel {
   var $name = 'Invoiceextraitem';
   var $displayField = 'id';

   var $belongsTo = array('Billing' =>
                           array('className'  => 'Billing',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'billing_id'
                           ),
                           'Invoicable' =>
                           array('className'  => 'Invoicable',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'invoicable_id'
                           )
                     );   

	public function translateArrayOfAcntFields(&$data, $chartofaccounts) {
		foreach ($data as &$record) {
			$this->translateAcntFields($record,$chartofaccounts);
		}
	}
	
	public function translateAcntFields(&$data, $chartofaccounts) {
		$data['Invoiceextraitem']['acnt_code'] = $chartofaccounts[$data['Invoiceextraitem']['acnt_code_new']];
	}
					 
	function beforeValidate(){
		if ( strlen($this->data['Invoiceextraitem']['billing_id']) == 0 ){
			$this->invalidate('billing_id');
		}
		if ( strlen($this->data['Invoiceextraitem']['invoicable_id']) == 0 ){
			$this->invalidate('invoicable_id');
		}		
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Invoiceextraitem']['item'] )){
			$this->invalidate('item');
		}
		if ( strlen($this->data['Invoiceextraitem']['item']) == 0 ){
			$this->invalidate('item');
		}
		// if ( preg_match( "/^ | \$|\t/"  , $this->data['Invoiceextraitem']['acnt_code'])){
			// $this->invalidate('acnt_code');
		// }
		if ( strlen($this->data['Invoiceextraitem']['taxcode']) == 0 ){
			$this->invalidate('taxcode');
		}		
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Invoiceextraitem']['comment'])){
			$this->invalidate('comment');
		}	
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Invoiceextraitem']['cost_per_unit'])){
			$this->invalidate('cost_per_unit');
		}
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Invoiceextraitem']['number_of_units'])){
			$this->invalidate('number_of_units');
		}		
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Invoiceextraitem']['number_of_units'])){
			$this->invalidate('number_of_units');
		}			
	}
	                     
}
    
?>
