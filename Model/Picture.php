<?php
class Picture extends AppModel {
	public $name = 'Picture';

	public $displayField = 'location';

	public function beforeFind($queryData) {
		parent::beforeFind($queryData);
// next line replaced by 2 if statements above (check belongsTo in Member model) 
		$defaultConditions = array('Picture.season' => Configure::read('Clubman.currentseason'));
//		if (substr($queryData['fields'][0], 0, 8) == 'Picture.') {
//			$defaultConditions = array('Picture.season' => Configure::read('Clubman.currentseason'));
//		}
		if (substr($queryData['fields'][0], 0, 15) == 'Picturelicense.') {
			$defaultConditions = array('Picturelicense.season' => Configure::read('Clubman.currentseason'));
		}
		$queryData['conditions'] = is_array($queryData['conditions']) ? array_merge($queryData['conditions'], $defaultConditions) : $defaultConditions;
		return $queryData;
	}

}
