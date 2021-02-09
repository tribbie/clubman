<?php
class Personparent extends AppModel {

	public $name = 'Personparent';

	public $belongsTo = array('Person',
														'Parent' => array(
													            'className' => 'Person',
													            'foreignKey' => 'parent_id'
																		)
        										);

}
