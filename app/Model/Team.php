<?php
class Team extends AppModel {
	public $name = 'Team';

//	public $virtualFields = array('name' => "CONCAT_WS(' ', Team.category, Team.gender, Team.number)");
	public $virtualFields = array('teaminfo' => "CONCAT_WS(' ', Team.name, '-', Team.competition)");
	public $displayField = 'name';
	public $order = array('display_order', 'shortname');

	public $belongsTo = array('Picture');
	public $hasMany = array(
						'Teammember' => array('class' => 'Teammember', 'order' => 'Teammember.teampriority'),
						'Trainingmomentsteam',
						'Training' => array('class' => 'Training', 'order' => array('Training.start_date' => 'asc', 'Training.start_time' => 'asc')),
						'Game' => array('class' => 'Game', 'order' => array('Game.game_date' => 'asc', 'Game.game_time' => 'asc'))
					);

	public function beforeFind($queryData) {
		parent::beforeFind($queryData);
		$defaultConditions = array('Team.season' => Configure::read('Clubman.currentseason'));
		$queryData['conditions'] = is_array($queryData['conditions']) ? array_merge($queryData['conditions'], $defaultConditions) : $defaultConditions;
		return $queryData;
	}
}
