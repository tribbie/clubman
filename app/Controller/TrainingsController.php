<?php
class TrainingsController extends AppController {

	//var $scaffold;
	public $helpers = array('Link');

	public function index() {
		$this->Training->recursive = 1;
		//$this->set('trainings', $this->Training->find('all', array('order' => array('Team.display_order' => 'ASC', 'Training.start_date' => 'ASC', 'Training.start_time' => 'ASC' ))));
		$this->set('trainings', $this->Training->find('all', array('order' => array('Training.start_date' => 'ASC', 'Training.start_time' => 'ASC' ))));
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
				if ($this->Training->save($this->request->data)) {
					$this->Session->setFlash(__('De training werd bewaard.'), "flash-info");
					parent::logAction(__FUNCTION__, 'training', $this->Training->id);
					if (isset($teamid)) {
						$this->redirect(array('controller' => 'teams', 'action' => 'view', $teamid));
					} else {
						$this->redirect(array('controller' => 'teams', 'action' => 'index'));
					}
				} else {
					$this->Session->setFlash(__('De training kon niet worden bewaard.'), "flash-error");
				}
			} else {
				$this->request->data['Training']['team_id'] = $teamid;
			}
			/// Old method -- not good -- allways returns the whole list of teams
			//$this->set('teams', $this->Training->Team->find('list'));
			/// Retrieve list of teams that this member is teammember of (but only with priority 0 - begeleiding)
			$memberid = $this->currentUser['Member']['id'];
			$this->loadModel('Teammember');
			$this->Teammember->recursive = -1;
			$memberteams = $this->Teammember->find('list', array('conditions' => array('Teammember.member_id' => $memberid, 'Teammember.teampriority' => 0), 'fields' => array('Teammember.id', 'Teammember.team_id')));
			$this->set('memberteams', $memberteams);
			$this->loadModel('Team');
			$this->Team->recursive = -1;

