<?php
class Trainingsteammember extends AppModel {
	public $name = 'Trainingsteammember';
	
	public $belongsTo = array('Teammember', 'Training');

}
