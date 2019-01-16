<!-- app/View/Teams/edit.ctp -->
<h2>Wijzig <?=$part['label'];?> informatie van <?=$team['Team']['name'];?> (<?=$team['Team']['shortname'];?>)</h2>

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

			<?=$this->Form->input('id', array('type' => 'hidden'))?>
			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>


			<?php if (($part['value'] == 'all') or ($part['value'] == 'general')) : ?>
				<?=$this->element('team-form-general')?>
			<?php endif; ?>

			<?php if (($part['value'] == 'all') or ($part['value'] == 'other')) : ?>
				<?=$this->element('team-form-other')?>
			<?php endif ;	?>

			<?php if ($part['value'] == 'picture') : ?>
				<?=$this->element('team-form-picture')?>
			<?php endif ; ?>

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
<?=$this->Html->link('Terug', array('controller' => 'teams', 'action' => 'view', $team['Team']['id']))?>

<?php
// pr($team);
?>
