<!-- app/View/Teammembers/add.ctp -->
<h2>Nieuw teamlid</h2>

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

		<div class="teammembers form">
			<?=$this->Form->create('Teammember', array('class' => 'form-horizontal'))?>
			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Team</label>
				<div class="col-sm-6">
					<?=$this->Form->input('team_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'required' => true, 'empty' => true, 'id' => 'focusme'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Lid</label>
				<div class="col-sm-6">
					<?=$this->Form->input('member_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'required' => true, 'empty' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Functie</label>
				<div class="col-sm-6">
					<?=$this->Form->input('teamfunction', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'required' => true, 'empty' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Prioriteit</label>
				<div class="col-sm-6">
					<?=$this->Form->input('teampriority', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'required' => true, 'empty' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Rugnummer</label>
				<div class="col-sm-6">
					<?=$this->Form->input('shirtnumber', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text'))?>
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
					<?=$this->Form->button(__('Bewaar'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>
<?=$this->Html->link('Terug', array('controller' => 'teammembers', 'action' => 'index'))?>


<?php
// pr($therequest);
// pr($teammember);
?>
