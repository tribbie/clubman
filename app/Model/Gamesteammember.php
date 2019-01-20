<?php
class Gamesteammember extends AppModel {
	public $name = 'Gamesteammember';
	
	public $belongsTo = array('Teammember', 'Game');

}
