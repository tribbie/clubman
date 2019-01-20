<!-- app/View/Teams/view.ctp -->
<h2><?= $team['Team']['name']; ?>, aka "<?= $team['Team']['shortname']?>"</h2>

<script>
	$(document).ready(function() {
		<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin']))) : ?>
			$("table#gamesTable tr.ancientgame").show();
			$("table#gamesTable tr.futuregame").show();
			$("table#trainingsTable tr.ancienttraining").show();
			$("table#trainingsTable tr.futuretraining").show();
		<?php else : ?>
			$("table#gamesTable tr.ancientgame").hide();
			$("table#gamesTable tr.futuregame").hide();
			$("table#trainingsTable tr.ancienttraining").hide();
			$("table#trainingsTable tr.futuretraining").hide();
		<?php endif; ?>

		$("#toggleAncientGames").click(function() {
			$("table#gamesTable tr.ancientgame").toggle('200');
		});
		$("#toggleFutureGames").click(function() {
			$("table#gamesTable tr.futuregame").toggle('200');
		});

		$("#toggleAncientTrainings").click(function() {
			$("table#trainingsTable tr.ancienttraining").toggle('200');
		});
		$("#toggleFutureTrainings").click(function() {
			$("table#trainingsTable tr.futuretraining").toggle('200');
		});
	});
</script>

<div class="row">

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				Foto
				<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin']))) : ?>
					<span class='pull-right'><?=$this->Html->link('wijzig', array('controller' => 'teams', 'action' => 'edit', $team['Team']['id'], 'picture'))?></span>
				<?php endif; ?>
			</div>
			<div class="panel-body">
				<?php if (isset($team['Picture']['location'])) : ?>
					<?=$this->Html->image($team['Picture']['location'], array('title' => $team['Team']['name'], 'class' => 'img-responsive'))?>
				<?php else : ?>
					<?=$this->Html->image('cmstyle/team_placeholder.png', array('title' => 'no image', 'class' => 'img-responsive'))?>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				Algemeen
				<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin']))) : ?>
					<span class='pull-right'><?=$this->Html->link('wijzig', array('controller' => 'teams', 'action' => 'edit', $team['Team']['id'], 'general'))?></span>
				<?php endif ; ?>
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Naam</dt>						<dd><?=$team['Team']['name']?></dd>
					<dt>Aka</dt>						<dd><?=$team['Team']['shortname']?></dd>
					<dt>Type</dt>						<dd><?=$team['Team']['teamtype']?></dd>
					<dt>Categorie</dt>			<dd><?=$team['Team']['category']?> <?=$team['Team']['gender']?></dd>
					<dt>Reeks</dt>					<dd><?=$team['Team']['series']?></dd>
					<dt>Competitiecode</dt>	<dd><?=$team['Team']['competition']?></dd>
					<dt>E-mail adres</dt>		<dd><?=$team['Team']['email']?></dd>
					<?php foreach ($team['Trainingmomentsteam'] as $trainingmomentteam) : ?>
						<dt>Training</dt>
						<dd>
							<?=$weekdays[$trainingmomentteam['Trainingmoment']['weekday']]?>
							<?=($trainingmomentteam['Trainingmoment']['remark'] == '' ? '' : '<span class="floatright">('.$trainingmomentteam['Trainingmoment']['remark'].')</span>')?>
							<?=($trainingmomentteam['remark'] == '' ? '' : '<span class="floatright">('.$trainingmomentteam['remark'].')</span>')?>
							<span class='pull-right'><?=$trainingmomentteam['Trainingmoment']['start_time_nice']?> - <?=$trainingmomentteam['Trainingmoment']['end_time_nice']?></span>
						</dd>
					<?php endforeach; ?>
					<dt>Thuiswedstrijd</dt>	<dd><?=$team['Team']['homegame']?></dd>
				</dl>
			</div>
		</div>
	</div>

</div>

