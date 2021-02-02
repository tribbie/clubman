<?php
class UsersController extends AppController {

	//var $scaffold;
	public $helpers = array('Link');
	var $roles = array(
						'admin'						=> 'Hoofdadministrator',
						'teamadmin'				=> 'Team administratie',
						'gameadmin'				=> 'Wedstrijd administratie',
						'memberadmin'			=> 'Ledenadministratie',
						'trainerfinance'	=> 'Financiën trainers',
						'memberfinance'		=> 'Financiën leden',
						'memberview'			=> 'Raadplegen leden',
						'memberedit'			=> 'Wijzigen leden',
						'trainer'					=> 'Trainer',
						'member'					=> 'Lid'
					);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login', 'logout', 'root');
		//$this->Auth->deny('index');
	}


	public function login() {
		if ($this->request->is('post')) {
			if (strtolower($this->request->data['User']['username']) == 'root') {
				/// root can always login
			} else {
				if (isset($this->currentClubman['allowlogin']) and ($this->currentClubman['allowlogin'] == 'no')) {
					$this->Session->setFlash(__('Login tijdelijk niet mogelijk.'), 'flash-error');
					return $this->redirect(array('controller' => 'users', 'action' => 'login'));
				}
			}
			if ($this->Auth->login()) {
				parent::logAction(__FUNCTION__, 'user');
				//$this->redirect($this->Auth->redirectUrl());
				/// Cumulated roles - we take the first role in the list
				$roles = explode(',', $this->Auth->user('role'));
				$mainRole = $roles[0];
				$this->redirect($this->cmuserrolehome[$mainRole]);
			} else {
				$this->Session->setFlash(__('Gebruiker of wachtwoord is fout.'), 'flash-error');
			}
		} else {
			$users = $this->User->find('list');
			if (count($users) == 0) {
				return $this->redirect(array('controller' => 'users', 'action' => 'root'));
			}
		}
	}


	public function logout() {
		$this->Session->setFlash(__('Gebruiker is afgemeld.'), 'flash-info');
		parent::logAction(__FUNCTION__, 'user');
		$this->redirect($this->Auth->logout());
	}


	public function root() {
		$users = $this->User->find('list');
		if (count($users) > 0) {
			$this->Session->setFlash(__('Er zijn reeds gebruikers. Gelieve in te loggen.'), 'flash-info');
			return $this->redirect(array('controller' => 'users', 'action' => 'login'));
		} else {
			if ($this->request->is('post')) {
				$this->User->create();
				$this->request->data['User']['username'] = 'root';
				$this->request->data['User']['role'] = 'root';
				$this->request->data['User']['remark'] = 'superuser';
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('De root gebruiker werd geïnitializeerd.'), 'flash-info');
					parent::logAction(__FUNCTION__, 'user', $this->User->id);
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('De root gebruiker kon niet worden geïnitializeerd.'), 'flash-error');
				}
			}
		}
	}


	/// Emergency function to reset the root password
	///
	/// 6 steps:
	/// step 1: uncomment this function
	/// step 2: add the function to the allow list (in beforeFilter)
	/// step 3: set the resetkey for root (directly in the database)
	/// step 4: go to the url clubman/users/resetroot/<your_resetkey>
	/// step 5: remove the function from the allow list (in beforeFilter)
	/// step 6: re-comment this function
	///
	// public function resetroot($resetkey = null) {
	// 	$this->User->id = 1;
	// 	if (!$this->User->exists()) {
	// 		throw new NotFoundException(__('Root gebruiker bestaat niet. Reset mislukt.'));
	// 	}
	// 	$user = $this->User->read(null);
	// 	if (trim($resetkey) == trim($user['User']['resetkey'])) {
	// 		$user['User']['password'] = 'root';
	// 		$user['User']['password_confirmation'] = 'root';
	// 		$user['User']['resetkey'] = null;
	// 		if ($this->User->save($user)) {
	// 			$this->Session->setFlash(__('Root gebruiker werd gereset.'), 'flash-info');
	// 			parent::logAction(__FUNCTION__, 'user', $this->User->id);
	// 			$this->redirect(array('controller' => 'users', 'action' => 'login'));
	// 		} else {
	// 			$this->Session->setFlash(__('Root gebruiker kon niet worden gereset.'), 'flash-error');
	// 		}
	// 	} else {
	// 		$this->Session->setFlash(__('Ongeldige resetkey. Reset mislukt.'), 'flash-error');
	// 	}
	// }


	public function index() {
		$this->User->recursive = 1;
		$listFields = array('User.id', 'User.uuid', 'User.member_id', 'User.username', 'User.role', 'User.active', 'User.remark', 'Member.lastname', 'Member.firstname', 'Member.email');
		$listOrder = array('User.active DESC', 'User.username');
		$users = $this->User->find('all', array('fields' => $listFields, 'order' => $listOrder));
		$this->set('users', $users);
	}


	public function view($id = null) {
		$this->User->recursive = 2;
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Gebruiker bestaat niet.'));
		}
		$this->set('user', $this->User->read(null, $id));
	}


	public function add() {
		if ($this->request->is('post')) {
			/// Flatten selected (multi-)roles into list
			$this->request->data['User']['role'] = implode(',', $this->request->data['User']['roles']);
			/// Generate a uuid 5ba63bb8-6a3c-4ba2-b923-0512c0a8000c
			$this->request->data['User']['uuid'] = CakeText::uuid();
			/// And create the new record
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('De gebruiker werd bewaard.'), 'flash-info');
				parent::logAction(__FUNCTION__, 'user', $this->User->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('De gebruiker kon niet worden bewaard. Mogelijk is deze gebruikersnaam reeds in gebruik of is er een ongeldige rol gekozen.'), 'flash-error');
			}
		}
		$this->set('members', $this->User->Member->find('list'));
		$this->set('roles', $this->roles);
	}


	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Gebruiker bestaat niet.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			/// Validate the roles: max 5 and no empty entry
			if (count($this->request->data['User']['roles']) > 5) {
				$this->Session->setFlash(__('De gebruiker kon niet worden bewaard. Er zijn te veel rollen gekozen (max 5).'), 'flash-error');
			} else {
				if (count(array_filter($this->request->data['User']['roles'])) == count($this->request->data['User']['roles'])) {
					/// Generate a uuid is only needed in add
					//if ($this->request->data['User']['uuid'] == '') {
					//	$this->request->data['User']['uuid'] = CakeText::uuid();
					//}
					/// Flatten selected (multi-)roles into list
					$this->request->data['User']['role'] = implode(',', $this->request->data['User']['roles']);
					/// And save the record
					if ($this->User->save($this->request->data)) {
						$this->Session->setFlash(__('De gebruiker werd bewaard.'), 'flash-info');
						parent::logAction(__FUNCTION__, 'user', $this->User->id);
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('De gebruiker kon niet worden bewaard. Mogelijk is deze gebruikersnaam reeds in gebruik of is er een ongeldige rol gekozen.'), 'flash-error');
					}
				} else {
					$this->Session->setFlash(__('De gebruiker kon niet worden bewaard. Ongeldige rol gekozen.'), 'flash-error');
				}
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			/// Remove the password (we don't want to send this to the browser)
			unset($this->request->data['User']['password']);
			/// Prepare multi-roles array
			$this->request->data['User']['roles'] = explode(',', $this->request->data['User']['role']);
		}
		$this->set('user', $this->User->read());
		$this->set('roles', $this->roles);
		//$this->set('shizzle', array('caketextuuid' => CakeText::uuid()));
	}


	public function reports() {
	}


	public function profile($id = null) {
		if (!isset($id)) $id = $this->currentUser['id'];
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Gebruiker bestaat niet.'));
		}
		$this->set('user', $this->User->read(null, $id));
	}


	public function changepassword($id = null) {
		if ($this->Auth->user('id') <> $id) {
			$this->Session->setFlash(__('Je kan enkel je eigen wachtwoord aanpassen'), 'flash-error');
			$this->redirect(array('action' => 'profile'));
		} else {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Gebruiker bestaat niet!'));
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('Het nieuwe wachtwoord werd bewaard'), 'flash-info');
					parent::logAction(__FUNCTION__, 'user', $this->User->id);
					$this->redirect(array('action' => 'profile'));
					//$this->redirect('/');
				} else {
					$this->Session->setFlash(__('Het nieuwe wachtwoord kon niet bewaard worden!'), 'flash-error');
				}
			} else {
				$this->request->data = $this->User->read(null, $id);
				unset($this->request->data['User']['password']);
			}
		}
	}


	public function resetpassword($id = null, $resetkey = null) {
		$pwResetAllowed = false;
		$pwResetMode = '';
		if ($this->Auth->user('username') == 'root') {
			// You are root -- you can reset every password (except your own)
			if ($id == 1) {
				$this->Session->setFlash(__('Paswoord resetten mislukt - gaat niet voor root'), 'flash-error');
				$this->redirect(array('action' => 'index'));
			} else {
				$pwResetAllowed = true;
				$pwResetMode = 'root';
			}
		} else {
			// You are not root -- you will need a reset-key
			if ($resetkey) {
				$pwResetAllowed = true;
				$pwResetMode = 'resetkey';
			} else {
				$this->Session->setFlash(__('Paswoord resetten mislukt - geen resetkey'), 'flash-error');
				$this->redirect('/');
			}
		}
		if ($pwResetAllowed) {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				$this->Session->setFlash(__('Paswoord resetten mislukt - gebruiker bestaat niet!'), 'flash-error');
				$this->redirect('/');
			}
			if ($pwResetMode == 'root') {
				$this->User->saveField('password', strtolower($this->User->field('username')));
				//$this->User->saveField('reset', date('Y-m-d H:i:s'));
				$this->Session->setFlash(__('Paswoord resetten gelukt - is nu hetzelfde als de login!'), 'flash-info');
				parent::logAction(__FUNCTION__, 'user', $id);
				$this->redirect(array('action' => 'index'));
			} elseif ($pwResetMode == 'resetkey') {
				/// check the (hidden) resetkey
				/// if resetkey found - update the user password
				$this->Session->setFlash(__('Paswoord resetten mislukt - nog niet ondersteund!'), 'flash-error');
				$this->redirect('/');
				//if ($this->request->is('post') || $this->request->is('put')) {
				//	if ($this->User->save($this->request->data)) {
				//		$this->Session->setFlash(__('Het wachtwoord werd gereset'), 'flash-info');
				//		parent::logAction(__FUNCTION__, 'user', $id);
				//		$this->redirect(array('action' => 'profile'));
				//		//$this->redirect('/');
				//	} else {
				//		$this->Session->setFlash(__('Het nieuwe wachtwoord kon niet bewaard worden!'), 'flash-error');
				//	}
				//} else {
				//	$this->request->data = $this->User->read(null, $id);
				//	unset($this->request->data['User']['password']);
				//}
			}
		} else {
			$this->Session->setFlash(__('Paswoord resetten gefaald - geen permissie!'), 'flash-error');
			$this->redirect('/');
		}
	}


	public function delete($id = null) {
		if (isset($id)) {
			if ($id == $this->Auth->user('id')) {
				$this->Session->setFlash(__('Je kan je eigen niet verwijderen.'), 'flash-error');
				//$this->redirect(array('action' => 'profile'));
				$this->redirect(array('action' => 'index'));
			} else {
				//if (!$this->request->is('post')) {
				//	throw new MethodNotAllowedException();
				//}
				$this->User->id = $id;
				if (!$this->User->exists()) {
					//throw new NotFoundException(__('Gebruiker bestaat niet!'));
					$this->Session->setFlash(__('Deze gebruiker bestaat niet. Er werd niets verwijderd.'), 'flash-error');
					$this->redirect(array('action' => 'index'));
				}
				/// Here should be added that user root cannot be deleted, unless we want to allow that ...
				if ($id == 1) {
					$this->Session->setFlash(__('De gebruiker "root" kan niet worden verwijderd'), 'flash-error');
					$this->redirect(array('action' => 'index'));
				}
				/// Besides, if only root is able to delete users, and one cannot delete itself, then there is no problem
				if ($this->User->delete()) {
					$this->Session->setFlash(__('De gebruiker is verwijderd.'), 'flash-info');
					parent::logAction(__FUNCTION__, 'user', $id);
					//$this->redirect(array('action' => 'profile'));
					$this->redirect(array('action' => 'index'));
				}
			}
		} else {
			$this->Session->setFlash(__('Deze gebruiker kon niet worden verwijderd'), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
	}


}
