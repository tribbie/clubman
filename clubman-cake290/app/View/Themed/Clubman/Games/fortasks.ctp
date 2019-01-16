<h1><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> - <?=$team['Team']['name']?> - wedstrijden van <?=$period['datefrom']?> tot <?=$period['dateto']?></h1>

<hr/>
<br/>
Andere lijsten:
<?= $this->Html->link('Alle thuiswedstrijden', array('controller' => 'games', 'action' => 'fortasks', 'allthuis', $period['datefrom'], $period['dateto'])); ?> -
<?= $this->Html->link('Thuiswedstrijden jeugd', array('controller' => 'games', 'action' => 'fortasks', 'jeugdthuis', $period['datefrom'], $period['dateto'])); ?> -
<?= $this->Html->link('Wedstrijden iedereen', array('controller' => 'games', 'action' => 'fortasks', 'all', $period['datefrom'], $period['dateto'])); ?> -
<?= $this->Html->link('Wedstrijden seniors', array('controller' => 'games', 'action' => 'fortasks', 'seniors', $period['datefrom'], $period['dateto'])); ?> -
<?= $this->Html->link('Wedstrijden jeugd', array('controller' => 'games', 'action' => 'fortasks', 'jeugd', $period['datefrom'], $period['dateto'])); ?>
<br/><br/>

<table class='wedstrijdlijst'>
<?php

	print(" <tr>\n");
	print("  <th>GID</th>\n");
	print("  <th>T</th>\n");
	print("  <th>Teamcode</th>\n");
	print("  <th>Dag</th>\n");
	print("  <th>Datum</th>\n");
	print("  <th>Tijd</th>\n");
	print("  <th>C</th>\n");
	print("  <th>Team</th>\n");
	print("  <th>Thuisploeg</th>\n");
	print("  <th>Bezoekers</th>\n");
	print("  <th>Scheidsrechter</th>\n");
	print("  <th>Markeerder</th>\n");
	print("  <th>Scorebord</th>\n");
	print("  <th>Opmerking</th>\n");
	print(" </tr>\n");

	foreach ($games as $game) {
		$trtitle = $game['Game']['game_code'];
		if ($game['Game']['game_change'] == '') {
			$trclass = "";
		} elseif ($game['Game']['game_change'] == 'afgelast') {
			$trclass = " class='gamecancel'";
			$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
		} elseif ($game['Game']['game_change'] == 'te verplaatsen') {
			$trclass = " class='gametochange'";
			$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
		} else {
			$trclass = " class='gamechange'";
			$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
		}

//		De wedstrijd
//		print(" <tr title='" . $trtitle . "' " . $trclass . ">\n");
		print(" <tr " . $trclass . ">\n");
		print("  <td>" . $game['Game']['id'] . "</td>\n");
		print("  <td>" . $game['Game']['team_id'] . "</td>\n");
		print("  <td>" . $game['Team']['competition'] . "</td>\n");
		print("  <td>" . $weekd[$game['Game']['day_of_week']] . "</td>\n");
		print("  <td>" . $game['Game']['game_date'] . "</td>\n");
		print("  <td>" . substr($game['Game']['game_time'], 0, 5) . "</td>\n");
		print("  <td>" . strtoupper(substr($game['Game']['game_code'], 0, 1)) . "</td>\n");
		print("  <td>" . $game['Team']['shortname'] . "</td>\n");
		print("  <td>" . $game['Game']['game_home'] . "</td>\n");
		print("  <td>" . $game['Game']['game_away'] . "</td>\n");
		print("  <td>" . $game['Game']['game_referee'] . "</td>\n");
		print("  <td>" . $game['Game']['game_marker'] . "</td>\n");
		print("  <td>" . $game['Game']['game_scoreboard'] . "</td>\n");
		print("  <td>" . $game['Game']['remark'] . "</td>\n");
		print(" </tr>\n");
	}

?>

</table>

<?php
//	pr($period);
//	pr($team);
//	pr($games);
?>
