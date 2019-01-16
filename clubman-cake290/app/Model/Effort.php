<?php
class Effort extends AppModel {
	public $name = 'Effort';

/*	virtual fields */
	var $virtualFields = array(
		'effortdow' => 'dayofweek(Effort.taskdate)',
		'taskdate_nice' => 'date_format(Effort.taskdate, "%e/%m/%Y")',
		'tasktime_nice' => 'date_format(Effort.tasktime, "%k:%i")'
	);

/*	validation */
	var $validate = array(
		'taskname' => array('rule' => 'notBlank', 'message'  => 'Taak is verplicht in te vullen'),
		'taskdate' => array('rule' => 'date', 'message'  => 'Gelieve een geldige datum te kiezen (jjjj-mm-dd)'),
		'tasktime' => array('rule' => 'time', 'message'  => 'Gelieve een geldige tijd te kiezen (uu:mm)')
	);

	public $displayField = 'taskname';
//	public $order = 'name';

	public $belongsTo = array('Member', 'Team');


/**
 * Initializes the filter to only get info for the "current season"
 *	The "current season" is set in the globally defined configuration (in core.php)
 *	The "current season" is also implemented in the AppController (as property currentSeason)
 *
 */
	public function beforeFind($queryData) {
		parent::beforeFind($queryData);
//		$defaultConditions = array('Effort.season' => '2015-2016');
		$defaultConditions = array('Effort.season' => Configure::read('Clubman.currentseason'));
		$queryData['conditions'] = is_array($queryData['conditions']) ? array_merge($queryData['conditions'], $defaultConditions) : $defaultConditions;
		return $queryData;
	}

}
