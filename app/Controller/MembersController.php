<?php
class MembersController extends AppController {

	// var $scaffold;

	public $components = array('RequestHandler');

	var $memberfilters = array(
							'root'						=> array('filter' => array('id >' => 0)),
							'admin'						=> array('filter' => array('active' => true)),
							'teamadmin'				=> array('filter' => array('active' => true)),
							'gameadmin'				=> array('filter' => array('active' => true)),
							'memberadmin'			=> array('filter' => array('active' => true)),
							'trainerfinance'	=> array('filter' => array('active' => true)),
							'memberfinance'		=> array('filter' => array('active' => true)),
							'memberview'			=> array('filter' => array('active' => true)),
							'memberedit'			=> array('filter' => array('active' => true)),
							'trainer'					=> array('filter' => array('active' => true)),
							'member'					=> array('filter' => array('active' => true)),
							'all'							=> array('filter' => array('id >' => 0), 'label' => 'alle'),
							'active'					=> array('filter' => array('active' => true), 'label' => 'actieve'),
							'inactive'				=> array('filter' => array('active' => false), 'label' => 'inactieve')
						);


	public function index($filter = null, $filtervalue = null) {
		if (!$filter) {
			//$memberfilter = $this->memberfilters[$this->currentUser['role']];
			$memberfilter = $this->memberfilters[$this->cmCurrentRoles[0]];
		} else {
			if (!$filtervalue) {
				$memberfilter = $this->memberfilters[$filter];
			} else {
				//$memberfilter = $this->memberfilters[$this->currentUser['role']];
				//$memberfilter['filter'][] = array($filter => $filtervalue);
				//$memberfilter['label'] = $filter . ' = ' . $filtervalue;
				$memberfilter = array('filter' => array('active' => true, $filter => $filtervalue), 'label' => $filter . ' = ' . $filtervalue);
			}
		}
		$this->Member->recursive = -1;
		$this->set('members', $this->Member->find('all', array('conditions' => $memberfilter['filter'], 'fields' => array('Member.id', 'Member.lastname', 'Member.name', 'Member.active'))));
		$this->set('memberfilter', $memberfilter);
	}


	public function filter() {
		$this->set('filters', $this->params['named']);
		if (count($this->params['named']) > 0) {
			foreach ($this->params['named'] as $paramkey => $paramvalue) {
				$memberfilter['filter'][] = array($paramkey => $paramvalue);
				$memberfilter['label'][] = $paramkey.'='.$paramvalue;
			}
		} else {
			$this->redirect(array('action' => 'index'));
		}
		$this->Member->recursive = -1;
		$this->set('members', $this->Member->find('all', array('conditions' => $memberfilter['filter'], 'fields' => array('Member.id', 'Member.lastname', 'Member.name', 'Member.active'))));
		$this->set('memberfilter', $memberfilter);
	}


	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Ongeldig lid', true), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
		$this->Member->id = $id;
		if (!$this->Member->exists()) {
			$this->Session->setFlash(__('Lid bestaat niet', true), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
		$this->Member->recursive = 2;
		$this->set('member', $this->Member->read());
		$this->set('teampriorities', $this->teampriorities);
	}


	public function show($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Ongeldig lid', true), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
		$this->Member->id = $id;
		if (!$this->Member->exists()) {
			$this->Session->setFlash(__('Lid bestaat niet', true), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
		if (ClubmanUtilityLib::elementsInArray($this->cmCurrentRoles, ['root', 'admin', 'memberadmin', 'memberfinance', 'memberedit']) > 0) {
			$this->Member->recursive = 2;
			$this->set('teampriorities', $this->teampriorities);
		} else {
			$this->Member->recursive = 1;
		}
		$this->set('member', $this->Member->read());
	}


	public function add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Member->create();
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash(__('Het lid werd bewaard.'), 'flash-info');
				parent::logAction(__FUNCTION__, 'member', $this->Member->id);
				$this->redirect(array('action' => 'view', $this->Member->id));
			} else {
				$this->Session->setFlash(__('Het lid kon niet worden bewaard.'), 'flash-error');
			}
		}
	}


