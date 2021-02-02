<?php
class EnquetesController extends AppController {

	/// Include the RequestHandler, it makes sure the proper layout and views files are used (for csv and pdf)
	/// Also check your routes.php for Router::parseExtensions('pdf', 'csv');
	var $components = array('RequestHandler');


	public function beforeFilter() {
		parent::beforeFilter();
		/// normal
		$this->Auth->allow('vulin');
		/// during testing
		//$this->Auth->allow('index', 'vulin', 'toon', 'lijst', 'toon_formulier', 'export', 'toon_vrijetekst');
	}


	public function index() {
		$enqueteSeasons = $this->Enquete->find('all', array('fields' => array('DISTINCT season'), 'order' => 'season DESC'));
		$this->set('enqueteSeasons', $enqueteSeasons);
	}


	public function generate() {
		if (!isset($enqueteSeason)) {
			$enqueteSeason = $this->currentSeason;
		}
		$teamcategorielist = '';
		$teammemberenquetes = array();
		$memberlist = array();
		$selectedmembers = array();
		$generatedenquetes = array();
		if ($this->request->is('post') || $this->request->is('put')) {
			/// If the preview button was pressed, we prepare the list of selected members
			if (isset($this->request->data['preview'])) {
				$teamcategorielist = $this->request->data['Enquete']['teamcategories'];
				$this->loadModel('Teammember');
				$this->Teammember->recursive = 1;
				$this->Teammember->unbindModel(array('hasMany' => array('Trainingsteammember', 'Gamesteammember'), 'belongsTo' => array('Picture')));
				/// Here we exclude the BEKER teams because their players were all additional prio 1 players (which shouldn't be)
				/// So to avoid double enquetes and double mails ... we exclude the BEKER teams all together
				$conditions = array('Teammember.teampriority' => 1, 'Team.series <>' => 'beker',  'Team.category' => $teamcategorielist);
				$teammemberenquetes = $this->Teammember->find('all', array('conditions' => $conditions, 'order' => array('Team.name' => 'ASC', 'Member.name' => 'ASC')));
				if (count($teammemberenquetes) > 0) {
					foreach ($teammemberenquetes as $member) {
						$memberlist[$member['Teammember']['id']] = $member['Member']['name'] . ' (' . $member['Team']['name'] . ')';
					}
				}
			}
			/// If the generate button was pressed, we ... hmmm ... generate
			if (isset($this->request->data['generate'])) {
				$generatelist = $this->request->data['Enquete']['memberlistresult'];
				$this->loadModel('Teammember');
				$this->Teammember->recursive = 1;
				$this->Teammember->unbindModel(array('hasMany' => array('Trainingsteammember', 'Gamesteammember'), 'belongsTo' => array('Picture')));
				$conditions = array('Teammember.id' => $generatelist);
				$generatememberlist = $this->Teammember->find('all', array('conditions' => $conditions, 'order' => array('Team.name' => 'ASC', 'Member.name' => 'ASC')));
				if (count($generatememberlist) > 0) {
					foreach ($generatememberlist as $member) {
						$generatedenquetes[] = array(
							'id' => hash('md5', $enqueteSeason . $member['Teammember']['id'] . $member['Team']['name'] . $member['Teammember']['member_id']),
							'member_id' => $member['Teammember']['member_id'],
							'teammember_id' => $member['Teammember']['id'],
							'team_id' => $member['Teammember']['team_id'],
							'team_prio' => $member['Teammember']['teampriority'],
							'season' => $enqueteSeason,
							'algemeen_seizoen' => $member['Team']['season'],
							'algemeen_naam' => $member['Member']['name'],
							'algemeen_ploeg' => $member['Team']['name'],
							'mail_ik' => $member['Member']['email'],
							'mail_mama' => $member['Member']['mom_email'],
							'mail_papa' => $member['Member']['dad_email'],
							'modified' => false
						);
					}
					if ($this->Enquete->saveMany($generatedenquetes)) {
						$this->Session->setFlash(count($generatedenquetes) . ' enquetes werden gegenereerd.', "flash-info");
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash('De enquetes konden niet worden bewaard.', "flash-error");
					}
				}
			}
		}
		$this->loadModel('Team');
		$this->Team->recursive = 0;
		$teamcategories = $this->Team->find('list', array('fields' => array('Team.category', 'Team.category'), 'conditions' => array('Team.category <>' => ''), 'order' => array('Team.name' => 'ASC')));
		$this->set('teamcategorielist', $teamcategorielist);
		$this->set('teamcategories', $teamcategories);
		$this->set('enqueteSeason', $enqueteSeason);
		$this->set('teammemberenquetes', $teammemberenquetes);
		$this->set('memberlist', $memberlist);
		$this->set('selectedmembers', $selectedmembers);
		$this->set('generatedenquetes', $generatedenquetes);
	}


	public function lijst($enqueteSeason = null) {
		if (!$enqueteSeason) {
			$enqueteSeason = $this->currentSeason;
		}
		$this->set('enquetes', $this->Enquete->find('all', array('conditions' => array('season' => $enqueteSeason), 'recursive' => -1, 'order' => array('algemeen_naam', 'algemeen_ploeg'))));
		$this->set('enqueteSeason', $enqueteSeason);
	}


