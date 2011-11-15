<?php

require_once APP . 'vendors/When/When.php';

class MonitorShell extends Shell {

	var $tasks = array('Job');

	var $uses = array('Email');

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
			$this->Email->jobify();
			$log = $this->Job->run();
			if ($log) $this->out(implode("\n", $log));
			$this->Job->notify();
			sleep(5);
		}
	}
}

?>