	public function quickadd() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Member->create();
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash(__('Het lid werd bewaard.'), 'flash-info');
				parent::logAction(__FUNCTION__, 'member', $this->Member->id);
				$this->redirect(array('action' => 'view', $this->Member->id));
			} else {
				$this->Session->setFlash(__('Het lid kon niet worden bewaard.'), 'flash-error');
			}
		}
	}


	public function edit($id = null, $partvalue = 'all') {
		$parts = array('all' => 'alle', 'general' => 'algemene', 'team' => 'team', 'contact' => 'contact', 'finance' => 'financiële', 'other' => 'overige', 'picture' => 'beeldjes');
		$part['label'] = $parts[$partvalue];
		$part['value'] = $partvalue;
		$this->Member->id = $id;
		if (!$this->Member->exists()) {
			throw new NotFoundException(__('Lid bestaat niet.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash(__('Het lid werd bewaard.'), 'flash-info');
				parent::logAction(__FUNCTION__, 'member', $id);
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('Het lid kon niet worden bewaard.'), 'flash-error');
			}
		} else {
			$member = $this->Member->read(null, $id);
			$this->request->data = $member;
			$this->set('member', $member);
			$this->set('part', $part);
			if ($partvalue == 'picture') {
				$this->set('pictures', $this->Member->Picture->find('list', array('conditions' => array('category' => 'member'), 'order' => array('modified DESC', 'created DESC'))));
				$this->set('picturelicenses', $this->Member->Picturelicense->find('list', array('conditions' => array('category' => 'memberid'), 'order' => array('modified DESC', 'created DESC'))));
			}
		}
	}


	public function editfinance($id = null) {
		$this->Member->id = $id;
		if (!$this->Member->exists()) {
			throw new NotFoundException(__('Lid bestaat niet.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash(__('Het lid werd bewaard.'), 'flash-info');
				parent::logAction(__FUNCTION__, 'member', $id);
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('Het lid kon niet worden bewaard.'), 'flash-error');
			}
		}
		$member = $this->Member->read(null, $id);
		$this->request->data = $member;
		$this->set('member', $member);
	}


	public function inactivate($id = null) {
		$this->Member->id = $id;
		$member = $this->Member->read();
		if (!$this->Member->exists()) {
			throw new NotFoundException(__('Lid bestaat niet.'));
		}
		if ($this->Member->savefield('active', false)) {
			$this->Session->setFlash(__('Het lid '.$member['Member']['name'].' is nu niet meer actief.'), 'flash-info');
			parent::logAction(__FUNCTION__, 'member', $id);
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__('Het lid kon niet inactief gezet worden.'), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
	}


	public function reactivate($id = null) {
		$this->Member->id = $id;
		$member = $this->Member->read();
		if (!$this->Member->exists()) {
			throw new NotFoundException(__('Lid bestaat niet.'));
		}
		if ($this->Member->savefield('active', true)) {
			$this->Session->setFlash(__('Het lid '.$member['Member']['name'].' is nu terug actief.'), 'flash-info');
			parent::logAction(__FUNCTION__, 'member', $id);
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__('Het lid kon niet actief gezet worden.'), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
	}


	public function reports() {
	}


	public function import() {
		$this->loadModel('Upload');
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->request->data['Member']['uploadid'] !== '') {
				$uploadid = $this->request->data['Member']['uploadid'];
				$this->Upload->id = $uploadid;
				if (!$this->Upload->exists()) {
					//throw new NotFoundException(__('Dit bestand bestaat niet.'));
					$this->Session->setFlash('Dit bestand bestaat niet.', 'flash-error');
				} else {
					$upload = $this->Upload->read();
					/// Import the data
					$importstuff['table'] = $this->Member->tablePrefix . $this->Member->table;
					$importstuff['csvurl'] = $upload['Upload']['location'];
					$importstuff['csvfullpath'] = WWW_ROOT . 'files/uploads/' . $upload['Upload']['location'];
					$importdata = $this->csv_to_array($importstuff['csvfullpath'], ';');
					$importstuff['meta']['csvlines'] = count($importdata);
					$importstuff['data'] = $importdata;
					if ($this->Member->saveMany($importdata, array('validate' => true, 'atomic' => false, 'deep' => false))) {
						$this->Session->setFlash('Importeren gelukt. ' . $importstuff['meta']['csvlines'] . ' leden zijn geïmporteerd.', 'flash-info');
						parent::logAction(__FUNCTION__, 'member', $importstuff['meta']['csvlines']);
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash('Er is iets fout gelopen bij het importeren. Gelieve het csv-bestand na te kijken en opnieuw te proberen.', 'flash-error');
					}
					/// For debugging
					//$this->set('thisimport', $importstuff);
				}
			} else {
				$this->Session->setFlash('Geen bestand geselecteerd. Gelieve een bestand te kiezen.', 'flash-error');
			}
		}
		$this->set('uploadids', $this->Upload->find('list', array('conditions' => array('category' => 'csv'))));
	}


	private function csv_to_array($filename='', $delimiter=',') {
    if (!file_exists($filename) || !is_readable($filename)) {
			return FALSE;
		}
    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE) {
      while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
          if (!$header) {
						$header = $row;
					} else {
						if (count($row) > 1) {
							$data[] = array_combine($header, $row);
						}
					}
      }
      fclose($handle);
    }
    return $data;
	}



	public function linkpictures($category = null, $format = null) {
		$categorydata = array(
							'member'   => array('filter' => '_F_', 'linkfield' => 'picture_id',        'categorystring' => 'foto'),
							'memberid' => array('filter' => '_L_', 'linkfield' => 'picturelicense_id', 'categorystring' => 'licentie')
						);
		$formatdata = array(
			'last_first_yyyy_yy_c_license'   => array('seasonpart' => '_YYYY_YY', 'example' => 'Smith_John_2017_18'.$categorydata[$category]['filter'].'0123456.JPG'),
			'last_first_yyyy_yyyy_c_license' => array('seasonpart' => '_YYYY_YYYY', 'example' => 'Smith_John_2017_2018'.$categorydata[$category]['filter'].'0123456.JPG')
		);
		### memberid/Adons_Nel_2017_18_L_0006731.JPG
		if (!$format) {
			$format = 'last_first_yyyy_yyyy_c_license';
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$links = $this->request->data;
			$savedata = array();
			foreach ($links['Member'] as $link) {
				if ($link['linkok'] == 1) {
					$savedata['Member'][] = array('id' => $link['id'], $categorydata[$category]['linkfield'] => $link['image_id']);
				}
			}
			$savecount = count($savedata['Member']);
			if ($this->Member->saveAll($savedata['Member'])) {
				$this->Session->setFlash(__($savecount . ' foto\'s werden gelinkt.'), 'flash-info');
				parent::logAction(__FUNCTION__, 'member', 0);
				$this->redirect(array('controller' => 'pictures', 'action' => 'category', $category));
			} else {
				$this->Session->setFlash(__('Geen links kunnen leggen.'), 'flash-error');
			}
			$this->set('postdata', $this->request->data);
			$this->set('savedata', $savedata);
			$this->set('linklist', array());
		}
		else {
			/// Retrieve Pictures info
			$this->loadModel('Picture');
			$this->Picture->recursive = 0;
			$pictures = $this->Picture->find('all', array('conditions' => array('category' => $category), 'fields' => array('Picture.id', 'Picture.location')));
			/// Retrieve Members info
			$this->Member->recursive = 0;
			$allmembers = $this->Member->find('all', array('conditions' => array('Member.id >' => 0, 'Member.active' => 1), 'fields' => array('Member.id', 'Member.uname')));
			/// Next hash combine works great, except ... names with accents keep their accents, and we don't want that ...
			//$memberlist = Hash::combine($allmembers, '{n}.Member.uname', '{n}.Member.id');
			/// ... so we do a foreach ourselves
			$memberlist = array();
			foreach ($allmembers as $onemember) {
				$acc   = explode(",","É,È,Ë,Ï");
				$noacc = explode(",","E,E,E,I");
				$flatname = str_replace($acc, $noacc, $onemember['Member']['uname']);
				$memberlist[$flatname] = $onemember['Member']['id'];
			}
			/// Do the controller stuff
			$linklist = array();
			foreach ($pictures as $picture) {
				/// 2014-2015
				/// I look up the beginning of the name by looking up the slash (/), adding this 1 character and adding 8 characters (for the 2014_15_ part)
				//$beginname = strripos($picture['Picture']['location'], '/') + 1 + 8;
				/// I look up the end of the name by looking up the subs (appropriate filter (_F_ for foto, _L_ for licentie) and subtracting the begin position
				//$endname = strripos($picture['Picture']['location'], $categorydata[$category]['filter']) - $beginname;
				/// I replace all underscores with blanks in the found name part
				//$membername = strtoupper(str_replace('_', ' ', substr($picture['Picture']['location'], $beginname, $endname)));
				/// 2015-2016
				/// 2016-2017
				/// VCE shizzle ... memberid/Adons_Nel_2016_17_L_0006731.JPG
				/// 2017-2018 - Now I try to support both (through format) ...
				/// VCW shizzle ... nothing yet ...
				/// VCE shizzle ... memberid/Adons_Nel_2017_18_L_0006731.JPG
				$filename = substr($picture['Picture']['location'], (strripos($picture['Picture']['location'], '/') + 1));
				$codelocation =  strripos($filename, $categorydata[$category]['filter']);
				//$seasonlength = strlen("_2017-2018");
				$seasonlength = strlen($formatdata[$format]['seasonpart']);
				$membername = strtoupper(str_replace('_', ' ', substr($filename, 0, ($codelocation-$seasonlength))));
				if (isset($memberlist[$membername])) {
					$linklist[]['Member'] = array('id' => $memberlist[$membername], 'image_id' => $picture['Picture']['id'], 'image' => $picture['Picture']['location'], 'membername' => $membername, 'linkok' => 1);
				}
			}
			/// Next ones are for debugging
			//$this->set('allmembers', $allmembers);
			//$this->set('pictures', $pictures);
			//$this->set('memberlist', $memberlist);
			/// Next one is needed
			//$this->set('membernames', $membernames);
			$this->set('linklist', $linklist);
		}
		$this->set('categorydata', $categorydata);
		$this->set('formatdata', $formatdata);
		$this->set('category', $category);
	}


	public function bad_linkpictures_with_fixed_infix($category = null) {
		$categorydata = array(
							'member'   => array('filter' => '_F_', 'linkfield' => 'picture_id',        'categorystring' => 'foto'),
							'memberid' => array('filter' => '_L_', 'linkfield' => 'picturelicense_id', 'categorystring' => 'licentie')
						);
		if ($this->request->is('post') || $this->request->is('put')) {
			$links = $this->request->data;
			$savedata = array();
			foreach ($links['Member'] as $link) {
				if ($link['linkok'] == 1) {
					$savedata['Member'][] = array('id' => $link['id'], $categorydata[$category]['linkfield'] => $link['image_id']);
				}
			}
			$savecount = count($savedata['Member']);
			if ($this->Member->saveAll($savedata['Member'])) {
				$this->Session->setFlash(__($savecount . ' foto\'s werden gelinkt.'), 'flash-info');
				parent::logAction(__FUNCTION__, 'member', 0);
				$this->redirect(array('controller' => 'pictures', 'action' => 'category', $category));
			} else {
				$this->Session->setFlash(__('Geen links kunnen leggen.'), 'flash-error');
			}
			$this->set('postdata', $this->request->data);
			$this->set('savedata', $savedata);
			$this->set('linklist', array());
		}
		else {
			/// Retrieve Pictures info
			$this->loadModel('Picture');
			$this->Picture->recursive = 0;
			$pictures = $this->Picture->find('all', array('conditions' => array('category' => $category), 'fields' => array('Picture.id', 'Picture.location')));
			/// Retrieve Members info
			$this->Member->recursive = 0;
			$allmembers = $this->Member->find('all', array('conditions' => array('Member.id >' => 0, 'Member.active' => 1), 'fields' => array('Member.id', 'Member.uname')));
			/// Next hash combine works great, except ... names with accents keep their accents, and we don't want that ...
			//$memberlist = Hash::combine($allmembers, '{n}.Member.uname', '{n}.Member.id');
			/// ... so we do a foreach ourselves
			$memberlist = array();
			foreach ($allmembers as $onemember) {
				$acc   = explode(",","É,È,Ë,Ï");
				$noacc = explode(",","E,E,E,I");
				$flatname = str_replace($acc, $noacc, $onemember['Member']['uname']);
				$memberlist[$flatname] = $onemember['Member']['id'];
			}
			/// Do the controller stuff
			$linklist = array();
			foreach ($pictures as $picture) {
				/// 2014-2015
				/// I look up the beginning of the name by looking up the slash (/), adding this 1 character and adding 8 characters (for the 2014_15_ part)
				//$beginname = strripos($picture['Picture']['location'], '/') + 1 + 8;
				/// I look up the end of the name by looking up the subs (appropriate filter (_F_ for foto, _L_ for licentie) and subtracting the begin position
				//$endname = strripos($picture['Picture']['location'], $categorydata[$category]['filter']) - $beginname;
				/// I replace all underscores with blanks in the found name part
				//$membername = strtoupper(str_replace('_', ' ', substr($picture['Picture']['location'], $beginname, $endname)));
				/// 2015-2016
				/// 2016-2017
				/// VCE shizzle ... memberid/Adons_Nel_2016_17_L_0006731.JPG
				/// 2017-2018
				/// VCW shizzle ... Adons_Nel_2017_2018_F_0006731.JPG
				$filename = substr($picture['Picture']['location'], (strripos($picture['Picture']['location'], '/') + 1));
				$codelocation =  strripos($filename, $categorydata[$category]['filter']);
				$seasonlength = strlen("_2017-2018");
				$membername = strtoupper(str_replace('_', ' ', substr($filename, 0, ($codelocation-$seasonlength))));
				if (isset($memberlist[$membername])) {
					$linklist[]['Member'] = array('id' => $memberlist[$membername], 'image_id' => $picture['Picture']['id'], 'image' => $picture['Picture']['location'], 'membername' => $membername, 'linkok' => 1);
				}
			}
			/// Next ones are for debugging
			//$this->set('allmembers', $allmembers);
			//$this->set('pictures', $pictures);
			//$this->set('memberlist', $memberlist);
			/// Next one is needed
			//$this->set('membernames', $membernames);
			$this->set('linklist', $linklist);
		}
		$this->set('categorydata', $categorydata);
		$this->set('category', $category);
	}


	public function unlinkpictures($category = null) {
		$categorydata = array(
							'member'   => array('linkmodel' => 'Picture',        'linkfield' => 'picture_id',        'categorystring' => 'foto'),
							'memberid' => array('linkmodel' => 'Picturelicense', 'linkfield' => 'picturelicense_id', 'categorystring' => 'licentie')
						);
		if ($this->request->is('post') || $this->request->is('put')) {
			$links = $this->request->data;
			$savedata = array();
			foreach ($links['Member'] as $link) {
				if ($link['unlinkok'] == 1) {
					$savedata['Member'][] = array('id' => $link['id'], $categorydata[$category]['linkfield'] => '');
				}
			}
			$savecount = count($savedata['Member']);
			if ($this->Member->saveAll($savedata['Member'])) {
				$this->Session->setFlash(__($savecount . ' foto\'s werden losgekoppeld.'), 'flash-info');
				parent::logAction(__FUNCTION__, 'member', 0);
				$this->redirect(array('controller' => 'pictures', 'action' => 'category', $category));
			} else {
				$this->Session->setFlash(__('Geen foto\"s kunnen loskoppelen.'), 'flash-error');
			}
			$this->set('postdata', $this->request->data);
			$this->set('savedata', $savedata);
			$linklist = array();
		} else {
			/// retrieve Members info
			$this->Member->recursive = 2;
			$this->Member->unbindModel(array('hasMany' => array('Teammember', 'Coach', 'User')));
			$allmembers = $this->Member->find('all', array('conditions' => array('Member.id >' => 0, 'Member.active' => 1), 'fields' => array('Member.id', 'Member.name', 'Member.picture_id', 'Member.picturelicense_id')));
			/// do the controller stuff
			$linklist = array();
			foreach ($allmembers as $member) {
				if ($member['Member'][$categorydata[$category]['linkfield']] <> '') {
					$linklist[]['Member'] = array('id' => $member['Member']['id'], 'image_id' => $member['Member'][$categorydata[$category]['linkfield']], 'image' => $member[$categorydata[$category]['linkmodel']]['location'], 'membername' => $member['Member']['name'], 'unlinkok' => 1);
				}
			}
			/// Next ones are for debugging
			//$this->set('allmembers', $allmembers);
			/// Next one is needed
			$this->set('linklist', $linklist);
		}
		$this->set('categorydata', $categorydata);
		$this->set('category', $category);
	}


	public function birthdays() {
		$allmembers = array();
		/// Retrieve Members info
		$this->Member->recursive = 2;
		$this->Member->unbindModel(array('hasMany' => array('Teammember', 'Coach', 'User'), 'belongsTo' => array('Picturelicense')));
		$fields = array('Member.id', 'Member.name', 'Member.picture_id', 'Member.active', 'Member.birthdate_nice', 'Member.birthday_public', 'Picture.id', 'Picture.location');
		$allmembers['active'] = $this->Member->find('all', array('conditions' => array('Member.id >' => 0, 'Member.active' => true), 'fields' => $fields));
		$this->Member->unbindModel(array('hasMany' => array('Teammember', 'Coach', 'User'), 'belongsTo' => array('Picturelicense')));
		$allmembers['inactive'] = $this->Member->find('all', array('conditions' => array('Member.id >' => 0, 'Member.active' => false), 'fields' => $fields));
		/// Do the controller stuff
		/// Next ones are for debugging
		//$this->set('allmembers', $allmembers);
		/// Next one is needed
		//$this->set('linklist', $linklist);
		$this->set('allmembers', $allmembers);
	}


	public function ajbirthdaypublic($id = null, $public = null) {
		$data = array();
		$this->request->onlyAllow('ajax'); /// No direct access via browser URL - Note for Cake2.5: allowMethod()
		if (!$id) {
			$this->Session->setFlash(__('Invalid member', true), 'flash-error');
			$data['error'] = 'Invalid member';
		}
		if (!$public) {
		 	$this->Session->setFlash(__('Invalid publish value', true), 'flash-error');
			$data['error'] = 'Invalid publish value';
		} else {
			if ($public == 'true') {
				$publicBool = true;
			} elseif ($public == 'false') {
				$publicBool = false;
			} else {
				$data['error'] = 'Invalid publish value';
			}
		}
		$this->Member->id = $id;
		$this->Member->unbindModel(array('hasMany' => array('Teammember', 'Coach', 'User'), 'belongsTo' => array('Picturelicense')));
		//$member = $this->Member->read(array('id', 'name', 'birthday_public'), $id);
		$member = $this->Member->read();
		if (!$this->Member->exists()) {
			//throw new NotFoundException(__('Lid bestaat niet.'));
			$data['error'] = 'Lid bestaat niet';
		}
		if (isset($publicBool)) {
			if ($this->Member->savefield('birthday_public', $publicBool)) {
				$this->Session->setFlash(__('Het lid '.$member['Member']['name'].' is aangepast.'), 'flash-info');
				//parent::logAction(__FUNCTION__, 'member', $id);
			} else {
				$this->Session->setFlash(__('Het lid kon niet aangepast worden.'), 'flash-error');
				$data['error'] = 'Het lid kon niet aangepast worden';
			}
		} else {
			$data['error'] = 'Het lid werd niet aangepast';
		}
		$data['content'] = array($id, $public, $publicBool);
		$this->Member->unbindModel(array('hasMany' => array('Teammember', 'Coach', 'User'), 'belongsTo' => array('Picturelicense')));
		$data['member'] = $this->Member->read(array('id', 'name', 'birthday_public'), $id);
		/// Pass $data to the view
		$this->set(compact('data'));
		/// Let the JsonView class know what variable to use
		$this->set('_serialize', 'data');
	}

}
