<?php
/* Notification Test cases generated on: 2011-11-10 13:32:45 : 1320949965*/
App::import('Model', 'Notification');

class NotificationTestCase extends CakeTestCase {
	var $fixtures = array('app.notification');

	function startTest() {
		$this->Notification =& ClassRegistry::init('Notification');
	}

	function endTest() {
		unset($this->Notification);
		ClassRegistry::flush();
	}

}
