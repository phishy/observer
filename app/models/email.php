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

}

?>
