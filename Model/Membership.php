<?php
class Membership extends AppModel {

	public $name = 'Membership';

	//public $hasOne = 'User';  ==> no good, made cakephp return duplicates
	//public $hasMany = array('Teammember', 'Coach', 'User');

	public $belongsTo = array(
		'Person' => array(
			'className'    => 'Person',
			'foreignKey'   => 'person_id'
		)
	);

}
