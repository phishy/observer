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
}

?>