<div class="row">

	<div class="col-md-6">

		<div class="panel panel-info">
		  <div class="panel-heading">
				Spelers info
				<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin']))) : ?>
					<span class='actionright pull-right'><?= $this->Html->link('wijzig', array('controller' => 'teammembers', 'action' => 'team', $team['Team']['id']))?></span>
				<?php endif ; ?>
			</div>
		  <div class="panel-body">
				<?php
					echo '<dl class="dl-horizontal">';
					if (count($team['Teammember']) > 0) {
						$prevteamprio = 0;
						foreach ($team['Teammember'] as $teammember) {
							// gestopte leden laten we niet zien ...
							if ($teammember['teampriority'] <> 99) {
								if (($prevteamprio <= 0) and ($teammember['teampriority'] > 0)) {
									echo '<hr>';
								}
								echo '<dt>' . $teammember['teamfunction'] . '</dt>';
								echo '<dd>' . $teammember['Member']['name'] . ($teammember['shirtnumber'] == 0 ? '' : '<span class="pull-right">'.$teammember['shirtnumber'].'</span>') . '</dd>';
								$prevteamprio = $teammember['teampriority'];
							}
						}
					} else {
						echo '<dt>Leeg</dt><dd>-</dd>';
					}
					echo '</dl>';
					if (count($team['Teammember']) == 0) {
						if (($loggedIn) and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin']))) {
							echo '<span>';
							echo $this->Html->link('initializeer dit team', array('controller' => 'teammembers', 'action' => 'addbulk', $team['Team']['id']));
							echo '</span>';
						}
					}
				?>
		  </div>
		</div>

	</div>

	<div class="col-md-6">

		<div class="panel panel-info">
		  <div class="panel-heading">
				Enkele handige teamlinks
			</div>
		  <div class="panel-body">
				<?php
					// first, define all links
					$cmLinks = array(
									'chgteam' => array('linktext' => 'Wijzig team', 'linkoptions' => array('controller' => 'teams', 'action' => 'edit', $team['Team']['id'])),
									'lstteam' => array('linktext' => 'Handig overzicht', 'linkoptions' => array('controller' => 'teams', 'action' => 'overview', $team['Team']['id'])),
									'lstlic' => array('linktext' => 'Licenties', 'linkoptions' => array('controller' => 'teams', 'action' => 'viewlicenses', $team['Team']['id'])),
									'neweffort' => array('linktext' => 'Nieuwe prestatie voor dit team', 'linkoptions' => array('controller' => 'efforts', 'action' => 'add', $team['Team']['id']))
								);
					// then, define who will get which links
					$cmLinkIdsPerRole = array(
									'root'           => array('chgteam', 'lstteam', 'lstlic', 'neweffort'),
									'admin'          => array('chgteam', 'lstteam', 'lstlic', 'neweffort'),
									'teamadmin'      => array('chgteam', 'lstteam', 'lstlic', 'neweffort'),
									'gameadmin'      => array('lstteam'),
									'memberadmin'    => array(),
									'memberedit'     => array(),
									'memberview'     => array('lstteam', 'lstlic'),
									'trainerfinance' => array(),
									'memberfinance'  => array(),
									'trainer'        => array('lstteam', 'lstlic', 'neweffort'),
									'member'         => array()
								);
					// finally, show them links
					if ($loggedIn) {
						/// Merge for cumulated roles
						$mergedLinkIdsToShow = $this->Link->mergeLinkIds($cmLinkIdsPerRole, $cmCurrentRoles);
						echo $this->Link->showLinks($cmLinks, $mergedLinkIdsToShow);
					}
				?>
		  </div>
		</div>

	</div>

</div>

<hr/>

