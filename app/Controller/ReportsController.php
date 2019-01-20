<?php
class ReportsController extends AppController {

	/// Include the RequestHandler, it makes sure the proper layout and views files are used (for csv and pdf)
	/// Also check your routes.php for Router::parseExtensions('pdf', 'csv');
	var $components = array('RequestHandler');

	public function index() {
		/// Load other models
	}

	public function members() {
		/// Load other models
		$this->loadModel('Teammember');
		//$this->set('teammembers', $this->Teammember->find('all', array('order' => 'team_id')));
		$this->set('teammembers', $this->Teammember->find('all', array('order' => array('Team.display_order' => 'ASC', 'Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' ))));
		parent::logAction(__FUNCTION__, 'report');
	}

	public function members4trainers() {
		/// Load other models
		$this->loadModel('Teammember');
		$teammembers = $this->Teammember->find('all', array('conditions' => array('Member.active' => true, 'Teammember.teampriority <' => 99), 'order' => array('Team.display_order' => 'ASC', 'Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' )));
		parent::logAction(__FUNCTION__, 'report');
		$this->set('teammembers', $teammembers);
	}

	public function members4mgmt() {
		// Load other models
		$this->loadModel('Teammember');
		$teammembers = $this->Teammember->find('all', array('conditions' => array('Member.active' => true, 'Teammember.teampriority <' => 99), 'order' => array('Team.display_order' => 'ASC', 'Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' )));
		parent::logAction(__FUNCTION__, 'report');
		$this->set('teammembers', $teammembers);
		/// SQL statement
		///		select count(t.member_id) priocount, m.lastname, m.firstname, t.teampriority
		///		from cm_teammembers t
		///		left join cm_members m on t.member_id = m.id
		///		where (m.active = true) and (t.teampriority = 1)
		///		group by t.teampriority, t.member_id
		///		order by priocount desc, m.lastname, m.firstname;
		$this->Teammember->unbindModel(array('hasMany' => array('Trainingsteammember', 'Gamesteammember')));
		$teammembersp1 = $this->Teammember->find('all', array(
														'fields' => array('COUNT(Teammember.member_id) as priocount', 'Member.lastname', 'Member.firstname', 'Teammember.teampriority'),
														'conditions' => array('Member.active' => true, 'Teammember.teampriority' => 1),
														'group' => 'Teammember.member_id',
														'order' => array('priocount' => 'DESC', 'Member.lastname', 'Member.firstname')
													)
												);
		$this->set('teammembersp1', $teammembersp1);
		//$this->render('teammembersexcel', 'export_xls');
	}

	public function membersbirthday() {
		$this->loadModel('Member');
		$members = $this->Member->find('all', array(
				'fields' => array('Member.firstname', 'Member.lastname', 'Member.birthdate', 'Member.birthdate_nice', 'Member.birthmonth', 'Member.birthday', 'Member.birthyear', 'Member.active'),
				'conditions' => array('Member.birthdate <>' => ''),
				'order' => array('Member.birthmonth', 'Member.birthday', 'Member.birthyear DESC'),
				'recursive' => 0
			)
		);
		$this->set('members', $members);
		parent::logAction(__FUNCTION__, 'report');
	}

	public function memberscomplete($filter = 'all') {
		$filters = array(
						'all' => array('Member.id >' => '0'),
						'active' => array('Member.active' => '1'),
						'inactive' => array('Member.active' => '0')
					);
		/// Load other models
		$this->loadModel('Member');
		$this->set('members', $this->Member->find('all', array('conditions' => $filters[$filter], 'order' => 'Member.name')));
		//$this->set('members', $this->Member->find('all', array('order' => array('Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' ))));
		parent::logAction(__FUNCTION__, 'report');
	}

	public function migratemembersbefore($filter = 'all') {
		$filters = array(
						'all' => array('Migratemember.id >' => '0'),
						'active' => array('Migratemember.active' => '1'),
						'inactive' => array('Migratemember.active' => '0')
					);
		/// Load other models
		$this->loadModel('Migratemember');
		$this->set('migratemembers', $this->Migratemember->find('all', array('conditions' => $filters[$filter], 'order' => 'Migratemember.name')));
		//$this->set('migratemembers', $this->Migratemember->find('all', array('order' => array('Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Migratemember.name' => 'ASC' ))));
		parent::logAction(__FUNCTION__, 'report');
	}

