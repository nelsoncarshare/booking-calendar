<?php
class BillingsController extends AppController {


	public $helpers = array('Html', 'Form' );
    public $paginate = array('limit' => 100 ,'order' => array(            'Billing.year' => 'desc', 'Billing.month' => 'desc'      )  );
    public $uses = array('Billing','Chartofaccounts');
	
	function beforeFilter()
    {
        $this->checkSession();
    }

	function index() {
		$this->Billing->recursive = 0;
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$data = $this->paginate();
		$this->Billing->translateArrayOfAcntFields($data,$chartofaccounts);
		$this->set('billings', $data);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Billing.');
			return $this->redirect('/billings/index');
		}
		$data = $this->Billing->read(null, $id);
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$this->Billing->translateAcntFields($data, $chartofaccounts);
		$this->set('billing', $data);
		
	}

	function add() {
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list', array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1),'OR' => Array('Chartofaccounts.type' => 2,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
		if (empty($this->request->data)) {
			$prevID = $this->Billing->query("select id from phpc_billings order by year, month DESC LIMIT 0,1");
			//print_r($prevID);
			if ( array_key_exists(0,$prevID) ){
				if ( array_key_exists('phpc_billings',$prevID[0]) ){
					if ( array_key_exists('id',$prevID[0]['phpc_billings']) ){
						$this->request->data = $this->Billing->read(null, $prevID[0]['phpc_billings']['id']);
						//print_r($this->request->data);
						unset($this->request->data['Billing']['id']);
						//print_r($this->request->data);
					}
				}
			}
			$this->render();
		} else {
			if ($this->Billing->save($this->request->data)) {
				$this->Session->setFlash('The Billing has been saved');
				return $this->redirect('/billings/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
			}
		}
	}

	function edit($id = null) {
		$mych = $this->Chartofaccounts->find('list', array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1),'OR' => Array('Chartofaccounts.type' => 2,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account')));
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list', array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1),'OR' => Array('Chartofaccounts.type' => 2,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
		//print_r($mych);
		
		if (empty($this->request->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Billing');
				return $this->redirect('/billings/index');
			}
			$this->request->data = $this->Billing->read(null, $id);
			$this->SwitchNullToZeroAll();
			$this->Set("data", $this->request->data);
		} else {
			if ($this->Billing->save($this->request->data)) {
				$this->Session->setFlash('The Billing has been saved');
				return $this->redirect('/billings/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
			}
		}
	}

	function SwitchNullToZeroAll()
	{
			$this->SwitchNullToZero('acnt_new_code_pst');
			$this->SwitchNullToZero('acnt_new_code_gst');
			$this->SwitchNullToZero('acnt_new_rental_tax');
			$this->SwitchNullToZero('acnt_new_gas_surcharge');
			$this->SwitchNullToZero('acnt_new_self_insurance');
			$this->SwitchNullToZero('acnt_new_carbon_offset');
			$this->SwitchNullToZero('acnt_new_member_plan_low');
			$this->SwitchNullToZero('acnt_new_member_plan_med');
			$this->SwitchNullToZero('acnt_new_member_plan_high');
			$this->SwitchNullToZero('acnt_new_member_plan_organization');
			$this->SwitchNullToZero('acnt_new_accounts_receivable');
			$this->SwitchNullToZero('acnt_new_long_term_member_discount');
			$this->SwitchNullToZero('acnt_new_accounts_receivable');
			$this->SwitchNullToZero('acnt_new_interest_charged');
	}
	
	function SwitchNullToZero($fieldName)
	{
		$val = $this->request->data['Billing'][$fieldName];
		if ($val == null){
			$this->request->data['Billing'][$fieldName] = 0;
		}
	}	
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Billing');
			return $this->redirect('/billings/index');
		}
		if ($this->Billing->delete($id)) {
			$this->Session->setFlash('The Billing deleted: id '.$id.'');
			return $this->redirect('/billings/index');
		}
	}

}
?>