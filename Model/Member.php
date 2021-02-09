<?php
class Member extends AppModel {
	public $name = 'Member';

	public $virtualFields = array(
				'name' => 'CONCAT_WS(" ", Member.lastname, Member.firstname)',
				'uname' => 'CONCAT_WS(" ", UPPER(Member.lastname), UPPER(Member.firstname))',
				'birthyear' => 'date_format(Member.birthdate, "%Y")',
				'birthmonth' => 'date_format(Member.birthdate, "%m")',
				'birthday' => 'date_format(Member.birthdate, "%d")',
				'birthdate_nice' => 'date_format(Member.birthdate, "%e/%m/%Y")',
				'mom_name' => 'CONCAT_WS(" ", Member.mom_lastname, Member.mom_firstname)',
				'dad_name' => 'CONCAT_WS(" ", Member.dad_lastname, Member.dad_firstname)',
				'membership_advancepaid_nice' => 'date_format(Member.membership_advancepaid, "%e/%m/%Y")',
				'membership_balancepaid_nice' => 'date_format(Member.membership_balancepaid, "%e/%m/%Y")',
				'camp_advance_nice' => 'date_format(Member.camp_advance, "%e/%m/%Y")',
				'camp_balance_nice' => 'date_format(Member.camp_balance, "%e/%m/%Y")'
			);

/*	validation */
	var $validate = array(
		'lastname'  => array('rule' => 'notBlank', 'message'  => 'Achternaam is verplicht in te vullen'),
		'firstname' => array('rule' => 'notBlank', 'message'  => 'Voornaam is verplicht in te vullen')
	);

	public $displayField = 'name';
	public $order = 'name';

//	public $hasOne = 'User';  ==> no good, made cakephp return duplicates
	public $hasMany = array('Teammember', 'Coach', 'User');
	public $belongsTo = array(
		'Picture' => array(
			'className'    => 'Picture',
			'foreignKey'   => 'picture_id'
		),
		'Picturelicense' => array(
			'className'    => 'Picture',
			'foreignKey'   => 'picturelicense_id'
		)
	);

}
