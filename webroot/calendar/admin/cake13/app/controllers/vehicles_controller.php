<?php
class VehiclesController extends AppController {

	var $name = 'Vehicles';
	var $helpers = array('Html', 'Form', 'csv');
    var $uses = array('Vehicle', 'Vehicletype', 'Chartofaccounts');
    var $paginate = array('limit' => 100 ,'order' => array(            'Vehicle.name' => 'asc'        )  );
	var $components = array('RequestHandler');
	
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
			$this->Session->setFlash(__('Invalid vehicle', true));
			$this->redirect(array('action' => 'index'));
		}
		$data = $this->Vehicle->read(null, $id);
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$this->Vehicle->translateAcntFields($data, $chartofaccounts);
		$this->set('vehicle', $data);
	}

	function add() {
        $this->set('vehicletypes', $this->Vehicletype->find("list", array('recursive' => 0, 'fields' => array('id', 'type'))));
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list', array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1), 'OR' => Array('Chartofaccounts.type' => 2,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
		if (!empty($this->data)) {
			$this->Vehicle->create();
			if ($this->Vehicle->save($this->data)) {
				$this->Session->setFlash(__('The vehicle has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vehicle could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
        $this->set('vehicletypes', $this->Vehicletype->find("list", array('recursive' => 0, 'fields' => array('id', 'type'))));
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list', array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1), 'OR' => Array('Chartofaccounts.type' => 2,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid vehicle', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Vehicle->save($this->data)) {
				$this->Session->setFlash(__('The vehicle has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vehicle could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Vehicle->read(null, $id);
            $this->set("data", $this->data); 
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for vehicle', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Vehicle->delete($id)) {
			$this->Session->setFlash(__('Vehicle deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Vehicle was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
