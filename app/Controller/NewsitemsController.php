<?php
class NewsitemsController extends AppController {

	//var $scaffold;

	public $helpers = array('Markdown.Markdown');
	public $components = array('RequestHandler');


	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'viewtxt');
		//$this->Auth->deny('index');
	}


	public function index() {
		$this->Newsitem->recursive = -1;
		$fieldlist = array(
										'id',
										'name',
										'category',
										'season',
										'title',
										'subtitle',
										'status',
										'itemdate_nice',
										'activate_nice',
										'expire_nice',
										'author'
									);
		$conditions = array('Newsitem.id >' => 0);
		$itemorder = array('season DESC', 'itemdate DESC', 'activate DESC', 'expire DESC');
		$this->set('newsitems', $this->Newsitem->find('all', array('fields' => $fieldlist, 'conditions' => $conditions, 'order' => $itemorder)));
	}


	public function view($itemname = null) {
		if (isset($this->params['named']['id'])) {
			$this->Newsitem->id = $this->params['named']['id'];
			if (!$this->Newsitem->exists()) {
				$this->Session->setFlash(__('Ongeldig nieuwsbericht.', true), "flash-error");
				$this->redirect('/');
			}
			$newsitem = $this->Newsitem->read();
			if (!$newsitem) {
				$this->Session->setFlash(__('Dit nieuwsbericht bestaat niet.', true), "flash-error");
				$this->redirect('/');
			}
		} else {
			if ($itemname) {
				$newsitem = $this->Newsitem->findByName($itemname);
				if (!$newsitem) {
					$newsitem = $this->Newsitem->findFileByName($itemname);
					if (!$newsitem) {
						$this->Session->setFlash(__(ucfirst($itemname) . ' is een ongeldig nieuwsbericht', true), "flash-error");
						$this->redirect('/');
					}
				} else {
				}
			} else {
				$this->Session->setFlash(__('Geen nieuwsbericht meegegeven.', true), "flash-error");
				$this->redirect('/');
			}
		}
		$newsitem['Newsitem']['content'] = str_replace('[wwwbase]', $this->base, $newsitem['Newsitem']['content']);
		$this->set('newsitem', $newsitem);
	}


	public function viewtxt($page = null) {
		// $this->layout = 'logoonly';
		$newsitem = $this->Newsitem->findFileByName($page);
		$this->set('newsitem', $newsitem);
	}


	public function add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Newsitem->create();
			$itemname = $this->request->data['Newsitem']['title'];
			$itemname = str_replace(array(" ", ".", ":", "!", "(", ")", ",", ";", "=", "+", "<", ">", "'", '"'), '-', $itemname);
			$itemname = strtolower(trim(str_replace(array("--"), '-', $itemname), "-"));
			$this->request->data['Newsitem']['name'] = $itemname;
			if (trim($this->request->data['Newsitem']['author']) == '') {
				$this->request->data['Newsitem']['author'] = (($this->currentUser['Member']['name'] == '') ? 'unknown' : $this->currentUser['Member']['name']);
			}
			if ($this->Newsitem->save($this->request->data)) {
				$this->Session->setFlash(__('Het nieuwsbericht werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'newsitem', $this->Newsitem->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het nieuwsbericht kon niet worden bewaard.'), "flash-error");
			}
		}
		$newsitem_categories = array(
				'club' => 'Club nieuws',
				'jeugd' => 'Jeugd nieuws',
				'seniors' => 'Seniors nieuws',
				'evenement' => 'Evenement nieuws',
				'kamp' => 'Kamp nieuws',
				'andere' => 'Ander nieuws'
			);
		$newsitem_statuses = array(
				'public' => 'Publiek',
				'private' => 'Privé',
				'test' => 'Test'
			);
		$this->set('newsitem_statuses', $newsitem_statuses);
		$this->set('newsitem_categories', $newsitem_categories);
	}


	public function edit($id = null) {
		$this->Newsitem->id = $id;
		if (!$this->Newsitem->exists()) {
			throw new NotFoundException(__('Dit nieuwsbericht bestaat niet.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$itemname = $this->request->data['Newsitem']['title'];
			$itemname = str_replace(array(" ", ".", ":", "!", "(", ")", ",", ";", "=", "+", "<", ">", "'", '"'), '-', $itemname);
			$itemname = strtolower(trim(str_replace(array("--"), '-', $itemname), "-"));
			$this->request->data['Newsitem']['name'] = $itemname;
			if (trim($this->request->data['Newsitem']['author']) == '') {
				$this->request->data['Newsitem']['author'] = (($this->currentUser['Member']['name'] == '') ? 'unknown' : $this->currentUser['Member']['name']);
			}
			if ($this->Newsitem->save($this->request->data)) {
				$this->Session->setFlash(__('Het nieuwsbericht werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'newsitem', $this->Newsitem->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het nieuwsbericht kon niet worden bewaard.'), "flash-error");
			}
		} else {
			$newsitem = $this->Newsitem->read(null, $id);
			$this->request->data = $newsitem;
		}
		$newsitem_categories = array(
				'club' => 'Club nieuws',
				'jeugd' => 'Jeugd nieuws',
				'seniors' => 'Seniors nieuws',
				'evenement' => 'Evenement nieuws',
				'kamp' => 'Kamp nieuws',
				'andere' => 'Ander nieuws'
			);
		$newsitem_statuses = array(
				'public' => 'Publiek',
				'private' => 'Privé',
				'test' => 'Test'
			);
		$this->set('newsitem_statuses', $newsitem_statuses);
		$this->set('newsitem_categories', $newsitem_categories);
	}


	public function setstatus($id = null, $newstatus = null) {
		if (!empty($id) and !empty($newstatus)) {
			$this->Newsitem->read(null, $id);
			$this->Newsitem->set('status', $newstatus);
			if ($this->Newsitem->save()) {
				$this->Session->setFlash(__('Het item werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'newsitem', $this->Newsitem->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het item kon niet worden bewaard.'), "flash-error");
				$this->redirect(array('action' => 'index'));
			}
		}
	}


}
