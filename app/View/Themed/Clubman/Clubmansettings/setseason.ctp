<!-- app/View/Users/setseason.ctp -->
<h2>Stel je seizoen in</h2>

<div class="row">
	<div class="col-md-12">

		<div class="panel panel-info">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<div class="alert alert-warning" role="alert">
					Je huidige seizoen is <strong><?=$currentSeason?></strong>.
				</div>
				<p>
					Hier stel je het (nieuwe) seizoen in voor Clubman.
				</p>
				<ul>
					<li>Je kan via dit formulier dus een nieuw seizoen beginnen.</li>
					<li>Je kan via dit formulier ook een oud seizoen reactiveren. <strong>Maar let op, het is dan voor iedereen weer actief.</strong></li>
				</ul>
				<?php if (count($seasons) > 0) : ?>
					Hier zijn de 'reeds gebruikte' seizoenen.
					<ul>
					<?php foreach($seasons as $oneseason) : ?>
						<li>
							<?=$oneseason['cm_teams']['season']?>
						</li>
					<?php endforeach; ?>
					</ul>
					<?php //pr($seasons); ?>
					<?php //pr($flatseasons); ?>
				<?php endif; ?>
				<p>
					Vergeet niet op "Bewaar" te klikken!
				</p>
		  </div>
		</div>

		<div class="settings form">

			<?=$this->Form->create('Clubmansettings', array('class' => 'form-horizontal'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Seizoen</label>
				<div class="col-sm-6">
					<?=$this->Form->input('newseason', array('label' => false, 'div' => false, 'class' => 'form-control', 'value' => $season, 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?= $this->Form->button(__('Bewaar'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>

			<?=$this->Form->end()?>

		</div>

		<hr/>

	</div>

</div>

<?php
	if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) {
		//	echo '<br/>';
		//	pr($user);
		//	echo '<hr/>currentUser';
		//	pr($currentUser);
		//	echo '<hr/>Clubman';
		//	pr($currentClubman);
		//	echo '<hr/>Club';
		//	pr($currentClub);
		//	echo '<hr/>cmCompleteConfig';
		//	pr($cmcompleteConfig);
		//	echo '<hr/>cmaclMerged';
		//	pr($cmaclMerged);
		//	echo '<hr/>cmmenuMerged';
		//	pr($cmmenuMerged);
		//	echo '<hr/>cmmenu';
		//	pr($cmmenu);
	}
?>
