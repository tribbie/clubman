<!-- app/View/Games/add.ctp -->
<h2>Nieuwe wedstrijd voor <?=$team['Team']['name']?></h2>
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
					Beste Trainer. Gelieve dit formulier enkel te gebruiken om <strong>extra wedstrijden</strong> (oefenwedstrijden en tornooien) mee aan te maken.<br/>
					De officiële wedstrijden (competitie en beker) worden door de Cel Jeugd of de kalenderverantwoordelijke toegevoegd.
				</p>
				<p>
					Vergeet onderaan niet op "Voeg wedstrijd toe" te klikken!
				</p>
		  </div>
		</div>

		<div class="games form">
			<?=$this->Form->create('Game', array('class' => 'form-horizontal'))?>
			<?=$this->Form->input('team_id', array('type' => 'hidden', 'default' => $team['Team']['id']))?>
			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>

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
				<label class="col-sm-3 control-label">Thuisploeg</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_home', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Wie speelt thuis', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Bezoekers</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_away', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Wie komt op bezoek', 'required' => true))?>
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
				<label class="col-sm-3 control-label">Opmerking</label>
				<div class="col-sm-6">
					<?=$this->Form->input('remark', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?=$this->Form->button(__('Voeg wedstrijd toe'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>

<?php
//	pr($game_data);
//	pr($game_coaches);
//	pr($teammembers);
// pr($team);
//	echo '<hr/>';
?>
