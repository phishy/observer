<?php
class JobsController extends AppController {

	var $name = 'Jobs';

	var $uses = array('Job', 'Email', 'EventStatus');

	var $paginate = array(
		'order' => 'name'
	);

	/**
	 * display help page
	 */
	function help() {
		
	}

	/**
	 * display job dashboard
	 */
	function dashboard() {
		$user = $this->Auth->user();
		$jobs = $this->Job->search(array('user_id' => $user['User']['id']));
		
		$emails = $this->Email->find('all', array('conditions' => array(
			'job_id IS NULL',
			'user_id' => $user['User']['id'],
		)));
		foreach ($emails as &$e) {
			$record = $e;
			$record['Email'] = array_merge($record['Email'], $this->Email->parse($e['Email']['body']));
			$e = $record;
		}

		$this->set(compact('jobs', 'emails'));
	}

	/**
	 * display index of jobs
	 */
	function index() {
		$user = $this->Auth->user();
		$this->paginate['conditions'] = array(
			'user_id' => $user['User']['id']
		);
		$jobs = $this->paginate();
		$this->set('jobs', $jobs);
	}

	/**
	 * display and individual job instance
	 */
	function view($hash = null) {
		if (!$hash) {
			$this->Session->setFlash(__('Invalid job', 'default', null, 'error'));
			$this->redirect(array('action' => 'dashboard'));
		}
		if (strstr($hash, '-')) {
			$hashed = $this->Job->unhash($hash);
			$id     = $hashed['id'];
		} else {
			$id = $hash;
			$hash = null;
		}
		$job = $this->Job->search(compact('id', 'hash'));
		$job = $job[0];
		$this->set('job', $job);
	}

	/**
	 * create a new job
	 */
	function add() {
		$user = $this->Auth->user();
		if ($this->data) {
			$this->data['Job']['user_id'] = $user['User']['id']; 
			if (!empty($this->data['Job']['freq'])) {
				$this->data['Job']['rrule'] = "freq={$this->data['Job']['freq']}";
			}
			if (!empty($this->data['Job']['interval']) && !empty($this->data['Job']['metric'])) {
				$this->data['Job']['tolerance'] = "{$this->data['Job']['interval']} {$this->data['Job']['metric']}";
			}
			if ($this->Job->add($this->data)) {
				$this->Session->setFlash(__('Successfully added job', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Failed to add job', 'default', null, 'error');
			}
		}
		if (!$this->data) {
			if (!empty($this->params['named']['email'])) {
				$email = $this->Email->find('first', array('conditions' => array(
					'user_id' => $user['User']['id'],
					'id'      => $this->params['named']['email']
				)));
				$email['Parsed'] = $this->Email->parse($email['Email']['body']);
				$this->data['Job']['from']    = $email['Parsed']['from_email'];
				$this->data['Job']['start']   = date('Y-m-d H:i:s', strtotime($email['Parsed']['date']));
				$this->data['Job']['name']    = $email['Email']['subject'];
				$this->data['Job']['subject'] = $email['Email']['subject'];
				$this->data['Job']['interval'] = round((strtotime($email['Email']['created']) - strtotime($email['Parsed']['date'])) / 60);
			}
		}
		
		$event_statuses = $this->EventStatus->find('list');
		
		$this->set(compact('event_statuses'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid job', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Job->save($this->data)) {
				$this->Session->setFlash(__('The job has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The job could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Job->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for job', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Job->delete($id)) {
			$this->Session->setFlash(__('Job deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Job was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
