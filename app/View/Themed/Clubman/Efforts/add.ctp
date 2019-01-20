<!-- app/View/Efforts/add.ctp -->
<h2>Registreer nieuwe prestatie voor <?=$currentUser['Member']['name']?></h2>
<script>
$(document).ready(function(){
	$('.datepicker').datepicker( { maxDate: "+1D", dateFormat: "yy-mm-dd", firstDay: 1 } );
});
</script>

<div class="row">
	<div class="col-xs-12">

		<div class="panel panel-info">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<p>
					Vergeet onderaan niet op "Bewaar" te klikken!
				</p>
		  </div>
		</div>

		<div class="efforts form">
			<h4>Voeg een prestatie toe</h4>
			<?=$this->Form->create('Effort', array('class' => 'form-horizontal'))?>

			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Team</label>
				<div class="col-sm-6">
					<?=$this->Form->input('team_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'empty' => true, 'id' => 'focusme', 'required' => true))?>
				</div>
			</div>

			<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin']))) : ?>
				<div class="form-group">
					<label class="col-sm-3 control-label">Lid</label>
					<div class="col-sm-6">
						<?=$this->Form->input('member_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'empty' => true, 'required' => true))?>
					</div>
				</div>
			<?php else : ?>
				<?=$this->Form->input('member_id', array('type' => 'hidden'))?>
			<?php endif; ?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Taak</label>
				<div class="col-sm-6">
					<?=$this->Form->input('taskname', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Datum</label>
				<div class="col-sm-6">
					<?=$this->Form->input('taskdate', array('label'=>false, 'div'=>false, 'class' => 'form-control datepicker', 'type' => 'text', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Tijdstip (UU:MM)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('tasktime', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text', 'title' => 'Tijdstip (UU:MM)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Duur (minuten)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('taskduration', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select'))?>
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
					<?= $this->Form->button(__('Bewaar'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>

		</div>

	</div>
</div>

<hr/>
<?= $this->Html->link('Terug', array('controller' => 'efforts', 'action' => 'index'))."\n"; ?>


<?php
// pr($currentUser);
// pr($userlist);
// pr($effort);
// pr($members);
// pr($users);
?>
