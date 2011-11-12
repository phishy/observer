<?php
class EventAction extends AppModel {
	var $name = 'EventAction';

	var $belongsTo = array('EventStatus');
}
