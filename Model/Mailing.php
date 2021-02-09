<?php
class Mailing extends AppModel {
	public $name = 'Mailing';
	public $actsAs = array('Containable');

	public $hasMany = 'Mail';

}
?>
