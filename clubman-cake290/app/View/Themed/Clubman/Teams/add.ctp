<!-- app/View/Teams/add.ctp -->
<h2>Nieuw team</h2>

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

		<div class="teams form">
			<?=$this->Form->create('Team', array('class' => 'form-horizontal'))?>
			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>
			<?=$this->element('team-form-general')?>
			<!--<?=$this->element('team-form-other')?>-->
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
<?=$this->Html->link('Terug', array('controller' => 'teams', 'action' => 'index'))?>


<?php
// pr($team);
?>
