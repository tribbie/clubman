<?php
class Upload extends AppModel {
	public $name = 'Upload';

	public $virtualFields = array(
			'created_nice' => 'date_format(Upload.created, "%d/%m/%Y")',
			'stamp_nice' => 'date_format(Upload.stamp, "%d/%m/%Y")',
		);

	var $validate = array(
		'name' => array('rule' => 'notBlank'),
		'category' => array('rule' => 'notBlank')
	);

}
?>
