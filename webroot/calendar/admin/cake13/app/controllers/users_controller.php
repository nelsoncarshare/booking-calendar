<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'csv');
    var $paginate = array('limit' => 100 ,'order' => array(            'User.displayname' => 'asc'        )  );
	var $uses = array('User', 'Chartofaccounts');
	var $components = array('RequestHandler');
	
    function beforeFilter()
    {
        $this->checkSession();
    }

	function getFor($data,$tableName){
		$ks = array_keys($data[0][$tableName]);
		
		$headers1 = Array();
		foreach ($ks as $value){
			$headers1[] = $value;
		}
		
		$headers = array($tableName => $headers1); 

		$d = array_unshift($data,$headers); 
		return $d;	
	}
	
	function export() 
	{  
		Configure::write('debug',0); 
		$tableName = "User";
		$data = $this->User->find('all', array($tableName => $tableName . ".id ASC",'contain' => false));
		
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
		$this->User->recursive = 0;
		$data =  $this->paginate();
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$this->User->translateArrayOfAcntFields($data,$chartofaccounts);
		$this->set('users',$data);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for User.');
			$this->redirect('/users/index');
		}
		$data = $this->User->read(null, $id);
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$this->User->translateAcntFields($data,$chartofaccounts);
		$this->set('user', $data);
		//print_r($this->User->read(null, $id));
	}

	function add() {
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list', array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1), 'OR' => Array('Chartofaccounts.type' => 1,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));

		if (empty($this->data)) {
			$this->set('permissions', $this->User->Permission->find('list'));
			$this->set('groups', $this->User->Group->find('list'));
			$this->set('selectedPermissions', null);
			$this->render();
		} else {

			$this->data['User']['password'] = md5( $this->data['User']['password'] );
			$errorMsg = "";
			if ($this->User->save($this->data)) {
				$myid = $this->User->getLastInsertID();
				if ($this->data['User']['group_id'] == 1 ) { // TODO get rid of magic number
					$myInvoicable= Array();
					$myInvoicable["Invoicable"] = Array();
					$myInvoicable["Invoicable"]["user_id"] = $myid;
					$myInvoicable["Invoicable"]["type"] = 1; //TODO get rid of magic number
					if ($this->User->Invoicable->save($myInvoicable)){

					} else {
						$errorMsg = 'Could not create invoicable record.';						
					}
				}
			} else {
				$errorMsg = 'Error saving user.';
			}
			
			if ($errorMsg != "") {
				$this->Session->setFlash('Please correct errors below. ' . $errorMsg);
				$this->set('permissions', $this->User->Permission->find('list'));
				$this->set('groups', $this->User->Group->find('list'));
				if (empty($this->data['Permission']['Permission'])) { $this->data['Permission']['Permission'] = null; }
				$this->set('selectedPermissions', $this->data['Permission']['Permission']);
			} else {
				$this->Session->setFlash('The User has been saved');
				$this->redirect('/users/index');				
			}
		}
	}

	function edit($id = null) {
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list',  array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1), 'OR' => Array('Chartofaccounts.type' => 1,'Chartofaccounts.id' => 0)), 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));

		if (empty($this->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for User');
				$this->redirect('/users/index');
			}
			$this->data = $this->User->read(null, $id);
			$this->data['User']['password'] = '';
			$this->set('user', $this->User->read(null, $id));
			$this->set('permissions', $this->User->Permission->find('list'));
			$this->set('groups', $this->User->Group->find('list'));
			if (empty($this->data['Permission'])) { $this->data['Permission'] = null; }
			$this->set('selectedPermissions', $this->data['Permission']);
		} else {
			// if password is blank then remove it from data
			if ($this->data['User']['password'] == ''){
				unset($this->data['User']['password']);
			} else {
				$this->data['User']['password'] = md5( $this->data['User']['password'] );
			}
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('The User has been saved');
				$this->redirect('/users/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('permissions', $this->User->Permission->find('list'));
				$this->set('groups', $this->User->Group->find('list'));
				if (empty($this->data['Permission']['Permission'])) { $this->data['Permission']['Permission'] = null; }
				$this->set('selectedPermissions', $this->data['Permission']['Permission']);
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for User');
			$this->redirect('/users/index');
		}
		$this->Session->setFlash('Cant delete users');
		//if ($this->User->del($id)) {
		//	$this->Session->setFlash('The User deleted: id '.$id.'');
		//	$this->redirect('/users/index');
		//}
	}

}
?>
