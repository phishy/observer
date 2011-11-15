<?php
/* Job Test cases generated on: 2011-11-10 12:26:17 : 1320945977*/
App::import('Model', 'Job');

class JobTestCase extends CakeTestCase {
	var $fixtures = array('app.job', 'app.event', 'app.email', 'app.user', 'app.event_action', 'app.event_status',
		'app.notification');

	function startTest() {
		$this->Job   =& ClassRegistry::init('Job');
		$this->Email =& ClassRegistry::init('Email');
		$this->Event =& ClassRegistry::init('Event');
		$this->Notification =& ClassRegistry::init('Notification');
	}

	function endTest() {
		unset($this->Job);
		ClassRegistry::flush();
	}

	function testSearchSingle() {
		$job = $this->Job->search(array('id' => 3));
		
		// should not be recurring, only one element
		$this->assertEqual(count($job), 1);
	
		// should have a calculated end
		$this->assertEqual($job[0]['Job']['time_end'], '2011-11-10 11:05:00');
	}

	function testSearchRecurring() {
		$jobs = $this->Job->search(array('id' => 1));
		$this->assertEqual(count($jobs), 24);
	}

	function testCheckEmailArrivedOnTime() {

		$msg = $this->Job->run(array(
			'start' => '2011-11-10 11:00:00',
			'end'   => '2011-11-10 12:00:00'
		));

		// time stub
		$time = date('Y-m-d H:i:s');

		// check returned log message
		$expected = $time . ': Job \'Pull Scientific Calendars\' successfully ran on 2011-11-10 11:00:00';
		$this->assertEqual($msg[0], $expected);

		// ensure Event is created
		$result = $this->Event->find('first');
		$expected = array (
		  'Event' => 
		  array (
		    'id' => '1',
		    'event_status_id' => '1',
		    'hash' => '1-1320940800-1320941100',
		    'job_id' => '1',
		    'message' => $time . ': Job \'Pull Scientific Calendars\' successfully ran on 2011-11-10 11:00:00',
		    'success' => '1',
		    'created' => $time,
		  ),
		);
		$this->assertEqual($result, $expected);

		// ensure Email `read` field is updated
		$result = $this->Email->find('first');
		$this->assertEqual($result['Email']['read'], $time);

		// ensure Success Notification is created
		$result = $this->Notification->findById(1);
		$expected = array (
		  'Notification' => 
		  array (
		    'id' => '1',
		    'event_id' => '1',
		    'to' => 'jeff@broadinstitute.org',
		    'subject' => $time . ': Job \'Pull Scientific Calendars\' successfully ran on 2011-11-10 11:00:00',
		    'body' => $time . ': Job \'Pull Scientific Calendars\' successfully ran on 2011-11-10 11:00:00',
		    'created' => $time,
		    'sent' => NULL,
		  ),
		);
		$this->assertEqual($result, $expected);
	}

	function testCheckEmailNeverArrived() {
		
		$msg = $this->Job->run(array(
			'start' => '2011-11-10 11:00:00',
			'end'   => '2011-11-10 12:00:00'
		));

		// time stub
		$time = date('Y-m-d H:i:s');

		// check return log message
		$expected = $time . ': Job \'This job never runs\' failed to run on 2011-11-10 11:00:00 +5 minutes';
		$this->assertEqual($msg[1], $expected);
		
		// ensure Event is created
		$result = $this->Event->findById(2);
		$expected = array (
		  'Event' => 
		  array (
		    'id' => '2',
		    'event_status_id' => '2',
		    'hash' => '2-1320940800-1320941100',
		    'job_id' => '2',
		    'message' => $time . ': Job \'This job never runs\' failed to run on 2011-11-10 11:00:00 +5 minutes',
		    'success' => '0',
		    'created' => $time,
		  ),
		);
		$this->assertEqual($result, $expected);

		// ensure Failure Notification is created
		$result = $this->Notification->findById(2);
		$expected = array (
		  'Notification' => 
		  array (
		    'id' => '2',
		    'event_id' => '2',
		    'to' => 'jeff@broadinstitute.org',
		    'subject' => $time . ': Job \'This job never runs\' failed to run on 2011-11-10 11:00:00 +5 minutes',
		    'body' => $time . ': Job \'This job never runs\' failed to run on 2011-11-10 11:00:00 +5 minutes',
		    'created' => $time,
		    'sent' => NULL,
		  ),
		);
		$this->assertEqual($result, $expected);
		// out of time and no email
		// email arrived on time/out of tolerance
		// email ran late
		
	}

	function testHash() {

	}

	function testUnhash() {

	}

}
