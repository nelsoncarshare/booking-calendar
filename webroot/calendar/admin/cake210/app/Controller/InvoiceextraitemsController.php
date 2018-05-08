<?php
App::uses('AppController', 'Controller');

class InvoiceextraitemsController extends AppController {


	public $helpers = array('Html', 'Form' );
	public $uses = array('Invoiceextraitem', 'Chartofaccounts');

    function beforeFilter()
    {
        $this->checkSession();
    }
    
	function index() {
		$this->Invoiceextraitem->recursive = 0;
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$data = $this->paginate();
		$this->Invoiceextraitem->translateArrayOfAcntFields($data,$chartofaccounts);
		$this->set('invoiceextraitems', $data);
		$myNames = Array();
		foreach($this->viewVars['invoiceextraitems'] as $value){
			$myNames[$value['Invoicable']['id']] = $this->Invoiceextraitem->Invoicable->getName( $value['Invoicable']['id'] );
		}
		$this->set('names', $myNames);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Invoiceextraitem.');
			return $this->redirect('/invoiceextraitems/index');
		}
		
		$data = $this->Invoiceextraitem->read(null, $id);
		$chartofaccounts = $this->Chartofaccounts->find("list");
		$this->Invoiceextraitem->translateAcntFields($data, $chartofaccounts);
		$this->set('invoiceextraitem', $data);
		
		$this->set('invoicablename', $this->Invoiceextraitem->Invoicable->getName($this->viewVars['invoiceextraitem']['Invoicable']['id']) );
	}

	function add() {
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list', array('conditions' => array('Chartofaccounts.show_in_lists' => 1),'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
		if (empty($this->request->data)) {
			$this->set('billings', $this->Invoiceextraitem->Billing->getDataForSelectList());
			$this->set('invoicables', $this->Invoiceextraitem->Invoicable->getDataForSelectList());
			$this->set('taxcodes', array( 1 => "PST Only", 2 => "GST Only", 3 => "PST/GST", 4 => "Tax Exempt" ));
			$this->render();
		} else {
			if ($this->Invoiceextraitem->save($this->request->data)) {
				$this->Session->setFlash('The Invoiceextraitem has been saved');
				return $this->redirect('/invoiceextraitems/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('billings', $this->Invoiceextraitem->Billing->getDataForSelectList());
				$this->set('invoicables', $this->Invoiceextraitem->Invoicable->getDataForSelectList());
				$this->set('taxcodes', array( 1 => "PST Only", 2 => "GST Only", 3 => "PST/GST", 4 => "Tax Exempt" ));
			}
		}
	}

	function edit($id = null) {
		$this->Set("chartofaccounts",$this->Chartofaccounts->find('list', array('conditions' => array('Chartofaccounts.show_in_lists' => 1),'order' => array('Chartofaccounts.type', 'Chartofaccounts.account'))));
		if (empty($this->request->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Invoiceextraitem');
				return $this->redirect('/invoiceextraitems/index');
			}
			$this->request->data = $this->Invoiceextraitem->read(null, $id);
			$this->set('billings', $this->Invoiceextraitem->Billing->getDataForSelectList());
			$this->set('invoicables', $this->Invoiceextraitem->Invoicable->getDataForSelectList());
			$this->set('taxcodes', array( 1 => "PST Only", 2 => "GST Only", 3 => "PST/GST", 4 => "Tax Exempt" ));
			$this->set("data", $this->request->data); 
		} else {
			if ($this->Invoiceextraitem->save($this->request->data)) {
				$this->Session->setFlash('The Invoiceextraitem has been saved');
				return $this->redirect('/invoiceextraitems/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('billings', $this->Invoiceextraitem->Billing->getDataForSelectList());
				$this->set('invoicables', $this->Invoiceextraitem->Invoicable->getDataForSelectList());
				$this->set('taxcodes', array( 1 => "PST Only", 2 => "GST Only", 3 => "PST/GST", 4 => "Tax Exempt" ));
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Invoiceextraitem');
			return $this->redirect('/invoiceextraitems/index');
		}
		if ($this->Invoiceextraitem->delete($id)) {
			$this->Session->setFlash('The Invoiceextraitem deleted: id '.$id.'');
			return $this->redirect('/invoiceextraitems/index');
		} 
	}

}
?>