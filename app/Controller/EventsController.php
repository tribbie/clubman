<?php
class EventsController extends AppController {

	var $scaffold;

	public $helpers = array('Markdown.Markdown');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'sitepage', 'maandkalender', 'dagkalender');
		//$this->Auth->deny('index');
	}


	public function index() {
		$todaymidnight = strtotime('today midnight');
		$eventfields = array(
			'id', 'season', 'name', 'status', 'category', 'title', 'subtitle', 'target_public',
			'year',
		 	'event_date_start_nice', 'event_date_end_nice',
			'publish_date_start_nice', 'publish_date_end_nice',
			'subscribe_able'
		);
		//$eventconditions = array('Event.season' => $this->currentSeason, 'Event.publish_date_start_epoch <' => $todaymidnight, 'Event.publish_date_end_epoch >' => $todaymidnight);
		//$eventconditions = array('Event.season' => $this->currentSeason);
		$eventconditions = array();
		$eventorder = array('Event.season DESC', 'Event.event_date_start DESC', 'Event.event_time_start DESC');
		$this->Event->unbindModel(array('hasMany' => array('Subscription')));
		$events = $this->Event->find('all', array('fields' => $eventfields, 'conditions' => $eventconditions, 'order' => $eventorder));
		$this->set('events', $events);
	}


	public function __no_longer_used__category($category = 'all') {
		$eventfields = array(
			'id', 'season', 'name', 'status', 'category', 'title', 'subtitle', 'image_url',
			'year',
		 	'event_date_start_nice', 'event_date_end_nice', 'event_time_start', 'event_time_end',
			'event_location', 'event_price',
			'publish_date_start', 'publish_date_end', 'publish_date_start_epoch', 'publish_date_end_epoch',
			'subscribe_able', 'subscribe_date_start_nice', 'subscribe_date_end_nice', 'subscribe_date_start_epoch', 'subscribe_date_end_epoch'
		);
		$eventconditions = array('Event.season' => $this->currentSeason);
		$eventorder = array('Event.event_date_start DESC', 'Event.event_time_start DESC');
		$this->Event->unbindModel(array('hasMany' => array('Subscription')));
		$events = $this->Event->find('all', array('fields' => $eventfields, 'conditions' => $eventconditions, 'order' => $eventorder));
		$this->set('events', $events);
	}


	public function view($eventname = null, $year = null) {
		$this->Event->Behaviors->load('Containable');
		$this->Event->contain(array(
														'Subscription' => array(
																'fields' => array('subsname', 'confirmed', 'confirmed_stamp_nice', 'created_nice', 'created'),
																'conditions' => array('confirmed' => true),
																'order' => array('created asc')
														),
													)
			);
		if (isset($this->params['named']['id'])) {
			$this->Event->id = $this->params['named']['id'];
			$event = $this->Event->read();
			if (!$event) {
				$this->Session->setFlash(__('Ongeldig evenement', true), "flash-error");
				$this->redirect(array('action' => 'index'));
			}
		} else {
			if (!$eventname or !$year) {
				$this->Session->setFlash(__('Ongeldig evenement', true), "flash-error");
				$this->redirect(array('action' => 'index'));
			} else {
				$event = $this->Event->findByNameAndYear($eventname, $year);
				if (!$event) {
					$event = $this->Event->findeventfile($eventname, $year);
					if (!$event) {
						$this->Session->setFlash(__(ucfirst($eventname) . ' - editie ' . $year . ' is een ongeldig evenement', true), "flash-error");
						$this->redirect(array('action' => 'index'));
					}
					$event['Event']['content'] = $event['Event']['Information'];
				} else {
				}
			}
		}
		$event['Event']['content'] = str_replace('[wwwbase]', $this->base, $event['Event']['content']);
		$today = strtotime('today midnight');
		$event['Event']['subscribe_able_now'] = (($today >= $event['Event']['subscribe_date_start_epoch']) and ($today <= $event['Event']['subscribe_date_end_epoch'])) ;
		$this->set('event', $event);
	}


	public function add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Event->create();
			$itemname = $this->request->data['Event']['title'];
			$itemname = str_replace(array(" ", ".", ":", "!", "(", ")", ",", ";", "=", "+", "<", ">", "'", '"'), '-', $itemname);
			$itemname = strtolower(trim(str_replace(array("--"), '-', $itemname), "-"));
			$this->request->data['Event']['name'] = $itemname;
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('Het evenement werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'event', $this->Event->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het evenement kon niet worden bewaard.'), "flash-error");
			}
		}
		$event_categories = array(
				'clubevenement' => 'Club evenement',
				'jeugdevenement' => 'Jeugd evenement',
				'seniorsevenement' => 'Seniors evenement',
				'bestuursevenement' => 'Bestuursevenement'
			);
		$event_targets = array(
				'club' => 'Club',
				'jeugd' => 'Jeugd',
				'seniors' => 'Seniors',
				'bestuur' => 'Bestuur',
				'iedereen' => 'Iedereen'
			);
		$event_statuses = array(
				'public' => 'Publiek',
				'private' => 'Privé',
				'test' => 'Test'
			);
		$this->set('event_statuses', $event_statuses);
		$this->set('event_targets', $event_targets);
		$this->set('event_categories', $event_categories);
	}


	public function edit($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Dit evenement bestaat niet.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$itemname = $this->request->data['Event']['title'];
			$itemname = str_replace(array(" ", ".", ":", "!", "(", ")", ",", ";", "=", "+", "<", ">", "'", '"'), '-', $itemname);
			$itemname = strtolower(trim(str_replace(array("--"), '-', $itemname), "-"));
			$this->request->data['Event']['name'] = $itemname;
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('Het evenement werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'event', $this->Event->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het evenement kon niet worden bewaard.'), "flash-error");
			}
		} else {
			$event = $this->Event->read(null, $id);
			$this->request->data = $event;
		}
		$event_categories = array(
				'clubevenement' => 'Club evenement',
				'jeugdevenement' => 'Jeugd evenement',
				'seniorsevenement' => 'Seniors evenement',
				'bestuursevenement' => 'Bestuursevenement'
			);
		$event_targets = array(
				'club' => 'Club',
				'jeugd' => 'Jeugd',
				'seniors' => 'Seniors',
				'bestuur' => 'Bestuur',
				'iedereen' => 'Iedereen'
			);
		$event_statuses = array(
				'public' => 'Publiek',
				'private' => 'Privé',
				'test' => 'Test'
			);
		$this->set('event_statuses', $event_statuses);
		$this->set('event_targets', $event_targets);
		$this->set('event_categories', $event_categories);
	}


	public function subscriptions($eventname = null, $year = null) {
		if (isset($this->params['named']['id'])) {
			$this->Event->id = $this->params['named']['id'];
			$event = $this->Event->read();
			if (!$event) {
				$this->Session->setFlash(__('Ongeldig evenement', true), "flash-error");
				$this->redirect(array('action' => 'index'));
			}
		} else {
			if (!$eventname or !$year) {
				$this->Session->setFlash(__('Ongeldig evenement', true), "flash-error");
				$this->redirect(array('action' => 'index'));
			} else {
				$event = $this->Event->findByNameAndYear($eventname, $year);
				if (!$event) {
						$this->Session->setFlash(__(ucfirst($eventname) . ' - editie ' . $year . ' is een ongeldig evenement', true), "flash-error");
						$this->redirect(array('action' => 'index'));
				}
			}
		}
		$this->set('event', $event);
	}


	public function sitepage($page = null) {
		$event = $this->Event->findpage($page);
		$this->set('event', $event);
	}


	public function maandkalender($year = 'current', $month = 'current') {
		$maandkalender = $this->Calendar->fetchMonth($year, $month);
		$this->set('maandkalender', $maandkalender);
	}


	public function dagkalender($year = 'current', $month = 'current', $dag = 'current') {
		$dagkalender = $this->Calendar->fetchDay($year, $month, $dag);
		$this->set('dagkalender', $dagkalender);
	}

}
