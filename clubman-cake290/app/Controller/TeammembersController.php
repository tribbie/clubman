<?php
class TeammembersController extends AppController {

	//var $scaffold;

	var $teamfunctions = array(
							'speler'        	=> 'Speler',
							'speelster'     	=> 'Speelster',
							'setter'        	=> 'Setter',
							'receptie-hoek' 	=> 'Receptie-hoek',
							'opposite'      	=> 'Opposite',
							'middenblok'    	=> 'Middenblok',
							'libero'        	=> 'Libero',
							'all-round'     	=> 'All-round',
							'trainer'       	=> 'Trainer',
							'assistent'     	=> 'Assistent',
							'coach'         	=> 'Coach',
							'coachpool'     	=> 'Coachpool',
							'PV'            	=> 'Ploegverantwoordelijke',
							'markeerder'    	=> 'Markeerder',
							'scheidsrechter'	=> 'Scheidsrechter',
							'teammanager'   	=> 'Teammanager',
							'scouter'    			=> 'Scouter',
							'andere'        	=> 'Andere'
						);


	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('view', 'category');
		//$this->Auth->deny('index');
	}


	public function index() {
		$this->Teammember->recursive = 2;
		/// Unbinding vastly reduces the recursion=2 effect (I need recursive=2 for the names of the coaches)
		$this->Teammember->unbindModel(array('hasMany' => array('Trainingsteammember', 'Gamesteammember')));
		$this->Teammember->Team->unbindModel(array('belongsTo' => array('Picture'), 'hasMany' => array('Teammember', 'Training', 'Game', 'Trainingmomentsteam')));
		$this->Teammember->Member->unbindModel(array('hasMany' => array('Teammember', 'Coach', 'User')));
		//$this->set('teammembers', $this->Teammember->find('all', array('conditions' => array('teampriority <>' => 99), 'order' => array('Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' ))));
		$this->set('teammembers', $this->Teammember->find('all', array('conditions' => array('team_id >' => 0), 'order' => array('Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' ))));
		$this->set('teampriorities', $this->teampriorities);
	}


	public function team($teamid = null) {
		/// Retrieve team info
		$this->loadModel('Team');
		$this->Team->id = $teamid;
		if (!$this->Team->exists()) {
			throw new NotFoundException(__('Team bestaat niet!'));
		}
		$this->Team->recursive = -1;
		$this->set('team', $this->Team->read());
		/// Retrieve teammembers info
		$this->Teammember->recursive = 2;
		//$this->set('teammembers', $this->Teammember->find('all', array('conditions' => array('team_id' => $teamid, 'teampriority <>' => 99), 'order' => array('Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' ))));
		$this->set('teammembers', $this->Teammember->find('all', array('conditions' => array('team_id' => $teamid), 'order' => array('Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' ))));
		$this->set('teampriorities', $this->teampriorities);
	}


	public function category($category = null) {
		$validcategory = 0;
		if (!$category) {
			$this->Session->setFlash(__('Ongeldige categorie', true), "flash-error");
		}
		/// Retrieve teammembers info
		$this->Teammember->recursive = 2;
		if ($category == 'trainers') {
			$teammembersconditions = array('Team.teamtype' => 'Volley', 'Teammember.teampriority' => 0);
			$validcategory = 1;
		} elseif ($category == 'players') {
			$teammembersconditions = array('Team.teamtype' => 'Volley', 'Teammember.teampriority in' => array(1, 2, 3, 4, 5, 6, 7, 8, 9), 'Team.series <>' => 'beker');
			$validcategory = 1;
		} else {
			$this->Session->setFlash(__('Ongeldige categorie: ' . $category, true), "flash-error");
		}
		if ($validcategory) {
			$teammembersorder = array('Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' );
			/// Unbinding vastly reduces the recursion effect (I need recursive=3 for the name of the coach)
			$this->Teammember->unbindModel(array('hasMany' => array('Trainingsteammember', 'Gamesteammember'), 'belongsTo' => array('Picture')));
			$this->Teammember->Team->unbindModel(array('hasMany' => array('Teammember', 'Training', 'Game', 'Trainingmomentsteam'), 'belongsTo' => array('Picture')));
			$this->Teammember->Member->unbindModel(array('hasMany' => array('Teammember', 'Coach', 'User'), 'belongsTo' => array('Picture', 'Picturelicense')));
			$this->set('teammembers', $this->Teammember->find('all', array('conditions' => $teammembersconditions, 'order' => $teammembersorder)));
		} else {
			/// This redirect does not work in Clubweb (no index allowed there)
			//$this->redirect(array('action' => 'index'));
		}
		$this->set('teampriorities', $this->teampriorities);
		$this->set('category', $category);
	}


	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Ongeldig teamlid', true), "flash-error");
			$this->redirect(array('action' => 'index'));
		}
		$this->Teammember->id = $id;
		$this->Teammember->recursive = 2;
		$this->set('teammember', $this->Teammember->read());
		$this->set('teampriorities', $this->teampriorities);
	}


	public function add($teamid = null) {
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Teammember->save($this->request->data)) {
				$this->Session->setFlash(__('Het teamlid werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'teammember', $this->Teammember->id);
				if (isset($this->params['named']['team'])) {
					$this->redirect(array('action' => 'team', $this->params['named']['team']));
				} else {
					if (!$teamid) {
						$this->redirect(array('action' => 'index'));
					} else {
						$this->redirect(array('action' => 'team', $teamid));
					}
				}
				//$this->redirect(array('action' => 'view', $this->Teammember->id));
			} else {
				$this->Session->setFlash(__('Het teamlid kon niet worden bewaard.'), "flash-error");
			}
		} else {
			if (isset($this->params['named']['team'])) {
				$this->Auth->request->data['Teammember']['team_id'] = $this->params['named']['team'];
			}
			if (isset($this->params['named']['member'])) {
				$this->Auth->request->data['Teammember']['member_id'] = $this->params['named']['member'];
			}
			if (isset($this->params['named']['function'])) {
				$this->Auth->request->data['Teammember']['teamfunction'] = $this->params['named']['function'];
			}
			$this->set('teams', $this->Teammember->Team->find('list'));
			$this->set('members', $this->Teammember->Member->find('list'));
			$this->set('teamfunctions', $this->teamfunctions);
			$this->set('teampriorities', $this->teampriorities);
		}
	}


	public function edit($id = null) {
		$this->Teammember->id = $id;
		if (!$this->Teammember->exists()) {
			throw new NotFoundException(__('Teamlid bestaat niet.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Teammember->save($this->request->data)) {
				$this->Session->setFlash(__('Het teamlid werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'teammember', $this->Teammember->id);
				//$this->redirect(array('action' => 'view', $id));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het teamlid kon niet worden bewaard.'), "flash-error");
			}
		} else {
			$teammember = $this->Teammember->read(null, $id);
			$this->request->data = $teammember;
			$this->set('teammember', $teammember);
			$this->set('teams', $this->Teammember->Team->find('list'));
			$this->set('members', $this->Teammember->Member->find('list'));
			$this->set('teamfunctions', $this->teamfunctions);
			$this->set('teampriorities', $this->teampriorities);
		}
	}


	public function addbulk($teamid = null) {
		$this->loadModel('Team');
		$this->Team->id = $teamid;
		if (!$this->Team->exists()) {
			throw new NotFoundException(__('Team bestaat niet!'));
		}
		$this->Team->recursive = -1;
		$team = $this->Team->read();
		if ($this->request->is('post') || $this->request->is('put')) {
			$memberdata = $this->request->data;
			$savedata = array();
			foreach ($memberdata['Team']['Teammember'] as $onemember) {
				if (isset($onemember['ismember']) and ($onemember['ismember'])) {
					$newteammember = array();
					$newteammember['team_id'] = $onemember['team_id'];
					$newteammember['member_id'] = $onemember['member_id'];
					$newteammember['tempname'] = $onemember['tempname'];
					$newteammember['season'] = $this->currentSeason;
					$newteammember['teamfunction'] = $memberdata['Team']['All']['teamfunction'];
					$newteammember['teampriority'] = $memberdata['Team']['All']['teampriority'];
					$savedata['Teammember'][] = $newteammember;
				}
			}
			if (! isset($savedata['Teammember'])) {
				$this->Session->setFlash(__('Geen (nieuwe) teamleden toegevoegd.'), "flash-error");
				$this->redirect(array('controller' => 'teams', 'action' => 'view', $teamid));
			} else {
				$savecount = count($savedata['Teammember']);
				if ($this->Teammember->saveAll($savedata['Teammember'])) {
					$this->Session->setFlash(__($savecount . ' teamleden werden toegevoegd.'), "flash-info");
					parent::logAction(__FUNCTION__, 'teammember', 0);
					$this->redirect(array('controller' => 'teams', 'action' => 'view', $teamid));
				} else {
					$this->Session->setFlash(__('Geen teamleden kunnen toevoegen.'), "flash-error");
				}
			}
			/// next is for debugging
			//$this->set('postdata', $this->request->data);
			//$this->set('memberdata', $memberdata);
			//$this->set('savedata', $savedata);
		} else {
			/// retrieve info
			$this->Teammember->Member->recursive = 0;
			$teammembers = $this->Teammember->find('all', array('conditions' => array('team_id ' => $teamid), 'fields' => array('id', 'member_id')));
			$allmembers = $this->Teammember->Member->find('all', array('conditions' => array('Member.id >' => 0, 'Member.active' => 1), 'fields' => array('Member.id', 'Member.uname')));
			/// do the controller stuff
			/// next hash combine works great, except ... names with accents keep their accents, and we don't want that ...
			$memberlist = Hash::combine($allmembers, '{n}.Member.id', '{n}.Member');
			foreach ($allmembers as $member) {
				$memberlist[$member['Member']['id']]['ismember'] = 0;
			}
			foreach ($teammembers as $teammember) {
				$memberlist[$teammember['Teammember']['member_id']]['ismember'] = true;
			}
			/// next is for debugging
			//$this->set('allmembers', $allmembers);
			/// next is needed
			$this->set('memberlist', $memberlist);
			$this->set('teamfunctions', $this->teamfunctions);
			$this->set('teampriorities', $this->teampriorities);
		}
		$this->set('team', $team);
	}


}
