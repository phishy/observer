<?php
/**
 * tests:
 *
 * test that email not shows up within tolerance
 * test duplicate email
 * test that notification is sent even when email comes in after tolerance
 * midnight bug..
 */
class JobTask extends Shell {
	var $uses = array('Email', 'Event', 'EventStatus', 'Job', 'Notification');

	/**
	 * inspect and run all jobs
	 */
	function run() {
		$log = array();
		$jobs = $this->Job->search();
		foreach ($jobs as $j) {
			$log = array_merge($log, $this->Job->check($j));
		}
		return $log;
	}

	/**
	 * process notifications
	 */
	function notify() {
		$notifications = $this->Notification->find('all', array('conditions' => array('sent IS NULL')));
		foreach ($notifications as $n) {
			$to      = $n['Notification']['to'];
			$subject = $n['Notification']['subject'];
			$body    = $n['Notification']['body'];
			$headers = array(
				$headers = 'From: Automata Observer <noreply@automata.me>'
			);
			$headers = implode("\r\n", $headers);
			if (mail($to, $subject, $body, $headers)) {
				$n['Notification']['sent'] = date('Y-m-d H:i:s');
				$this->Notification->save($n);
			}
		}
	}
}

?>