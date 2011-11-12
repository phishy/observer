<?php

require_once APP . 'vendors/When/When.php';

App::import('Model', 'EventStatus');

class Job extends AppModel {

	var $name = 'Job';
	var $displayField = 'name';

	var $belongsTo = array('User');
	var $hasMany = array('EventAction');

	var $validate = array(
		'from' => array(
			'rule' => 'email',
			'message' => 'Valid email required'
		),
		'start' => array(
			'rule' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',
			'message' => 'Valid date and time required'
		),
		'end' => array(
			'rule' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',
			'message' => 'Valid date and time required',
			'allowEmpty' => true
		),
		'count' => array(
			'rule' => '/^[0-9]+$/',
			'message' => 'Must be an integer',
			'allowEmpty' => true
		)
	);

	/**
	 * retrieves associated events given a job
	 */
	function _events($job) {
		$this->Event = ClassRegistry::init('Event');
		return $this->Event->find('all', array('conditions' => array('hash' => $job['Job']['hash'])));
	}

	/**
	 * retrieves associated emails given a job
	 */
	function _emails($job) {
		$this->Email = ClassRegistry::init('Email');
		$emails = $this->Email->find('all', array('conditions' => array(
			"created BETWEEN '{$job['Job']['time_start']}' AND '{$job['Job']['time_end']}'",
			'from'    => $job['Job']['from'],
			'subject' => $job['Job']['subject']
		)));
		return $emails;
	}

	/**
	 * returns a formatted date
	 */
	function _date($str) {
		return date('Y-m-d H:i:s', strtotime($str));
	}

