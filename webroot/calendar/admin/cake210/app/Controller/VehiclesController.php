<?php
App::uses('AppController', 'Controller');

class VehiclesController extends AppController {


	public $helpers = array('Html', 'Form', 'csv');
    public $uses = array('Vehicle', 'Vehicletype', 'Chartofaccounts');
    public $paginate = array('limit' => 100 ,'order' => array(            'Vehicle.name' => 'asc'        )  );
	public $components = array('RequestHandler');
	
    function beforeFilter(){
        $this->checkSession();
    }
 
 	function export() 
	{  
		Configure::write('debug',0); 
		$tableName = "Vehicle";
		$data = $this->Vehicle->find('all', array($tableName => $tableName . ".id ASC",'contain' => false));
		
		$ks = array_keys($data[0][$tableName]);
		
		$headers1 = Array();
		foreach ($ks as $value){
			$headers1[] = $value;
		}
		
		$headers = array($tableName=> $headers1); 
		
		array_unshift($data,$headers); 
		
		$this->set(compact('data')); 
		$this->set('tableName', $tableName);
	} 
 
	function index() {
		$this->Vehicle->recursive = 0;
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$data = $this->paginate();
		$this->Vehicle->translateArrayOfAcntFields($data,$chartofaccounts);
		$this->set('vehicles', $data);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid vehicle'));
			return $this->redirect(array('action' => 'index'));
		}
		$data = $this->Vehicle->read(null, $id);
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$this->Vehicle->translateAcntFields($data, $chartofaccounts);
		$this->set('vehicle', $data);
	}

	function add() {
        $this->set('vehicletypes', $this->Vehicletype->find("list", array('recursive' => 0, 'fields' => array('id', 'type'))));
		$this->Set("chartofaccounts",
			$this->Chartofaccounts->find('list', array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1), 'OR' => Array('Chartofaccounts.type' => 2,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account')))
			);
					
		if (!empty($this->request->data)) {
			$this->Vehicle->create();
			if ($this->Vehicle->save($this->request->data)) {
				$this->Session->setFlash(__('The vehicle has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vehicle could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
        $this->set('vehicletypes', $this->Vehicletype->find("list", array('recursive' => 0, 'fields' => array('id', 'type'))));
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list', array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1), 'OR' => Array('Chartofaccounts.type' => 2,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
	
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid vehicle'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Vehicle->save($this->request->data)) {
				$this->Session->setFlash(__('The vehicle has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vehicle could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Vehicle->read(null, $id);
	
			$this->SwitchNullToZeroAll();
			
            $this->set("data", $this->request->data); 
		}
	}
	
	function SwitchNullToZeroAll()
	{
			$this->SwitchNullToZero('acnt_new_code_gas');
			$this->SwitchNullToZero('acnt_new_code_admin');
			$this->SwitchNullToZero('acnt_new_code_repair');
			$this->SwitchNullToZero('acnt_new_code_insurance');
			$this->SwitchNullToZero('acnt_new_code_fines');
			$this->SwitchNullToZero('acnt_new_code_misc_2');
			$this->SwitchNullToZero('acnt_new_code_misc_3');
			$this->SwitchNullToZero('acnt_new_code_misc_4');
			$this->SwitchNullToZero('acnt_new_code_hours');
			$this->SwitchNullToZero('acnt_new_code_blocked_time');
			$this->SwitchNullToZero('acnt_new_code_km');
	}
	
	function SwitchNullToZero($fieldName)
	{
		$val = $this->request->data['Vehicle'][$fieldName];
		if ($val == null){
			$this->request->data['Vehicle'][$fieldName] = 0;
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for vehicle'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->Vehicle->delete($id)) {
			$this->Session->setFlash(__('Vehicle deleted'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Vehicle was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