	public function migratemembersafter($filter = 'some') {
		$filters = array(
						'all' => array('Migratemember.id >' => '0'),
						'active' => array('Migratemember.active' => '1'),
						'inactive' => array('Migratemember.active' => '0'),
						'some' => array('Migratemember.id' => array(22,112,127,172,19,157,409,453))
					);
		/// Load other models
		$this->loadModel('Migratemember');
		$this->Migratemember->recursive = 2;
		//$this->Migratemember->recursive = 3;
		$this->Migratemember->Behaviors->load('Containable');
		$fields = array(
										'Migratemember.id', 'Migratemember.lastname', 'Migratemember.firstname', 'Migratemember.nationalnumber', 'Migratemember.birthdate', 'Migratemember.birthday_public',
		 								'Migratemember.email', 'Migratemember.tel', 'Migratemember.address', 'Migratemember.postcode', 'Migratemember.city',
										'Migratemember.mom_lastname', 'Migratemember.mom_firstname', 'Migratemember.mom_email', 'Migratemember.mom_tel', 'Migratemember.mom_address', 'Migratemember.mom_postcode', 'Migratemember.mom_city',
										'Migratemember.dad_lastname', 'Migratemember.dad_firstname', 'Migratemember.dad_email', 'Migratemember.dad_tel', 'Migratemember.dad_address', 'Migratemember.dad_postcode', 'Migratemember.dad_city'
										);
		$contain = array(
				'Person' => array(
					'fields' => array('id', 'uniquenumber', 'lastname', 'firstname', 'birthdate', 'birthday_public', 'email', 'mobile', 'metadata'),
					'Contactaddress' => array(
						'fields' => array('id', 'address', 'postcode', 'city', 'landline'),
					),
					'Membership' => array(
						'fields' => array('id', 'person_id', 'licensenumber'),
					),
					'Personparent' => array(
						'fields' => array('id', 'person_id', 'parent_id', 'type'),
						'Parent' => array(
							'fields' => array('id', 'contactaddress_id', 'lastname', 'firstname', 'birthdate', 'email', 'mobile'),
						),
						'Person' => array(
							'fields' => array('id', 'contactaddress_id', 'lastname', 'firstname', 'birthdate', 'email', 'mobile'),
						),
					),
				),
    );
		$this->set('migratemembers', $this->Migratemember->find('all', array('fields' => $fields, 'contain' => $contain, 'conditions' => $filters[$filter], 'order' => 'Migratemember.name')));
		parent::logAction(__FUNCTION__, 'report');
	}

	public function mailmerge() {
		/// Load teammembers model and get them
		$this->loadModel('Teammember');
		$this->Teammember->recursive = 3;
		/// Unbind some stuff
		$this->Teammember->unbindModel(array('hasMany' => array('Gamesteammember', 'Trainingsteammember')));
		$this->Teammember->Member->unbindModel(array('belongsTo' => array('Picture', 'Picturelicense'), 'hasMany' => array('User', 'Coach')));
		//$this->Teammember->Member->Teammember->unbindModel(array('belongsTo' => array('Member')));
		$this->Teammember->Team->unbindModel(array('hasMany' => array('Teammember', 'Game', 'Training')));
		$this->Teammember->Team->Trainingmomentsteam->unbindModel(array('belongsTo' => array('Team')));
		/// Some test queries
		//$teammembers = $this->Teammember->find('all', array('order' => 'team_id'));
		//$teammembers = $this->Teammember->find('all', array('conditions' => array('Member.lastname' => 'Seghers', 'Member.active' => 1, 'Teammember.teampriority' => array(1, 10)), 'order' => array('Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' )));
		/// Below is the real query
		$teammembers = $this->Teammember->find('all', array('conditions' => array('Member.active' => 1, 'Teammember.teampriority' => array(1, 10)), 'order' => array('Team.name' => 'ASC', 'Teammember.teampriority' => 'ASC', 'Member.name' => 'ASC' )));
		/// Load trainingmomentsteam model and get them
		$this->loadModel('Trainingmomentsteam');
		$this->Trainingmomentsteam->recursive = 0;
		$trainingmomentsteams = $this->Trainingmomentsteam->find('all');
		/// Make info available for view
		$this->set('teammembers', $teammembers);
		$this->set('trainingmomentsteams', $trainingmomentsteams);
		$this->set('teampriorities', $this->teampriorities);
		parent::logAction(__FUNCTION__, 'report');
	}

