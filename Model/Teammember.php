<?php
class Teammember extends AppModel {
	public $name = 'Teammember';

//	public $displayField = 'name';
//	public $order = array('teampriority');

	public $belongsTo = array('Team', 'Member');
	public $hasMany = array('Trainingsteammember', 'Gamesteammember');

	public function beforeFind($queryData) {
		parent::beforeFind($queryData);
		$defaultConditions = array('Teammember.season' => Configure::read('Clubman.currentseason'));
		$queryData['conditions'] = is_array($queryData['conditions']) ? array_merge($queryData['conditions'], $defaultConditions) : $defaultConditions;
		return $queryData;
	}

}
