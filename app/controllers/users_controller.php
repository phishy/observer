<?php

class UsersController extends AppController {

	function beforeFilter() {
		$this->Auth->allow('signup', 'login');
		parent::beforeFilter();
	}

	/**
	 * generates a unique member access key
	 */
	function generateKey() {
		print uniqid();exit;
	}

	/**
	 * become another user
	 */
	function sudo($user_id = null) {
		if ($user_id) $this->Session->write('Auth', $this->User->findById($user_id));
		$this->redirect('/jobs/dashboard');
	}

	/**
	 * creates a new users
	 */
	function signup() {
		if ($this->data) {
			if ($this->data['User']['password'] == $this->Auth->password('')) {
				$this->User->invalidate('password', 'Password is required');
			}
			$this->data['User']['password_confirm'] = $this->Auth->password($this->data['User']['password_confirm']);
			if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
				$this->User->invalidate('password_confirm', 'Passwords must match');
			}
			if ($this->User->validates()) {
				if ($this->User->add($this->data)) {
					$this->Auth->login($this->data);
					$this->Session->setFlash('Successfully created an account');
					$this->redirect('/jobs/dashboard');
				} else {
					$this->Session->setFlash('Failed to create new account', 'default', null, 'error');
				}	
			}
		}
		unset($this->data['User']['password']);
		unset($this->data['User']['password_confirm']);
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