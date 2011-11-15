<?php

class Email extends AppModel {

	var $name = 'Email';
	var $displayField = 'subject';

	/**
	 * parses en email body
	 */
	function parse($buffer = '') {
		if (!$buffer) {
			return false;
		}
		$mail = mailparse_msg_create();
		mailparse_msg_parse($mail, $buffer);
		$struct = mailparse_msg_get_structure($mail);
		$section = mailparse_msg_get_part($mail, 1);
		$info = mailparse_msg_get_part_data($section);
		
		if (strstr($info['headers']['from'], '<')) {
			list($before, $after) = explode('<', $info['headers']['from']);
			$info['headers']['from_email'] = str_replace('>', '', $after);
		}
		
		return $info['headers'];
	}

	/**
	 * find emails not yet assigned to jobs, and link them
	 */
	function jobify() {
		$this->Job = ClassRegistry::init('Job');
		$emails = $this->find('all', array('conditions' => array(
			'job_id IS NULL'
		)));
		foreach ($emails as $e) {
			$job = $this->Job->find('first', array('conditions' => array(
				'user_id' => $e['Email']['user_id'],
				'from'    => $e['Email']['from'],
				'subject' => $e['Email']['subject']
			)));
			if ($job) {
				$e['Email']['job_id'] = $job['Job']['id'];
				$this->save($e);
			}
		}
	}

}

?>
