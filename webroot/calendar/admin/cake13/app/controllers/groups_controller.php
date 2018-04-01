<?php
class GroupsController extends AppController {

	var $name = 'Groups';
	var $helpers = array('Html', 'Form', 'csv' );
	var $uses = array('Group', 'Invoicable', 'Chartofaccounts');
    var $paginate = array('limit' => 100 ,'order' => array(            'Group.grp_displayname' => 'asc'        )  );
	var $components = array('RequestHandler');
	
    function beforeFilter()
    {
        $this->checkSession();
    }

	function export() 
	{  
		Configure::write('debug',0); 
		$tableName = "Group";
		$data = $this->Group->find('all', array($tableName => $tableName . ".id ASC",'contain' => false));
		
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
		$this->Group->recursive = 0;
		$data =  $this->paginate();
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$this->Group->translateArrayOfAcntFields($data,$chartofaccounts);		
		$this->set('groups', $data);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Group.');
			$this->redirect('/groups/index');
		}
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$data = $this->Group->read(null, $id);
		$this->Group->translateAcntFields($data,$chartofaccounts);
		$this->set('group', $data);
		$inv_rec = $this->Invoicable->find('first',array('conditions' => array("Invoicable.group_id" => $id)));
		$this->set('invoicable', $inv_rec);
		$this->data['Group']['force_user_member_plan'] = $inv_rec['Invoicable']['force_user_member_plan'];
		
	}

	function add() {
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list',  array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1), 'OR' => Array('Chartofaccounts.type' => 1,'Chartofaccounts.id' => 0)), 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
		if (empty($this->data)) {
			$this->set('grouptypes', $this->Group->Grouptype->find('list'));
			$this->render();
		} else {
			//----------------
			$errorMsg = "";
			if ($this->Group->save($this->data)) {
				$myid = $this->Group->getLastInsertID();
				
				$myInvoicable= Array();
				$myInvoicable["Invoicable"] = Array();
				$myInvoicable["Invoicable"]["group_id"] = $myid;
				$myInvoicable["Invoicable"]["type"] = $this->data['Group']['type']; //TODO get rid of magic number
				$myInvoicable["Invoicable"]["force_user_member_plan"] = $this->data['Group']['force_user_member_plan'];
				if ($this->Group->Invoicable->save($myInvoicable)){

				} else {
					$errorMsg = 'Could not create invoicable record.';						
				}
		
			} else {
				$errorMsg = 'Error saving group.';
			}
			
			if ($errorMsg != "") {
				$this->Session->setFlash('Please correct errors below. ' . $errorMsg);
				$this->set('grouptypes', $this->Group->Grouptype->find('list'));
			} else {
				$this->Session->setFlash('The Group has been saved');
				$this->redirect('/groups/index');				
			}			
			//-----------------
		}
	}

	function edit($id = null) {
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list',  array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1), 'OR' => Array('Chartofaccounts.type' => 1,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
		if (empty($this->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Group');
				$this->redirect('/groups/index');
			}
			$this->set('grouptypes', $this->Group->Grouptype->find('list'));
			$this->data = $this->Group->read(null, $id);
			$inv_rec = $this->Invoicable->find("first", array('conditions' => array("Invoicable.group_id" => $id)));
			$this->data['Group']['force_user_member_plan'] = $inv_rec['Invoicable']['force_user_member_plan'];
		} else {
			if ($this->Group->save($this->data)) {
			    $inv_rec = $this->Invoicable->find("first", array('conditions' => array("Invoicable.group_id" => $id)));	
			    $inv_rec["Invoicable"]["force_user_member_plan"] = $this->data['Group']['force_user_member_plan'];
			    $this->Invoicable->save($inv_rec);
				$this->Session->setFlash('The Group has been saved');
				$this->redirect('/groups/index');
			} else {
				$this->set('grouptypes', $this->Group->Grouptype->find('list'));
				$this->Session->setFlash('Please correct errors below.');
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Group');
			$this->redirect('/groups/index');
		}
		//if ($this->Group->del($id)) {
		//	$this->Session->setFlash('The Group deleted: id '.$id.'');
		//	$this->redirect('/groups/index');
		//}
	}

}
?>