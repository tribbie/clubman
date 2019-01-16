<?php
class Coach extends AppModel {
	public $name = 'Coach';

	public $useTable = 'teammembers';

	public $displayField = 'copy_member_name';

	public $belongsTo = array('Member');

}
