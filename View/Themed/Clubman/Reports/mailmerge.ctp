<!-- app/View/Reports/mailmerge.ctp -->
<h2>Lijst <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden voor mailmerge</h2>

<hr/>
<?= $this->Html->link('Download deze lijst', array('action' => 'mailmerge', 'ext' => 'csv'))."\n"; ?>
<br/>
<br/>

<div class='box simplebox'>
De theorie:<br/><br/>
<ul>Deze lijst bevat informatie
<li>enkel van spelende leden (geen begeleiding, zoals trainers, coaches, PVs, ...)</li>
<li>enkel van het hoofdteam van de leden (team-prioriteit = 1)</li>
<li>voor elk verschillend emailadres zou er een lijn moeten zijn (meerdere per lid, maar geen dubbels per lid)</li>
<li>als ze geen individuele trainingsmomenten hebben, worden die van hun hoofdteam (en enkel van hun hoofdteam) genomen</li>
<li>als ze wel individuele trainingsmomenten hebben, worden enkel die individuele genomen (dus niet meer die van hun hoofdteam)</li>
</ul>
</div>
<br/>

<table class="table">
	<tr class="groupheader info">
		<th>Achternaam</th>
		<th>Voornaam</th>
		<th>Email</th>
		<th>Lidgeld</th>
		<th>Korting</th>
		<th>Voorschot</th>
		<th>Saldo</th>
		<th>Hoofdeam</th>
		<th>Niveau</th>
		<th>Functie</th>
		<th>Prionr</th>
		<th>Prio</th>
		<th>Thuiswedstrijd</th>
		<th>Regime</th>
		<th>Trainingsmomenten</th>
		<th>Mijn teams</th>
	</tr>
	<?php foreach ($teammembers as $teammember) : ?>
		<?php
			$mymailaddresses = array();
			if (trim($teammember['Member']['email'])) $mymailaddresses[] = trim($teammember['Member']['email']);
			if (trim($teammember['Member']['mom_email'])) $mymailaddresses[] = trim($teammember['Member']['mom_email']);
			if (trim($teammember['Member']['dad_email'])) $mymailaddresses[] = trim($teammember['Member']['dad_email']);
			$mymailaddresses = array_unique($mymailaddresses);
			$mytrainingmoments = array();
			if ((isset($teammember['Trainingmomentsteammember'])) and (count($teammember['Trainingmomentsteammember']) > 0)) {
				// individual trainingmoments found -- using these and only these
				$mytrainingsregime = 'individueel';
				$mytrainingmoments[] = (isset($teammember['Trainingmomentsteammember'][0]['trainingmoment_id']) ? $teammember['Trainingmomentsteammember'][0]['Trainingmoment']['name'] . ' (' . $teammember['Trainingmomentsteammember'][0]['Trainingmoment']['start_time_nice'] . '-' .  $teammember['Trainingmomentsteammember'][0]['Trainingmoment']['end_time_nice'] . ')' : '');
				$mytrainingmoments[] = (isset($teammember['Trainingmomentsteammember'][1]['trainingmoment_id']) ? $teammember['Trainingmomentsteammember'][1]['Trainingmoment']['name'] . ' (' . $teammember['Trainingmomentsteammember'][1]['Trainingmoment']['start_time_nice'] . '-' .  $teammember['Trainingmomentsteammember'][1]['Trainingmoment']['end_time_nice'] . ')' : '');
				$mytrainingmoments[] = (isset($teammember['Trainingmomentsteammember'][2]['trainingmoment_id']) ? $teammember['Trainingmomentsteammember'][2]['Trainingmoment']['name'] . ' (' . $teammember['Trainingmomentsteammember'][2]['Trainingmoment']['start_time_nice'] . '-' .  $teammember['Trainingmomentsteammember'][2]['Trainingmoment']['end_time_nice'] . ')' : '');
				$mytrainingmoments[] = (isset($teammember['Trainingmomentsteammember'][3]['trainingmoment_id']) ? $teammember['Trainingmomentsteammember'][3]['Trainingmoment']['name'] . ' (' . $teammember['Trainingmomentsteammember'][3]['Trainingmoment']['start_time_nice'] . '-' .  $teammember['Trainingmomentsteammember'][3]['Trainingmoment']['end_time_nice'] . ')' : '');
				$mytrainingmoments[] = (isset($teammember['Trainingmomentsteammember'][4]['trainingmoment_id']) ? $teammember['Trainingmomentsteammember'][4]['Trainingmoment']['name'] . ' (' . $teammember['Trainingmomentsteammember'][4]['Trainingmoment']['start_time_nice'] . '-' .  $teammember['Trainingmomentsteammember'][4]['Trainingmoment']['end_time_nice'] . ')' : '');
			} else {
				// no individual trainingmoments found -- using those of main team (and main team only)
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
				// looking up all teams where the teammember plays -- yes only where he plays
				foreach ($teammember['Member']['Teammember'] as $myteam) {
					if ($myteam['teampriority'] > 0) $myteams[$myteam['teampriority']] = ($myteam['Team']['name']);
				}
			}
			$allmyteams = implode(', ', array_filter($myteams));
		?>
		<?php	foreach ($mymailaddresses as $mymailaddress) :  ?>
			<tr>
				<td><?= $teammember['Member']['lastname']; ?></td>
				<td><?= $teammember['Member']['firstname']; ?></td>
				<td><?= $mymailaddress; ?></td>
				<td><?= $teammember['Member']['membershipfee']; ?></td>
				<td><?= $teammember['Member']['membershipfee_discount']; ?></td>
				<td><?= $teammember['Member']['membership_advancepaid']; ?></td>
				<td><?= $teammember['Member']['membership_balancepaid']; ?></td>
				<td><?= $teammember['Team']['name']; ?></td>
				<td><?= $teammember['Team']['series']; ?></td>
				<td><?= $teammember['Teammember']['teamfunction']; ?></td>
				<td><?= $teammember['Teammember']['teampriority']; ?></td>
				<td><?= $teampriorities[$teammember['Teammember']['teampriority']]; ?></td>
				<td><?= $teammember['Team']['homegame']; ?></td>
				<td><?= $mytrainingsregime; ?></td>
				<td><?= $allmytrainingmoments; ?></td>
				<td><?= $allmyteams; ?></td>
			</tr>
		<?php endforeach ; ?>
	<?php endforeach ; ?>
</table>


<?php
// pr($trainingmomentsteams);
// pr($teammembers);
?>
