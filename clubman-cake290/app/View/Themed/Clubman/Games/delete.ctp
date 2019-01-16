<!-- app/View/Games/delete.ctp -->
<h2>Wedstrijd van <?=$game['Team']['name']?></h2>

<div class="row">
	<div class="col-xs-12">

		<div class="panel panel-danger">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<p class="text-danger">
					<strong>Verwijderen wedstrijd van <?=$game['Team']['name']?></strong>:<br/>
					<?=$game['Game']['game_home']?> - <?=$game['Game']['game_away']?><br/>
					van <?=$weekdays[$game['Game']['day_of_week']]?>
					<?=$game['Game']['game_date_nice']?>
					om <?=$game['Game']['game_time_nice']?>
					(week <?=$game['Game']['week_of_year']?>)
				</p>
				<p>
					Ben je zeker dat je deze wedstrijd wil verwijderen?
				</p>
				<p class="text-danger">
					De volgende aanwezigheden van deze wedstrijd zullen mee verwijderd worden.
				</p>

				<hr/>

				<?php if (count($game['Gamesteammember']) > 0) : ?>
					<div class="table-responsive">
						<table class="table table-striped table-condensed">
							<tr>
								<th>Naam</th>
								<th>Status</th>
								<th>Opmerking</th>
							</tr>
							<?php foreach ($game['Gamesteammember'] as $thepresence) : ?>
								<tr>
									<td><?=$thepresence['Teammember']['Member']['name']?></td>
									<td><?=$thepresence['status']?></td>
									<td><?=$thepresence['remark']?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				<?php else : ?>
					<p>
						Voor deze wedstrijd zijn momenteel nog geen aanwezigheden ingegeven.<br/>
						Deze wedstrijd verwijderen zal dus geen extra informatie verloren doen gaan.
					</p>
				<?php endif; ?>
				<hr/>
				<p>
					Opmerking bij deze wedstrijd: <?=(($game['Game']['remark'] != '') ? $game['Game']['remark'] : '-')?>
				</p>
		  </div>
		</div>

		<div class="games form presences">
			<?=$this->Form->create('Game', array('class' => 'form-horizontal'))?>
			<?=$this->Form->hidden('Game.id', array('value' => $game['Game']['id']))?>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?=$this->Form->button(__('Verwijder deze wedstrijd'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>

<?php
//	pr($formdata);
//	pr($game);
//	echo '<hr/>';
//	pr($teammembers);
//	pr($gamesteammembers);
//	pr($thepresences);
?>
