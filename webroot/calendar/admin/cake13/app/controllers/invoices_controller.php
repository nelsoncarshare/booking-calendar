<?php
class InvoicesController extends AppController {

	var $name = 'Invoices';
	var $helpers = array('Html', 'Form' );

    function beforeFilter()
    {
        $this->checkSession();
    }
    
	function index($id = null) {
		$this->Invoice->recursive = 0;
		//print_r($this->Invoice->getInvoicesForBilling($id));
		$this->set('invoices', $this->Invoice->getInvoicesForBilling($id));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Invoice.');
			$this->redirect('/invoices/index');
		}
		$this->set('invoice', $this->Invoice->read(null, $id));
	}

	function add() {
		if (empty($this->data)) {
			$this->render();
		} else {
			if ($this->Invoice->save($this->data)) {
				$this->Session->setFlash('The Invoice has been saved');
				$this->redirect('/invoices/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
			}
		}
	}

	function edit($id = null) {
		if (empty($this->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Invoice');
				$this->redirect('/invoices/index');
			}
			$this->data = $this->Invoice->read(null, $id);
		} else {
			if ($this->Invoice->save($this->data)) {
				$this->Session->setFlash('The Invoice has been saved');
				$this->redirect('/invoices/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Invoice');
			$this->redirect('/invoices/index');
		}
		if ($this->Invoice->del($id)) {
			$this->Session->setFlash('The Invoice deleted: id '.$id.'');
			$this->redirect('/invoices/index');
		}
	}

}
?>