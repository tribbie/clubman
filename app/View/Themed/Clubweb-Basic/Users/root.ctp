<!-- app/View/Users/add.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> "root" gebruiker</h2>

<div class="row">
	<div class="col-xs-12">

		<div class="panel panel-danger">
		  <div class="panel-heading">
				<p>
					Belangrijke informatie
				</p>
				<p>
					Door dit formulier in te vullen stel je het wachtwoord in voor de superuser (root) van Clubman!<br/>
					Maak dit wachtwoord lang genoeg, en onthoud het goed!
				</p>
			</div>
		  <div class="panel-body">
				<p>
					Vergeet onderaan niet op "Initializeer root gebruiker" te klikken!
				</p>
		  </div>
		</div>

		<div class="users form">
			<h4>Initializeer "root" gebruiker</h4>
			<?=$this->Form->create('User', array('class' => 'form-horizontal'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Wachtwoord</label>
				<div class="col-sm-6">
					<?=$this->Form->input('password', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'password', 'required' => true, 'id' => 'focusme'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Confirmeer wachtwoord</label>
				<div class="col-sm-6">
					<?=$this->Form->input('password_confirmation', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'password', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?= $this->Form->button(__('Initializeer root gebruiker'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>

		</div>

	</div>
</div>

<hr/>
