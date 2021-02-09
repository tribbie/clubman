<!-- app/View/Trainings/generate.ctp -->
<?php if (isset($generatedtrainings)) : ?>
	<div class="panel panel-default">
		<!-- List group -->
		<ul class="list-group">
			<?php foreach ($generatedtrainings as $generatedtraining) : ?>
				<li class="list-group-item list-group-item-<?=($generatedtraining['SaveResult']['rc'] ? 'success' : 'danger')?>">
					<font size="-1">
						Training van <?=$generatedtraining['Training']['start_date']?> om <?=$generatedtraining['Training']['start_time']?>: <?=$generatedtraining['SaveResult']['msg']?><br/>
					</font>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
<h2>Nieuwe trainingen</h2>

<script>
	$(document).ready(function(){
		$('.datepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1 } );
	});
</script>

<div class="row">
	<div class="col-xs-12">

		<div class="panel panel-info">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<p>
					Vergeet onderaan niet op "Genereer trainingen" te klikken!
				</p>
		  </div>
		</div>

		<div class="trainings form">
			<h4>Voeg trainingen toe</h4>
			<?=$this->Form->create('Training', array('class' => 'form-horizontal'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Team</label>
				<div class="col-sm-6">
					<?=$this->Form->input('team_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'empty' => true, 'required' => true, 'id' => 'focusme'))?>
				</div>
			</div>

			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Datum van (YYYY-MM-DD)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('datefrom', array('label'=>false, 'div'=>false, 'class' => 'form-control datepicker', 'type' => 'text', 'required' => true, 'title' => 'Datum van (YYYY-MM-DD)'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Datum tot (YYYY-MM-DD)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('dateto', array('label'=>false, 'div'=>false, 'class' => 'form-control datepicker', 'type' => 'text', 'required' => true, 'title' => 'Datum tot (YYYY-MM-DD)'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Trainingmoment</label>
				<div class="col-sm-6">
					<?=$this->Form->input('trainingmoment_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'empty' => true, 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?= $this->Form->button(__('Genereer trainingen'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>

		</div>

	</div>
</div>

<hr/>

<?php if (isset($teamname)) : ?>
	<h3>Trainingen voor team "<?=$teamname?>"</h3>
	<div class="table-responsive">
		<table class="table table-striped table-condensed normalelijst">
			<tr class="groupheader info">
				<th>moment</th>
				<th>datum</th>
				<th>begin</th>
				<th>end</th>
				<th>data</th>
				<th>action</th>
			</tr>
			<?php foreach ($trainings as $training) : ?>
				<tr>
					<td><?=$training['Trainingmoment']['name']?></td>
					<td><?=$training['Training']['start_date']?></td>
					<td><?=$training['Training']['start_time']?></td>
					<td><?=$training['Training']['end_time']?></td>
					<td><?=((count($training['Trainingsteammember']) == 0) ? '' : '*')?></td>
					<td>
						<?=$this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'trainings', 'action' => 'delete', $training['Training']['id']), array('title' => 'verwijder deze training', 'escape' => false))?>
					</td>
				</tr>
			<?php endforeach ; ?>
		</table>
	</div>
<?php endif; ?>

<?php
//if (isset($formdata)) pr($formdata);
//if (isset($generatedtrainings)) pr($generatedtrainings);
//if (isset($trainings)) pr($trainings);
?>
