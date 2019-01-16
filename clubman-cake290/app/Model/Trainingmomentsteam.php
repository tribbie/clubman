<?php
class Trainingmomentsteam extends AppModel {
	public $name = 'Trainingmomentsteam';

//	public $virtualFields = array('name' => 'Team.name');
//	public $displayField = 'copy_member_name';

	public $belongsTo = array('Trainingmoment', 'Team');

}
