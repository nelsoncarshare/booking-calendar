<?php
App::uses('AppController', 'Controller');

class GrouptypesController extends AppController {


	public $helpers = array('Html', 'Form' );

    function beforeFilter()
    {
        $this->checkSession();
    }
	
	function index() {
		$this->Grouptype->recursive = 0;
		$this->set('grouptypes', $this->Grouptype->find('all'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Grouptype.');
			return $this->redirect('/grouptypes/index');
		}
		$this->set('grouptype', $this->Grouptype->read(null, $id));
	}

	function add() {
		if (empty($this->request->data)) {
			$this->set('groups', $this->Grouptype->Group->find('list'));
			$this->render();
		} else {
			if ($this->Grouptype->save($this->request->data)) {
				$this->Session->setFlash('The Grouptype has been saved');
				return $this->redirect('/grouptypes/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('groups', $this->Grouptype->Group->find('list'));
			}
		}
	}

	function edit($id = null) {
		if (empty($this->request->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Grouptype');
				return $this->redirect('/grouptypes/index');
			}
			$this->request->data = $this->Grouptype->read(null, $id);
			$this->set('groups', $this->Grouptype->Group->find('list'));
		} else {
			if ($this->Grouptype->save($this->request->data)) {
				$this->Session->setFlash('The Grouptype has been saved');
				return $this->redirect('/grouptypes/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('groups', $this->Grouptype->Group->find('list'));
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Grouptype');
			return $this->redirect('/grouptypes/index');
		}
		if ($this->Grouptype->del($id)) {
			$this->Session->setFlash('The Grouptype deleted: id '.$id.'');
			return $this->redirect('/grouptypes/index');
		}
	}

}
?>