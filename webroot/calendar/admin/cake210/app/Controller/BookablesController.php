<?php
App::uses('AppController', 'Controller');

class BookablesController extends AppController {


	public $helpers = array('Html', 'Form', 'Csv' );
    public $paginate = array('limit' => 100 ,'order' => array(            'Bookable.name' => 'asc'        )  );
    public $components = array('RequestHandler');
	
	function beforeFilter()
    {
        $this->checkSession();
    }
	
	function export(){
		$this->response->download("export.csv");

		$tableName = "Bookables";
		$data = $this->Bookable->find('all', array($tableName => $tableName . ".id ASC",'contain' => false));
		
		$this->set(compact('data'));

		$this->layout = 'json';

		return;	
	}	
    
	function index() {
		$this->Bookable->recursive = 0;
		$this->set('bookables', $this->Paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Bookable.');
			return $this->redirect('/bookables/index');
		}
		$this->set('bookable', $this->Bookable->read(null, $id));
	}

	function add() {
		if (empty($this->request->data)) {
			$this->set('calendars', $this->Bookable->Calendar->find('list'));
			$this->set('selectedCalendars', null);
			$this->set('announcements', $this->Bookable->Announcement->find('list'));
			$this->set('selectedAnnouncements', null);
			$this->set('vehicles', $this->Bookable->Vehicle->find('list'));
			$this->set('locations', $this->Bookable->Location->find('list'));
			$this->render();
		} else {
			if ($this->Bookable->save($this->request->data)) {
				$this->Session->setFlash('The Bookable has been saved');
				return $this->redirect('/bookables/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('calendars', $this->Bookable->Calendar->find('list'));
				if (empty($this->request->data['Calendar']['Calendar'])) { $this->request->data['Calendar']['Calendar'] = null; }
				$this->set('selectedCalendars', $this->request->data['Calendar']['Calendar']);
				$this->set('announcements', $this->Bookable->Announcement->find('list'));
				if (empty($this->request->data['Announcement']['Announcement'])) { $this->request->data['Announcement']['Announcement'] = null; }
				$this->set('selectedAnnouncements', $this->request->data['Announcement']['Announcement']);
				$this->set('vehicles', $this->Bookable->Vehicle->find('list'));
				$this->set('locations', $this->Bookable->Location->find('list'));
			}
		}
	}

	function edit($id = null) {
		if (empty($this->request->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Bookable');
				return $this->redirect('/bookables/index');
			}
			$this->request->data = $this->Bookable->read(null, $id);
			$this->set('calendars', $this->Bookable->Calendar->find('list'));
			if (empty($this->request->data['Calendar'])) { $this->request->data['Calendar'] = null; }
			$this->set('selectedCalendars', $this->request->data['Calendar']);
			$this->set('announcements', $this->Bookable->Announcement->find('list'));
			if (empty($this->request->data['Announcement'])) { $this->request->data['Announcement'] = null; }
			$this->set('selectedAnnouncements', $this->request->data['Announcement']);
			$this->set('vehicles', $this->Bookable->Vehicle->find('list'));
			$this->set('locations', $this->Bookable->Location->find('list'));
		} else {
			if ($this->Bookable->save($this->request->data)) {
				$this->Session->setFlash('The Bookable has been saved');
				return $this->redirect('/bookables/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('calendars', $this->Bookable->Calendar->find('list'));
				if (empty($this->request->data['Calendar']['Calendar'])) { $this->request->data['Calendar']['Calendar'] = null; }
				$this->set('selectedCalendars', $this->request->data['Calendar']['Calendar']);
				$this->set('announcements', $this->Bookable->Announcement->find('list'));
				if (empty($this->request->data['Announcement']['Announcement'])) { $this->request->data['Announcement']['Announcement'] = null; }
				$this->set('selectedAnnouncements', $this->request->data['Announcement']['Announcement']);
				$this->set('vehicles', $this->Bookable->Vehicle->find('list'));
				$this->set('locations', $this->Bookable->Location->find('list'));
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Bookable');
			return $this->redirect('/bookables/index');
		}
		if ($this->Bookable->del($id)) {
			$this->Session->setFlash('The Bookable deleted: id '.$id.'');
			return $this->redirect('/bookables/index');
		}
	}

}
?>