	public function delete($id = null) {
		if (isset($id)) {
			$this->Enquete->id = $id;
			if (!$this->Enquete->exists()) {
				$this->Session->setFlash(__('Deze enquete bestaat niet. Er werd geen enquete verwijderd.'), "flash-error");
			} else {
				$algemeen_naam = $this->Enquete->field('algemeen_naam');
				if ($this->Enquete->field('season') == $this->currentSeason) {
					if ($this->Enquete->field('modified') == $this->Enquete->field('created')) {
						if ($this->Enquete->delete($id, true)) {
							$this->Session->setFlash(__('De enquete van ' . $algemeen_naam . ' werd verwijderd.'), "flash-info");
							parent::logAction(__FUNCTION__, 'enquete', $id);
						} else {
							$this->Session->setFlash(__('De enquete kon niet verwijderd worden.'), "flash-error");
						}
					} else {
						$this->Session->setFlash(__('De enquete is reeds ingevuld. Deze kan niet verwijderd worden.'), "flash-error");
					}
				} else {
					$this->Session->setFlash(__('De enquete is niet van het huidige seizoen.'), "flash-error");
				}
			}
		} else {
			$this->Session->setFlash(__('Geen enquete meegegeven om te verwijderen'), "flash-error");
		}
		$this->redirect(array('controller' => 'enquetes', 'action' => 'lijst'));
	}


	public function vulin($id = null, $enqueteSeason = null) {
		/// This theme is the temporary way of enabling the enquetes for everyone
		$this->theme = 'Clubman';
		$this->layout = 'enquete';
		if (!$enqueteSeason) {
			$enqueteSeason = $this->currentSeason;
		}
		$this->Enquete->id = $id;
		//$enquete = $this->Enquete->read(null, $id);
		if (!$this->Enquete->exists()) {
			throw new NotFoundException(__('Enqueteformulier niet gevonden.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($enqueteSeason <> $this->currentSeason) {
				$this->Session->setFlash('Deze enquete kan niet meer worden bewaard.', "flash-error");
				$this->redirect('/');
			}
			if ($this->Enquete->save($this->request->data)) {
				$this->Session->setFlash('Enquete werd bewaard.', "flash-info");
				$this->redirect('/');
			} else {
				$this->Session->setFlash('De enquete kon niet worden bewaard.', "flash-error");
			}
		} else {
			$this->request->data = $this->Enquete->read();
		}
		$this->set('enqueteSeason', $enqueteSeason);
	}


	public function toon($id = null) {
		$this->Enquete->id = $id;
		if (!$this->Enquete->exists()) {
			throw new NotFoundException(__('Enquete niet gevonden.'));
		}
		$enquete = $this->Enquete->read();
		$this->set('enquete', $enquete);
		$enqueteSeason = $enquete['Enquete']['season'];
		$this->set('enqueteSeason', $enqueteSeason);
	}


	public function export($enqueteSeason = null) {
		if (!$enqueteSeason) {
			$enqueteSeason = $this->currentSeason;
		}
		$this->set('enquetes', $this->Enquete->find('all',
		                         array('conditions' => array('season' => $enqueteSeason),
                                     'fields' => array('id', 'modified', 'algemeen_seizoen', 'algemeen_naam',
																												'algemeen_ploeg',
																												'algemeen_ploeg_tevreden',
																												'algemeen_score_huidige_ploegsfeer',
																												'algemeen_score_huidige_trainer',
																												'algemeen_dubbelploeg',
																												'algemeen_volgendseizoenploeg',
																												'algemeen_positie_keuze_1',
																												'algemeen_positie_keuze_2',
																												'algemeen_volgendseizoendubbelploeg',
																												'training_aantal',
																												'training_ma19002100',
																												'training_di17301900',
																												'training_di20002200',
																												'training_wo16001700',
																												'training_wo17001830',
																												'training_wo18002000',
																												'training_wo18302000',
																												'training_do20002200',
																												'training_vr17001900',
																												'training_vr17301900',
																												'training_vr19002100',
																												'training_locatie_elders',
																												'training_verplaatsing',
																												'wedstrijd_aantal',
																												'engagement_steun_ouders',
																												'engagement_andere_activiteiten',
																												'engagement_prio_volleybal',
																												'gsm_ik',
																												'mail_ik', 'mail_ikfrequentie',
																												'gsm_mama',
																												'mail_mama', 'mail_mamafrequentie',
																												'gsm_papa',
																												'mail_papa', 'mail_papafrequentie',
																												'begeleiding_pvmama', 'begeleiding_pvpapa', 'begeleiding_pvandere',
																												'organisatie_naam', 'organisatie_taak',
																												'volley_leuk'
		                                                ),
		                               'recursive' => -1, 'order' => array('algemeen_naam'))));
	}


	public function toon_vrijetekst($enqueteSeason = null) {
		if (!$enqueteSeason) {
			$enqueteSeason = $this->currentSeason;
		}
		$this->set('enquetes', $this->Enquete->find('all',
		                         array('conditions' => array('season' => $enqueteSeason),
                                     'fields' => array('id', 'modified', 'algemeen_naam', 'diversen_tekst'),
		                               'recursive' => -1, 'order' => array('algemeen_naam'))));
		$this->set('enqueteSeason', $enqueteSeason);
	}

}
?>
