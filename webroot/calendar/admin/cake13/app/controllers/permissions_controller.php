<?php
class PermissionsController extends AppController {

	var $name = 'Permissions';
	var $scaffold;

	/*
	var $helpers = array('Html', 'Form' );

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
			$this->flash('Invalid id for User', '/users/index');
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (empty($this->data)) {
			$this->render();
		} else {
			$this->cleanUpFields();
			$this->data['User']['password'] = md5( $this->data['User']['password'] );
			if ($this->User->save($this->data)) {
				$this->flash('User saved.', '/users/index');
			} else {
			}
		}
	}

	function edit($id = null) {
		if (empty($this->data)) {
			if (!$id) {
				$this->flash('Invalid id for User', '/users/index');
			}
			$this->data = $this->User->read(null, $id);
		} else {
			$this->cleanUpFields();
			$this->data['User']['password'] = md5( $this->data['User']['password'] );
			if ($this->User->save($this->data)) {
				$this->flash('User saved.', '/users/index');
			} else {
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash('Invalid id for User', '/users/index');
		}
		if ($this->User->del($id)) {
			$this->flash('User deleted: id '.$id.'.', '/users/index');
		}
	}
	*/
}
?>