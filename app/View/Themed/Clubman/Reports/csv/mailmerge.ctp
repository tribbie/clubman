<?php
	echo "\"" . 'mailmerge leden' . "\"\n";

		echo "\"" . 'achternaam' . "\";";
		echo "\"" . 'voornaam' . "\";";
		echo "\"" . 'email' . "\";";
		echo "\"" . 'lidgeld' . "\";";
		echo "\"" . 'korting' . "\";";
		echo "\"" . 'voorschot' . "\";";
		echo "\"" . 'saldo' . "\";";
		echo "\"" . 'team' . "\";";
		echo "\"" . 'niveau' . "\";";
		echo "\"" . 'Functie' . "\";";
		echo "\"" . 'Prionr' . "\";";
		echo "\"" . 'Prio' . "\";";
		echo "\"" . 'Thuiswedstrijd' . "\";";
		echo "\"" . 'Regime' . "\";";
		echo "\"" . 'Trainingsmomenten' . "\";";
		echo "\"" . 'Mijn teams' . "\";";
		echo "\n";	
	
	foreach ($teammembers as $teammember) {
		$mymailaddresses = array();
		if (trim($teammember['Member']['email'])) $mymailaddresses[] = trim($teammember['Member']['email']);
		if (trim($teammember['Member']['mom_email'])) $mymailaddresses[] = trim($teammember['Member']['mom_email']);
		if (trim($teammember['Member']['dad_email'])) $mymailaddresses[] = trim($teammember['Member']['dad_email']);
		$mymailaddresses = array_unique($mymailaddresses);

		$mytrainingmoments = array();
		if ((isset($teammember['Trainingmomentsteammember'])) and (count($teammember['Trainingmomentsteammember']) > 0)) {
//			individual trainingmoments found -- using these and only these
			$mytrainingsregime = 'individueel';
			$mytrainingmoments[] = (isset($teammember['Trainingmomentsteammember'][0]['trainingmoment_id']) ? $teammember['Trainingmomentsteammember'][0]['Trainingmoment']['name'] . ' (' . $teammember['Trainingmomentsteammember'][0]['Trainingmoment']['start_time_nice'] . '-' .  $teammember['Trainingmomentsteammember'][0]['Trainingmoment']['end_time_nice'] . ')' : '');
			$mytrainingmoments[] = (isset($teammember['Trainingmomentsteammember'][1]['trainingmoment_id']) ? $teammember['Trainingmomentsteammember'][1]['Trainingmoment']['name'] . ' (' . $teammember['Trainingmomentsteammember'][1]['Trainingmoment']['start_time_nice'] . '-' .  $teammember['Trainingmomentsteammember'][1]['Trainingmoment']['end_time_nice'] . ')' : '');
			$mytrainingmoments[] = (isset($teammember['Trainingmomentsteammember'][2]['trainingmoment_id']) ? $teammember['Trainingmomentsteammember'][2]['Trainingmoment']['name'] . ' (' . $teammember['Trainingmomentsteammember'][2]['Trainingmoment']['start_time_nice'] . '-' .  $teammember['Trainingmomentsteammember'][2]['Trainingmoment']['end_time_nice'] . ')' : '');
			$mytrainingmoments[] = (isset($teammember['Trainingmomentsteammember'][3]['trainingmoment_id']) ? $teammember['Trainingmomentsteammember'][3]['Trainingmoment']['name'] . ' (' . $teammember['Trainingmomentsteammember'][3]['Trainingmoment']['start_time_nice'] . '-' .  $teammember['Trainingmomentsteammember'][3]['Trainingmoment']['end_time_nice'] . ')' : '');
			$mytrainingmoments[] = (isset($teammember['Trainingmomentsteammember'][4]['trainingmoment_id']) ? $teammember['Trainingmomentsteammember'][4]['Trainingmoment']['name'] . ' (' . $teammember['Trainingmomentsteammember'][4]['Trainingmoment']['start_time_nice'] . '-' .  $teammember['Trainingmomentsteammember'][4]['Trainingmoment']['end_time_nice'] . ')' : '');
		} else {
//			no individual trainingmoments found -- using those of main team (and main team only)
			$mytrainingsregime = 'team';
			$mytrainingmoments[] = (isset($teammember['Team']['Trainingmomentsteam'][0]['trainingmoment_id']) ? $teammember['Team']['Trainingmomentsteam'][0]['Trainingmoment']['name'] . ' (' . $teammember['Team']['Trainingmomentsteam'][0]['Trainingmoment']['start_time_nice'] . '-' . $teammember['Team']['Trainingmomentsteam'][0]['Trainingmoment']['end_time_nice'] . ')' : '');
			$mytrainingmoments[] = (isset($teammember['Team']['Trainingmomentsteam'][1]['trainingmoment_id']) ? $teammember['Team']['Trainingmomentsteam'][1]['Trainingmoment']['name'] . ' (' . $teammember['Team']['Trainingmomentsteam'][1]['Trainingmoment']['start_time_nice'] . '-' . $teammember['Team']['Trainingmomentsteam'][1]['Trainingmoment']['end_time_nice'] . ')' : '');
			$mytrainingmoments[] = (isset($teammember['Team']['Trainingmomentsteam'][2]['trainingmoment_id']) ? $teammember['Team']['Trainingmomentsteam'][2]['Trainingmoment']['name'] . ' (' . $teammember['Team']['Trainingmomentsteam'][2]['Trainingmoment']['start_time_nice'] . '-' . $teammember['Team']['Trainingmomentsteam'][2]['Trainingmoment']['end_time_nice'] . ')' : '');
			$mytrainingmoments[] = (isset($teammember['Team']['Trainingmomentsteam'][3]['trainingmoment_id']) ? $teammember['Team']['Trainingmomentsteam'][3]['Trainingmoment']['name'] . ' (' . $teammember['Team']['Trainingmomentsteam'][3]['Trainingmoment']['start_time_nice'] . '-' . $teammember['Team']['Trainingmomentsteam'][3]['Trainingmoment']['end_time_nice'] . ')' : '');
			$mytrainingmoments[] = (isset($teammember['Team']['Trainingmomentsteam'][4]['trainingmoment_id']) ? $teammember['Team']['Trainingmomentsteam'][4]['Trainingmoment']['name'] . ' (' . $teammember['Team']['Trainingmomentsteam'][4]['Trainingmoment']['start_time_nice'] . '-' . $teammember['Team']['Trainingmomentsteam'][4]['Trainingmoment']['end_time_nice'] . ')' : '');
		}
		$allmytrainingmoments = implode(', ', array_filter($mytrainingmoments));
	
		$myteams = array();
		if ((isset($teammember['Member']['Teammember'])) and (count($teammember['Member']['Teammember']) > 0)) {
//			looking up all teams where the teammember plays -- yes only where he plays
			foreach ($teammember['Member']['Teammember'] as $myteam) {
				if ($myteam['teampriority'] > 0) $myteams[$myteam['teampriority']] = ($myteam['Team']['name']);
			}
		}
		$allmyteams = implode(', ', array_filter($myteams));

		foreach ($mymailaddresses as $mymailaddress) {

			echo "\"" . $teammember['Member']['lastname'] . "\";";
			echo "\"" . $teammember['Member']['firstname'] . "\";";
			echo "\"" . $mymailaddress . "\";";
			echo "\"" . $teammember['Member']['membershipfee'] . "\";";
			echo "\"" . $teammember['Member']['membershipfee_discount'] . "\";";
			echo "\"" . $teammember['Member']['membership_advancepaid'] . "\";";
			echo "\"" . $teammember['Member']['membership_balancepaid'] . "\";";
			echo "\"" . $teammember['Team']['name'] . "\";";
			echo "\"" . $teammember['Team']['series'] . "\";";
			echo "\"" . $teammember['Teammember']['teamfunction'] . "\";";
			echo "\"" . $teammember['Teammember']['teampriority'] . "\";";
			echo "\"" . $teampriorities[$teammember['Teammember']['teampriority']] . "\";";
			echo "\"" . $teammember['Team']['homegame'] . "\";";
			echo "\"" . $mytrainingsregime . "\";";
			echo "\"" . $allmytrainingmoments . "\";";
			echo "\"" . $allmyteams . "\";";
			echo "\n";	

		}
	}
