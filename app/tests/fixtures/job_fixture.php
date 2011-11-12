<?php
/* Job Fixture generated on: 2011-11-10 12:27:03 : 1320946023 */
class JobFixture extends CakeTestFixture {
	var $name = 'Job';
	var $import = array('model' => 'Job');


	var $records = array(
		array(
			'id' => '1',
			'user_id' => '1',
			'name' => 'Pull Scientific Calendars',
			'subject' => 'Pull Scientific Calendars',
			'from' => 'root@broadinstitute.org',
			'start' => '2011-11-10 11:00:00',
			'end' => NULL,
			'rrule' => 'freq=hourly',
			'tolerance' => '5 minutes',
			'whitecheck' => '',
			'blackcheck' => '',
			'owner_email' => NULL,
			'count' => '2',
			'description' => '',
			'enabled' => 1
		),
		array(
			'id' => '2',
			'user_id' => '1',
			'name' => 'This job never runs',
			'subject' => '',
			'from' => '',
			'start' => '2011-11-10 11:00:00',
			'end' => NULL,
			'rrule' => 'freq=hourly',
			'tolerance' => '5 minutes',
			'whitecheck' => '',
			'blackcheck' => '',
			'owner_email' => NULL,
			'count' => '2',
			'description' => '',
			'enabled' => 1
		),
		array(
			'id' => '3',
			'user_id' => '1',
			'name' => 'Single instance job',
			'subject' => '',
			'from' => '',
			'start' => '2011-11-10 11:00:00',
			'end' => NULL,
			'rrule' => '',
			'tolerance' => '5 minutes',
			'whitecheck' => '',
			'blackcheck' => '',
			'owner_email' => NULL,
			'count' => '2',
			'description' => '',
			'enabled' => 1
		),
		array(
			'id' => '4',
			'user_id' => '1',
			'name' => 'Message can come anytime',
			'subject' => '',
			'from' => '',
			'start' => '2011-11-10 00:00:01',
			'end' => NULL,
			'rrule' => '',
			'tolerance' => '23 hours',
			'whitecheck' => '',
			'blackcheck' => '',
			'owner_email' => NULL,
			'count' => 0,
			'description' => '',
			'enabled' => 1
		),
	);
}
