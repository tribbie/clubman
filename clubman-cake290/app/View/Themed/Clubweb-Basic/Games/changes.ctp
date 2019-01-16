<h1>Wijzigingen</h1>
<h2>Wijzigingen t.o.v. de oorspronkelijke kalender sinds <?=$period['datefrom']?>.</h2>

<?php if ($team['Team']['full_name'] == 'allemaal') : ?>
	<h3>Alle teams</h3>
<?php else : ?>
	<h3>Team <?=$team['Team']['full_name']?></h3>
<?php endif; ?>

Een klein woordje uitleg bij deze pagina. In de "wijziging" kolom kun je volgende waarden vinden:<br/>
<br/>
<table class='uitleglijst'>
	<tr><th style="text-align:right;">te verplaatsen:</th><td>Een nieuwe datum moet nog afgesproken worden. De datum die je ziet is nog steeds die de oorspronkelijke datum.</td></tr>
	<tr><th style="text-align:right;">verplaatst:</th><td>De wedstrijd gaat op een andere dag door. De datum die je ziet is de nieuwe datum.</td></tr>
	<tr><th style="text-align:right;">vervroegd/verlaat:</th><td>Enkel het uur is gewijzigd.</td></tr>
	<tr><th style="text-align:right;">afgelast:</th><td>Er werd geen nieuwe datum gevonden. Deze wedstrijd gaat dus niet meer door.</td></tr>
	<tr><th style="text-align:right;">niets:</th><td>Dit zijn de bekerwedstrijden, oefenwedstrijden en tornooien. Deze stonden ook niet op de oorspronkelijke kalender.</td></tr>
</table>
<br/>
<hr/>
<br/>

<table class='wedstrijdlijst'>
	<tr>
	  <th>Type</th>
	  <th>Team</th>
	  <th>Wijziging</th>
	  <th style="text-align:right;">Datum</th>
	  <th style="text-align:right;">Tijd</th>
	  <th>Thuisploeg</th>
	  <th>Bezoekers</th>
	  <th>Coach</th>
		<!--<th>Sporthal</th>-->
	</tr>
	<?php foreach ($games as $game) : ?>
		<?php
			if ($game['Game']['game_change'] == '') {
				$trchange = "";
			} elseif ($game['Game']['game_change'] == 'afgelast') {
				$trchange = "class='gamecancel' title='Wedstrijd " . $game['Game']['game_change'] . "'";
			} else {
				$trchange = "class='gamechange' title='Wedstrijd " . $game['Game']['game_change'] . "'";
			}
		?>
		<tr <?=$trchange?>>
		  <td><?=$game['Game']['game_code']?></td>
		  <td><?=$game['Team']['name']?>&nbsp;(<?=$game['Team']['competition']?>)</td>
		  <td><?=$game['Game']['game_change']?></td>
			<td style="text-align:right;"><?=$weekd[$game['Game']['day_of_week']]?>&nbsp;<?=date("j/m/Y", strtotime($game['Game']['game_date']))?></td>
		  <td style="text-align:right;"><?=$game['Game']['game_time_nice']?></td>
		  <td><?=$game['Game']['game_home']?></td>
		  <td><?=$game['Game']['game_away']?></td>
			<?php if (isset($game['Coach']['Member'])) : ?>
		  	<td><?=$game['Coach']['Member']['name']?></td>
			<?php else : ?>
			  <td>?</td>
			<?php endif; ?>
			<!--<td>" . $game['Game']['game_hall'] . "</td>-->
		</tr>
	<?php endforeach; ?>
</table>

<?
	//pr($period);
	//pr($team);
	//pr($games);
?>
