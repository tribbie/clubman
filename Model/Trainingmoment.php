<?php
class Trainingmoment extends AppModel {
	public $name = 'Trainingmoment';

/*	virtual fields */
	var $virtualFields = array(
		'training_dow' => 'dayofweek(Trainingmoment.weekday)',
		'start_time_nice' => 'date_format(Trainingmoment.start_time, "%k:%i")',
		'end_time_nice' => 'date_format(Trainingmoment.end_time, "%k:%i")'
	);

	public $order = array('Trainingmoment.weekday' => 'ASC', 'Trainingmoment.start_time' => 'ASC', 'Trainingmoment.end_time' => 'ASC');

//	public $hasMany = array('Trainingmomentsteam', 'Trainingmomentsteammember', 'Training');

}
