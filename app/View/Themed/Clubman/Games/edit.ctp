<!-- app/View/Games/edit.ctp -->
<h2>Wijzig wedstrijd van de <?=$this->request->data['Team']['name'];?></h2>
<h3><?=$this->request->data['Game']['game_home'];?> - <?=$this->request->data['Game']['game_away'];?></h3>
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
					Vergeet onderaan niet op "Bewaar de wedstrijd" te klikken!
				</p>
		  </div>
		</div>

		<div class="games form">
			<?=$this->Form->create('Game', array('class' => 'form-horizontal'))?>
			<?=$this->Form->input('id', array('type' => 'hidden'))?>
			<?=$this->Form->input('team_id', array('type' => 'hidden'))?>
			<?=$this->Form->input('season', array('type' => 'hidden'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Datum</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_date', array('label'=>false, 'div'=>false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Datum (YYYY-MM-DD)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Om (UU:MM)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_time', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text', 'title' => 'Tijdstip (UU:MM)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Type wedstrijd</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_code', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $game_codes, 'empty' => '(kies een type)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Teamcode (bond)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('team_code', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Teamcode'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Wedstrijdnr (bond)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_number', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Wedstrijdnummer'))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<div class="checkbox">
						<label>
							<?=$this->Form->input('home_game', array('label' => false, 'hiddenField' => true, 'type' => 'checkbox', 'div'=>false, 'title' => 'Is dit een thuiswedstrijd'))?>Thuiswedstrijd</label>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Coach</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_coach_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'title' => 'Wie coacht', 'options' => $game_coaches, 'empty' => '(kies een coach)'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Locatie</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_hall', array('label' => false, 'div' => false, 'class' => 'form-control', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Scheidsrechter</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_referee', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Enkel voor thuiswedstrijden'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Markeerder</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_marker', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Enkel voor thuiswedstrijden'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Scorebord</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_scoreboard', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Enkel voor thuiswedstrijden'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Wijziging</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_change', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Wat is de wijziging', 'type' => 'select', 'options' => $game_changes, 'empty' => true, 'required' => true))?>
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
					<?=$this->Form->button(__('Bewaar de wedstrijd'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>


<?php
// pr($this->request->data);
//	pr($game_coaches);
//	pr($teammembers);
//	echo '<hr/>';
?>
