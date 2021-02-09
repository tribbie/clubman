<?php
class Person extends AppModel {

	public $name = 'Person';

	public $useTable = 'persons';

	/// Juli 2018 -- the virtual fields give shizzle:
	/// - with Person.    - invalid fields when accessing through Parent model
	/// - without Person. - ambiguous fields in ajfetchall because of Personparent link
	//public $virtualFields = array(
	//			'name'           => 'CONCAT_WS(" ", Person.lastname, Person.firstname)',
	//			'uname'          => 'CONCAT_WS(" ", UPPER(Person.lastname), UPPER(Person.firstname))',
	//			'birthyear'      => 'date_format(Person.birthdate, "%Y")',
	//			'birthmonth'     => 'date_format(Person.birthdate, "%m")',
	//			'birthday'       => 'date_format(Person.birthdate, "%d")',
	//			'birthdate_nice' => 'date_format(Person.birthdate, "%e/%m/%Y")'
	//		);

	//public $displayField = 'name';
	//public $order = 'name';

	public $hasOne = array('Membership',
												'Dad' => array(
																		'className' => 'Personparent',
																		'foreignKey' => 'person_id',
																		'conditions' => array('Dad.type' => 'FATHER')
																	),
												'Mom' => array(
																		'className' => 'Personparent',
																		'foreignKey' => 'person_id',
																		'conditions' => array('Mom.type' => 'MOTHER')
																	)
												);

	//public $hasOne = 'Membership';

	public $hasMany = 'Personparent';

	public $belongsTo = array('Picture', 'Contactaddress');

}
