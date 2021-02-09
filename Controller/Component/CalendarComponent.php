<?php

App::uses('Component', 'Controller');

class CalendarComponent extends Component {

	var $wd  = array(1 => 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag', 'zondag');
	var $swd = array(1 => 'ma', 'di', 'wo', 'do', 'vr', 'za', 'zo');
	var $m   = array(1 => 'januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december');


	private function make_date($originaldate, $addmonths = 0, $adddays = 0, $addyears = 0) {
		$cd = strtotime($originaldate);
		$nd = mktime(0, 0, 0, date('m', $cd) + $addmonths, date('d', $cd) + $adddays, date('Y', $cd) + $addyears);
		$newdate = array();
		$newdate['dateYMD'] = date('Y-m-d', $nd);
		$newdate['year']    = date('Y', $nd);
		$newdate['month']   = date('m', $nd);
		$newdate['monthname'] = $this->m[date('n', $nd)];
		$newdate['day']     = date('d', $nd);
		$newdate['dow']     = date('N', $nd);
		$newdate['dayname'] = $this->wd[date('N', $nd)];
		$newdate['daynameshort'] = $this->swd[date('N', $nd)];
		return $newdate;
	}


	private function fetchBirthdays($datefrom, $dateto) {
		/////$birthdaykal = array();
		// fetch birthday-stuff from the database
		$birthdayfields = array('birthdate', 'name', 'firstname', 'lastname', 'birthyear', 'birthmonth', 'birthday', 'active');
		if ($datefrom['month'] == $dateto['month']) {
			$birthdayconditions = array(
																	'Member.birthday_public' => true,
																	'Member.birthmonth' => $datefrom['month'],
																	array(
																		'Member.birthday >=' => $datefrom['day'],
																		'Member.birthday <=' => $dateto['day']
																	)
																);
		} else {
			$birthdayconditions = array(
																	'Member.birthday_public' => true,
																	'OR' => array(
																		array('Member.birthmonth' => $datefrom['month'], 'Member.birthday >=' => $datefrom['day']),
																		array('Member.birthmonth' => $dateto['month'], 'Member.birthday <=' => $dateto['day'])
																	)
															);

		}
		$birthdayorder = array('birthmonth ASC', 'birthday ASC', 'birthyear DESC');
		$MemberModel = ClassRegistry::init('Member');
		$MemberModel->create(false);
		$birthdays = $MemberModel->find('all', array('recursive' => -1, 'fields' => $birthdayfields, 'conditions' => $birthdayconditions, 'order' => $birthdayorder));
		return $birthdays;
	}


	private function fetchGames($datefrom, $dateto) {
		$games = array();
		$gamesfields = array('Game.id', 'Game.game_code', 'Game.game_change', 'Game.game_date', 'Game.yyyy', 'Game.day_of_month', 'Game.month_of_year', 'Game.game_time_nice', 'Game.home_game', 'Game.game_home', 'Game.game_away', 'Team.shortname', 'Team.mininame');
		$gamesconditions = array('Game.game_date >=' => $datefrom['dateYMD'], 'Game.game_date <=' => $dateto['dateYMD']);
		$GameModel = ClassRegistry::init('Game');
		$GameModel->create(false);
		$GameModel->Team->unbindModel(array('hasMany' => array('Game', 'Training', 'Trainingmomentsteam', 'Teammember'), 'belongsTo' => array('Picture')));
		$GameModel->unbindModel(array('hasMany' => array('Gamesteammember'), 'belongsTo' => array('Coach')));
		$games = $GameModel->find('all', array('fields' => $gamesfields, 'conditions' => $gamesconditions, 'recursive' => 2, 'order' => array('Game.game_date', 'Game.game_time', 'Team.shortname')));
		return $games;
	}


	private function fetchCalendar($datumvan, $datumtot) {
		$kalenderitems = array();
		// fetch birthdays from the database
		$thebirthdays = $this->fetchBirthdays($datumvan, $datumtot);
		// fill calendar items
		foreach ($thebirthdays as $member) {
			if (($datumvan['month'] <> $datumtot['month']) and ($member['Member']['birthmonth'] == '01')) {
				$yyyy = $datumtot['year'];
			} else {
				$yyyy = $datumvan['year'];
			}
			$newage = $yyyy - $member['Member']['birthyear'];
			$mm = str_pad($member['Member']['birthmonth'], 2, "0", STR_PAD_LEFT);
			$dd = str_pad($member['Member']['birthday'], 2, "0", STR_PAD_LEFT);
			$dow = date('N', strtotime($yyyy.'-'.$mm.'-'.$dd));
			$index = $yyyy . '-' . $mm . '-' . $dd;
			$kalenderitems[$index][] = array(
													'year'       => $yyyy,
													'month'      => $mm,
													'day'        => $dd,
													'dow'        => $dow,
													'time'       => '',
													'class'      => 'verjaardag',
													'change'     => '',
													'titlemini'  => $member['Member']['firstname'],
													'titleshort' => $member['Member']['firstname'],
													'title'      => $member['Member']['firstname'] . ' - ' . $dd . '/' . $mm,
													'bubble'     => $member['Member']['firstname'] . ' ' . $member['Member']['lastname'] . ' wordt ' . $newage . ' jaar!'
												);
		}
		// fetch game-stuff from the database
		$thegames = $this->fetchGames($datumvan, $datumtot);
		// fill calendar items
		foreach ($thegames as $game) {
			$yyyy = $game['Game']['yyyy'];
			$mm = str_pad($game['Game']['month_of_year'], 2, "0", STR_PAD_LEFT);
			$dd = str_pad($game['Game']['day_of_month'], 2, "0", STR_PAD_LEFT);
			$dow = date('N', strtotime($yyyy.'-'.$mm.'-'.$dd));
			$index = $yyyy . '-' . $mm . '-' . $dd;
			$gameloc = '';
			if ($game['Game']['game_code'] <> 'competitie') {
				$gametypeprefix = '(' . $game['Game']['game_code'] . ') ';
			} else {
				$gametypeprefix = '';
			}
			if ($game['Game']['home_game']) {
				$gameloc = 'thuis';
				$gametypes = array('competitie' => 'thuiswedstrijd', 'beker' => 'bekerthuis', 'oefenmatch' => 'oefenthuis', 'tornooi' => 'tornooi');
				$gameclass = $gametypes[$game['Game']['game_code']];
				$gamelocprefix = 'tegen';
				$opponent = $game['Game']['game_away'];
			} else {
				$gameloc = 'uit';
				$gametypes = array('competitie' => 'uitwedstrijd', 'beker' => 'bekeruit', 'oefenmatch' => 'oefenuit', 'tornooi' => 'tornooi');
				$gameclass = $gametypes[$game['Game']['game_code']];
				$gamelocprefix = 'op';
				$opponent = $game['Game']['game_home'];
			}
			$kalenderitems[$index][] = array(
													'year'       => $yyyy,
													'month'      => $mm,
													'day'        => $dd,
													'dow'        => $dow,
													'time'       => $game['Game']['game_time_nice'],
													'class'      => $gameclass,
													'change'     => $game['Game']['game_change'],
													'titlemini'  => $game['Team']['mininame'] . ' ' . $gameloc,
													'titleshort' => $game['Team']['shortname'] . ' ' . $gameloc,
													'title'      => $game['Team']['shortname'] . ' ' . $gameloc . ' - ' . $dd . '/' . $mm,
													'bubble'     => $gametypeprefix . $gamelocprefix . ' ' . $opponent . ' (om ' . $game['Game']['game_time_nice'] . ')'
												);
		}
		// fill calendar
		ksort($kalenderitems);
		$kalender = array();
		$datumprev = $this->make_date($datumvan['dateYMD'], 0, -1, 0);
		$datumnext = $this->make_date($datumtot['dateYMD'], 0, 1, 0);
		$kalender['meta'] = array('begin' => $datumvan, 'end' => $datumtot, 'prev' => $datumprev, 'next' => $datumnext);
		$kalender['content'] = $kalenderitems;
		return $kalender;
	}


	public function fetchDay($jaar = 'current', $maand = 'current', $dag = 'current') {
		// fill some dates
		$datenow = time();
		if ($jaar == 'current')  $jaar  = date('Y', $datenow);
		if ($maand == 'current') $maand = date('n', $datenow);
		if ($dag == 'current') $dag = date('j', $datenow);
    $d = new DateTime("$jaar-$maand-$dag");
		$dvan = $d->format('Y-m-d');
		$datumvan = $this->make_date($dvan);
		return $this->fetchCalendar($datumvan, $datumvan);
	}


	public function fetchWeek() {
		// fill some dates
		$datenow = time();
		$datumnu = date("Y-m-d", $datenow);
		$mindagvanweek = -1 * (date("N", $datenow) - 1);
		$datumvan = $this->make_date($datumnu, 0, $mindagvanweek, 0);
		$datumtot = $this->make_date($datumvan['dateYMD'], 0, 6, 0);
		return $this->fetchCalendar($datumvan, $datumtot);
	}


	public function fetchMonth($jaar = 'current', $maand = 'current') {
		// fill some dates
		$datenow = time();
		if ($jaar == 'current')  $jaar  = date('Y', $datenow);
		if ($maand == 'current') $maand = date('n', $datenow);
		// first day of the month
    $d = new DateTime("$jaar-$maand-01");
		$dvan = $d->format('Y-m-d');
    $d->modify('last day of this month');
		$dtot = $d->format('Y-m-d');
		$datumvan = $this->make_date($dvan);
		$datumtot = $this->make_date($dtot);
		return $this->fetchCalendar($datumvan, $datumtot);
	}


}
