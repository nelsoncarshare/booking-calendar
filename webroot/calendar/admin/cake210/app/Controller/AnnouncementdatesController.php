<?php
App::uses('AppController', 'Controller');

class AnnouncementdatesController extends AppController {


    public $paginate = array('limit' => 100 ,'order' => array(            'Announcement.title' => 'asc'        )  );

    function beforeFilter()
    {
        $this->checkSession();
    }	
	
	function index() {
		$this->Announcementdate->recursive = 0;
		$this->set('announcementdates', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid announcementdate'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('announcementdate', $this->Announcementdate->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Announcementdate->create();
			if ($this->Announcementdate->save($this->request->data)) {
				$this->Session->setFlash(__('The announcementdate has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The announcementdate could not be saved. Please, try again.'));
			}
		}
		$announcements = $this->Announcementdate->Announcement->find('list');
		$this->set(compact('announcements'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid announcementdate'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Announcementdate->save($this->request->data)) {
				$this->Session->setFlash(__('The announcementdate has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The announcementdate could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Announcementdate->read(null, $id);
		}
		$announcements = $this->Announcementdate->Announcement->find('list');
		$this->set(compact('announcements'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for announcementdate'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->Announcementdate->delete($id)) {
			$this->Session->setFlash(__('Announcementdate deleted'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Announcementdate was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
