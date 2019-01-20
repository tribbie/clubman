<!-- app/View/Teammembers/addbulk.ctp -->
<h2>Nieuwe teamleden voor <?=$team['Team']['name']?></h2>

<?php if (!isset($savedata)) : ?>

	<div class="row">
		<div class="col-xs-12">

			<div class="panel panel-info">
			  <div class="panel-heading">Belangrijke informatie</div>
			  <div class="panel-body">
					<p>
						<strong>Pas op!</strong> Dit formulier dient enkel om leden <strong>toe te voegen</strong> aan een team.<br/>
						Je kan hier geen teamleden mee weghalen!
					</p>
					<p>
						Selecteer eerst de juiste prioriteit en functie.<br/>
						Let wel, dit is voor iedereen die je hier aanduidt.<br/>
						Kies de meest voorkomende, en pas de individuele achteraf aan...<br/>
						Vink vervolgens al de leden aan die je bij het bovenvermelde team wil toevoegen.
					</p>
					<p>
						Vergeet niet te bewaren.
					</p>
			  </div>
			</div>

			<div class="teammembers form">
				<?=$this->Form->create('Team', array('class' => 'form-horizontal'))?>

				<div class="form-group">
					<label class="col-sm-3 control-label">Prioriteit</label>
					<div class="col-sm-6">
						<?=$this->Form->input('Team.All.teampriority', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'selected' => 1))?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Functie</label>
					<div class="col-sm-6">
						<?=$this->Form->input('Team.All.teamfunction', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'empty' => true))?>
					</div>
				</div>

				<?php $mcount = 0; ?>
				<?php foreach ($memberlist as $member) : ?>
					<?=$this->Form->hidden('Team.Teammember.'.$mcount.'.season', array('type' => 'hidden', 'default' => $currentSeason))?>
					<?=$this->Form->hidden('Team.Teammember.'.$mcount.'.team_id', array('type' => 'hidden', 'value' => $team['Team']['id']))?>
					<?=$this->Form->hidden('Team.Teammember.'.$mcount.'.member_id', array('type' => 'hidden', 'value' => $member['id']))?>
					<?=$this->Form->hidden('Team.Teammember.'.$mcount.'.tempname', array('type' => 'hidden', 'value' => $member['uname']))?>
					<?php $checkoptions = array('label' => $member['uname'], 'hiddenField' => false, 'type' => 'checkbox', 'div'=>false, 'checked' => $member['ismember'], 'disabled' => $member['ismember']); ?>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
							<div class="checkbox">
								<label>
									<?=$this->Form->input('Team.Teammember.'.$mcount.'.ismember', $checkoptions)?>
								</label>
							</div>
						</div>
					</div>
					<?php $mcount += 1; ?>
				<?php endforeach; ?>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<?=$this->Form->button(__('Bewaar'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
					</div>
				</div>
				<?=$this->Form->end()?>
			</div>

		</div>
	</div>

<?php else : ?>

	<!--
	<div class="box">
		Volgende teammembers werden toegevoegd bij het team <strong>"<?=$team['Team']['name']?>"</strong><br/>
		<br/>
		<ul>
		<?php foreach ($savedata['Teammember'] as $addedmember) : ?>
			<li><?= $addedmember['tempname'] ?></li>
		<?php endforeach; ?>
		</ul>
		<br/>
	</div>
	-->

<?php endif; ?>

<hr/>
<?=$this->Html->link('Terug', array('controller' => 'teammembers', 'action' => 'index'))?>

<?php
// if (isset($team)) pr($team);
// if (isset($memberlist)) pr($memberlist);
// if (isset($allmembers)) pr($allmembers);
// if (isset($memberdata)) pr($memberdata);
// if (isset($savedata)) pr($savedata);
?>
