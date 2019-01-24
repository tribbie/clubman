<?php
class GamesController extends AppController {

	//var $scaffold;

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('shortoverview', 'overview', 'changes', 'forpasseurke');
		//$this->Auth->deny('index');
	}


	public function index() {
		$this->Game->recursive = 1;
		$this->set('games', $this->Game->find('all', array('order' => array('Game.game_date' => 'ASC', 'Game.game_time' => 'ASC','Team.display_order' => 'ASC'))));
	}


	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Deze wedstrijd bestaat niet.', true), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
		$this->Game->id = $id;
		/// Unbinding vastly reduces the recursion effect (I need recursive=3 for the name of the coach)
		$this->Game->Team->unbindModel(array('hasMany' => array('Game', 'Training', 'Trainingmomentsteam', 'Teammember'), 'belongsTo' => array('Picture')));
		$this->Game->Coach->Member->unbindModel(array('hasMany' => array('Teammember', 'Coach', 'User')));
		$this->Game->Gamesteammember->unbindModel(array('belongsTo' => array('Game')));
		$this->Game->Gamesteammember->Teammember->unbindModel(array('belongsTo' => array('Team'), 'hasMany' => array('Trainingsteammember', 'Gamesteammember')));
		$this->Game->recursive = 3;
		$game = $this->Game->read();
		$this->set('game', $game);
	}


	public function add($teamid = null) {
		if (isset($this->params['named']['team'])) {
			$teamid = $this->params['named']['team'];
		}
		if ($teamid == null) {
			$this->Session->setFlash(__('Je moet dit via een team doen.'), "flash-error");
			$this->redirect(array('controller' => 'teams', 'action' => 'index'));
		} else {
			if ($this->request->is('post') || $this->request->is('put')) {
				/// To prevent from game_referee becoming NULL, we make it empty
				if (!isset($this->request->data['Game']['game_referee'])) $this->request->data['Game']['game_referee'] = '';
				if ($this->Game->save($this->request->data)) {
					$this->Session->setFlash(__('De wedstrijd werd bewaard.'), "flash-info");
					parent::logAction(__FUNCTION__, 'game', $this->Game->id);
					$this->redirect(array('controller' => 'teams', 'action' => 'view', $teamid));
				} else {
					$this->Session->setFlash(__('De wedstrijd kon niet worden bewaard.'), "flash-error");
				}
			}
			$this->request->data['Game']['team_id'] = $teamid;
			$this->loadModel('Team');
			/// We only get the current team (as provided in the url), so no team selection dropdown (because the list of coaches does not adapt the selection of another team)!
			$this->Team->recursive = -1;
			$this->set('team', $this->Game->Team->find('first', array('fields' => array('Team.id', 'Team.name'), 'conditions' => array('Team.id' => $teamid))));
			/// Retrieve the teammembers of the team with priority = 0 to get a shortlist for coaches
			$this->Team->recursive = 1;
			$this->Team->id = $teamid;
			$teammembers = $this->Team->Teammember->find('all',
							array('fields' => array('Teammember.id', 'Teammember.teampriority', 'Member.id', 'Member.lastname', 'Member.firstname'),
								'conditions' => array('Teammember.team_id' => $teamid, 'Teammember.teampriority' => 0),
								'order' => array('Teammember.teampriority', 'Member.lastname', 'Member.firstname')
								));
			//$this->set('teammembers', $teammembers);
			$game_coaches = array();
			foreach ($teammembers as $teammember) {
				$game_coaches[$teammember['Teammember']['id']] = $teammember['Member']['lastname'] . ' ' . $teammember['Member']['firstname'];
			}
			$this->set('game_coaches', $game_coaches);
			$this->set('game_codes', array('beker' => 'Bekerwedstrijd', 'competitie' => 'Competitie', 'tornooi' => 'Tornooi', 'oefenmatch' => 'Oefenwedstrijd'));
			//$this->set('teammembers', $teammembers);
		}
	}


	public function edit($id = null) {
		if ($id == null) {
			$this->Session->setFlash(__('Geen wedstrijd gekozen.'), "flash-error");
			$this->redirect(array('controller' => 'teams', 'action' => 'index'));
		} else {
			$game = $this->Game->findById($id);
			$teamid = $game['Game']['team_id'];
			if (empty($this->request->data)) {
				$this->request->data = $game;
			} else {
				/// Save logic goes here
				if ($this->Game->save($this->request->data)) {
					$this->Session->setFlash(__('De wedstrijd werd bewaard.'), "flash-info");
					parent::logAction(__FUNCTION__, 'game', $id);
					$this->redirect(array('controller' => 'teams', 'action' => 'view', $teamid));
				} else {
					$this->Session->setFlash(__('De wedstrijd kon niet worden bewaard.'), "flash-error");
				}
			}
			/// Retrieve the teammembers of the team with priority = 0 to get a shortlist for coaches
			$this->loadModel('Team');
			$this->Team->id = $teamid;
			$teammembers = $this->Team->Teammember->find('all',
							array('fields' => array('Teammember.id', 'Teammember.teampriority', 'Member.id', 'Member.lastname', 'Member.firstname'),
								'conditions' => array('Teammember.team_id' => $teamid, 'Teammember.teampriority' => 0),
								'order' => array('Teammember.teampriority', 'Member.lastname', 'Member.firstname')
								));
			$game_coaches = array();
			foreach ($teammembers as $teammember) {
				$game_coaches[$teammember['Teammember']['id']] = $teammember['Member']['lastname'] . ' ' . $teammember['Member']['firstname'];
			}
			$this->set('game_coaches', $game_coaches);
			$this->set('teams', $this->Game->Team->find('list'));
			$this->set('game_codes', array('beker' => 'Bekerwedstrijd', 'competitie' => 'Competitie', 'tornooi' => 'Tornooi', 'oefenmatch' => 'Oefenwedstrijd'));
			$this->set('game_changes', array('verplaatst' => 'verplaatst', 'te verplaatsen' => 'te verplaatsen', 'vervroegd' => 'vervroegd', 'verlaat' => 'verlaat', 'afgelast' => 'afgelast'));
		}
	}


	public function delete($id = null) {
		if (isset($id)) {
			$this->Game->id = $id;
			if (!$this->Game->exists()) {
				$this->Session->setFlash(__('Deze wedstrijd bestaat niet. Er werd geen wedstrijd verwijderd.'), "flash-error");
				$this->redirect(array('controller' => 'teams', 'action' => 'index'));
			} else {
				$this->Game->recursive = 3;
				/// Unbinding from the team down vastly reduces the recursion=2 effect (I need recursive=2 for the names of the coaches)
				$this->Game->Team->unbindModel(array('belongsTo' => array('Picture'), 'hasMany' => array('Teammember', 'Training', 'Game', 'Trainingmomentsteam')));
				$this->Game->Gamesteammember->unbindModel(array('belongsTo' => array('Game')));
				$this->Game->Gamesteammember->Teammember->unbindModel(array('belongsTo' => array('Team'), 'hasMany' => array('Trainingsteammember', 'Gamesteammember')));
				$game = $this->Game->read();
				$teamid = $game['Team']['id'];
				if ($this->request->is('post')) {
					if ($this->Game->delete($id, true)) {
						$this->Session->setFlash(__('De wedstrijd werd verwijderd.'), "flash-info");
						parent::logAction(__FUNCTION__, 'game', $id);
						$this->redirect(array('controller' => 'teams', 'action' => 'view', $teamid));
					} else {
						$this->Session->setFlash(__('De wedstrijd kon niet verwijderd worden.'), "flash-error");
						//$this->redirect(array('action' => 'profile'));
					}
				}
				$this->set('game', $game);
			}
		} else {
			$this->Session->setFlash(__('Geen wedstrijd meegegeven om te verwijderen'), "flash-error");
			//$this->redirect(array('action' => 'index'));
		}
	}


	public function reports() {
	}


	public function presences($id = null) {
		/// Retrieve the game info
		$this->Game->id = $id;
		$game = $this->Game->read();
		$this->set('game', $game);
		$this->loadModel('Gamesteammember');
		$gamesteammembers = $this->Gamesteammember->find('all', array('conditions' => array('Gamesteammember.game_id' => $this->Game->id)));
		$this->set('gamesteammembers', $gamesteammembers);
		/// Retrieve the teammembers of the team (minus the "gestopten")
		$this->loadModel('Team');
		$this->Team->id = $game['Game']['team_id'];
		$teammembers = $this->Team->Teammember->find('all',
                         array('fields' => array('Teammember.id', 'Teammember.teampriority', 'Member.id', 'Member.lastname', 'Member.firstname'),
                               'conditions' => array('Teammember.team_id' => $game['Game']['team_id'], 'Teammember.teampriority >' => 0, 'Teammember.teampriority <>' => 99),
                               'order' => array('Teammember.teampriority', 'Member.lastname', 'Member.firstname')
                               ));
		/// Build up array with presences
		$thepresences = array();
		foreach ($teammembers as $teammember) {
			unset($existingpresence);
			foreach ($gamesteammembers as $gamesteammember) {
				if ($gamesteammember['Gamesteammember']['teammember_id'] == $teammember['Teammember']['id']) {
					$existingpresence = $gamesteammember['Gamesteammember'];
				}
			}
			$thisid = (isset($existingpresence['id'])) ? $existingpresence['id'] : '';
			$thisseason = (isset($existingpresence['season'])) ? $existingpresence['season'] : $this->currentSeason;
			$thisstatus = (isset($existingpresence['status'])) ? $existingpresence['status'] : '';
			$thisremark = (isset($existingpresence['remark'])) ? $existingpresence['remark'] : '';
			$thepresences[] = array(
								'id' => $thisid,
								'season' => $thisseason,
								'member_id' => $teammember['Member']['id'],
								'name' => $teammember['Member']['lastname'] . ' ' . $teammember['Member']['firstname'],
								'teammember_id' => $teammember['Teammember']['id'],
								'game_id' => $this->Game->id,
								'status' => $thisstatus,
								'remark' => $thisremark
								);
		}
		/// Retrieve the coaches of the team
		$teamcoaches = $this->Team->Teammember->find('all',
                         array('fields' => array('Teammember.id', 'Teammember.teampriority', 'Member.id', 'Member.lastname', 'Member.firstname'),
                               'conditions' => array('Teammember.team_id' => $game['Game']['team_id'], 'Teammember.teampriority' => 0),
                               'order' => array('Member.lastname', 'Member.firstname')
                               ));
		$this->set('teamcoaches', $teamcoaches);
		/// Build up array with presences
		$thecoaches = array();
		foreach ($teamcoaches as $teamcoach) {
			$thecoaches[$teamcoach['Teammember']['id']] = $teamcoach['Member']['lastname'] . ' ' . $teamcoach['Member']['firstname'];
		}
		$this->set('game_coaches', $thecoaches);
		$this->set('thepresences', $thepresences);
		$this->set('teammembers', $teammembers);
		if ($this->request->is('post')) {
			/// Put the form data into a variable
			$formdata = $this->request->data;
			$this->loadModel('Gamesteammember');
			if ($this->Gamesteammember->saveMany($formdata['Gamesteammember'])) {
				if ($this->Game->save($formdata['Game'])) {
					$this->Session->setFlash('De wedstrijd werd bewaard.', "flash-info");
					parent::logAction(__FUNCTION__, 'game', $this->Game->id);
					$this->redirect(array('controller' => 'teams', 'action' => 'view', $this->Team->id));
				} else {
					$this->Session->setFlash('De wedstrijd werd niet correct bewaard.', "flash-error");
				}
			} else {
				$this->Session->setFlash('De aanwezigheden werden niet correct bewaard.', "flash-error");
			}
			$this->set('formdata', $formdata);
		} else {
		}
	}


	public function overview($category = null, $datefrom = null, $dateto = null) {
		if ($this->loggedIn) {
			/// Do not change the default
		} else {
			$this->layout = 'logoonly';
		}
		$this->set('weekd', array('Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'));
		if (!$datefrom) $datefrom = $this->currentYears[0].'-08-01';
		if (!$dateto)   $dateto   = $this->currentYears[1].'-07-31';
		if ($category == 'week') {
			$datestart = strtotime('Monday this week');
			$datefrom = date("Y-m-d", $datestart);
			$dateto   = date("Y-m-d", strtotime('next monday', $datestart)-1);
		}
		$this->set('period', array('datefrom' => $datefrom, 'dateto' => $dateto));
		$fields = array(
									'Game.game_code', 'Game.game_change', 'Game.day_of_week', 'Game.game_date', 'Game.game_time',
									'Game.game_referee', 'Game.game_marker', 'Game.game_scoreboard',
									'Game.game_hall', 'Game.game_home', 'Game.game_away', 'Game.remark',
								);
		$baseconditions = array('Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto);
		$order = array('Game.game_date', 'Game.game_time', 'Game.team_id');
		/// Containable (like unbind) also vastly reduces the recursion effect (I need Game->GamesTeammember->Teammember->Member['name'])
		/// Plus it facilitates the fetching of only the wanted fields in associated models
		/// Containable magic
		$this->Game->Behaviors->load('Containable');
		$contain = array(
        'Team' => array(
            'fields' => array('id', 'name', 'shortname', 'mininame')
        ),
        'Coach' => array(
					'fields' => array('id', 'member_id'),
					'Member' => array(
						'fields' => array('id', 'firstname', 'lastname', 'name')
					)
        ),
				'Gamesteammember' => array(
					'fields' => array('id', 'teammember_id', 'game_id', 'status'),
					'conditions' => array('status' => 'aanwezig'),
					'Teammember' => array(
						'fields' => array('id', 'member_id', 'team_id', 'teamfunction', 'teampriority'),
						'Member' => array(
							'fields' => array('id', 'firstname', 'lastname', 'name')
						)
					)
				)
    );
		if ($category == 'all') {
			$additionalconditions = array();
			$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'allemaal'));
		} elseif ($category == 'week') {
			$additionalconditions = array();
			$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'deze week'));
		} elseif ($category == 'beker') {
			$additionalconditions = array('Game.game_code' => 'beker');
			$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'beker'));
		} elseif ($category == 'jeugd') {
			$additionalconditions = array('Team.gender' => array('meisjes', 'jongens', 'gemengd'));
			$teaminfo = array('Team' => array('name' => 'jeugd', 'competition' => 'allemaal'));
		} elseif ($category == 'seniors') {
			$additionalconditions = array('Team.category' => 'Seniors');
			$teaminfo = array('Team' => array('name' => 'seniors', 'competition' => 'allemaal'));
		} elseif ($category == 'jeugdbeker') {
			$additionalconditions = array('Team.gender' => array('meisjes', 'jongens', 'gemengd'), 'Game.game_code' => 'beker');
			$teaminfo = array('Team' => array('name' => 'jeugd', 'competition' => 'beker'));
		} elseif ($category == 'seniorsbeker') {
			$additionalconditions = array('Team.category' => 'Seniors', 'Game.game_code' => 'beker');
			$teaminfo = array('Team' => array('name' => 'seniors', 'competition' => 'beker'));
		} else {
			$additionalconditions = array('Game.team_id' => $category);
			$this->loadModel('Team');
			$teaminfo = $this->Team->find('first', array('conditions' => array('Team.id' => $category), 'recursive' => -1, 'fields' => array('id', 'name', 'competition')));
		}
		$allconditions = array_merge($baseconditions, $additionalconditions);
		$thegames = $this->Game->find('all', array('fields' => $fields, 'contain' => $contain, 'conditions' => $allconditions, 'order' => $order));
		//$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'allemaal'));
		$this->set('team', $teaminfo);
		$this->set('games', $thegames);
	}


	public function shortoverview($category = null, $datefrom = null, $dateto = null) {
		if ($this->loggedIn) {
			/// Do not change the default
		} else {
			$this->layout = 'logoonly';
		}
		$this->set('weekd', array('Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'));
		if (!$datefrom) $datefrom = $this->currentYears[0].'-08-01';
		if (!$dateto)   $dateto   = $this->currentYears[1].'-07-31';
		if ($category == 'week') {
			$datestart = strtotime('Monday this week');
			$datefrom = date("Y-m-d", $datestart);
			$dateto   = date("Y-m-d", strtotime('next monday', $datestart)-1);
		}
		$this->set('period', array('datefrom' => $datefrom, 'dateto' => $dateto));

		/// NO MORE UNBINDING - "containable" is the new and better "unbunding"
		/// Unbinding vastly reduces the recursion effect (I need recursive=2 for the names of the coaches)
		//$this->Game->Team->unbindModel(array('hasMany' => array('Game', 'Training', 'Trainingmomentsteam', 'Teammember'), 'belongsTo' => array('Picture')));
		//$this->Game->unbindModel(array('hasMany' => array('Gamesteammember')));

		$fields = array(
									'Game.game_code', 'Game.game_change', 'Game.day_of_week', 'Game.game_date', 'Game.game_time',
									'Game.game_home', 'Game.game_away', 'Game.remark'
								);
		$baseconditions = array('Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto);
		$order = array('Game.game_date', 'Game.game_time', 'Game.team_id');
		/// Containable (like unbind) also vastly reduces the recursion effect (I need Game->GamesTeammember->Teammember->Member['name'])
		/// Plus it facilitates the fetching of only the wanted fields in associated models
		/// Containable magic
		$this->Game->Behaviors->load('Containable');
		$contain = array(
        'Team' => array(
            'fields' => array('id', 'name', 'shortname', 'mininame')
        ),
        'Coach' => array(
					'fields' => array('id', 'member_id'),
					'Member' => array(
						'fields' => array('id', 'firstname', 'lastname', 'name')
					)
        )
    );
		if ($category == 'all') {
			//$thegames = $this->Game->find('all', array('conditions' => array('Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time', 'Game.team_id')));
			//$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'allemaal'));
			$additionalconditions = array();
			$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'allemaal'));
		} elseif ($category == 'week') {
			//$thegames = $this->Game->find('all', array('conditions' => array('Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time', 'Game.team_id')));
			//$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'deze week'));
			$additionalconditions = array();
			$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'deze week'));
		} elseif ($category == 'beker') {
			//$thegames = $this->Game->find('all', array('conditions' => array('Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto, 'Game.game_code' => 'beker'), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time', 'Game.team_id')));
			//$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'beker'));
			$additionalconditions = array('Game.game_code' => 'beker');
			$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'beker'));
		} elseif ($category == 'jeugd') {
			//$thegames = $this->Game->find('all', array('conditions' => array('Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto, 'Team.gender' => array('meisjes', 'jongens', 'gemengd')), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time', 'Game.team_id')));
			//$teaminfo = array('Team' => array('name' => 'jeugd', 'competition' => 'allemaal'));
			$additionalconditions = array('Team.gender' => array('meisjes', 'jongens', 'gemengd'));
			$teaminfo = array('Team' => array('name' => 'jeugd', 'competition' => 'allemaal'));
		} elseif ($category == 'seniors') {
			//$thegames = $this->Game->find('all', array('conditions' => array('Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto, 'Team.category' => 'Seniors'), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time', 'Game.team_id')));
			//$teaminfo = array('Team' => array('name' => 'seniors', 'competition' => 'allemaal'));
			$additionalconditions = array('Team.category' => 'Seniors');
			$teaminfo = array('Team' => array('name' => 'seniors', 'competition' => 'allemaal'));
		} elseif ($category == 'jeugdbeker') {
			//$thegames = $this->Game->find('all', array('conditions' => array('Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto, 'Team.gender' => array('meisjes', 'jongens', 'gemengd'), 'Game.game_code' => 'beker'), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time', 'Game.team_id')));
			//$teaminfo = array('Team' => array('name' => 'jeugd', 'competition' => 'beker'));
			$additionalconditions = array('Team.gender' => array('meisjes', 'jongens', 'gemengd'), 'Game.game_code' => 'beker');
			$teaminfo = array('Team' => array('name' => 'jeugd', 'competition' => 'beker'));
		} elseif ($category == 'seniorsbeker') {
			//$thegames = $this->Game->find('all', array('conditions' => array('Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto, 'Team.category' => 'Seniors', 'Game.game_code' => 'beker'), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time', 'Game.team_id')));
			//$teaminfo = array('Team' => array('name' => 'jeugd', 'competition' => 'beker'));
			$additionalconditions = array('Team.category' => 'Seniors', 'Game.game_code' => 'beker');
			$teaminfo = array('Team' => array('name' => 'seniors', 'competition' => 'beker'));
		} elseif ($category == 'thuis') {
			//$thegames = $this->Game->find('all', array('conditions' => array('Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto, 'Game.home_game' => 1), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time', 'Game.team_id')));
			//$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'alle thuiswedstrijden'));
			$additionalconditions = array('Game.home_game' => 1);
			$teaminfo = array('Team' => array('name' => 'allemaal', 'competition' => 'alle thuiswedstrijden'));
		} else {
			//$thegames = $this->Game->find('all', array('conditions' => array('Game.team_id' => $category, 'Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time')));
			//$this->loadModel('Team');
			//$teaminfo = $this->Team->find('first', array('conditions' => array('Team.id' => $category), 'recursive' => -1, 'fields' => array('id', 'name', 'competition')));
			$additionalconditions = array('Game.team_id' => $category);
			$this->loadModel('Team');
			$teaminfo = $this->Team->find('first', array('conditions' => array('Team.id' => $category), 'recursive' => -1, 'fields' => array('id', 'name', 'competition')));
		}
		$allconditions = array_merge($baseconditions, $additionalconditions);
		$thegames = $this->Game->find('all', array('fields' => $fields, 'contain' => $contain, 'conditions' => $allconditions, 'order' => $order));
		$this->set('team', $teaminfo);
		$this->set('games', $thegames);
	}


	public function changes($teamid = null, $datefrom = null) {
		if ($this->loggedIn) {
			/// Do not change the default
		} else {
			$this->layout = 'logoonly';
		}
		$this->set('weekd', array('Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'));
		if (!$datefrom) $datefrom = $this->currentYears[0].'-08-01';
		$this->set('period', array('datefrom' => $datefrom));
		if ($teamid) {
			$this->loadModel('Team');
			$teaminfo = $this->Team->find('first', array('conditions' => array('Team.id' => $teamid), 'recursive' => -1, 'fields' => array('id', 'name', 'competition')));
			/// Unbinding from the team down vastly reduces the recursion effect (I need recursive=2 for the names of the coaches)
			$this->Game->Team->unbindModel(array('hasMany' => array('Game', 'Training', 'Trainingmomentsteam', 'Teammember')));
			//$thegames = $this->Game->find('all', array('conditions' => array('Game.team_id' => $teamid, 'Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time')));
			$thegames = $this->Game->find('all', array('conditions' => array('Game.team_id' => $teamid, 'Game.game_date >=' => $datefrom, 'OR' => array('Game.game_change <>' => '', 'Game.game_code !=' => 'competitie')), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time')));
			$this->set('games', $thegames);
		} else {
			$teaminfo = array('Team' => array('full_name' => 'allemaal', 'competition' => 'allemaal'));
			$this->set('team', $teaminfo);
			/// Unbinding from the team down vastly reduces the recursion effect (I need recursive=2 for the names of the coaches)
			$this->Game->Team->unbindModel(array('hasMany' => array('Game', 'Training', 'Trainingmomentsteam', 'Teammember')));
			$thegames = $this->Game->find('all', array('conditions' => array('Game.game_date >=' => $datefrom, 'OR' => array('Game.game_change <>' => '', 'Game.game_code !=' => 'competitie')), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time', 'Game.team_id')));
			$this->set('games', $thegames);
		}
	}


	public function fortasks($teamid = 'all', $datefrom = null, $dateto = null) {
		$this->layout = 'logoonly';
		$this->set('weekd', array('Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'));
		$filterconditions = array();
		$filterconditions['Team.teamtype'] = 'volley';
		$filterconditions['Game.game_code'] = 'competitie';
		if ($teamid == 'all')  {
			$teaminfo = array('Team' => array('name' => 'alle teams', 'competition' => 'allemaal'));
		} elseif ($teamid == 'allthuis') {
			$filterconditions['Game.home_game'] = 1;
			$teaminfo = array('Team' => array('name' => 'alle [thuis]', 'competition' => 'allemaal'));
		} elseif ($teamid == 'jeugdthuis') {
			$filterconditions['Team.category <>'] = 'Seniors';
			$filterconditions['Game.home_game'] = 1;
			$teaminfo = array('Team' => array('name' => 'jeugd [thuis]', 'competition' => 'allemaal'));
		} elseif ($teamid == 'jeugd') {
			$filterconditions['Team.category <>'] = 'Seniors';
			$teaminfo = array('Team' => array('name' => 'jeugd', 'competition' => 'allemaal'));
		} elseif ($teamid == 'seniors') {
			$filterconditions['Team.category'] = 'Seniors';
			$teaminfo = array('Team' => array('name' => 'seniors', 'competition' => 'allemaal'));
		} else {
			$filterconditions['Game.team_id'] = $teamid;
			$this->loadModel('Team');
			$teaminfo = $this->Team->find('first', array('conditions' => array('Team.id' => $teamid), 'recursive' => -1, 'fields' => array('id', 'name', 'competition')));
		}
		if (!$datefrom) $datefrom = $this->currentYears[0].'-08-01';
		if (!$dateto)   $dateto   = $this->currentYears[1].'-07-31';
		$filterconditions['Game.game_date >='] = $datefrom;
		$filterconditions['Game.game_date <='] = $dateto;
		/// Unbinding the from the team down vastly reduces the recursion=2 effect (I need recursive=2 for the names of the coaches)
		$this->Game->Team->unbindModel(array('hasMany' => array('Game', 'Training', 'Trainingmomentsteam', 'Teammember')));
		$thegames = $this->Game->find('all', array('conditions' => $filterconditions, 'recursive' => 1, 'order' => array('Game.game_date', 'Game.game_time', 'Game.team_id')));
		parent::logAction(__FUNCTION__, 'game', 0);
		$this->set('period', array('datefrom' => $datefrom, 'dateto' => $dateto));
		$this->set('team', $teaminfo);
		$this->set('games', $thegames);
	}


	public function forpasseurke($teamid = null, $datefrom = null, $dateto = null) {
		$this->layout = 'logoonly';
		if (!$datefrom) $datefrom = $this->currentYears[0].'-08-01';
		if (!$dateto)   $dateto   = $this->currentYears[1].'-07-31';
		$this->set('period', array('datefrom' => $datefrom, 'dateto' => $dateto));
		/// Unbinding vastly reduces the recursion effect (I need recursive=2 for the names of the coaches)
		$this->Game->Team->unbindModel(array('hasMany' => array('Game', 'Training', 'Trainingmomentsteam', 'Teammember'), 'belongsTo' => array('Picture')));
		$this->Game->unbindModel(array('hasMany' => array('Gamesteammember')));
		$this->loadModel('Team');
		if ($teamid == null) {
			$teaminfo = $this->Team->find('all', array('recursive' => -1, 'fields' => array('id', 'name', 'competition')));
			$thegames = 0;
		} else {
			$teaminfo = $this->Team->find('first', array('conditions' => array('Team.id' => $teamid), 'recursive' => -1, 'fields' => array('id', 'name', 'competition')));
			$thegames = $this->Game->find('all', array('conditions' => array('Game.team_id' => $teamid, 'Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto), 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time')));
		}
		$this->set('teaminfo', $teaminfo);
		$this->set('games', $thegames);
	}


	public function forgoogle($filter = null) {
		$this->layout = 'logoonly';
		$datefrom = $this->currentYears[0].'-08-01';
		$dateto   = $this->currentYears[1].'-07-31';
		if ($filter == 'ronde1') {
			$gFilter = array('Game.period' => 1, 'Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto);
			$gOrder = array('Team.display_order', 'Game.game_date', 'Game.game_time');
			$forgoogle = array('filter' => 'ronde1');
		} elseif ($filter == 'ronde2') {
			$gFilter = array('Game.period' => 2, 'Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto);
			$gOrder = array('Team.display_order', 'Game.game_date', 'Game.game_time');
			$forgoogle = array('filter' => 'ronde2');
		} elseif ($filter == 'beker') {
			$gFilter = array('Game.game_code' => 'beker', 'Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto);
			$gOrder = array('Game.game_date', 'Game.game_time', 'Team.display_order');
			$forgoogle = array('filter' => 'alle bekerwedstrijden');
		} else {
			$gFilter = array('Game.period' => 999);
			$gOrder = array('Team.display_order');
			$forgoogle = array('filter' => 'no filter given -- use ronde1, ronde2 or beker');
		}
		/// Unbinding the from the team down vastly reduces the recursion=2 effect (I need recursive=2 for the names of the coaches)
		$this->Game->Team->unbindModel(array('hasMany' => array('Game', 'Training', 'Trainingmomentsteam', 'Teammember'), 'belongsTo' => array('Picture')));
		$this->Game->unbindModel(array('hasMany' => array('Gamesteammember'), 'belongsTo' => array('Coach')));
		$thegames = $this->Game->find('all', array('conditions' => $gFilter, 'recursive' => 1, 'order' => $gOrder));
		$this->set('period', array('datefrom' => $datefrom, 'dateto' => $dateto));
		$this->set('forgoogle', $forgoogle);
		$this->set('games', $thegames);
	}


	// format of the inline-csv
	// separator: specified in form
	// header line is mandatory (all lowercase)
	// mandatory fields: Reeks, Wedstrijdnr, Datum, Uur, Thuis, Bezoekers, Sporthall
	// unused fields: all other :-)
	//
	// Important: The first part from wedstrijdnr must match 'competitie' code from the team
	//
	public function import($teamid = null) {
		if (isset($this->params['named']['team'])) {
			$teamid = $this->params['named']['team'];
		}
		if (empty($this->request->data)) {
		} else {
			if (empty($this->request->data['GameImport']['gamesinjson'])) {
				$this->Session->setFlash(__('Geen wedstrijden om te importeren.'), "flash-error");
			} else {
				$importinput = json_decode($this->request->data['GameImport']['gamesinjson'], true);
				$importgames = array();
				foreach ($importinput as $oneinput) {
					if ((isset($oneinput['Wedstrijdnr'])) and (trim($oneinput['Wedstrijdnr']) <> "")) {
						$onegame = array();
						$onegame['team_id'] = $this->request->data['GameImport']['team_id'];
						$onegame['opponent_club_id'] = '';
						$onegame['season'] = $this->currentSeason;
						$tmpgamenumberinfo = explode('-', $oneinput['Wedstrijdnr']);
						$onegame['team_code'] = trim($tmpgamenumberinfo[0]);
						$onegame['game_code'] = 'competitie';
						$onegame['home_game'] = (trim($oneinput['Thuis']) == trim($this->request->data['GameImport']['game_hometeam'])) ? 1 : 0;
						$onegame['period'] = '';
						$onegame['game_number'] = trim($oneinput['Wedstrijdnr']);
						$onegame['game_date'] = $this->make_yyyymmdd($oneinput['Datum'], $this->request->data['GameImport']['game_date_format']);
						$onegame['game_time'] = $oneinput['Uur'];
						$onegame['game_home'] = $oneinput['Thuis'];
						$onegame['game_away'] = $oneinput['Bezoekers'];
						$onegame['game_coach_id'] = $this->request->data['GameImport']['game_coach_id'];
						$onegame['game_hall'] = $oneinput['Sporthall'];;
						$onegame['game_home_or_away'] = (isset($oneinput['homeoraway']) ? $oneinput['homeoraway'] : '');
						$onegame['game_referee'] = '';
						$onegame['game_marker'] = '';
						$onegame['game_scoreboard'] = '';
						$onegame['game_change'] = '';
						$onegame['game_t123'] = (isset($oneinput['terrein']) ? $oneinput['terrein'] : '');
						$onegame['remark'] = '';
						$importgames[] = $onegame;
					}
				}
				$this->set('importinput', $importinput);
				$this->set('importgames', $importgames);
				//$this->Session->setFlash(__('Wel wedstrijden om te importeren.'), "flash-info");
				if ($this->Game->saveMany($importgames)) {
					$this->Session->setFlash(__('De wedstrijden werden geïmporteerd.'), "flash-info");
					parent::logAction(__FUNCTION__, 'game', $onegame['team_id']);
					$this->redirect(array('controller' => 'teams', 'action' => 'view', $onegame['team_id']));
				} else {
					$this->Session->setFlash(__('De wedstrijden konden niet worden geïmporteerd.'), "flash-error");
				}
			}
		}
		if ($teamid) {
			$this->request->data['GameImport']['team_id'] = $teamid;
			$this->loadModel('Team');
			$this->Team->id = $teamid;
			$teaminfo = $this->Team->find('first', array('conditions' => array('Team.id' => $teamid), 'recursive' => -1, 'fields' => array('id', 'season', 'name', 'shortname', 'competition')));
			$teamcoaches = $this->Team->Teammember->find('all',
							array('fields' => array('Teammember.id', 'Teammember.teampriority', 'Member.id', 'Member.lastname', 'Member.firstname'),
								'conditions' => array('Teammember.team_id' => $teamid, 'Teammember.teampriority' => 0),
								'order' => array('Teammember.teampriority', 'Member.lastname', 'Member.firstname')
								));
			$game_coaches = array();
			foreach ($teamcoaches as $teamcoach) {
				$game_coaches[$teamcoach['Teammember']['id']] = $teamcoach['Member']['lastname'] . ' ' . $teamcoach['Member']['firstname'];
			}
			$this->set('game_coaches', $game_coaches);
			$this->set('teaminfo', $teaminfo);
			$source_date_formats = array(
										'DD/MM/YYYY' => 'DD/MM/YYYY',
										'DD-MM-YYYY' => 'DD-MM-YYYY',
										'YYYY/MM/DD' => 'YYYY/MM/DD',
										'YYYY-MM-DD' => 'YYYY-MM-DD',
										'MM/DD/YYYY' => 'MM/DD/YYYY',
										'MM-DD-YYYY' => 'MM-DD-YYYY'
			);
			$this->set('source_date_formats', $source_date_formats);
			$source_separators = array(
										',' => 'komma (,)',
										';' => 'puntkomma (;)'
			);
			$this->set('source_separators', $source_separators);
		} else {
			$this->Session->setFlash(__('Fout. Gelieve een team mee te geven.'), "flash-error");
		}
		//$this->set('teams', $this->Game->Team->find('list', array('fields' => array('Team.id', 'Team.teaminfo'))));
	}


	// importtasks function
	// format of the inline-csv
	// separator: specified in form
	// header line is mandatory (all lowercase)
	// mandatory fields: id
	// also mandatory - one or more of the following: referee_name, marker_name, scoreboard_name
	//
	public function importtasks() {
		$headererror = '';
		if (empty($this->request->data)) {
		} else {
			if (empty($this->request->data['GameTask']['csv'])) {
				$this->Session->setFlash(__('Geen taken om te importeren.'), "flash-error");
			} else {
				$importinput = explode("\n", $this->request->data['GameTask']['csv']);
				$importtasks = array();
				$headerrow = NULL;
				//$importheader = array("id", "game_referee", "game_marker", "game_scoreboard");
				foreach ($importinput as $oneinput) {
					$importrow = str_getcsv($oneinput, $this->request->data['GameTask']['separator']);
					if (!$headerrow) {
						$headerrow = $importrow;
						/// Check whether the headerrow contains at least "id",
						/// And one of the other three: "game_referee", "game_marker", "game_scoreboard"
						/// If not ==> exit the foreach
						if ((isset($importrow[0])) and ($importrow[0] <> 'id')) {
							$headererror = ' [Headerrow error. No id.]';
							break;
						}
						if ((isset($importrow[0])) and (count($importrow)) > 4) {
							$headererror = ' [Headerrow error. Too many fields (max=4).]';
							break;
						}
						if ((isset($importrow[1])) and (!in_array($importrow[1], array('game_referee', 'game_marker', 'game_scoreboard')))) {
							$headererror = ' [Headerrow error. Field "' . $importrow[1] . '" not in "game_referee, game_marker, game_scoreboard".]';
							break;
						}
						if ((isset($importrow[2])) and (!in_array($importrow[2], array('game_referee', 'game_marker', 'game_scoreboard')))) {
							$headererror = ' [Headerrow error. Field "' . $importrow[2] . '" not in "game_referee, game_marker, game_scoreboard".]';
							break;
						}
						if ((isset($importrow[3])) and (!in_array($importrow[3], array('game_referee', 'game_marker', 'game_scoreboard')))) {
							$headererror = ' [Headerrow error. Field "' . $importrow[3] . '" not in "game_referee, game_marker, game_scoreboard".]';
							break;
						}
					} else {
						if (isset($importrow[0]) and isset($importrow[1])) {
							$importtasks[] = array_combine($headerrow, $importrow);
						}
					}
				}
				$this->set('importinput', $importinput);
				$this->set('importtasks', $importtasks);
				if (count($importtasks) == 0) {
					$this->Session->setFlash(__('Geen taken om te importeren.' . $headererror), "flash-error");
				} else {
					$this->Session->setFlash(__(count($importtasks) . ' taken om te importeren.'), "flash-info");
					if ($this->Game->saveMany($importtasks)) {
						$this->Session->setFlash(__('De taken werden geïmporteerd.'), "flash-info");
						parent::logAction(__FUNCTION__, 'game', 0);
						//$this->redirect(array('controller' => 'teams', 'action' => 'view', $onegame['team_id']));
					} else {
						$this->Session->setFlash(__('De taken konden niet worden geïmporteerd.'), "flash-error");
					}
				}
			}
		}
		$source_separators = array(
									"," => 'komma (,)',
									";" => 'puntkomma (;)',
									"\t" => 'tab'
		);
		$this->set('source_separators', $source_separators);
		$source_headerline = array(
									'yep' => 'de eerste lijn is de hoofdinglijn',
									'nope' => 'er is geen hoofdinglijn'
		);
		$this->set('source_headerline', $source_headerline);
	}


	// importtasks function
	// format of the inline-csv
	// separator: specified in form
	// header line is mandatory (all lowercase)
	// mandatory fields: id
	// also mandatory - one or more of the following: referee_name, marker_name, scoreboard_name
	//
	public function importtasksbygamenumber() {
		$headererror = '';
		if (empty($this->request->data)) {
		} else {
			if (empty($this->request->data['GameTask']['csv'])) {
				$this->Session->setFlash(__('Geen taken om te importeren.'), "flash-error");
			} else {
				$importinput = explode("\n", $this->request->data['GameTask']['csv']);
				$importcsv = array();
				$importtasks = array();
				$foundrecords = array();
				$invalidforimport = array();
				$headerrow = NULL;
				/// process the csv data into a usable cake array
				//$importheader = array("game_number", "game_referee", "game_marker", "game_scoreboard");
				foreach ($importinput as $oneinput) {
					$importrow = str_getcsv($oneinput, $this->request->data['GameTask']['separator']);
					if (!$headerrow) {
						$headerrow = $importrow;
						/// Check whether the headerrow contains at least "game_number",
						/// And one of the other three: "game_referee", "game_marker", "game_scoreboard"
						/// If not ==> exit the foreach
						if ((isset($importrow[0])) and ($importrow[0] <> 'game_number')) {
							$headererror = ' [Headerrow error. No game_number.]';
							break;
						}
						if ((isset($importrow[0])) and (count($importrow)) > 4) {
							$headererror = ' [Headerrow error. Too many fields (max=4).]';
							break;
						}
						if ((isset($importrow[1])) and (!in_array($importrow[1], array('game_referee', 'game_marker', 'game_scoreboard')))) {
							$headererror = ' [Headerrow error. Field "' . $importrow[1] . '" not in "game_referee, game_marker, game_scoreboard".]';
							break;
						}
						if ((isset($importrow[2])) and (!in_array($importrow[2], array('game_referee', 'game_marker', 'game_scoreboard')))) {
							$headererror = ' [Headerrow error. Field "' . $importrow[2] . '" not in "game_referee, game_marker, game_scoreboard".]';
							break;
						}
						if ((isset($importrow[3])) and (!in_array($importrow[3], array('game_referee', 'game_marker', 'game_scoreboard')))) {
							$headererror = ' [Headerrow error. Field "' . $importrow[3] . '" not in "game_referee, game_marker, game_scoreboard".]';
							break;
						}
					} else {
						if (isset($importrow[0]) and isset($importrow[1])) {
							$importcsv[] = array_combine($headerrow, $importrow);
						}
					}
				}
				/// process the cake array
				/// - to filter rows (only keep record if game_number is found)
				/// - to filter fields (only keep the valid fields)
				foreach ($importcsv as $onetask) {
					$foundgamenumbers = $this->Game->findAllByGameNumber($onetask['game_number'], array('Game.id', 'Game.game_number', 'Game.season', 'Game.game_date', 'Game.game_home', 'Game.game_away'),array(),0,0,0);
					$datatoimport = array();
					if (!empty($foundgamenumbers)) {
						if (count($foundgamenumbers) == 1) {
							$datatoimport['game_number'] = $onetask['game_number'];
							if (isset($onetask['game_referee'])) $datatoimport['game_referee'] = $onetask['game_referee'];
							if (isset($onetask['game_marker'])) $datatoimport['game_marker'] = $onetask['game_marker'];
							if (isset($onetask['game_scoreboard'])) $datatoimport['game_scoreboard'] = $onetask['game_scoreboard'];
							$datatoimport['id'] = $foundgamenumbers[0]['Game']['id'];
							$importtasks[] = $datatoimport;
						} else {
							$invalidforimport[] = array('game_number' => $onetask['game_number'], 'reason' => 'multiple games found for this game number');
						}
					} else {
						$invalidforimport[] = array('game_number' => $onetask['game_number'], 'reason' => 'game number not found');
					}
					$foundrecords[] = $foundgamenumbers;
				}
				/// Prepare some data for view
				$this->set('importinput', $importinput);
				$this->set('importcsv', $importcsv);
				$this->set('importtasks', $importtasks);
				$this->set('invalidforimport', $invalidforimport);
				$this->set('foundrecords', $foundrecords);
				/// Process the requested action
				$importfeedback = array();
				$noimportfeedback = array();
				if (count($importtasks) == 0) {
					$this->Session->setFlash(__('Geen taken om te importeren.' . $headererror), "flash-error");
				} else {
					foreach($importtasks as $oneitem) {
						$importfeedback[] = array('game_number' => $oneitem['game_number'], 'id' => $oneitem['id']);
					}
					foreach($invalidforimport as $oneitem) {
						$noimportfeedback[] = array('game_number' => $oneitem['game_number'], 'reason' => $oneitem['reason']);
					}
					$flashmessage = count($importtasks) . ' '. __('taken om te importeren.');
					if (isset($this->request->data['do_simulate'])) {
						$flashmessage .= ' - DIT IS EEN SIMULATIE!';
						$this->Session->setFlash($flashmessage, "flash-info");
					}
					if (isset($this->request->data['do_import'])) {
						$flashmessage .= ' - DIT IS DE IMPORT!';
						if ($this->Game->saveMany($importtasks)) {
							$flashmessage .= ' - ' . __('De taken werden geïmporteerd.');
							$this->Session->setFlash($flashmessage, "flash-info");
							parent::logAction(__FUNCTION__, 'game', 0);
							//$this->redirect(array('controller' => 'teams', 'action' => 'view', $onegame['team_id']));
						} else {
							$flashmessage .= ' - ' . __('De taken konden niet worden geïmporteerd.');
							$this->Session->setFlash($flashmessage, "flash-error");
						}
					}
				}
				$this->set('feedback', array('import' => $importfeedback, 'noimport' => $noimportfeedback));
			}
		}
		$source_separators = array(
									"," => 'komma (,)',
									";" => 'puntkomma (;)',
									"\t" => 'tab'
		);
		$this->set('source_separators', $source_separators);
		//$this->set('previousrequestdata', $this->request->data);
	}


	/// Obsolete - ARUNAR no longer exists
	public function calendarfromarunar() {
		$calendarfromarunarxml = "files/downloads/arunar/vb1072_kalender_" . $this->currentSeason . ".xml";
		$localxmlfile = $calendarfromarunarxml;
		if (!file_exists($localxmlfile)) {
			/// Here we should try and get the "current" info from ARUNAR
			$remotexmlfile = 'http://haezeleer.be/arunar/rapporten/export4club.php?bond=vb&stamnr=VB1072';
			$xmlrc = $this->downloadxmlfromarunar($remotexmlfile, $localxmlfile);
		}
		if (file_exists($localxmlfile)) {
	    $calendar = simplexml_load_file($localxmlfile);
		} else {
	    $calendar = array('error' => "Clubman error: Failed to open/download $localxmlfile");
		}
		$this->set('calendar', $calendar);
	}


	// Obsolete - ARUNAR no longer exists
	public function fromarunar($info = 'test') {
		$arunardir = 'files/downloads/arunar/';
		$remoterangschikkingenxmlfile = 'http://haezeleer.be/arunar/exports/vb_rangschikkingen.xml';
		$rangschikkingenxmlpattern = $arunardir . 'vb_rangschikkingen_*.xml';
		$rangschikkingenxmlfiles = array();
		foreach (glob($rangschikkingenxmlpattern) as $filename) {
			$rangschikkingenxmlfiles[] = array('filename' => $filename, 'filesize' => filesize($filename), 'filestamp' => date('Y-m-d G:i:s', filemtime($filename)));
		}
		$remoteuitslagenxmlfiles = 'http://haezeleer.be/arunar/exports/vb_uitslagen.xml';
		$uitslagenxmlpattern = $arunardir . 'vb_uitslagen_*.xml';
		$uitslagenxmlfiles = array();
		foreach (glob($uitslagenxmlpattern) as $filename) {
			$uitslagenxmlfiles[] = array('filename' => $filename, 'filesize' => filesize($filename), 'filestamp' => date('Y-m-d G:i:s', filemtime($filename)));
		}
		$remotekalenderxmlfiles = 'http://haezeleer.be/arunar/exports/vb_kalender.xml';
		$kalenderxmlpattern = $arunardir . 'vb_kalender_*.xml';
		$kalenderxmlfiles = array();
		foreach (glob($kalenderxmlpattern) as $filename) {
			$kalenderxmlfiles[] = array('filename' => $filename, 'filesize' => filesize($filename), 'filestamp' => date('Y-m-d G:i:s', filemtime($filename)));
		}
		$thiswoy = date('Y-W');
		$rangschikkingenxmlfile = $arunardir . "vb_rangschikkingen_$thiswoy.xml";
		if (file_exists($rangschikkingenxmlfile)) {
		  $xmlexists = true;
		} else {
		  $xmlexists = false;
		}
		$xmlnotefile = "files/downloads/note_$thiswoy.xml";
		if (file_exists($xmlnotefile)) {
	    $xmlnoteexisted = true;
		} else {
	    $xmlnoteexisted = false;
			$xmlrc = $this->downloadexternalxml('http://www.w3schools.com/xml/note.xml', "files/downloads/note_$thiswoy.xml");
		}
		if (file_exists($xmlnotefile)) {
		  $xmlnote = simplexml_load_file($xmlnotefile);
		} else {
		  $xmlnote = array('error' => "Failed to open $xmlnotefile");
		}
		$this->set(compact('rangschikkingenxmlfiles', 'rangschikkingenxmlfile', 'xmlexists', 'xmlnotefile', 'xmlnote', 'xmlnoteexisted'));
	}


	private function fetchexternalxml($xmlurl = 'http://www.w3schools.com/xml/note.xml') {
		/// Create curl resource
		$ch = curl_init();
		/// Set url
		curl_setopt($ch, CURLOPT_URL, $xmlurl);
		/// Return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		/// $xmlinfo contains the output string
		$xmlinfo = curl_exec($ch);
		/// Close curl resource to free up system resources
		curl_close($ch);
		return $xmlinfo;
	}


	private function downloadexternalxml($sourcexmlfile = 'http://www.w3schools.com/xml/note.xml', $targetxmlfile = 'files/downloads/test.xml') {
		/// Save to file -- nog te testen ...
		$ch = curl_init($sourcexmlfile);
		$fp = fopen($targetxmlfile, "w");
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}


	private function make_yyyymmdd($datestring, $sourceformat = 'DD/MM/YYYY') {
		$dateconversions = array(
				'DD/MM/YYYY' => array('ddelimiter' => '/', 'dformat' => array('Y' => 3, 'M' => 2, 'D' => 1))
		);
		$thisdateconversion = $dateconversions[$sourceformat];
		$datearray = explode($thisdateconversion['ddelimiter'], $datestring);
		$newdate = mktime(0, 0, 0, $datearray[($thisdateconversion['dformat']['M'])-1], $datearray[($thisdateconversion['dformat']['D'])-1], $datearray[($thisdateconversion['dformat']['Y'])-1]);
		$newlyformatteddate = date("Y-m-d", $newdate);
		return $newlyformatteddate;
	}


}
