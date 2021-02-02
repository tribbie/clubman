<?php
class Clubmansetting extends AppModel {
	public $name = 'Clubmansetting';

	public $useTable = false;

	public function saveOneSetting($settingname = null, $settingvalue = null) {
		$settingsection = 'club';
		if (($settingname == null) or ($settingvalue == null)) {
			/// no change will occur
			return false;
		} else {
			/// filename backup configuration
			$nowFile = "club_config_".strtotime('now').".php";
			/// backup the current club configuration into a timestamped version
			Configure::dump("clubman/$nowFile", 'default', array('Club'));
			/// set the new variable
			Configure::write('Club.'.$settingname, $settingvalue);
			/// overwrite the club configuration into the given file
			Configure::dump('clubman/club.php', 'default', array('Club'));
			return true;
		}
	}

}
