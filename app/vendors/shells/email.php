<?php
class EmailShell extends Shell 
{
	var $uses = array('Email', 'User');

	function _welcome() {}
	function _clear() {}

	/**
	 * find emails not yet assigned to jobs, and link them
	 */
	function jobify() {
		$this->Email->jobify();
	}

	/**
	 * receives an email
	 */
	function receive() {
		$data = file_get_contents('php://stdin');
		preg_match('/observer\+[A-Za-z0-9]+@automata.me/', $data, $matches);
		if (!$matches) {
			exit(67);
		}
		$email = $matches[0];
		if ($matches) {
			list($user, $domain) = explode('@', $email);
			list($mailbox, $key) = explode('+', $user);
		}
		if (!$user = $this->User->findByKey($key)) {
			exit(67);
		}
		
		$info = $this->_parse($data);

		$email = array(
			'user_id' => $user['User']['id'],
			'body'    => $data,
			'from'    => $info['from'],
			'subject' => $info['subject']
		);
		if ($this->Email->save($email)) {
			exit(0);
		} else {
			exit(67);
		}
	}

	/**
	 * a dumb email parsing function
	 */
	function _parse($data = '') {
		if (!$data) return;
		$lines = explode("\n", $data);
		if (!$lines) return;
		foreach ($lines as $l) {
			if (strstr($l, 'From: ')) {
				preg_match('/[A-Za-z0-9.\-_+]+@[A-Za-z0-9]+.[A-Z-a-z]+/', $l, $matches);
				$from = $matches[0];
			}
		}
		foreach ($lines as $l) {
			if (strstr($l, 'Subject:')) {
				list(, $subject) = explode('Subject:', $l);
			}
		}
		return array(
			'from'    => trim($from),
			'subject' => trim($subject)
		);
	}
}
?>