<?php
class EmailTask extends Shell 
{
	var $uses = array('Email');

	/**
	 * updates email metadata
	 */
	function update_metadata() 
	{
		$emails = $emails = $this->Email->find('all', array('conditions' => array('from' => NULL)));
		foreach ($emails as $e) {
			$info = $this->_parse($e['Email']['body']);
			$e['Email']['from'] = $info['from'];
			$e['Email']['subject'] = $info['subject'];
			$this->Email->save($e);
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