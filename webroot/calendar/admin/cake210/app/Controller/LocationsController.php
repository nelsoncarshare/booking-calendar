<?php
App::uses('AppController', 'Controller');

class LocationsController extends AppController {


	public $helpers = array('Html', 'Form', 'Csv' );
    public $paginate = array('limit' => 100 ,'order' => array(            'Location.name' => 'asc'        )  );
	public $components = array('RequestHandler');
    function beforeFilter()
    {
        $this->checkSession();
    }

	/*
	function export() 
	{  
		Configure::write('debug',0); 
		$tableName = "Location";
		$data = $this->Location->find('all', array($tableName => $tableName . ".id ASC",'contain' => false));
		
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
*/	
    
	function export(){
		$this->response->download("export.csv");

		$tableName = "Location";
		$data = $this->Location->find('all', array($tableName => $tableName . ".id ASC",'contain' => false));
		
		$this->set(compact('data'));

		$this->layout = 'json';

		return;	
	}		
	
	function index() {
		$this->Location->recursive = 0;
        $this->set('locations', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Location.');
			return $this->redirect('/locations/index');
		}
		$this->set('location', $this->Location->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Location->create();
			if ($this->Location->save($this->request->data)) {
				$this->Session->setFlash(__('The Location has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Location could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Location'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Location->save($this->request->data)) {
				$this->Session->setFlash(__('The Location has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Location could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Location->read(null, $id);
		}
	}

	function updateGPS($lt = null, $lg = null, $vid = null, $op = null ) {
		$this->layout = 'ajax';
			
			//TODO put validation into model
			if ( !is_numeric($lt) ){
				echo("latitude was not numeric");
				exit();
			}
			
			if ( !is_numeric($lg) ){
				echo("longitude was not numeric");
				exit();
			}
			
			if ( !is_numeric($vid) ){
				echo("vehicle number was not set for this vehicle");
				exit();
			}
			
			
			if ( $op == "ADMIN_SET_LOC" ){
				$row = $this->Location->find(Array("id=$vid"));
				$row['Location']['GPS_coord_x'] = $lt;
				$row['Location']['GPS_coord_y'] = $lg;
				$this->Location->save($row);
				echo("Saved new location.");
			} else {
				echo("Unknown operation");
			}

	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Location');
			return $this->redirect('/locations/index');
		}
		if ($this->Location->del($id)) {
			$this->Session->setFlash('The Location deleted: id '.$id.'');
			return $this->redirect('/locations/index');
		}
	}

}
?>