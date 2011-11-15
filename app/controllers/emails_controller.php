<?php

class EmailsController extends AppController {

	var $name = 'Emails';

	function index() {
		$this->Email->recursive = 0;
		$this->set('emails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid email', true));
			$this->redirect(array('action' => 'index'));
		}
		$email = $this->Email->findById($id);
		$email['Email'] = array_merge($email['Email'], $this->Email->parse($email['Email']['body']));
		$this->set('email', $email);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Email->create();
			if ($this->Email->save($this->data)) {
				$this->Session->setFlash(__('The email has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The email could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid email', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Email->save($this->data)) {
				$this->Session->setFlash(__('The email has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The email could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Email->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid email', 'default', null, 'error');
			$this->redirect($this->referer());
		}
		if ($this->Email->delete($id)) {
			$this->Session->setFlash(__('Email deleted', true));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash('Failed to delete email', 'default', null, 'error');
		$this->redirect($this->referer());
	}
}
