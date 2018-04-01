<?php
class AnnouncementsController extends AppController {

	var $name = 'Announcements';
	var $helpers = array('Html', 'Form' );
    var $paginate = array('limit' => 100 ,'order' => array(            'Announcement.created' => 'desc'        )  );
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
			$this->redirect('/announcements/index');
		}
		$this->set('announcement', $this->Announcement->read(null, $id));
	}

	function add() {
		if (empty($this->data)) {
			$this->set('calendars', $this->Announcement->Calendar->find('list'));
			$this->set('selectedCalendars', null);
			$this->set('bookables', $this->Announcement->Bookable->find('list'));
			$this->set('selectedBookables', null);
			$this->render();
		} else {
			if ($this->Announcement->save($this->data)) {
				$this->Session->setFlash('The Announcement has been saved');
				$this->redirect('/announcements/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('calendars', $this->Announcement->Calendar->find('list'));
				if (empty($this->data['Calendar']['Calendar'])) { $this->data['Calendar']['Calendar'] = null; }
				$this->set('selectedCalendars', $this->data['Calendar']['Calendar']);
				$this->set('bookables', $this->Announcement->Bookable->find('list'));
				if (empty($this->data['Bookable']['Bookable'])) { $this->data['Bookable']['Bookable'] = null; }
				$this->set('selectedBookables', $this->data['Bookable']['Bookable']);
			}
		}
	}

	function edit($id = null) {
		if (empty($this->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Announcement');
				$this->redirect('/announcements/index');
			}
			$this->data = $this->Announcement->read(null, $id);
			$this->set('calendars', $this->Announcement->Calendar->find('list'));
			if (empty($this->data['Calendar'])) { $this->data['Calendar'] = null; }
			$this->set('selectedCalendars', $this->data['Calendar']);
			$this->set('bookables', $this->Announcement->Bookable->find('list'));
			if (empty($this->data['Bookable'])) { $this->data['Bookable'] = null; }
			$this->set('selectedBookables', $this->data['Bookable']);
		} else {
			if ($this->Announcement->save($this->data)) {
				$this->Session->setFlash('The Announcement has been saved');
				$this->redirect('/announcements/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('calendars', $this->Announcement->Calendar->find('list'));
				if (empty($this->data['Calendar']['Calendar'])) { $this->data['Calendar']['Calendar'] = null; }
				$this->set('selectedCalendars', $this->data['Calendar']['Calendar']);
				$this->set('bookables', $this->Announcement->Bookable->find('list'));
				if (empty($this->data['Bookable']['Bookable'])) { $this->data['Bookable']['Bookable'] = null; }
				$this->set('selectedBookables', $this->data['Bookable']['Bookable']);
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Announcement');
			$this->redirect('/announcements/index');
		}
		if ($this->Announcement->delete($id)) {
			$this->Session->setFlash('The Announcement deleted: id '.$id.'');
			$this->redirect('/announcements/index');
		}
	}

}
?>