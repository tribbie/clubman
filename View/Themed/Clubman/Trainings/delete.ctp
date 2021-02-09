<!-- app/View/Trainings/delete.ctp -->
<h2>Training van <?=$training['Team']['name']?></h2>

<div class="row">
	<div class="col-xs-12">

		<div class="panel panel-danger">
			<div class="panel-heading">Belangrijke informatie</div>
			<div class="panel-body">
				<p class="text-danger">
					<strong>Verwijderen training van <?=$training['Team']['name']?></strong>:<br/>
					<?=$weekdays[$training['Training']['day_of_week']]?>
					<?=$training['Training']['start_date_nice']?>
					van <?=$training['Training']['start_time_nice']?>
					tot <?=$training['Training']['end_time_nice']?>
					(week <?=$training['Training']['week_of_year']?>)
				</p>
				<p>
					Ben je zeker dat je deze training wil verwijderen?
				</p>
				<p class="text-danger">
					De aanwezigheden van deze training zullen mee verwijderd worden.
				</p>
				<hr/>
				<?php if (count($training['Trainingsteammember']) > 0) : ?>
					<div class="table-responsive">
						<table class="table table-striped table-condensed">
							<tr>
								<th>Naam</th>
								<th>Status</th>
								<th>Opmerking</th>
							</tr>
							<?php foreach ($training['Trainingsteammember'] as $thepresence) : ?>
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
						Voor deze training zijn momenteel nog geen aanwezigheden ingegeven.<br/>
						Deze training verwijderen zal dus geen extra informatie verloren doen gaan.
					</p>
				<?php endif; ?>
				<hr/>
				<p>
					Opmerking bij deze training: <?=(($training['Training']['remark'] != '') ? $training['Training']['remark'] : '-')?>
				</p>
			</div>
		</div>

		<div class="trainings form presences">
			<?=$this->Form->create('Training', array('class' => 'form-horizontal'))?>

			<?=$this->Form->hidden('Training.id', array('value' => $training['Training']['id']))?>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?=$this->Form->button(__('Verwijder deze training'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>

<?php
//	pr($formdata);
//	pr($training);
//	echo '<hr/>';
//	pr($teammembers);
//	pr($trainingsteammembers);
//	pr($thepresences);
?>
