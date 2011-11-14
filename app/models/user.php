<?php

class User extends AppModel {

	var $validate = array(
		'email' => array(
			'rule' => 'email',
			'message' => 'Email is required'
		),
		'password' => array(
			'rule' => array('minLength', 6),
			'message' => 'Password must be at least six (6) characters'
		)
	);

	/**
	 * creates a new user
	 */
	function add($data = array()) {
		if ($this->set($data) && !$this->validates()) {
			return false;
		}
		$exists = $this->findByEmail($data['User']['email']);
		if ($exists) {
			$this->invalidate('email', 'This email is already taken');
			return false;
		}
		$this->data['User']['key'] = uniqid();
		if ($this->save($data)) {
			return true;
		}
	}
}

?>