	////	this is an alternative start for the efforts report.
	////	But it doesn't work because the beforefind in the Effort Model overwrites the condition to the currentSeason
	////	So for this to work, you need to comment out the beforeFind function in the Effort Model
	//		public function efforts($theseason = null) {
	//		if (isset($theseason)) {
	//			$this->currentSeason = $theseason;
	//		}
	//		$this->loadModel('Effort');
	//		$this->set('efforts', $this->Effort->find('all', array('order' => array('Effort.taskdate', 'Effort.tasktime'))));
	//		parent::logAction(__FUNCTION__, 'report');
	//	}

	public function efforts() {
		/// Load other models
		$this->loadModel('Effort');
		$this->set('efforts', $this->Effort->find('all', array('order' => array('Effort.taskdate', 'Effort.tasktime'))));
		parent::logAction(__FUNCTION__, 'report');
	}

	public function memberspread() {
		/// Load other models
		$this->loadModel('Member');
		$this->Member->recursive = -1;
		$activememberspercity = $this->Member->find('all',
									array(
										'fields'     => array('Member.city', 'COUNT(Member.city) as aantal'),
										'conditions' => array('Member.active' => true),
										'group'      => array('Member.city'),
										'order'      => array('aantal DESC')
									)
								);
		$memberspreadcity = array();
		foreach ($activememberspercity as $citymembers) {
			$city = (($citymembers['Member']['city'] == '') ? '(geen)' : $citymembers['Member']['city'] );
			$memberspreadcity[$city]['active'] = $citymembers[0]['aantal'];
		}
		$inactivememberspercity = $this->Member->find('all',
									array(
										'fields'     => array('Member.city', 'COUNT(Member.city) as aantal'),
										'conditions' => array('Member.active' => false),
										'group'      => array('Member.city'),
										'order'      => array('aantal DESC')
									)
								);
		foreach ($inactivememberspercity as $citymembers) {
			$city = (($citymembers['Member']['city'] == '') ? '(geen)' : $citymembers['Member']['city'] );
			$memberspreadcity[$city]['inactive'] = $citymembers[0]['aantal'];
		}
		$this->set('memberspreadcity', $memberspreadcity);
		parent::logAction(__FUNCTION__, 'report');
	}

	public function presencestrainings($team_id = null) {
		$this->set('weekd', array('Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'));
		$datefrom = $this->currentYears[0].'-08-01';
		$dateto   = $this->currentYears[1].'-07-31';
		$this->set('period', array('datefrom' => $datefrom, 'dateto' => $dateto));
		if ($team_id <> null) {
			/// Load models
			$this->loadModel('Team');
			$this->Team->id = $team_id;
			$this->Team->recursive = 2;
			$this->Team->unbindModel(array('hasMany' => array('Game', 'Training', 'Trainingmomentsteam')));
			$this->Team->Teammember->unbindModel(array('belongsTo' => array('Team'), 'hasMany' => array('Gamesteammember', 'Trainingsteammember')));
			$team = $this->Team->read();
			$theteam = array('name' => $team['Team']['name']);
			foreach ($team['Teammember'] as $teammember) {
				if ($teammember['teampriority'] > 0) {
					$theteam['members'][$teammember['id']] = $teammember['Member']['name'];
				}
			}
			$this->loadModel('Training');
			$this->Training->recursive = 0;
			$this->Training->unbindModel(array('belongsTo' => array('Team', 'Trainingmoment')));
			$thetrainings = $this->Training->find('all', array('conditions' => array('Training.team_id' => $team_id, 'Training.start_date >=' => $datefrom, 'Training.start_date <=' => $dateto), 'order' => array('Training.start_date'), 'recursive' => 1));
			$thematrix = array();
			foreach ($thetrainings as $thetraining) {
				$thematrix[$thetraining['Training']['id']]['day'] = $thetraining['Training']['day_of_week'];
				$thematrix[$thetraining['Training']['id']]['date'] = $thetraining['Training']['start_date_nice'];
				$thematrix[$thetraining['Training']['id']]['time'] = $thetraining['Training']['start_time_nice'];
				$thematrix[$thetraining['Training']['id']]['presences'] = array();
				foreach ($thetraining['Trainingsteammember'] as $thepresence) {
					$thematrix[$thetraining['Training']['id']]['presences'][$thepresence['teammember_id']] = $thepresence['status'];
				}
			}
			$this->set('matrix', $thematrix);
			//$this->set('team', $team);
			$this->set('theteam', $theteam);
			$this->set('trainings', $thetrainings);
			//$this->set('teammembers', $teammembers);
			parent::logAction(__FUNCTION__, 'report', $team_id);
		} else {
			$this->set('team', array('Team' => array('full_name' => 'geen', 'competition' => '-')));
		}
	}

