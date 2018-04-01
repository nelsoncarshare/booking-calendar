<?php
class GrouptypesController extends AppController {

	var $name = 'Grouptypes';
	var $helpers = array('Html', 'Form' );

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
			$this->redirect('/grouptypes/index');
		}
		$this->set('grouptype', $this->Grouptype->read(null, $id));
	}

	function add() {
		if (empty($this->data)) {
			$this->set('groups', $this->Grouptype->Group->find('list'));
			$this->render();
		} else {
			if ($this->Grouptype->save($this->data)) {
				$this->Session->setFlash('The Grouptype has been saved');
				$this->redirect('/grouptypes/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('groups', $this->Grouptype->Group->find('list'));
			}
		}
	}

	function edit($id = null) {
		if (empty($this->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Grouptype');
				$this->redirect('/grouptypes/index');
			}
			$this->data = $this->Grouptype->read(null, $id);
			$this->set('groups', $this->Grouptype->Group->find('list'));
		} else {
			if ($this->Grouptype->save($this->data)) {
				$this->Session->setFlash('The Grouptype has been saved');
				$this->redirect('/grouptypes/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('groups', $this->Grouptype->Group->find('list'));
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Grouptype');
			$this->redirect('/grouptypes/index');
		}
		if ($this->Grouptype->del($id)) {
			$this->Session->setFlash('The Grouptype deleted: id '.$id.'');
			$this->redirect('/grouptypes/index');
		}
	}

}
?>