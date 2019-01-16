<!-- app/View/Users/setlogin.ctp -->
<h2>Wijzig login mogelijkheden</h2>

<div class="row">
	<div class="col-md-12">

		<div class="panel panel-info">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<div class="alert alert-warning" role="alert">
					Je huidige waarde is "<strong><?=$currentallowlogin?></strong>".
				</div>
				<p>
					Hier stel je in wie er kan inloggen in Clubman.
				</p>
				<p>
					Vergeet niet op "Bewaar" te klikken!
				</p>
		  </div>
		</div>

		<div class="settings form">

			<?=$this->Form->create('Clubmansettings', array('class' => 'form-horizontal'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Laat login toe</label>
				<div class="col-sm-6">
					<?=$this->Form->input('allowlogin', array('label' => false, 'div' => false, 'class' => 'form-control', 'value' => $currentallowlogin, 'options' => $allowloginoptions,'required' => true))?>
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
