<?php
class Trainingmomentsteammember extends AppModel {
	public $name = 'Trainingmomentsteammember';

	public $belongsTo = array('Trainingmoment', 'Teammember');

}
