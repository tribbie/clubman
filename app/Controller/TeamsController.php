<?php
class TeamsController extends AppController {

	//var $scaffold;
	public $helpers = array('Link');
	var $teamtypes  = array('volley'=>'Volley', 'beachvolley'=>'Beachvolley', 'omkadering'=>'Omkadering', 'andere'=>'Andere');
	var $categories = array('Seniors'=>'Seniors', 'U19'=>'U19', 'U17'=>'U17', 'U15'=>'U15', 'U13'=>'U13', 'U11'=>'U11', 'U9'=>'U9', 'Bengels'=>'Bengels', 'Setters'=>'Setters', 'Bestuur'=>'Bestuur', 'Jeugdbestuur'=>'Jeugdbestuur', 'Andere'=>'Andere', 'Onbekend'=>'Onbekend');
	var $genders    = array('meisjes'=>'Meisjes', 'jongens'=>'Jongens', 'dames'=>'Dames', 'heren'=>'Heren', 'gemengd'=>'Gemengd');
	var $numbers    = array(''=>'enige team', '1'=>'Team 1', '2'=>'Team 2', '3'=>'Team 3', '4'=>'Team 4', '5'=>'Team 5');
	var $series     = array('1ste prov'=>'1ste Prov.', '2de prov'=>'2de Prov.', '3de prov'=>'3de Prov.', '4de prov'=>'4de Prov.', '1ste div'=>'1ste Div.', '2de div'=>'2de Div.', '1ste nat'=>'1ste Nat.', 'liga a'=>'Liga A', 'liga b'=>'Liga B', 'beker' => 'Enkel beker', 'andere'=>'Andere');
	var $homegames  = array('zaterdag shift 1'=>'Zaterdag shift 1', 'zaterdag shift 2'=>'Zaterdag shift 2', 'zaterdagavond'=>'Zaterdagavond', 'geen thuiswedstijden'=>'Geen thuiswedstijden', 'geen wedstijden'=>'Geen wedstijden', 'andere'=>'Andere');


	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('category', 'view', 'viewold', 'calendar');
		//$this->Auth->deny('index');
	}


	public function index() {
		if (($this->loggedIn) and (ClubmanUtilityLib::elementsInArray($this->cmCurrentRoles, ['root']) > 0)) {
			$this->Team->recursive = 0;
			$teams = $this->Team->find('all', array('fields' => array('Team.id', 'Team.name', 'Team.shortname', 'Team.competition', 'Picture.location')));
		} else {
			$memberid = $this->currentUser['Member']['id'];
			/// We retrieve list of teams that this member is teammember of (but only with priority 0 - begeleiding)
			$this->Team->Teammember->recursive = -1;
			$memberteams = $this->Team->Teammember->find('list', array('conditions' => array('Teammember.member_id' => $memberid, 'Teammember.teampriority' => 0), 'fields' => array('Teammember.id', 'Teammember.team_id')));
			$this->set('memberteams', $memberteams);
			$this->Team->recursive = 0;
			// The role of trainer or member will only see the teams the user belongs to
			if (ClubmanUtilityLib::elementsInArray($this->cmCurrentRoles, ['trainer', 'member']) > 0) {
				$teamfilter = array('Team.id' => array_values($memberteams));
			}
			/// To support cumulated roles, the following can override the shortlist of a trainer
			if (ClubmanUtilityLib::elementsInArray($this->cmCurrentRoles, ['root', 'admin', 'teamadmin', 'gameadmin']) > 0) {
				$teamfilter = array('Team.id >' => 0);
			}
			$teams = $this->Team->find('all', array('conditions' => $teamfilter));
		}
		$this->set('teams', $teams);
	}


	public function listing() {
		$teams = $this->Team->find('all', array('order' => array('Team.display_order' => 'ASC', 'Team.name' => 'ASC'), 'recursive' => -1));
		$this->set('teams', $teams);
	}


	public function category($category = 'jeugd') {
		$this->Team->recursive = 1;
		switch ($category) {
			case 'seniors':
				$catselect = array('Team.category' => 'Seniors');
				break;
			case 'jeugd':
				$catselect = array('Team.category' => array('U19', 'U17', 'U15', 'U13', 'U11', 'U9', 'Bengels'));
				break;
			case 'bestuur':
				$catselect = array('Team.teamtype' => 'bestuur');
				break;
			default:
				$catselect = array('Team.teamtype <>' => 'volley');
		}
		$this->set('teams', $this->Team->find('all', array('conditions' => $catselect)));
		$this->set('category', $category);
	}


	public function view($id = null) {
		$this->Team->recursive = 2;
		$this->Team->Behaviors->load('Containable');
		$fields = array('Team.id', 'Team.name', 'Team.shortname', 'Team.mininame', 'Team.category', 'Team.gender', 'Team.series', 'Team.teamtype', 'Team.competition', 'Team.email', 'Team.homegame');
		$contain = array(
				'Picture' => array(
					'fields' => array('id', 'location'),
				),
				'Teammember' => array(
					'fields' => array('id', 'member_id', 'team_id', 'teamfunction', 'teampriority', 'shirtnumber', 'remark'),
					//'conditions' => array('season' => 'aanwezig'),
					'order' => array('teampriority', 'shirtnumber'),
					'Member' => array(
						'fields' => array('id', 'firstname', 'lastname', 'name', 'email')
					)
				),
				'Trainingmomentsteam' => array(
					'fields' => array('id', 'team_id', 'remark'),
					'Trainingmoment' => array(
						'fields' => array('id', 'name', 'weekday', 'location', 'start_time_nice', 'end_time_nice', 'remark'),
					),
				),
				'Game' => array(
					'fields' => array('id', 'team_id', 'game_code', 'game_home', 'game_away', 'game_change', 'day_of_week', 'game_hall', 'game_date', 'game_date_nice', 'game_time_nice', 'remark'),
					'Gamesteammember' => array(
						'fields' => array('id'),
					)
				),
				'Training' => array(
					'fields' => array('id', 'team_id', 'start_date', 'start_date_nice', 'start_time_nice', 'end_time_nice', 'location', 'remark'),
					'Trainingsteammember' => array(
						'fields' => array('id'),
					)
				)
    );
		if (isset($this->params['named']['name'])) {
			$teamname = $this->params['named']['name'];
			//$team = $this->Team->findByShortname($teamname);
			$conditions = array('Team.shortname' => $teamname);
			$team = $this->Team->find('first', array('fields' => $fields, 'contain' => $contain, 'conditions' => $conditions));
		} elseif (isset($this->params['named']['mininame'])) {
			$teamname = $this->params['named']['mininame'];
			//$team = $this->Team->findByMininame($teamname);
			$conditions = array('Team.mininame' => $teamname);
			$team = $this->Team->find('first', array('fields' => $fields, 'contain' => $contain, 'conditions' => $conditions));
		} else {
			if (!$id) {
				$this->Session->setFlash(__('Ongeldig team', true), "flash-error");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Team->id = $id;
				$team = $this->Team->read();
			}
		}
		$this->set('team', $team);
	}


	public function viewlicenses($id = null) {
		$this->Team->recursive = 3;
		$this->Team->unbindModel(array('hasMany' => array('Training', 'Game', 'Trainingmomentsteam')));
		$this->Team->Teammember->unbindModel(array('belongsTo' => array('Team'), 'hasMany' => array('Trainingsteammember', 'Gamesteammember')));
		$this->Team->Teammember->Member->unbindModel(array('hasMany' => array('Teammember', 'Coach', 'User')));
		if (isset($this->params['named']['name'])) {
			$teamname = $this->params['named']['name'];
			$team = $this->Team->findByShortname($teamname);
		} else {
			if (!$id) {
				$this->Session->setFlash(__('Ongeldig team', true), "flash-error");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Team->id = $id;
				$team = $this->Team->read();
			}
		}
		$this->set('team', $team);
	}


	public function add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Team']['name'] = $this->request->data['Team']['category'];
			$this->request->data['Team']['name'] .= ' ' . $this->request->data['Team']['gender'];
			$this->request->data['Team']['name'] .= ' ' . $this->request->data['Team']['number'];
			$this->request->data['Team']['name'] = trim($this->request->data['Team']['name']);
			if ($this->Team->save($this->request->data)) {
				$this->Session->setFlash(__('Het team werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'team', $this->Team->id);
				$this->redirect(array('action' => 'view', $this->Team->id));
			} else {
				$this->Session->setFlash(__('Het team kon niet worden bewaard.'), "flash-error");
			}
		}
		$this->set('teamtypes', $this->teamtypes);
		$this->set('categories', $this->categories);
		$this->set('genders', $this->genders);
		$this->set('numbers', $this->numbers);
		$this->set('series', $this->series);
		$this->set('homegames', $this->homegames);
		//$this->set('clubs', $this->Team->Club->find('list'));
		$this->set('pictures', $this->Team->Picture->find('list'));
	}


	public function edit($id = null, $partvalue = 'all') {
		$parts = array('all' => 'alle', 'general' => 'algemene', 'other' => 'overige', 'picture' => 'foto');
		$part['label'] = $parts[$partvalue];
		$part['value'] = $partvalue;
		$this->Team->id = $id;
		$team = $this->Team->read(null, $id);
		if (!$this->Team->exists()) {
			throw new NotFoundException(__('Team bestaat niet.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Team->save($this->request->data)) {
				$this->Session->setFlash(__('Het team werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'team', $this->Team->id);
				$this->redirect(array('action' => 'view', $this->Team->id));
			} else {
				$this->Session->setFlash(__('Het team kon niet worden bewaard.'), "flash-error");
			}
		} else {
			$this->request->data = $team;
		}
		$this->set('team', $team);
		/// prepare the select boxes
		$this->set('teamtypes', $this->teamtypes);
		$this->set('categories', $this->categories);
		$this->set('genders', $this->genders);
		$this->set('numbers', $this->numbers);
		$this->set('series', $this->series);
		$this->set('homegames', $this->homegames);
		//$this->set('clubs', $this->Team->Club->find('list'));
		//$this->set('pictures', $this->Team->Picture->find('list', array('conditions' => array('category' => 'member'))));
		/// prepare the form parts
		$this->set('part', $part);
		if ($partvalue == 'picture') {
			$this->set('pictures', $this->Team->Picture->find('list', array('conditions' => array('category' => 'team'))));
		}
	}


	public function reports() {
	}


	public function overview($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Ongeldig team', true), "flash-error");
			$this->redirect(array('action' => 'index'));
		}
		$this->Team->id = $id;
		$this->Team->recursive = 2;
		$this->set('team', $this->Team->read());
	}



	public function calendar($id = null, $type = 'games') {
		$this->Team->recursive = 1;
		$this->Team->Behaviors->load('Containable');
		$fields = array('Team.id', 'Team.name', 'Team.shortname', 'Team.mininame', 'Team.category', 'Team.gender', 'Team.series', 'Team.teamtype', 'Team.competition', 'Team.email', 'Team.homegame');
		$contain = array(
				'Game' => array(
					'fields' => array('id', 'team_id', 'game_code', 'game_home', 'game_away', 'game_change', 'day_of_week', 'game_hall', 'game_date', 'game_date_nice', 'game_time_nice', 'remark'),
				),
    );
		if (isset($this->params['named']['name'])) {
			$teamname = $this->params['named']['name'];
			//$team = $this->Team->findByShortname($teamname);
			$conditions = array('Team.shortname' => $teamname);
			$team = $this->Team->find('first', array('fields' => $fields, 'contain' => $contain, 'conditions' => $conditions));
		} elseif (isset($this->params['named']['mininame'])) {
			$teamname = $this->params['named']['mininame'];
			//$team = $this->Team->findByMininame($teamname);
			$conditions = array('Team.mininame' => $teamname);
			$team = $this->Team->find('first', array('fields' => $fields, 'contain' => $contain, 'conditions' => $conditions));
		} else {
			if (!$id) {
				$this->Session->setFlash(__('Ongeldig team', true), "flash-error");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Team->id = $id;
				$team = $this->Team->read();
			}
		}
		$calendar = <<<HEREDOC
BEGIN:VCALENDAR
PRODID:-//Google Inc//Google Calendar 70.9054//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME:DudeSerieusCalendar
X-WR-RELCALID:s=calendar.test@dudeserieus.be
X-WR-TIMEZONE:Europe/Brussels
REFRESH-INTERVAL;VALUE=DURATION:PT4H
X-PUBLISHED-TTL:PT4H
BEGIN:VTIMEZONE
TZID:Europe/Brussels
X-LIC-LOCATION:Europe/Brussels
BEGIN:DAYLIGHT
TZOFFSETFROM:+0100
TZOFFSETTO:+0200
TZNAME:CEST
DTSTART:19700329T020000
RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:+0200
TZOFFSETTO:+0100
TZNAME:CET
DTSTART:19701025T030000
RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU
END:STANDARD
END:VTIMEZONE
BEGIN:VEVENT
DTSTART:20180307T160000Z
DTEND:20180307T173000Z
DTSTAMP:20180310T232800Z
UID:calendar.test.item_67211@dudeserieus.be
CREATED:20180310T232800Z
DESCRIPTION;ENCODING=QUOTED-PRINTABLE:1PV-0001: VC WOLVERTEM - LIZARDS LUBBEEK-LEUVEN B
LAST-MODIFIED:20180310T232800Z
LOCATION:Sportschuur, Wolvertem Belgie
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY: VC Wolvertem - LIZARDS B
TRANSP:OPAQUE
END:VEVENT
BEGIN:VEVENT
DTSTART:20180303T163000Z
DTEND:20180303T180000Z
DTSTAMP:20180310T232800Z
UID:calendar.test.item_67212@dudeserieus.be
CREATED:20180310T232800Z
DESCRIPTION;ENCODING=QUOTED-PRINTABLE:1PV-0002: WEVOK ST.-JORIS WEERT A - JEUGDVOLLEYBAL LONDERZEEL B
LAST-MODIFIED:20180310T232800Z
LOCATION:Ontmoetingscentrum, Sint-Joris-Weert, Beekstraat 13, 3051 Sint-Joris-Weert Belgie
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY: WEVOK ST.-JORIS WEERT A - JEUGDVOLLEYBAL LONDERZEEL B
TRANSP:OPAQUE
END:VEVENT
END:VCALENDAR
HEREDOC;
		echo $calendar; die;
	}


	public function rangschikking($id = null, $yyyyww = null) {
		$this->Session->setFlash(__('Het nieuwe rangschikkingensysteem is nog niet beschikbaar.', true), "flash-error");
		$this->redirect(array('action' => 'listing'));
		if (!$id) {
			$this->Session->setFlash(__('Ongeldig team', true), "flash-error");
			$this->redirect(array('action' => 'listing'));
		}
		if (!$yyyyww) {
			//$yyyyww = date('Y-W');
			$yyyy = date('Y');
			$ww = date('W');
			$yyyyww = "$yyyy-$ww";
		} else {
			list ($yyyy, $ww) = split('-', $yyyyww, 2);
		}
		$nextyyyyww = $yyyy . '-' . ($ww + 1);
		$prevyyyyww = $yyyy . '-' . ($ww - 1);
		$yyyywwsuffix = $yyyyww;
		$rangschikkingenxml = "files/downloads/arunar/vb_rangschikkingen_$yyyywwsuffix.xml";
		/// Get the team
		$this->Team->id = $id;
		$this->Team->recursive = 0;
		$team = $this->Team->read();
		$localxmlfile = $rangschikkingenxml;
		if (($yyyyww == date('Y-W')) and (!file_exists($localxmlfile))) {
			/// Here we should try and get the "current" info from ARUNAR
			$remotexmlfile = 'http://haezeleer.be/arunar/exports/vb_rangschikkingen.xml';
			$xmlrc = $this->downloadxmlfromarunar($remotexmlfile, $localxmlfile);
		}
		///	Download the extra 2 files from arunar
		$localxmlfile2 = "files/downloads/arunar/vb_uitslagen_$yyyywwsuffix.xml";
		if (($yyyyww == date('Y-W')) and (!file_exists($localxmlfile2))) {
			/// Here we should try and get the "current" info from ARUNAR
			$remotexmlfile2 = 'http://haezeleer.be/arunar/exports/vb_uitslagen.xml';
			$xmlrc = $this->downloadxmlfromarunar($remotexmlfile2, $localxmlfile2);
		}
		///	Kalender
		$localxmlfile3 = "files/downloads/arunar/vb_kalender_$yyyywwsuffix.xml";
		if (($yyyyww == date('Y-W')) and (!file_exists($localxmlfile3))) {
			/// Here we should try and get the "current" info from ARUNAR
			$remotexmlfile3 = 'http://haezeleer.be/arunar/exports/vb_uitslagen.xml';
			$xmlrc = $this->downloadxmlfromarunar($remotexmlfile3, $localxmlfile3);
		}
		///	End download the extra 2 files from arunar
		if (file_exists($localxmlfile)) {
	    $rangschikkingen = simplexml_load_file($localxmlfile);
		} else {
	    $rangschikkingen = array('error' => "Clubman error: Failed to open/download $localxmlfile");
		}
		$this->set('week', array('yyyyww' => $yyyyww, 'yyyy' => $yyyy, 'ww' => $ww, 'prev' => $prevyyyyww, 'next' => $nextyyyyww));
		$this->set('rangschikkingen', $rangschikkingen);
		$this->set('team', $team);
	}


	private function downloadxmlfromarunar($sourcexmlfile = 'http://www.w3schools.com/xml/note.xml', $targetxmlfile = 'files/downloads/test.xml') {
		/// create curl resource
		//$ch = curl_init();
		//curl_setopt($ch, CURLOPT_URL, $xmlurl);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//$xmlinfo = curl_exec($ch);
		//curl_close($ch);
		//return $xmlinfo;
		/// save to file -- nog te testen ...
		$ch = curl_init($sourcexmlfile);
		$fp = fopen($targetxmlfile, "w");
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}


}