			/// If I am a trainer, the list of teams will be limited to my teams
			if (ClubmanUtilityLib::elementsInArray($this->cmCurrentRoles, ['trainer', 'member']) > 0) {
				$teamfilter = array('Team.id' => array_values($memberteams));
			}
			/// If I am some admin, the list of teams will be the complete list of teams
			/// This will overwrite the previous check, as it should
			if (ClubmanUtilityLib::elementsInArray($this->cmCurrentRoles, ['root', 'admin', 'teamadmin']) > 0) {
				$teamfilter = array('Team.id >' => 0);
			}
			$teams = $this->Team->find('list', array('conditions' => $teamfilter));
			$this->set('teams', $teams);
		}
	}


	public function generate() {
		/// Load other models
		$this->loadModel('Team');
		$this->loadModel('Trainingmoment');
		if ($this->request->is('post')) {
			/// Put the form data into a variable
			$formdata = $this->request->data;
			/// Get the right record ready
			$this->Team->id = $formdata['Training']['team_id'];
			$this->Trainingmoment->id = $formdata['Training']['trainingmoment_id'];
			/// Initialize some variables
			$teamname = $this->Team->field('name');
			$trainingmomentname = $this->Trainingmoment->field('name');
			/// Prepare some stuff
			$datefromarray = explode('-', $formdata['Training']['datefrom']);
			$datetoarray   = explode('-', $formdata['Training']['dateto']);
			$begindate = mktime(0, 0, 0, $datefromarray[1], $datefromarray[2], $datefromarray[0]);
			$enddate   = mktime(0, 0, 0, $datetoarray[1], $datetoarray[2], $datetoarray[0]);
			$trainingmomentdow = $this->Trainingmoment->field('weekday');
			$trainingmomentstart = $this->Trainingmoment->field('start_time');
			$trainingmomentend = $this->Trainingmoment->field('end_time');
			$trainingmomentlocation = $this->Trainingmoment->field('location');
			$trainingdate = $begindate;
			$days = 0;
			$generatedtrainings = array();
			/// Begin generation
			while ($trainingdate < $enddate) {
				$thetrainingdate = date("Y-m-d", $trainingdate);
				/// date(N) returns day-of-week with monday = 1, tuesday = 2, ...
				/// But we use ... day-of-week with monday = 0, tuesday = 1, ... (check AppController)
				/// Hence the "minus 1"
				$trainingdow = date("N", $trainingdate) - 1;
				//echo $thetrainingdate . "(" . $trainingdow . "/" . $trainingmomentdow . ")" . "<br/>\n";
				if ($trainingdow == $trainingmomentdow) {
					unset($onetraining);
					$onetraining = array('Training' => array(
														'team_id' => $formdata['Training']['team_id'],
														'trainingmoment_id' => $formdata['Training']['trainingmoment_id'],
														'season' => $formdata['Training']['season'],
														'start_date' => $thetrainingdate,
														'start_time' => $trainingmomentstart,
														'end_time' => $trainingmomentend,
														'location' => $trainingmomentlocation,
														'remark' => ''
													));
					$this->Training->create();
					if ($this->Training->save($onetraining)) {
						parent::logAction(__FUNCTION__, 'training', $this->Training->id);
						$onetraining['SaveResult']['msg'] = 'training toegevoegd.';
						$onetraining['SaveResult']['rc'] = 1;
					} else {
						$onetraining['SaveResult']['msg'] = 'DUBBELE training: deze training werd NIET toegevoegd!';
						$onetraining['SaveResult']['rc'] = 0;
					}
					$generatedtrainings[] = $onetraining;
				}
				$days += 1;
				$trainingdate = mktime(0, 0, 0, $datefromarray[1], $datefromarray[2] + $days, $datefromarray[0]);
			}
			/// With saveMany, if one new training was invalidated (eg. because duplicate), none were saved
			/// But I wanted to save the non-duplicates, and skip the duplicates, so now I save single records in the loop above, so I can skip invalid ones ...
			$this->Session->setFlash(count($generatedtrainings) . ' "'. $trainingmomentname . '" trainingen voor team "' . $teamname . '" in deze periode.', "flash-info");
			//$this->redirect(array('controller' => 'teams', 'action' => 'index'));
			/// Load ALL the trainings for the team
			$trainings = $this->Training->find('all', array('conditions' => array('team_id' => $formdata['Training']['team_id']), 'order' => array('Team.name' => 'ASC', 'Training.start_date' => 'ASC', 'Training.start_time' => 'ASC' )));
			$this->set('trainings', $trainings);
			$this->set('teamname', $teamname);
			$this->set('generatedtrainings', $generatedtrainings);
			/// Debugging
			//$this->set('formdata', $formdata);
		} else {
			if (isset($this->params['named']['team'])) {
				$this->request->data['Training']['team_id'] = $this->params['named']['team'];
			}
		}
		/// Prepare the dropdown lists
		$this->set('teams', $this->Training->Team->find('list'));
		$this->set('trainingmoments', $this->Training->Trainingmoment->find('list'));
	}


	public function edit($id = null) {
		$this->Training->id = $id;
		if (!$this->Training->exists()) {
			throw new NotFoundException(__('Deze training bestaat niet.'));
		}
		$training = $this->Training->read(null, $id);
		//$training = $this->Training->findById($id);
		$teamid = $training['Training']['team_id'];
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Training->save($this->request->data)) {
				$this->Session->setFlash(__('De training werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'training', $id);
				$this->redirect(array('controller' => 'teams', 'action' => 'view', $teamid));
			} else {
				$this->Session->setFlash(__('De training kon niet worden bewaard.'), "flash-error");
			}
		} else {
			$this->set('teams', $this->Training->Team->find('list'));
			$this->request->data = $training;
			//$this->set('training', $training);
		}
	}


	public function delete($id = null) {
		if (isset($id)) {
			$this->Training->id = $id;
			if (!$this->Training->exists()) {
				$this->Session->setFlash(__('Deze training bestaat niet. Er werd geen training verwijderd.'), "flash-error");
				$this->redirect(array('controller' => 'teams', 'action' => 'index'));
			} else {
				$this->Training->recursive = 3;
				/// Unbinding from the team down vastly reduces the recursion=2 effect (I need recursive=2 for the names of the coaches)
				$this->Training->unbindModel(array('belongsTo' => array('Trainingmoment')));
				$this->Training->Team->unbindModel(array('belongsTo' => array('Picture'), 'hasMany' => array('Teammember', 'Training', 'Game', 'Trainingmomentsteam')));
				$this->Training->Trainingsteammember->unbindModel(array('belongsTo' => array('Training')));
				$this->Training->Trainingsteammember->Teammember->unbindModel(array('belongsTo' => array('Team'), 'hasMany' => array('Trainingsteammember', 'Gamesteammember')));
				$training = $this->Training->read();
				$teamid = $training['Team']['id'];
				if ($this->request->is('post')) {
					if ($this->Training->delete($id, true)) {
						$this->Session->setFlash(__('De training werd verwijderd.'), "flash-info");
						parent::logAction(__FUNCTION__, 'training', $id);
						$this->redirect(array('controller' => 'teams', 'action' => 'view', $teamid));
					} else {
						$this->Session->setFlash(__('De training kon niet verwijderd worden.'), "flash-error");
						//$this->redirect(array('action' => 'profile'));
					}
				}
				$this->set('training', $training);
			}
		} else {
			$this->Session->setFlash(__('Geen training meegegeven om te verwijderen'), "flash-error");
			//$this->redirect(array('action' => 'index'));
		}
	}


	public function presences($id = null) {
		/// Retrieve the training info
		$this->Training->id = $id;
		$training = $this->Training->read();
		$this->set('training', $training);
		$this->loadModel('Trainingsteammember');
		$trainingsteammembers = $this->Trainingsteammember->find('all', array('conditions' => array('Trainingsteammember.training_id' => $this->Training->id)));
		$this->set('trainingsteammembers', $trainingsteammembers);
		/// Retrieve the teammembers of the team minus de "gestopten"
		$this->loadModel('Team');
		$this->Team->id = $training['Training']['team_id'];
		$teammembers = $this->Team->Teammember->find('all',
                         array('fields' => array('Teammember.id', 'Teammember.teampriority', 'Member.id', 'Member.lastname', 'Member.firstname'),
                               'conditions' => array('Teammember.team_id' => $training['Training']['team_id'], 'Teammember.teampriority >' => 0, 'Teammember.teampriority <>' => 99),
                               'order' => array('Teammember.teampriority', 'Member.lastname', 'Member.firstname')
                               ));
		/// Build up array with presences
		$thepresences = array();
		foreach ($teammembers as $teammember) {
			unset($existingpresence);
			foreach ($trainingsteammembers as $trainingsteammember) {
				if ($trainingsteammember['Trainingsteammember']['teammember_id'] == $teammember['Teammember']['id']) {
					$existingpresence = $trainingsteammember['Trainingsteammember'];
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
								'training_id' => $this->Training->id,
								'status' => $thisstatus,
								'remark' => $thisremark
								);
		}
		$this->set('thepresences', $thepresences);
		$this->set('teammembers', $teammembers);
		if ($this->request->is('post')) {
			/// Put the form data into a variable
			$formdata = $this->request->data;
			$this->loadModel('Trainingsteammember');
			if ($this->Trainingsteammember->saveMany($formdata['Trainingsteammember'])) {
				if ($this->Training->save($formdata['Training'])) {
					$this->Session->setFlash('De training werd bewaard.', "flash-info");
					parent::logAction(__FUNCTION__, 'training', $this->Training->id);
					$this->redirect(array('controller' => 'teams', 'action' => 'view', $this->Team->id));
				} else {
					$this->Session->setFlash('De training werd niet correct bewaard.', "flash-error");
				}
			} else {
				$this->Session->setFlash('De aanwezigheden werden niet correct bewaard.', "flash-error");
			}
			$this->set('formdata', $formdata);
		} else {
		}
	}


}
