<?php
class Metering extends AppModel {
	public $name = 'Metering';

	public $validate = array(
		'member_id' => array('rule' => 'notBlank', 'message' => 'Je moet een lid kiezen.'),
	);

	public $belongsTo = array('Member');

}
?>