<div class="row">

	<div class="col-xs-12">

		<h3>Wedstrijden voor team <?= $team['Team']['name']; ?></h3>
		<div class="table-responsive">
			<table class="normalelijst table table-striped table-condensed table-hover" id='gamesTable'>

				<thead>
					<tr class="info">
						<th><span class="pull-right">datum</span></th>
						<th>begin</th>
						<th>type</th>
						<th>*</th>
						<th>thuisploeg</th>
						<th>bezoekers</th>
						<th>locatie</th>
						<th>opmerking</th>
						<th>wijziging</th>
						<?php $gamecolumns = 9; ?>
						<?php if (($loggedIn) and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'gameadmin']))): ?>
							<th>akties</th>
							<?php $gamecolumns += 1; ?>
						<?php endif ; ?>
					</tr>
				</thead>
				<tbody>
					<?php
						$ancientstartdate = strtotime('-8 days');
						$ancientstart = date('Y-m-d', $ancientstartdate);
						$ancientstartnice = date('d/m/Y', $ancientstartdate);
						$ancienttoggle = 0;
						$ancientgames = 0;

						$futurestartdate = strtotime('+21 days');
						$futurestart = date('Y-m-d', $futurestartdate);
						$futurestartnice = date('d/m/Y', $futurestartdate);
						$futuretoggle = 0;
						$futuregames = 0;
					?>

					<?php foreach ($team['Game'] as $game) : ?>

						<?php
							$gameclass = 'nearbygame';
							if ($game['game_date'] < $ancientstart) {
								$gameclass = 'ancientgame';
								$ancientgames += 1;
							} elseif ($game['game_date'] <= $futurestart) {
								$gameclass = 'nearbygame';
							} else {
								$gameclass = 'futuregame';
								$futuregames += 1;
							}

	    				if ($game['game_change'] == '') {
	    					$tdclass = "";
	    				} elseif ($game['game_change'] == 'afgelast') {
	    					$tdclass = "class='gamecancel'";
	    				} elseif ($game['game_change'] == 'te verplaatsen') {
	    					$tdclass = "class='gametochange'";
	    				} else {
	    					$tdclass = "class='gamechange'";
	    				}


						?>

						<?php if (($ancientgames > 0) and ($ancienttoggle == 0) and (($gameclass == 'nearbygame') or ($gameclass == 'futuregame'))) : ?>
							<tr id='toggleAncientGames' style='border: solid 1px #ccc; background: #eee; cursor: pointer;'><td colspan='<?=$gamecolumns?>'>... vroeger dan <?=$ancientstartnice?> ...</td></tr>
							<?php $ancienttoggle = 1; ?>
						<?php endif ; ?>

						<?php if (($futuregames > 0) and ($futuretoggle == 0)) : ?>
							<tr id='toggleFutureGames' style='border: solid 1px #ccc; background: #eee; cursor: pointer;'><td colspan='<?=$gamecolumns?>'>... later dan <?=$futurestartnice?> ...</td></tr>
							<?php $futuretoggle = 1; ?>
						<?php endif ; ?>


						<tr class='<?=$gameclass?>'>
							<?php if (($loggedIn) and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'trainer']))) : ?>
								<td style='text-align: right'><?=$this->Html->link($game['game_date_nice'], array('controller' => 'games', 'action' => 'presences', $game['id']))?></td>
							<?php else : ?>
								<td style='text-align: right'><?=$game['game_date_nice']?></td>
							<?php endif ; ?>
							<td><?=$game['game_time_nice']?></td>
							<td <?=$tdclass?>><?=$game['game_code']?></td>
							<td <?=$tdclass?>><?=((count($game['Gamesteammember']) == 0) ? '' : '*')?></td>
							<td <?=$tdclass?>><?=$game['game_home']?></td>
							<td <?=$tdclass?>><?=$game['game_away']?></td>
							<td <?=$tdclass?>><?=$game['game_hall']?></td>
							<td><?=$game['remark']?></td>
							<td><?=$game['game_change']?></td>
							<?php if (($loggedIn) and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'gameadmin']))) : ?>
								<td>
									<?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'games', 'action' => 'edit', $game['id']), array('title' => 'wijzig deze wedstrijd', 'escape' => false))?>
									<?php if (($loggedIn) and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin']))) : ?>
										<?=$this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'games', 'action' => 'delete', $game['id']), array('title' => 'verwijder deze wedstrijd', 'escape' => false))?>
									<?php endif ; ?>
								</td>
							<?php endif ; ?>
						</tr>

					<?php endforeach; ?>

					<!-- if all games are processed, and there are ancient games, but still no toggle, then we put the slider here -->
					<?php if (($ancientgames > 0) and ($ancienttoggle == 0)) : ?>
						<tr id='toggleAncientGames' style='border: solid 1px #ccc; background: #eee; cursor: pointer;'><td colspan='<?=$gamecolumns?>'>... vroeger dan <?=$ancientstartnice?> ...</td></tr>
						<?php $ancienttoggle = 1; ?>
					<?php endif ; ?>
				</tbody>

			</table>
		</div>

		<?php
		// first, define all links
		$cmLinks = array(
						'addgame'      => array('linktext' => 'Voeg wedstrijd toe', 'linkoptions' => array('controller' => 'games', 'action' => 'add', 'team' => $team['Team']['id'])),
						'addgames'     => array('linktext' => 'Importeer wedstrijden', 'linkoptions' => array('controller' => 'games', 'action' => 'import', 'team' => $team['Team']['id'])),
						'gameoverview' => array('linktext' => 'Wedstrijdoverzicht', 'linkoptions' => array('controller' => 'games', 'action' => 'overview', $team['Team']['id'])),
						'gamepres'     => array('linktext' => 'Overzicht aanwezigheden', 'linkoptions' => array('controller' => 'reports', 'action' => 'presencesgames', $team['Team']['id']))
					);
		// then, define who will get which links
		$cmLinkIdsPerRole = array(
						'root'           => array('addgame', 'addgames', 'gameoverview', 'gamepres'),
						'admin'          => array('addgame', 'addgames', 'gameoverview', 'gamepres'),
						'teamadmin'      => array('addgame', 'addgames', 'gameoverview', 'gamepres'),
						'gameadmin'      => array('addgame', 'addgames', 'gameoverview'),
						'memberadmin'    => array(),
						'memberedit'     => array(),
						'memberview'     => array('gamepres'),
						'trainerfinance' => array(),
						'memberfinance'  => array(),
						'trainer'        => array('addgame', 'gameoverview', 'gamepres'),
						'member'         => array()
					);
		// finally, show them links
		if ($loggedIn) {
			/// Merge for cumulated roles
			$mergedLinkIdsToShow = $this->Link->mergeLinkIds($cmLinkIdsPerRole, $cmCurrentRoles);
			echo $this->Link->showLinks($cmLinks, $mergedLinkIdsToShow);
		}
		?>

	</div>

