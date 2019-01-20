<!-- app/View/Games/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> wedstrijdfiche</h2>


<div class="row">

	<div class="col-md-6">

		<div class="panel panel-info">
			<div class="panel-heading">
				Wedstrijd van <?=$game['Team']['name']?><br/>
				<?=$game['Game']['game_home']?> - <?=$game['Game']['game_away']?>
				<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'gameadmin']))) : ?>
					<span class='pull-right'><?= $this->Html->link('wijzig', array('controller' => 'games', 'action' => 'edit', $game['Game']['id'])) ?></span>
				<?php endif ; ?>
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Team</dt>						<dd><?=$game['Team']['name']?></dd>
					<dt>Datum</dt>					<dd><?=$game['Game']['game_date_nice']?></dd>
					<dt>Uur</dt>						<dd><?=$game['Game']['game_time_nice']?></dd>
					<dt>Type</dt>						<dd><?=$game['Game']['game_code']?></dd>
					<dt>Thuisploeg</dt>			<dd><?=$game['Game']['game_home']?></dd>
					<dt>Bezoekers</dt>			<dd><?=$game['Game']['game_away']?></dd>
					<dt>Wedstrijdnummer</dt><dd><?=$game['Game']['game_number'];?></dd>
					<dt>Coach</dt>					<dd><?=((isset($game['Coach']['Member'])) ? $game['Coach']['Member']['name'] : '?')?></dd>
					<dt>Locatie</dt>				<dd><?=$game['Game']['game_hall'];?></dd>
					<dt>Scheidsrechter</dt>	<dd><?=$game['Game']['game_referee'];?></dd>
					<dt>Markeerder</dt>			<dd><?=$game['Game']['game_marker'];?></dd>
					<dt>Scorebord</dt>			<dd><?=$game['Game']['game_scoreboard'];?></dd>
					<dt>Wijziging</dt>			<dd><?=$game['Game']['game_change'];?></dd>
					<dt>Opmerking</dt>			<dd><?=$game['Game']['remark'];?></dd>
				</dl>
			</div>
		</div>

	</div>

	<div class="col-md-6">

				<div class="table-responsive">
					<table class="table table-condesed table-striped table-bordered normalelijst">
						<tr class="groupheader info">
							<th>Speler</th>
							<th>Status</th>
						</tr>
						<?php
							$statusstyle = array('aanwezig' => 'color: #090;', 'afwezig' => 'color: #900;', 'verwittigd' => 'color: #666;', 'gekwetst' => 'color: #009;', 'ziek' => 'color: #333;', 'telaat' => 'color: #f90;', '' => 'color: #000;');
							$statusclass = array('aanwezig' => 'bg-success', 'afwezig' => 'bg-danger', 'verwittigd' => 'bg-info', 'gekwetst' => 'bg-info', 'ziek' => 'bg-info', 'telaat' => 'bg-warning', '' => '');
						?>
						<?php foreach ($game['Gamesteammember'] as $teammember) : ?>
							<tr>
								<td><?=$teammember['Teammember']['Member']['name']?></td>
								<td class="text-center <?=$statusclass[$teammember['status']]?>" style="<?=$statusstyle[$teammember['status']]?>"><?=$teammember['status']?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>

	</div>

</div>

<hr/>
<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'gameadmin']))) : ?>
	<?= $this->Html->link('Wijzig wedstrijd', array('controller' => 'games', 'action' => 'edit', $game['Game']['id']))."\n"; ?>
<?php endif ; ?>

<?php
// pr($game);
?>
