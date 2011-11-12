<?php

class UsersController extends AppController {

	function beforeFilter() {
		$this->Auth->allow('signup', 'login');
		parent::beforeFilter();
	}

	/**
	 * creates a new users
	 */
	function signup() {
		if ($this->data) {
			$exists = $this->User->findByEmail($this->data['User']['email']);
			if ($exists) {
				$this->Session->setFlash('An account with this email address already exists', 'default', null, 'error');
				$this->redirect($this->referer());
			}
			if ($this->User->save($this->data)) {
				$this->Auth->login($this->data);
				$this->Session->setFlash('Successfully created an account');
				$this->redirect('/jobs/dashboard');
			} else {
				$this->Session->setFlash('Failed to create new account', 'default', null, 'error');
			}
		}
		unset($this->data['User']['password']);
	}

	/**
	 * logs a user in
	 */
	function login() {

	}

	/**
	 * logout a user
	 */
	function logout() {
		$this->redirect($this->Auth->logout());
	}
}

?>