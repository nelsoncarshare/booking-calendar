<?php
App::uses('AppController', 'Controller');

class PermissionsController extends AppController {


	public $scaffold;

	/*
	public $helpers = array('Html', 'Form' );

    function beforeFilter()
    {
        $this->checkSession();
    }

	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->User->find('all', null,null,"displayname"));
	}

	function view($id = null) {
		if (!$id) {
			return $this->flash('Invalid id for User', '/users/index');
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (empty($this->request->data)) {
			$this->render();
		} else {
			$this->cleanUpFields();
			$this->request->data['User']['password'] = md5( $this->request->data['User']['password'] );
			if ($this->User->save($this->request->data)) {
				return $this->flash('User saved.', '/users/index');
			} else {
			}
		}
	}

	function edit($id = null) {
		if (empty($this->request->data)) {
			if (!$id) {
				return $this->flash('Invalid id for User', '/users/index');
			}
			$this->request->data = $this->User->read(null, $id);
		} else {
			$this->cleanUpFields();
			$this->request->data['User']['password'] = md5( $this->request->data['User']['password'] );
			if ($this->User->save($this->request->data)) {
				return $this->flash('User saved.', '/users/index');
			} else {
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			return $this->flash('Invalid id for User', '/users/index');
		}
		if ($this->User->del($id)) {
			return $this->flash('User deleted: id '.$id.'.', '/users/index');
		}
	}
	*/
}
?>