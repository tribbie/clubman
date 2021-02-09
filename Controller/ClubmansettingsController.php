<?php
class ClubmansettingsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	public $helpers = array('Link');

	public function setseason() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$newSeason = $this->request->data['Clubmansettings']['newseason'];
			/// writes runtime configuration
			$settingrc = Configure::write('Clubman.currentseason', $newSeason);
			/// dumps partial configuration into the given file
			$settingrc = Configure::dump('clubman/clubman.php', 'default', array('Clubman'));
			if ($settingrc) {
				$this->Session->setFlash(__('De instelling werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'clubmansetting', 0);
				/// I hope this reloads the config so that it is directly visible
				Configure::load('clubman/clubman', 'default', true);
				$this->currentClubman = Configure::read('Clubman');
				$this->redirect(array('controller' => 'clubmansettings', 'action' => 'view'));
			} else {
				$this->Session->setFlash(__('De instelling kon niet worden bewaard.'), "flash-error");
			}
		} else {
			/// Load other models
			$this->loadModel('Team');
			$this->Team->recursive = 0;
			//$queryoptions = array(
    	//	'fields' => array('DISTINCT (Team.season) AS my_column_name'),
    	//	'order' =>array('Team.season DESC')
			//);
			//$seasons = $this->Team->find('all', $queryoptions);
			$seasons = $this->Team->query("SELECT DISTINCT season FROM cm_teams GROUP BY season;");
			$flatseasons = Hash::flatten($seasons);
			$this->set('flatseasons', $flatseasons);
			$this->set('seasons', $seasons);
			$season = $this->currentSeason;
			$this->set('season', $season);
		}
	}


	public function setlogins() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$newallowlogin = $this->request->data['Clubmansettings']['allowlogin'];
			/// writes runtime configuration
			$settingrc = Configure::write('Clubman.allowlogin', $newallowlogin);
			/// dumps partial configuration into the given file
			$settingrc = Configure::dump('clubman/clubman.php', 'default', array('Clubman'));
			if ($settingrc) {
				$this->Session->setFlash(__('De instelling werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'clubmansetting', 0);
				/// I hope this reloads the config so that it is directly visible
				Configure::load('clubman/clubman', 'default', true);
				$this->currentClubman = Configure::read('Clubman');
				$this->redirect(array('controller' => 'clubmansettings', 'action' => 'view'));
			} else {
				$this->Session->setFlash(__('De instelling kon niet worden bewaard.'), "flash-error");
			}
		} else {
			$season = $this->currentSeason;
			$this->set('season', $season);
			$allowloginoptions = array("no" => "Neen (alleen root)", "yes" => "Ja (actieve gebruikers)");
			$this->set('allowloginoptions', $allowloginoptions);
			$currentallowlogin = $this->allowLogin;
			$this->set('currentallowlogin', $currentallowlogin);
		}
	}


	public function view() {
		$this->set('clubman', $this->currentClubman);
		$this->set('club', $this->cmclub);
	}


	public function configure($direction = "read") {
		if ($direction == "read") {
			/// re-reads partial configuration
			Configure::load('clubman/club', 'default', true);
		} elseif ($direction == "dump") {
			/// dumps the complete configuration into the given file
			Configure::dump('clubman_complete_config_dump.php', 'default');
			Configure::dump('clubman/clubman_partial_config.php', 'default', array('Clubman'));
			Configure::dump('clubman/club_partial_config.php', 'default', array('Club'));
			$this->Session->setFlash(__('Configuratie werd gedumpt'), 'flash-info');
		} else {
			//$this->currentClubman = Configure::read('Clubman');
			$this->Session->setFlash(__('Deze optie wordt niet ondersteund'), 'flash-error');
		}
	}


	public function update($settingsection = null, $settingname = null, $settingvalue = null) {
		if ($this->request->is('post') || $this->request->is('put')) {
			$itemname = $this->request->data['Clubmansetting']['settingname'];
			$itemvalue = $this->request->data['Clubmansetting']['settingvalue'];
			if ($this->Clubmansetting->saveOneSetting($itemname, $itemvalue)) {
				$this->Session->setFlash(__('De setting werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'setting', 0);
				// next appears to be needed for immediate refresh
				$this->cmclub = Configure::read('Club');
			} else {
				$this->Session->setFlash(__('De setting kon niet worden bewaard.'), "flash-error");
			}
		} else {
			//$this->Session->setFlash(__('Deze aanpassing wordt niet ondersteund'), 'flash-error');
		}
		$this->set('clubman', $this->currentClubman);
		$this->set('club', $this->cmclub);
		$settingnames = array();
		foreach (array_keys($this->cmclub) as $sk) {
			$settingnames[$sk] = $sk;
		};
		$this->set('settingnames', $settingnames);
		$req = $this->request->query;
		$this->set('req', $req);
		$reqdata = $this->request->data;
		$this->set('reqdata', $reqdata);
		//return $this->redirect(array('action' => 'view'));
	}

	// This does not work
	public function viewclubmanschema() {
		$db = $this->getDataSource();
		$schemaselect = "SELECT table_name, ordinal_position, column_name, COLUMN_TYPE, IS_NULLABLE, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'clubman' ORDER BY table_name, ordinal_position";
		$clubmanschema = $db->fetchAll('SELECT * from cm_users');
		$this->set('clubmanschema', $clubmanschema);
	}


}
