<!-- app/View/Teammembers/edit.ctp -->
<h2>Wijzig teamlid <?=$teammember['Member']['name']?> bij team <?=$teammember['Team']['name']?></h2>

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
			<?=$this->Form->input('id', array('type' => 'hidden'))?>
			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>
			<!-- we do not want to 'move' teammembers from one team to another, this renders presence data unusable, so team_id is set hidden -->
			<?=$this->Form->input('team_id', array('type' => 'hidden'))?>
			<!-- we do not want to 'change' teammembers from one member to another, this renders presence data unusable, so member_id is set hidden -->
			<?=$this->Form->input('member_id', array('type' => 'hidden'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Functie</label>
				<div class="col-sm-6">
					<?=$this->Form->input('teamfunction', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'empty' => true, 'id' => 'focusme', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Prioriteit</label>
				<div class="col-sm-6">
					<?=$this->Form->input('teampriority', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'empty' => true, 'required' => true))?>
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
<?=$this->Html->link('Terug', array('controller' => 'teammembers', 'action' => 'view', $teammember['Teammember']['id']))?>


<?php
// pr($teammember);
?>