	public function presencesgames($team_id = null) {
		$this->set('weekd', array('Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'));
		$datefrom = $this->currentYears[0].'-08-01';
		$dateto   = $this->currentYears[1].'-07-31';
		$this->set('period', array('datefrom' => $datefrom, 'dateto' => $dateto));
		if ($team_id <> null) {
			/// Load models
			$this->loadModel('Team');
			$this->Team->id = $team_id;
			$this->Team->recursive = 2;
			$this->Team->unbindModel(array('hasMany' => array('Game', 'Training', 'Trainingmomentsteam')));
			$this->Team->Teammember->unbindModel(array('belongsTo' => array('Team'), 'hasMany' => array('Gamesteammember', 'Trainingsteammember')));
			$team = $this->Team->read();
			$theteam = array('name' => $team['Team']['name']);
			foreach ($team['Teammember'] as $teammember) {
				if ($teammember['teampriority'] > 0) {
					$theteam['members'][$teammember['id']] = $teammember['Member']['name'];
				}
			}
			$this->loadModel('Game');
			$this->Game->recursive = 0;
			$this->Game->unbindModel(array('belongsTo' => array('Team', 'Coach')));
			$thegames = $this->Game->find('all', array('conditions' => array('Game.team_id' => $team_id, 'Game.game_date >=' => $datefrom, 'Game.game_date <=' => $dateto), 'order' => array('Game.game_date'), 'recursive' => 1));
			$thematrix = array();
			foreach ($thegames as $thegame) {
				$thematrix[$thegame['Game']['id']]['day'] = $thegame['Game']['day_of_week'];
				$thematrix[$thegame['Game']['id']]['date'] = $thegame['Game']['game_date_nice'];
				$thematrix[$thegame['Game']['id']]['time'] = $thegame['Game']['game_time_nice'];
				$thematrix[$thegame['Game']['id']]['title'] = (($thegame['Game']['home_game'] == '1') ? 'tegen ' . $thegame['Game']['game_away'] : 'op ' . $thegame['Game']['game_home']);
				$thematrix[$thegame['Game']['id']]['presences'] = array();
				foreach ($thegame['Gamesteammember'] as $thepresence) {
					$thematrix[$thegame['Game']['id']]['presences'][$thepresence['teammember_id']] = $thepresence['status'];
				}
			}
			$this->set('matrix', $thematrix);
			//$this->set('team', $team);
			$this->set('theteam', $theteam);
			$this->set('games', $thegames);
			//$this->set('teammembers', $teammembers);
			parent::logAction(__FUNCTION__, 'report', $team_id);
		} else {
			$this->set('team', array('Team' => array('full_name' => 'geen', 'competition' => '-')));
		}
	}

