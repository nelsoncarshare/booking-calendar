<?php
class BillingsController extends AppController {

	var $name = 'Billings';
	var $helpers = array('Html', 'Form' );
    var $paginate = array('limit' => 100 ,'order' => array(            'Billing.year' => 'desc', 'Billing.month' => 'desc'      )  );
    var $uses = array('Billing','Chartofaccounts');
	
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
			$this->redirect('/billings/index');
		}
		$data = $this->Billing->read(null, $id);
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$this->Billing->translateAcntFields($data, $chartofaccounts);
		$this->set('billing', $data);
		
	}

	function add() {
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list', array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1),'OR' => Array('Chartofaccounts.type' => 2,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
		if (empty($this->data)) {
			$prevID = $this->Billing->query("select id from phpc_billings order by year, month DESC LIMIT 0,1");
			//print_r($prevID);
			if ( array_key_exists(0,$prevID) ){
				if ( array_key_exists('phpc_billings',$prevID[0]) ){
					if ( array_key_exists('id',$prevID[0]['phpc_billings']) ){
						$this->data = $this->Billing->read(null, $prevID[0]['phpc_billings']['id']);
						//print_r($this->data);
						unset($this->data['Billing']['id']);
						//print_r($this->data);
					}
				}
			}
			$this->render();
		} else {
			if ($this->Billing->save($this->data)) {
				$this->Session->setFlash('The Billing has been saved');
				$this->redirect('/billings/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
			}
		}
	}

	function edit($id = null) {
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list', array('conditions' => array('AND' => Array('Chartofaccounts.show_in_lists' => 1),'OR' => Array('Chartofaccounts.type' => 2,'Chartofaccounts.id' => 0)) , 'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
		if (empty($this->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Billing');
				$this->redirect('/billings/index');
			}
			$this->data = $this->Billing->read(null, $id);
			$this->Set("data", $this->data);
		} else {
			if ($this->Billing->save($this->data)) {
				$this->Session->setFlash('The Billing has been saved');
				$this->redirect('/billings/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Billing');
			$this->redirect('/billings/index');
		}
		if ($this->Billing->delete($id)) {
			$this->Session->setFlash('The Billing deleted: id '.$id.'');
			$this->redirect('/billings/index');
		}
	}

}
?>