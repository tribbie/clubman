<?php
class Migratemember extends AppModel {

	public $name = 'Migratemember';

	public $virtualFields = array(
				'name' => 'CONCAT_WS(" ", Migratemember.lastname, Migratemember.firstname)',
				'uname' => 'CONCAT_WS(" ", UPPER(Migratemember.lastname), UPPER(Migratemember.firstname))',
				'birthyear' => 'date_format(Migratemember.birthdate, "%Y")',
				'birthmonth' => 'date_format(Migratemember.birthdate, "%m")',
				'birthday' => 'date_format(Migratemember.birthdate, "%d")',
				'birthdate_nice' => 'date_format(Migratemember.birthdate, "%e/%m/%Y")',
				'mom_name' => 'CONCAT_WS(" ", Migratemember.mom_lastname, Migratemember.mom_firstname)',
				'dad_name' => 'CONCAT_WS(" ", Migratemember.dad_lastname, Migratemember.dad_firstname)'
			);

	public $displayField = 'name';
	public $order = 'name';

	//public $hasOne = 'User';  ==> no good, made cakephp return duplicates
	//public $hasMany = array('Teammember', 'Coach', 'User');
	public $belongsTo = array(
		'Person' => array(
			'className'    => 'Person',
			'foreignKey'   => 'person_id'
		)
	);

}
