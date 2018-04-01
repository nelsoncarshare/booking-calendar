<?php
class BookablesController extends AppController {

	var $name = 'Bookables';
	var $helpers = array('Html', 'Form', 'csv' );
    var $paginate = array('limit' => 100 ,'order' => array(            'Bookable.name' => 'asc'        )  );
    var $components = array('RequestHandler');
	
	function beforeFilter()
    {
        $this->checkSession();
    }

	function export() 
	{  
		Configure::write('debug',0); 
		$tableName = "Bookables";
		$data = $this->Bookable->find('all', array($tableName => $tableName . ".id ASC",'contain' => false));
		
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
		$this->Bookable->recursive = 0;
		$this->set('bookables', $this->Paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Bookable.');
			$this->redirect('/bookables/index');
		}
		$this->set('bookable', $this->Bookable->read(null, $id));
	}

	function add() {
		if (empty($this->data)) {
			$this->set('calendars', $this->Bookable->Calendar->find('list'));
			$this->set('selectedCalendars', null);
			$this->set('announcements', $this->Bookable->Announcement->find('list'));
			$this->set('selectedAnnouncements', null);
			$this->set('vehicles', $this->Bookable->Vehicle->find('list'));
			$this->set('locations', $this->Bookable->Location->find('list'));
			$this->render();
		} else {
			if ($this->Bookable->save($this->data)) {
				$this->Session->setFlash('The Bookable has been saved');
				$this->redirect('/bookables/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('calendars', $this->Bookable->Calendar->find('list'));
				if (empty($this->data['Calendar']['Calendar'])) { $this->data['Calendar']['Calendar'] = null; }
				$this->set('selectedCalendars', $this->data['Calendar']['Calendar']);
				$this->set('announcements', $this->Bookable->Announcement->find('list'));
				if (empty($this->data['Announcement']['Announcement'])) { $this->data['Announcement']['Announcement'] = null; }
				$this->set('selectedAnnouncements', $this->data['Announcement']['Announcement']);
				$this->set('vehicles', $this->Bookable->Vehicle->find('list'));
				$this->set('locations', $this->Bookable->Location->find('list'));
			}
		}
	}

	function edit($id = null) {
		if (empty($this->data)) {
			if (!$id) {
				$this->Session->setFlash('Invalid id for Bookable');
				$this->redirect('/bookables/index');
			}
			$this->data = $this->Bookable->read(null, $id);
			$this->set('calendars', $this->Bookable->Calendar->find('list'));
			if (empty($this->data['Calendar'])) { $this->data['Calendar'] = null; }
			$this->set('selectedCalendars', $this->data['Calendar']);
			$this->set('announcements', $this->Bookable->Announcement->find('list'));
			if (empty($this->data['Announcement'])) { $this->data['Announcement'] = null; }
			$this->set('selectedAnnouncements', $this->data['Announcement']);
			$this->set('vehicles', $this->Bookable->Vehicle->find('list'));
			$this->set('locations', $this->Bookable->Location->find('list'));
		} else {
			if ($this->Bookable->save($this->data)) {
				$this->Session->setFlash('The Bookable has been saved');
				$this->redirect('/bookables/index');
			} else {
				$this->Session->setFlash('Please correct errors below.');
				$this->set('calendars', $this->Bookable->Calendar->find('list'));
				if (empty($this->data['Calendar']['Calendar'])) { $this->data['Calendar']['Calendar'] = null; }
				$this->set('selectedCalendars', $this->data['Calendar']['Calendar']);
				$this->set('announcements', $this->Bookable->Announcement->find('list'));
				if (empty($this->data['Announcement']['Announcement'])) { $this->data['Announcement']['Announcement'] = null; }
				$this->set('selectedAnnouncements', $this->data['Announcement']['Announcement']);
				$this->set('vehicles', $this->Bookable->Vehicle->find('list'));
				$this->set('locations', $this->Bookable->Location->find('list'));
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Bookable');
			$this->redirect('/bookables/index');
		}
		if ($this->Bookable->del($id)) {
			$this->Session->setFlash('The Bookable deleted: id '.$id.'');
			$this->redirect('/bookables/index');
		}
	}

}
?>