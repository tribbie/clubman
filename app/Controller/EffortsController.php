<?php
class EffortsController extends AppController {

	public $components = array('RequestHandler');

	var $tasknames = array(
										'' => '',
										'training' 		=> 'Training',
										'coaching' 		=> 'Coaching',
										'assistentie' => 'Assistentie',
										'demotornooi'	=> 'Demotornooi',
										'coordinatie' => 'Coördinatie',
										'andere' 			=> 'Andere'
									);
	var $taskdurations = array('0' => '-', '30' => 'half uur', '45' => 'drie kwartier', '60' => '1 uur', '75' => '1 uur en een kwart', '90' => '1,5 uur', '105' => '1 uur en drie kwart', '120' => '2 uur', '135' => '2 uur en een kwart', '150' => '2,5 uur', '180' => '3 uur', '210' => '3,5 uur', '240' => '4 uur');


	public function index() {
		$memberid = $this->currentUser['Member']['id'];
		//$this->Effort->recursive = -1;
		$efforts = $this->Effort->find('all', array('conditions' => array('Effort.member_id' => $memberid), 'order' => array('Effort.taskdate', 'Effort.tasktime')));
		$this->set('efforts', $efforts);
	}


	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Ongeldige prestatie', true), "flash-error");
			$this->redirect(array('action' => 'index'));
		}
		$this->Effort->id = $id;
		if (!$this->Effort->exists()) {
			$this->Session->setFlash(__('Prestatie bestaat niet', true), "flash-error");
			$this->redirect(array('action' => 'index'));
		}
		//$this->Effort->recursive = 2;
		$this->set('effort', $this->Effort->read());
	}


	public function add($teamid = null) {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Effort->create();
			if ($this->Effort->save($this->request->data)) {
				$this->Session->setFlash(__('De prestatie werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'effort', $this->Effort->id);
				//$this->redirect(array('action' => 'view', $this->Effort->id));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('De prestatie kon niet worden bewaard.'), "flash-error");
			}
		}
		$this->request->data['Effort']['member_id'] = $this->currentUser['Member']['id'];
		$this->request->data['Effort']['team_id'] = $teamid;
		$this->set('teams', $this->Effort->Team->find('list'));
		/// We now put the list of users into the dropdown list - see further below
		//$this->set('members', $this->Effort->Member->User->find('list', array('fields' => array('User.member_id', 'User.username'), 'conditions' => array('User.active' => 1), 'recursive' => 0)));
		$this->set('tasknames', $this->tasknames);
		$this->set('taskdurations', $this->taskdurations);
		/// The contain parameter needs the containable setting in the model ...
		$users = $this->Effort->Member->User->find('all', array('contain' => array('Member.id', 'Member.name'), 'conditions' => array('User.member_id <>' => '', 'User.active' => 1), 'order' => 'Member.name'));
		$userlist = Set::combine($users , '{n}.User.member_id', array('{0} ({1})', '{n}.Member.name', '{n}.User.username'));
		$this->set('members', $userlist);
		//$this->set('current_user', $this->currentUser);
	}


	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Fout: Geen prestatie meegegeven.'));
		}
		$effort = $this->Effort->findById($id);
		if (!$effort) {
			throw new NotFoundException(__('Fout: Prestatie bestaat niet.'));
		}
		/// Only root and admin can edit efforts not belonging to them
		if ((ClubmanUtilityLib::elementsInArray($this->cmCurrentRoles, ['root', 'admin']) == 0) and ($effort['Effort']['member_id'] <> $this->currentUser['member_id'])) {
			$this->Session->setFlash(__('Je kan enkel je eigen prestaties wijzigen.'), "flash-error");
			//parent::logAction(__FUNCTION__, 'effort', $this->Effort->id);
			$this->redirect(array('action' => 'index'));
		} else {
			if ($this->request->is('post') || $this->request->is('put')) {
				$this->Effort->id = $id;
				if ($this->Effort->save($this->request->data)) {
					$this->Session->setFlash(__('De prestatie werd bewaard.'), "flash-info");
					parent::logAction(__FUNCTION__, 'effort', $this->Effort->id);
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('De prestatie kon niet worden bewaard.'), "flash-error");
				}
			}
			if (!$this->request->data) {
				$this->request->data = $effort;
			}
			//$this->set('effort', $effort);
			$this->set('member', $this->Effort->Member->read(null, $this->request->data['Effort']['member_id']));
			$this->set('teams', $this->Effort->Team->find('list'));
			/// We now put the list of users into the dropdown list - see further below
			//$this->set('members', $this->Effort->Member->find('list'));
			$this->set('tasknames', $this->tasknames);
			$this->set('taskdurations', $this->taskdurations);
			/// The contain parameter needs the containable setting in the model ...
			$users = $this->Effort->Member->User->find('all', array('contain' => array('Member.id', 'Member.name'), 'conditions' => array('User.member_id <>' => '', 'User.active' => 1), 'order' => 'Member.name'));
			$userlist = Set::combine($users , '{n}.User.member_id', array('{0} ({1})', '{n}.Member.name', '{n}.User.username'));
			$this->set('members', $userlist);
			//$this->set('current_user', $this->currentUser);
		}
	}


	public function reports() {
	}


	public function listmember($memberid = 'all') {
		$members = array();
		if ($memberid == 'all') {
			$member['Member']['name'] = 'iedereen';
			$efforts = $this->Effort->find('all', array('order' => array('Member.name', 'Effort.taskdate', 'Effort.tasktime')));
		} else {
			$member = $this->Effort->Member->read(array('Member.name', 'Picture.location'), $memberid);
			$efforts = $this->Effort->find('all', array('conditions' => array('Effort.member_id' => $memberid), 'order' => array('Effort.taskdate', 'Effort.tasktime')));
		}
		$this->set('member', $member);
		$this->set('efforts', $efforts);
	}


	public function listteam($teamid = null) {
		$this->set('team', $this->Effort->Team->read(array('Team.name', 'Picture.location'), $teamid));
		$this->set('efforts', $this->Effort->find('all', array('conditions' => array('Effort.team_id' => $teamid), 'order' => array('Effort.taskdate', 'Effort.tasktime'))));
	}


	public function periodicoverview($datefrom = null, $dateto = null) {
		if (isset($this->params['named']['from'])) {
			$datefrom = $this->params['named']['from'];
		}
		if (isset($this->params['named']['to'])) {
			$dateto = $this->params['named']['to'];
		}
		$this->request->data = array('Effort' => array('datefrom' => $datefrom, 'dateto' => $dateto));
	}


	public function ajfetchperiod($datefrom = null, $dateto = null) {
		/// We don't render a view in this example
		$this->autoRender = false;
		if (isset($this->params['named']['from'])) {
			$datefrom = $this->params['named']['from'];
		}
		if (isset($this->params['named']['to'])) {
			$dateto = $this->params['named']['to'];
		}
		if (!$datefrom) $datefrom = $this->currentYears[0].'-08-01';
		if (!$dateto)   $dateto   = $this->currentYears[1].'-07-31';
		$effortsAndTotals = $this->getEffortsAndTotals($datefrom, $dateto);
		parent::logAction(__FUNCTION__, 'effort', 0);
		$period  = $effortsAndTotals['period'];
		$efforts = $effortsAndTotals['efforts'];
		$totals  = $effortsAndTotals['totals'];
		$response = array(
			'data' => array('period' => $period, 'totals' => $totals),
			'meta' => array('request' => $this->request, 'cakedata' => array('efforts' => $efforts)),
			//'error' => '',
		);
		return json_encode($response);
	}


	private function getEffortsAndTotals($datefrom = null, $dateto = null) {
		if (!$datefrom) $datefrom = $this->currentYears[0].'-08-01';
		if (!$dateto)   $dateto   = $this->currentYears[1].'-07-31';
		$period = array('datefrom' => $datefrom, 'dateto' => $dateto);
		$this->Effort->Behaviors->load('Containable');
		$fields = array('Effort.season', 'Effort.member_id', 'Effort.taskdate', 'Effort.taskname', 'Effort.taskduration', 'Effort.remark');
		$contain = array(
				'Member' => array(
					'fields' => array('firstname', 'lastname'),
				),
    );
		$conditions = array('Effort.taskdate >=' => $datefrom, 'Effort.taskdate <=' => $dateto);
		$efforts = $this->Effort->find('all', array('fields' => $fields, 'contain' => $contain, 'conditions' => $conditions, 'order' => array('member_id', 'taskdate')));
		$totals = array();
		$totals = $this->generateTotals($efforts);
		return array('period' => $period, 'totals' => $totals, 'efforts' => $efforts);
	}


	private function generateTotals($theEfforts) {
		$totals = array();
		foreach ($theEfforts as $effort) {
			$memberid = $effort['Member']['id'];
			$membername = $effort['Member']['lastname'] . ' ' . $effort['Member']['firstname'];
			if (isset($totals[$memberid]) == FALSE) {
				$totals[$memberid]['totals']['id'] = $memberid;
				$totals[$memberid]['totals']['name'] = $membername;
				$totals[$memberid]['totals']['trainings'] = 0;
				$totals[$memberid]['totals']['trainingminutes'] = 0;
				$totals[$memberid]['totals']['coachings'] = 0;
				$totals[$memberid]['totals']['demos'] = 0;
				$totals[$memberid]['totals']['assists'] = 0;
				$totals[$memberid]['totals']['assistminutes'] = 0;
				$totals[$memberid]['totals']['coords'] = 0;
				$totals[$memberid]['totals']['coordminutes'] = 0;
				$totals[$memberid]['totals']['others'] = 0;
				$totals[$memberid]['totals']['otherminutes'] = 0;
				$totals[$memberid]['totals']['effortcount'] = 0;
				$totals[$memberid]['totals']['amount'] = 0;
			}
			$totals[$memberid]['totals']['effortcount'] += 1;
			$totals[$memberid]['efforts'][] = $effort;
			switch ($effort['Effort']['taskname']) {
				case 'coaching':
					$totals[$memberid]['totals']['coachings'] += 1;
					break;
				case 'training':
					$totals[$memberid]['totals']['trainings'] += 1;
					$totals[$memberid]['totals']['trainingminutes'] += $effort['Effort']['taskduration'];
					break;
				case 'demotornooi':
					$totals[$memberid]['totals']['demos'] += 1;
					break;
				case 'assistentie':
					$totals[$memberid]['totals']['assists'] += 1;
					$totals[$memberid]['totals']['assistminutes'] += $effort['Effort']['taskduration'];
					break;
				case 'coordinatie':
					$totals[$memberid]['totals']['coords'] += 1;
					$totals[$memberid]['totals']['coordminutes'] += $effort['Effort']['taskduration'];
					break;
				case 'andere':
					$totals[$memberid]['totals']['others'] += 1;
					$totals[$memberid]['totals']['otherminutes'] += $effort['Effort']['taskduration'];
					break;
			}
		}
		return $totals;
	}


}