	/**
	 * creates a new job
	 */
	function add($data) {
		if ($this->saveAll($data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * runs jobs and return a log
	 */
	function run($options = array()) {
		$log = array();
		$jobs = $this->search($options);
		foreach ($jobs as $j) {
			$log = array_merge($log, $this->check($j));
		}
		return $log;
	}

	/**
	 * checks the current status of a job and generates events and notifications
	 */
	function check($j = array()) {

		$log = array();

		// out of time and no email
		if (!$j['Job']['Email'] && time() >= strtotime($j['Job']['time_end'])) {
			foreach ($j['Job']['Event'] as $e) {
				// skip this iteration if we've already had a failure
				if ($e['event_status_id'] == EventStatus::Failure) return array();
			}
			$msg = date('Y-m-d H:i:s') . ": Job '{$j['Job']['name']}' failed to run on {$j['Job']['time_start']} +{$j['Job']['tolerance']}";
			$event = array(
				'hash'    => $j['Job']['hash'],
				'job_id'  => $j['Job']['id'],
				'success' => 0,
				'message' => $msg,
				'event_status_id' => EventStatus::Failure
			);
			$this->Event->create($event);
			if (!$this->Event->save()) {
				throw new Exception('failed to save event');
			}

			$event_status_id = EventStatus::Failure;
			foreach (Set::extract("/EventAction[event_status_id=$event_status_id]", $j) as $action) {
				$notification = array(
					'event_id' => $this->Event->id,
					'to'       => $action['EventAction']['email'],
					'subject'  => $msg,
					'body'     => $msg  
				);
				$this->Notification = ClassRegistry::init('Notification');
				if ($this->Notification->create($notification) && !$this->Notification->save()) {
					throw new Exception('failed to save notification');
				}	
			}
			$log[] = $msg;
		}

		// emails arrived ontime/out-of-tolerance
		foreach ($j['Job']['Email'] as $e) {

			// continue if email has already been read
			if ($e['read']) continue;

			// check for tolerance
			if ($e['created'] >= $j['Job']['time_start'] 
				&& $e['created'] <= $j['Job']['time_end']) {
					
				if (count($j['Job']['Email']) > $j['Job']['count']) {
					$msg = date('Y-m-d H:i:s') . ": Job '{$j['Job']['name']}' ran over tolerance on {$e['created']}";
					$event_status_id = EventStatus::Duplicate;
				} else {
					$msg = date('Y-m-d H:i:s') . ": Job '{$j['Job']['name']}' successfully ran on {$e['created']}";
					$event_status_id = EventStatus::Success;
				}
				
				$this->Email->save(array(
					'id'     => $e['id'],
					'job_id' => $j['Job']['id'],
					'read'   => date('Y-m-d H:i:s')
				));

				$event = array(
					'hash'    => $j['Job']['hash'],
					'job_id'  => $j['Job']['id'],
					'success' => 1,
					'message' => $msg,
					'event_status_id' => $event_status_id
				);
				$this->Event->create($event);
				if (!$this->Event->save()) {
					throw new Exception('failed to save event');
				}

				foreach (Set::extract("/EventAction[event_status_id=$event_status_id]", $j) as $action) {
					$notification = array(
						'event_id' => $this->Event->id,
						'to'       => $action['EventAction']['email'],
						'subject'  => $msg,
						'body'     => $msg  
					);
					$this->Notification = ClassRegistry::init('Notification');
					if ($this->Notification->create($notification) && !$this->Notification->save()) {
						throw new Exception('failed to save notification');
					}	
				}
				$log[] = $msg;
			} else {
				$msg = date('Y-m-d H:i:s') . ": Job '{$j['Job']['name']}' ran late on {$j['Job']['time_start']} +{$j['Job']['tolerance']}";
				$event = array(
					'hash'    => $j['Job']['hash'],
					'job_id'  => $j['Job']['id'],
					'success' => 0,
					'message' => $msg,
					'event_status_id' => EventStatus::Late
				);
				$this->Event->create($event);
				if (!$this->Event->save()) {
					throw new Exception('failed to save event');
				}

				$event_status_id = EventStatus::Late;
				foreach (Set::extract("/EventAction[event_status_id=$event_status_id]", $j) as $action) {
					$notification = array(
						'event_id' => $this->Event->id,
						'to'       => $action['EventAction']['email'],
						'subject'  => $msg,
						'body'     => $msg  
					);
					$this->Notification = ClassRegistry::init('Notification');
					if ($this->Notification->create($notification) && !$this->Notification->save()) {
						throw new Exception('failed to save notification');
					}	
				}

				$this->Email->save(array(
					'id'     => $e['id'],
					'job_id' => $j['Job']['id'],
					'read'   => date('Y-m-d H:i:s')
				));
				$log[] = $msg;
			}
		}
		return $log;
	}

	/**
	 * search for job data
	 */
	function search($options = array()) {
		$defaults = array(
			'id'       => null,
			'user_id'  => null,
			'hash'     => null,
			'start'    => date('Y-m-d'),
			'end'      => date('Y-m-d 23:59:59'),
			'enabled'  => true
		);
		$options = $options + $defaults;

		$conditions = array();

		if (!empty($options['id'])) {
			$conditions['Job.id'] = $options['id'];
		}

		// if (!empty($options['start'])) {
		// 	$conditions['start <='] = $this->_date($options['start']);
		// }
		// 
		// if (!empty($options['end'])) {
		// 	$conditions['OR'] = array(
		// 		array('end >=' => $this->_date($options['end'])),
		// 		array('end' => NULL)
		// 	);
		// }

		if (!empty($options['user_id'])) {
			$conditions['user_id'] = $options['user_id'];
		}

		if (empty($options['end'])) {
			$options['end'] = date('Y-m-d 23:59:59');
		}

		if (!empty($options['enabled'])) {
			$conditions['enabled'] = $options['enabled'];
		}
		
		if (!empty($options['hash'])) {
			$hash = $this->unhash($options['hash']);
			$conditions['Job.id'] = $options['id'];
			$options['start'] = $hash['time_start'];
			$options['end']   = $hash['time_end'];
		}

		// debug($conditions);
		// debug($options);
		// exit;

		$jobs = $this->find('all', array('conditions' => $conditions));

		// debug($jobs);
		// 
		// $db = ConnectionManager::getDataSource('default');
		// debug($db);exit;

		$out = array();
		foreach ($jobs as $k => $j) {
			$out = array_merge($out, $this->_build($j, $options));
		}

		// return by hash
		if (!empty($options['hash'])) {
			foreach ($out as $j) {
				if ($j['Job']['hash'] == $options['hash']) {
					return $j;
				}
			}
		}

		return $out;
	}

	/**
	 * expands job record into it's recurrences and data
	 */
	function _build($job = null, $options = null) 
	{
		if (!$job) return;

		if (!empty($job['Job']['rrule'])) {
			$jobs = $this->_recurrences($job, $options);
		} else {
			$job['Job']['time_start'] = $job['Job']['start'];
			$job['Job']['time_end']   = $job['Job']['end'];
			$job['Job']['hash']       = $this->hash(array(
				'id'    => $job['Job']['id'],
				'start' => strtotime($job['Job']['time_start']),
				'end'   => strtotime($job['Job']['time_end'])
			));
			$jobs = array($job);
		}

		foreach ($jobs as &$j) {
			$j['Job']['Event']  = Set::extract('{n}.Event', $this->_events($j));
			$j['Job']['Email']  = Set::extract('{n}.Email', $this->_emails($j));
		}
		return $jobs;
	}

	/**
	 * expands job into its recurrences
	 *
	 * @param array $job an array of data about a job
	 * @return array an array of expanded jobs
	 */
	function _recurrences($job = null, $options = null) 
	{
		$when = new When();
		$rule = $this->_parseRule($job['Job']['rrule']);

		if (empty($rule['until']) && $job['Job']['end']) {
			$rule['until'] = date('c', strtotime($job['Job']['end']));
		}
		if (empty($rule['until']) && !$job['Job']['end']) {
			$rule['until'] = date('c', strtotime($options['end']));
		}

		// build recurrences
		$rule = $this->_buildRule($rule);
		$when->recur($job['Job']['start'])->rrule($rule);

		$jobs = array();
		while ($result = $when->next()) {
			$j = $job;
			$j['Job']['time_start'] = $result->format('Y-m-d H:i:s');
			$j['Job']['time_end'] = date('Y-m-d H:i:s', strtotime($result->format('c') . " +{$job['Job']['tolerance']}"));

			$j['Job']['hash'] = $this->hash(array(
				'id'    => $j['Job']['id'],
				'start' => strtotime($j['Job']['time_start']),
				'end'   => strtotime($j['Job']['time_end'])
			));

			if (strtotime($j['Job']['time_start']) < strtotime($options['start'])) {
				continue;
			}
			
			if (strtotime($j['Job']['time_end']) > strtotime($options['end'])) {
				continue;
			}

			$jobs[] = $j;
		}
		return $jobs;
	}

	/**
	 * creates a job instance hash from an array
	 */
	function hash($hash = null) {
		return implode('-', $hash);
	}

	/**
	 * returns an array from a job instance hash string
	 */
	function unhash($hash = null) {
		list($id, $time_start, $time_end) = explode('-', $hash);
		return array(
			'id'         => $id,
			'time_start' => date('Y-m-d H:i:s', (int) $time_start),
			'time_end'   => date('Y-m-d H:i:s', (int) $time_end)
		);
	}

	/**
	 * parse rrule into an array
	 */
	function _parseRule($r) {
		if (!$r) return;
		$out = array();
		$rules = explode(';', $r);
		foreach ($rules as $r) {
			list($k, $v) = explode('=', $r);
			$out[$k] = $v;
		}
		return $out;
	}

	/**
	 * turn rrule array into string
	 */
	function _buildRule($rules) {
		$out = '';
		foreach ($rules as $k => $v) {
			$out .= "$k=$v;";
		}
		return $out;
	}

}
