<?php
App::uses('AppController', 'Controller');

class AnnouncementsController extends AppController {


	public $helpers = array('Html', 'Form' );
    public $paginate = array('limit' => 100 ,'order' => array(            'Announcement.created' => 'desc'        )  );
    function beforeFilter()
    {
        $this->checkSession();
    }

	function index() {
		$this->Announcement->recursive = 0;
		$this->set('announcements', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Announcement.');
			return $this->redirect('/announcements/index');
		}
		$this->set('announcement', $this->Announcement->read(null, $id));
	}

	function add() {
		if (empty($this->request->data)) {
			$this->set('calendars', $this->Announcement->Calendar->find('list'));
			$this->set('selectedCalendars', null);
			$this->set('bookables', $this->Announcement->Bookable->find('list'));
			$this->set('selectedBookables', null);
			$this->render();
		} else {
			if ($this->Announcement->save($this->request->data)) {
				$this->Session->setFlash('The Announcement has been saved');
				return $this->redirect('/announcements/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('calendars', $this->Announcement->Calendar->find('list'));
				if (empty($this->request->data['Calendar']['Calendar'])) { $this->request->data['Calendar']['Calendar'] = null; }
				$this->set('selectedCalendars', $this->request->data['Calendar']['Calendar']);
				$this->set('bookables', $this->Announcement->Bookable->find('list'));
				if (empty($this->request->data['Bookable']['Bookable'])) { $this->request->data['Bookable']['Bookable'] = null; }
				$this->set('selectedBookables', $this->request->data['Bookable']['Bookable']);
			}
		}
	}

	function edit($id = null) {
		if (empty($this->request->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Announcement');
				return $this->redirect('/announcements/index');
			}
			$this->request->data = $this->Announcement->read(null, $id);
			$this->set('calendars', $this->Announcement->Calendar->find('list'));
			if (empty($this->request->data['Calendar'])) { $this->request->data['Calendar'] = null; }
			$this->set('selectedCalendars', $this->request->data['Calendar']);
			$this->set('bookables', $this->Announcement->Bookable->find('list'));
			if (empty($this->request->data['Bookable'])) { $this->request->data['Bookable'] = null; }
			$this->set('selectedBookables', $this->request->data['Bookable']);
		} else {
			if ($this->Announcement->save($this->request->data)) {
				$this->Session->setFlash('The Announcement has been saved');
				return $this->redirect('/announcements/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('calendars', $this->Announcement->Calendar->find('list'));
				if (empty($this->request->data['Calendar']['Calendar'])) { $this->request->data['Calendar']['Calendar'] = null; }
				$this->set('selectedCalendars', $this->request->data['Calendar']['Calendar']);
				$this->set('bookables', $this->Announcement->Bookable->find('list'));
				if (empty($this->request->data['Bookable']['Bookable'])) { $this->request->data['Bookable']['Bookable'] = null; }
				$this->set('selectedBookables', $this->request->data['Bookable']['Bookable']);
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Announcement');
			return $this->redirect('/announcements/index');
		}
		if ($this->Announcement->delete($id)) {
			$this->Session->setFlash('The Announcement deleted: id '.$id.'');
			return $this->redirect('/announcements/index');
		}
	}

}
?>