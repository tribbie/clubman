<h2>Wijzigingen</h2>
<p>
	Deze pagina bevat wijzigingen t.o.v. de oorspronkleijke kalender sinds <?=$period['datefrom']?>.
</p>
<?php if ($team['Team']['full_name'] == 'allemaal') : ?>
	<h3>Alle teams</h3>
<?php else : ?>
	<h3>Team <?=$team['Team']['full_name']?></h3>
<?php endif; ?>

<div class="row">
	<div class="col-xs-12">

		<div class="panel panel-info">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<p>
					Een klein woordje uitleg bij deze pagina.<br/>
					Als er in de "wijziging" kolom niets staat, gaat het om een niet-competitiewedstrijd.<br/>
					In de "wijziging" kolom kun je volgende waarden vinden:
				</p>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<table class='uitleglijst table table-condensed'>
							<tr><th class="text-right">te verplaatsen:</th><td>Een nieuwe datum moet nog afgesproken worden. De datum die je ziet is nog steeds die van de oorspronkelijke competitiekalender.</td></tr>
							<tr><th class="text-right">verplaatst:</th><td>De wedstrijd gaat op een andere dag door. De datum die je ziet is de nieuwe datum.</td></tr>
							<tr><th class="text-right">vervroegd/verlaat:</th><td>Enkel het uur is gewijzigd.</td></tr>
							<tr><th class="text-right">afgelast:</th><td>Er werd geen nieuwe datum gevonden. Deze wedstrijd gaat dus niet meer door.</td></tr>
							<tr><th class="text-right">niets:</th><td>Dit zijn de bekerwedstrijden, oefenwedstrijden en tornooien. Deze staan ook niet op de oorspronkelijke competitiekalender.</td></tr>
						</table>
					</div>
				</div>
		  </div>
		</div>

		<hr/>

		<table class="table table-condensed table-striped normalelijst">
			<tr class="info">
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
				  <td style="text-align:right;"><?=substr($game['Game']['game_time'], 0, 5)?></td>
				  <td><?=$game['Game']['game_home']?></td>
				  <td><?=$game['Game']['game_away']?></td>
					<?php if (isset($game['Coach']['Member'])) : ?>
						<td><?=$game['Coach']['Member']['name']?></td>
					<?php else : ?>
						<td>?</td>
					<?php endif; ?>
					<!--<td><?=$game['Game']['game_hall']?></td>-->
			 	</tr>
			<?php endforeach; ?>
		</table>

	</div>
</div>
<?
	//pr($period);
	//pr($team);
	//pr($games);
?>
