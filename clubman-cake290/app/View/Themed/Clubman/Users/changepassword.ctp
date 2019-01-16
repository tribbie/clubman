<!-- app/View/Users/changepassword.ctp -->
<h2>Wijzig wachtwoord voor gebruiker "<?=h($currentUser['username']);?>"</h2>

<div class="row">

	<div class="col-xs-12">
		<div class="panel panel-info">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<p>
					Stel je nieuwe wachtwoord in.
				</p>
		  </div>
		</div>

		<div class="users form">
			<?=$this->Form->create('User', array('class' => 'form-horizontal'))?>
			<?=$this->Form->input('id', array('type'  => 'hidden'))?>
			<?=$this->Form->input('username', array('type' => 'hidden'))?>
			<?=$this->Form->input('role', array('type' => 'hidden'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Nieuw wachtwoord</label>
				<div class="col-sm-6">
					<?=$this->Form->input('password', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'focusme'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Bevestig uw wachtwoord</label>
				<div class="col-sm-6">
					<?=$this->Form->input('password_confirmation', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'password'))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?= $this->Form->button(__('Wijzig wachtwoord'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?= $this->Form->end();?>

		</div>
	</div>

</div>




<hr/>
<?php
// pr($this->request->data);
?>