	public function presencesallgames($filter = null) {
		$this->set('weekd', array('Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'));
		$datefrom = $this->currentYears[0].'-08-01';
		$dateto   = $this->currentYears[1].'-07-31';
		$this->set('period', array('datefrom' => $datefrom, 'dateto' => $dateto));
		if ($filter <> null) {
			if ($filter == 'all') {
				/// Load models
				$this->loadModel('Team');
				$this->Team->recursive = 2;
				/// Prevent unwanted info from being loaded
				$this->Team->unbindModel(array('belongsTo' => array('Picture'), 'hasMany' => array('Teammember', 'Training', 'Trainingmomentsteam')));
				$this->Team->Game->unbindModel(array('belongsTo' => array('Team', 'Coach')));
				$this->Team->bindModel(array('hasMany' => array('Teammember' => array(
																			'className' => 'Teammember',
																			'conditions' => array('Teammember.teampriority >=' => '1', 'Teammember.teampriority <=' => '10')
																		))));
				$this->Team->Teammember->unbindModel(array('belongsTo' => array('Team'), 'hasMany' => array('Gamesteammember', 'Trainingsteammember')));
				$team = $this->Team->find('all', array('conditions' => array('Team.id >' => 0), 'order' => array('Team.display_order' => 'ASC', 'Team.name' => 'ASC')));
				$theMatrix = array();
				foreach ($team as $oneTeam) {
					$theMatrix[$oneTeam['Team']['id']] = array();
					foreach ($oneTeam['Game'] as $oneGame) {
						$theMatrix[$oneTeam['Team']['id']][$oneGame['id']]['presence'] = array();
						foreach ($oneGame['Gamesteammember'] as $onepresence) {
							$theMatrix[$oneTeam['Team']['id']][$oneGame['id']]['presence'][$onepresence['teammember_id']] = $onepresence['status'];
						}
					}
				}
			}
			$this->set('team', $team);
			$this->set('theMatrix', $theMatrix);
			parent::logAction(__FUNCTION__, 'report');
		} else {
			$this->set('team', array('Team' => array('full_name' => 'geen', 'competition' => '-')));
		}
	}

	public function presencesalltrainings($filter = null) {
		$this->set('weekd', array('Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'));
		$datefrom = $this->currentYears[0].'-08-01';
		$dateto   = $this->currentYears[1].'-07-31';
		$this->set('period', array('datefrom' => $datefrom, 'dateto' => $dateto));
		if ($filter <> null) {
			if ($filter == 'all') {
				/// Load models
				$this->loadModel('Team');
				$this->Team->recursive = 2;
				/// Prevent unwanted info from being loaded
				$this->Team->unbindModel(array('belongsTo' => array('Picture'), 'hasMany' => array('Teammember', 'Game', 'Trainingmomentsteam')));
				$this->Team->Training->unbindModel(array('belongsTo' => array('Team', 'Trainingmoment')));
				$this->Team->bindModel(array('hasMany' => array('Teammember' => array(
																			'className' => 'Teammember',
																			'conditions' => array('Teammember.teampriority >=' => '1', 'Teammember.teampriority <=' => '10')
																		))));
				$this->Team->Teammember->unbindModel(array('belongsTo' => array('Team'), 'hasMany' => array('Gamesteammember', 'Trainingsteammember')));
				$team = $this->Team->find('all', array('conditions' => array('Team.id >' => 0), 'order' => array('Team.display_order' => 'ASC', 'Team.name' => 'ASC')));
				$theMatrix = array();
				foreach ($team as $oneTeam) {
					$theMatrix[$oneTeam['Team']['id']] = array();
					foreach ($oneTeam['Training'] as $oneTraining) {
						$theMatrix[$oneTeam['Team']['id']][$oneTraining['id']]['presence'] = array();
						foreach ($oneTraining['Trainingsteammember'] as $onepresence) {
							$theMatrix[$oneTeam['Team']['id']][$oneTraining['id']]['presence'][$onepresence['teammember_id']] = $onepresence['status'];
						}
					}
				}
			}
			$this->set('team', $team);
			$this->set('theMatrix', $theMatrix);
			parent::logAction(__FUNCTION__, 'report');
		} else {
			$this->set('team', array('Team' => array('full_name' => 'geen', 'competition' => '-')));
		}
	}

	public function usersperrole() {
		/// Load other models
		$this->loadModel('User');
		$this->set('users', $this->User->find('all', array('order' => array('User.role', 'User.active DESC', 'User.username'))));
		parent::logAction(__FUNCTION__, 'report');
	}

}
