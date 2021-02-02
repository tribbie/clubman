<!-- app/View/Teams/view.ctp -->
<?php if (isset($team['Team'])) : ?>
	<h2><?= $team['Team']['name']; ?></h2>

	<?php
		/// Reorder the teammembers according to shirtnumber
		$vieworder = array();
		$sortedteammembers = $team['Teammember'];
		foreach ($sortedteammembers as $key => $row) {
		    $vieworder[$key] = $row['shirtnumber'];
		}
		array_multisort($vieworder, SORT_ASC, SORT_NATURAL, $sortedteammembers);
	?>
	<div class="row oneteam">
		<div class="col-md-6">

			<div class='blockview teamview' id='teamimage'>
				<?php if (isset($team['Picture']['location'])) : ?>
					<?= $this->Html->image($team['Picture']['location'], array('title' => $team['Team']['name'], 'class' => 'img-responsive img-rounded center-block', 'width' => '100%')); ?>
				<?php else : ?>
					<?= $this->Html->image('cmstyle/team_placeholder.png', array('title' => 'no image', 'class' => 'img-responsive img-rounded center-block', 'width' => '100%')); ?>
				<?php endif; ?>
			</div>

		</div>

		<div class="col-md-6">

			<?php if ((strtolower($team['Team']['teamtype']) == 'omkadering') or (strtolower($team['Team']['category']) == 'onbekend')) : ?>

				<h3>Team info</h3>
				<div class="table-responsive">
					<table class='ploegalgemeen table table-condensed'>
						<tr>
							<th>Categorie</th>
							<td align='right'><?=$team['Team']['category'];?></th>
						</tr>
						<tr class='grouping active'><th colspan='2' align='center'>Leden</th></tr>
							<?php	foreach ($team['Teammember'] as $teammember) : ?>
							<!--//	gestopte leden laten we niet zien ... -->
							<?php	if ($teammember['teampriority'] <> 99) : ?>
								<tr>
									<td>
										<?php	if (trim($teammember['Member']['email'] == '')) : ?>
											<?=$teammember['Member']['name']?>
										<?php else : ?>
											<a href="mailto:<?=$teammember['Member']['email']?>"><?=$teammember['Member']['name']?></a>
										<?php endif ; ?>
									</td>
									<td align='right'>
										<?=$teammember['remark']?>
										<!--<?=$teammember['shirtnumber']?>-->
									</td>
								</tr>
							<?php endif ; ?>
						<?php endforeach ; ?>
					</table>
				</div>

			<?php else : ?>

				<h3>Team info</h3>
				<div class="table-responsive">
					<table class='ploegalgemeen table table-condensed'>
						<tr class='grouping active'><th colspan='3' align='center'>Algemeen</th></tr>
						<tr><th align='right'>Categorie</th><td colspan='2'><?=$team['Team']['category'];?> <?=$team['Team']['gender'];?></td></tr>
						<tr><th align='right'>Competitie</th><td colspan='2'><?=$team['Team']['series'];?></td></tr>
						<tr class='grouping active'><th colspan='3' align='center'>Momenten</th></tr>
						<tr><th align='right'>Thuiswedstrijden</th><td colspan='2'><?=$team['Team']['homegame'];?></tr>
						<?php foreach ($team['Trainingmomentsteam'] as $trainingmomentteam) : ?>
							<tr>
								<th align='right'>Training</th>
								<td>
									<?=$weekdays[$trainingmomentteam['Trainingmoment']['weekday']]?>
									<?=($trainingmomentteam['Trainingmoment']['remark'] == '' ? '' : '<span class="floatright">('.$trainingmomentteam['Trainingmoment']['remark'].')</span>')?>
									<?=($trainingmomentteam['remark'] == '' ? '' : '<span class="floatright">('.$trainingmomentteam['remark'].')</span>')?>
								</td>
								<td>
									<?=$trainingmomentteam['Trainingmoment']['start_time_nice']; ?>
									-
									<?= $trainingmomentteam['Trainingmoment']['end_time_nice']?>
									-
									<?= $trainingmomentteam['Trainingmoment']['location']?>
								</td>
							</tr>
						<?php endforeach; ?>
						<tr class='grouping active'><th colspan='3' align='center'>Begeleiding</th></tr>
						<?php	$prevteamprio = 0; ?>
						<?php	foreach ($team['Teammember'] as $teammember) : ?>
							<!--//	gestopte leden laten we niet zien ... -->
							<?php if ($teammember['teampriority'] <> 99) : ?>
								<?php if (($prevteamprio <= 0) and ($teammember['teampriority'] > 0))  : ?>
									<tr class='grouping active'><th colspan='3' align='center'>Spelers</th></tr>
								<?php endif ; ?>
								<tr title="<?=$teammember['remark']?>">
									<th align='right'><?=$teammember['teamfunction']?></th>
									<td align='right'>
										<?php if ($teammember['teampriority'] > 0) : ?>
											<?=($teammember['shirtnumber'] == 0 ? '' : '<span class="floatright">'.$teammember['shirtnumber'].'</span>')?>
										<?php endif; ?>
									</td>
									<td><?=$teammember['Member']['name']?></td>
								</tr>
								<?php $prevteamprio = $teammember['teampriority']; ?>
							<?php endif ; ?>
						<?php endforeach ; ?>
					</table>
				</div>

			<?php endif; ?>

		</div>

		<hr/>

		<?php if ((strtolower($team['Team']['teamtype']) <> 'omkadering') and (strtolower($team['Team']['category']) <> 'onbekend')) : ?>
			<div class="col-xs-12">

				<h3>Wedstrijden voor team <?= $team['Team']['name']; ?></h3>
				<div class="table-responsive">
					<table id='gamesTable' class='ploegkalender table table-condensed table-striped'>
						<tr>
							<th>dag</th>
							<th>datum</th>
							<th>begin</th>
							<th>thuisploeg</th>
							<th>bezoekers</th>
							<th>wijziging</th>
						</tr>
						<?php foreach ($team['Game'] as $game) : ?>
							<?php
								if ($game['game_change'] == '') {
		    					$tdclass = "";
		    				} elseif ($game['game_change'] == 'afgelast') {
		    					$tdclass = $game['game_change'];
		    				} else {
									$tdclass = "";
								}
							?>
							<tr title='<?=$game['game_code']?> <?=($game['remark'] == '' ? '' : '('.$game['remark'].')')?>'>
								<td class='<?=$game['game_code']?>'><?= $shortweekdays[$game['day_of_week']]; ?></td>
								<td class='<?=$game['game_code']?>' align='right'><?= $game['game_date_nice']; ?></td>
								<td class='<?=$tdclass?> <?=$game['game_code']?>'><?= $game['game_time_nice']; ?></td>
								<td class='<?=$tdclass?> <?=$game['game_code']?>'><?= $game['game_home']; ?></td>
								<td class='<?=$tdclass?> <?=$game['game_code']?>'><?= $game['game_away']; ?></td>
								<td class='<?=$game['game_code']?>'><?= $game['game_change']; ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>

			</div>
			<hr/>
		<?php endif; ?>

	</div>
<?php endif; ?>

<?php
	// pr($team);
?>
