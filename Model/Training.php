<?php
class Training extends AppModel {
	public $name = 'Training';

	public $virtualFields = array(
		'day_of_week'     => 'WEEKDAY(start_date)',
		'week_of_year'    => 'WEEK(start_date)',
		'start_date_nice' => 'date_format(Training.start_date, "%e/%m/%Y")',
		'start_time_nice' => 'date_format(Training.start_time, "%k:%i")',
		'end_time_nice'   => 'date_format(Training.end_time, "%k:%i")',
		'full_name'       => 'CONCAT("", Training.team_id, "--", date_format(Training.start_date, "%e/%m/%Y"), "--", date_format(Training.start_time, "%k:%i"))'
	);

	public $order = array("Training.start_date" => "asc", "Training.start_time" => "asc");

	public $belongsTo = array('Team', 'Trainingmoment');
	public $hasMany = array('Trainingsteammember' => array(
														'className'=>'Trainingsteammember',
														'foreignKey'=>'training_id',
														'dependent' => true
													)
							);

//	Validation rules
	public $validate = array(
		'team_id' => array(
			'unique' => array(
				'rule' => array('checkUnique', array('team_id', 'start_date', 'start_time'), false),
				'message' => 'Duplicate training'
			)
		),
		'start_date' => array('rule' => 'notBlank', 'message'  => 'Datum is verplicht in te vullen'),
		'start_time' => array('rule' => 'notBlank', 'message'  => 'Datum is verplicht in te vullen'),

	);


/**
 * Checks if there are records on the datasource with the same team_id and same start_date
 *
 */
	public function checkUnique($ignoredData, $fields, $or = true) {
		return $this->isUnique($fields, $or);
	}


/**
 * Initializes the filter to only get info for the "current season"
 *	The "current season" is set in the globally defined configuration (in core.php)
 *	The "current season" is also implemented in the AppController (as property currentSeason)
 *
 */
	public function beforeFind($queryData) {
		parent::beforeFind($queryData);
		$defaultConditions = array('Training.season' => Configure::read('Clubman.currentseason'));
		$queryData['conditions'] = is_array($queryData['conditions']) ? array_merge($queryData['conditions'], $defaultConditions) : $defaultConditions;
		return $queryData;
	}

}