</div>


<hr/>


<div class="row">

	<div class="col-xs-12">

		<h3>Trainingen voor team <?=$team['Team']['name']?></h3>
		<div class="table-responsive">
			<table class="normalelijst table table-striped table-condensed table-hover" id='trainingsTable'>
				<thead>
					<tr class="info">
						<th><span class="pull-right">datum</span></th>
						<th>moment</th>
						<th>begin</th>
						<th>einde</th>
						<th>*</th>
						<th>locatie</th>
						<th>opmerking</th>
						<?php $trainingcolumns = 7; ?>
						<?php if (($loggedIn) and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'trainer']))): ?>
							<th>akties</th>
							<?php $trainingcolumns += 1; ?>
						<?php endif ; ?>
					</tr>
				</thead>
				<tbody>
					<?php
					$ancientstartdate = strtotime('-7 days');
					$ancientstart = date('Y-m-d', $ancientstartdate);
					$ancientstartnice = date('d/m/Y', $ancientstartdate);
					$ancienttoggle = 0;
					$ancienttrainings = 0;

					$futurestartdate = strtotime('+14 days');
					$futurestart = date('Y-m-d', $futurestartdate);
					$futurestartnice = date('d/m/Y', $futurestartdate);
					$futuretoggle = 0;
					$futuretrainings = 0;
					?>

					<?php foreach ($team['Training'] as $training) : ?>
						<?php
						$trainingclass = 'nearbytraining';
						if ($training['start_date'] < $ancientstart) {
							$trainingclass = 'ancienttraining';
							$ancienttrainings += 1;
						}
						if ($training['start_date'] > $futurestart) {
							$trainingclass = 'futuretraining';
							$futuretrainings += 1;
						}
						?>

						<?php if (($ancienttrainings > 0) and ($ancienttoggle == 0) and (($trainingclass == 'nearbytraining') or ($trainingclass == 'futuregame'))) : ?>
							<tr id='toggleAncientTrainings' style='border: solid 1px #ccc; background: #eee; cursor: pointer;'><td colspan='<?=$trainingcolumns?>'>... vroeger dan <?=$ancientstartnice?> ...</td></tr>
							<?php $ancienttoggle = 1; ?>
						<?php endif ; ?>

						<?php if (($futuretrainings > 0) and ($futuretoggle == 0)) : ?>
							<tr id='toggleFutureTrainings' style='border: solid 1px #ccc; background: #eee; cursor: pointer;'><td colspan='<?=$trainingcolumns?>'>... later dan <?=$futurestartnice?> ...</td></tr>
							<?php $futuretoggle = 1; ?>
						<?php endif ; ?>

						<tr class='<?=$trainingclass?>'>
							<?php if (($loggedIn) and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'trainer']))) : ?>
								<td style='text-align: right'><?=$this->Html->link($training['start_date_nice'], array('controller' => 'trainings', 'action' => 'presences', $training['id']))?></td>
							<?php else : ?>
								<td style='text-align: right'><?=$training['start_date_nice']?></td>
							<?php endif ; ?>
							<td><?=(isset($training['Trainingmoment']['name']) ? $training['Trainingmoment']['name'] : 'toegevoegde training')?></td>
							<td><?=$training['start_time_nice']?></td>
							<td><?=$training['end_time_nice']?></td>
							<td><?=((count($training['Trainingsteammember']) == 0) ? '' : '*')?></td>
							<td><?=$training['location']?></td>
							<td><?=$training['remark']?></td>
							<?php if (($loggedIn) and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'trainer']))) : ?>
								<td>
									<?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'trainings', 'action' => 'edit', $training['id']), array('title' => 'wijzig deze training', 'escape' => false))?>
									<?php if (($loggedIn) and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin']))) : ?>
										<?=$this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'trainings', 'action' => 'delete', $training['id']), array('title' => 'verwijder deze training', 'escape' => false))?>
									<?php endif ; ?>
								</td>
							<?php endif ; ?>
						</tr>
					<?php endforeach; ?>

					<!-- if all trainings are processed, and there are ancient trainings, but still no toggle, then we put the slider here -->
					<?php if (($ancienttrainings > 0) and ($ancienttoggle == 0)) : ?>
						<tr id='toggleAncientTrainings' style='border: solid 1px #ccc; background: #eee; cursor: pointer;'><td colspan='<?=$gamecolumns?>'>... vroeger dan <?=$ancientstartnice?> ...</td></tr>
						<?php $ancienttoggle = 1; ?>
					<?php endif ; ?>
				</tbody>

			</table>
		</div>

		<?php
			// first, define all links
			$cmLinks = array(
							'addonetr'  => array('linktext' => 'Voeg een training toe', 'linkoptions' => array('controller' => 'trainings', 'action' => 'add', 'team' => $team['Team']['id'])),
							'addmoretr' => array('linktext' => 'Voeg een hoop trainingen toe', 'linkoptions' => array('controller' => 'trainings', 'action' => 'generate', 'team' => $team['Team']['id'])),
							'trpres'    => array('linktext' => 'Overzicht aanwezigheden', 'linkoptions' => array('controller' => 'reports', 'action' => 'presencestrainings', $team['Team']['id']))
						);
			// then, define who will get which links
			$cmLinkIdsPerRole = array(
							'root'           => array('addonetr', 'addmoretr', 'trpres'),
							'admin'          => array('addonetr', 'addmoretr', 'trpres'),
							'teamadmin'      => array('addonetr', 'addmoretr', 'trpres'),
							'gameadmin'      => array(),
							'memberadmin'    => array(),
							'memberedit'     => array(),
							'memberview'     => array('trpres'),
							'trainerfinance' => array(),
							'memberfinance'  => array(),
							'trainer'        => array('addonetr', 'trpres'),
							'member'         => array()
						);
			// finally, show them links
			if ($loggedIn) {
				/// Merge for cumulated roles
				$mergedLinkIdsToShow = $this->Link->mergeLinkIds($cmLinkIdsPerRole, $cmCurrentRoles);
				echo $this->Link->showLinks($cmLinks, $mergedLinkIdsToShow);
			}
		?>

	</div>

</div>


<hr/>

<?php
// pr($team);
?>
