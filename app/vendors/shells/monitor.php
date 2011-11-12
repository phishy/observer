<?php

require_once APP . 'vendors/When/When.php';

class MonitorShell extends Shell {

	var $tasks = array('Email', 'Job');

	function _welcome(){}
	function _clear(){}

	/**
	 * main loop
	 */
	function main() {
		$this->out('Job Observer v1.0alpha');
		$this->out('Written by Jeff Loiselle <jeff.loiselle@gmail.com>');
		$this->out();
		$this->out('Started Job Observer process.');
		$this->out('Awaiting correspondence...');
		while (true) {
			$this->Email->update_metadata();
			$this->Job->run();
			$this->Job->notify();
			sleep(5);
		}
	}
}

?>