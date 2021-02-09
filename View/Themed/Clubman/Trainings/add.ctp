<!-- app/View/Trainings/add.ctp -->
<h2>Nieuwe training</h2>
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
					Gelieve dit formulier enkel te gebruiken om <strong>extra trainingen</strong> mee aan te maken.<br/>
					De normale trainingen worden door de Cel Jeugd toegevoegd.
				</p>
				<p>
					Vergeet onderaan niet op "Voeg training toe" te klikken!
				</p>
		  </div>
		</div>

		<div class="trainings form">
			<h4>Voeg een training toe</h4>
			<?=$this->Form->create('Training', array('class' => 'form-horizontal'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Team</label>
				<div class="col-sm-6">
					<?=$this->Form->input('team_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'empty' => true, 'id' => 'focusme', 'required' => true))?>
				</div>
			</div>

			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Datum (YYYY-MM-DD)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('start_date', array('label'=>false, 'div'=>false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Datum (YYYY-MM-DD)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Van (UU:MM)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('start_time', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text', 'title' => 'Uur van (UU:MM)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Tot (UU:MM)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('end_time', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text', 'title' => 'Uur tot (UU:MM)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Locatie</label>
				<div class="col-sm-6">
					<?=$this->Form->input('location', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Locatie', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Opmerking</label>
				<div class="col-sm-6">
					<?=$this->Form->input('remark', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?= $this->Form->button(__('Voeg training toe'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>

		</div>

	</div>
</div>

<hr/>
<?= $this->Html->link('Terug', array('controller' => 'efforts', 'action' => 'index'))."\n"; ?>

<?php
// pr($memberteams);
// pr($teams);
?>
