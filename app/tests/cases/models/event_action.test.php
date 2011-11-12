<?php
/* EventAction Test cases generated on: 2011-11-10 14:00:06 : 1320951606*/
App::import('Model', 'EventAction');

class EventActionTestCase extends CakeTestCase {
	var $fixtures = array('app.event_action');

	function startTest() {
		$this->EventAction =& ClassRegistry::init('EventAction');
	}

	function endTest() {
		unset($this->EventAction);
		ClassRegistry::flush();
	}

}
