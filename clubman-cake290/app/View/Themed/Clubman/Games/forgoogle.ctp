<h1>for Google Calendar -- <?=$forgoogle['filter']?></h1>
<br/>
Subject,Start Date,Start Time,End Date,End Time,All Day Event,Description,Location,Private,Reminder On/Off<br/>
<br/>

<?php
	$delim = ',';
	foreach ($games as $game) {
		$gSubject = $game['Team']['shortname'] . (($game['Game']['home_game'] == 1) ? '' : ' uit') . (($game['Game']['game_code'] == 'beker') ? ' (b)' : '') . (($game['Game']['game_code'] == 'tornooi') ? ' (t)' : '') . (($game['Game']['game_code'] == 'oefenmatch') ? ' (o)' : '');
		if ($game['Game']['game_referee'] == '') {
			$gRef = ' (ref. ' . $game['Game']['game_referee'] . ')';
		} else {
			$gRef = '';
		}
		$gDescription = $game['Team']['name'] . (($game['Game']['home_game'] == 1) ? ' tegen ' . $game['Game']['game_away'] . $gRef : ' op ' . $game['Game']['game_home']) . '(' . $game['Game']['game_code'] . ')';
		
		
//		De wedstrijd

// the SELECT statement 
//SELECT 
//		CONCAT(t.shortname, if((g.home_game = 1), '', ' uit'), if (g.game_code = 'beker', ' (b)', '')) Subject,
//		g.game_date StartDate,
//		g.game_time StartTime,
//		g.game_date EndDate,
//		ADDTIME(g.game_time, '02:00:00') EndTime,
//		"FALSE" AllDay, 
//		CONCAT(t.name, if((g.home_game = 1), CONCAT(' tegen ', g.game_away, if (g.game_referee IS NULL, '', CONCAT(' (ref. ', g.game_referee, ')'))), CONCAT(' op ', g.game_home))) Description,
//		g.game_hall Location,
//		"FALSE" Private,
//		"FALSE" ReminderOnOff
//FROM cm_games g
//LEFT JOIN cm_teams t ON t.id = g.team_id
//WHERE g.period = 2
//ORDER BY g.game_date, g.game_time, g.team_id

//		echo $game['Game']['id'] . $delim;
		echo '"' . $gSubject . '"' . $delim;
		echo $game['Game']['game_date'] . $delim;
		echo substr($game['Game']['game_time'], 0, 5) . $delim;
		echo $game['Game']['game_date'] . $delim;
		echo substr($game['Game']['game_time_end'], 0, 5) . $delim;
		echo 'FALSE' . $delim;
		echo '"' . $gDescription . '"' . $delim;
		echo '"' . $game['Game']['game_hall'] . '"' . $delim;
		echo 'FALSE' . $delim;
		echo 'FALSE' . $delim;
		echo '<br/>'."\n";
	}

?>

<br/>

<?
//	echo '<hr/>';
//	pr($period);
//	pr($forgoogle);
//	pr($games);
?>

