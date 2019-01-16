<?php
class Enquete extends AppModel {
	public $name = 'Enquete';

	public $belongsTo = 'Member';
	
/** 
 * Initializes the filter to only get info for the "current season" 
 *	The "current season" is set in the globally defined configuration (in core.php)
 *	The "current season" is also implemented in the AppController (as property currentSeason)
 * 
 */ 

// For the enquetes, we will be applying the following logic:
// - if none is sprecified, the current season applies
// - otherwise, a season will need be add a the end of the url
// - the specific controller functions will need to take care of retrieving the correct records
// So no beforefind to only include current season ...    
//	public function beforeFind($queryData) {
//		parent::beforeFind($queryData);
//		$defaultConditions = array('Enquete.season' => Configure::read('Clubman.currentseason'));
//		$queryData['conditions'] = is_array($queryData['conditions']) ? array_merge($queryData['conditions'], $defaultConditions) : $defaultConditions;
//		return $queryData;
//	}

}
?>
