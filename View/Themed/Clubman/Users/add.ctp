<!-- app/View/Users/add.ctp -->
<h2>Nieuwe <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> gebruiker</h2>
<script>
	$(document).ready(function(){
		//$('.datepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1 } );
		/// Limit selecting of 5 items in the list
		$("select#UserRoles").on('mouseup', 'option', function() {
			if ($("select#UserRoles option:selected").length > 5) {
				if ($("select#UserRoles option:selected").length == 6) {
					$(this).removeAttr("selected");
					alert('Selecteer maximum 5 rollen - de laatste is gedeselecteerd');
				} else {
					$("select#UserRoles option").removeAttr("selected");
					alert('Selecteer maximum 5 rollen - gelieve opnieuw te selecteren');
				}
			}
		});
	});
</script>

<div class="row">
	<div class="col-xs-12">

		<!--
		<div class="panel panel-primary">
		  <div class="panel-heading">UUID shizzle</div>
		  <div class="panel-body">
				<p>
					ALTER TABLE cm_users ADD uuid BINARY(36) after id;
				</p>
		  </div>
		</div>
		-->

		<div class="panel panel-info">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<p>
					Vergeet onderaan niet op "Voeg gebruiker toe" te klikken!
				</p>
		  </div>
		</div>

		<div class="users form">
			<h4>Voeg een gebruiker toe</h4>
			<?=$this->Form->create('User', array('class' => 'form-horizontal'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Gebruikersnaam</label>
				<div class="col-sm-6">
					<?=$this->Form->input('username', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'focusme', 'required' => true, 'placeholder' => "letters en cijfers - geen blanko's", 'pattern' => "[a-zA-Z0-9]*"))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Lid</label>
				<div class="col-sm-6">
					<?=$this->Form->input('member_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'empty' => 'kies een lid', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Wachtwoord</label>
				<div class="col-sm-6">
					<?=$this->Form->input('password', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'focusme'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Confirmeer wachtwoord</label>
				<div class="col-sm-6">
					<?=$this->Form->input('password_confirmation', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'password'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">(Multi-)Rol op de website</label>
				<div class="col-sm-6">
					<?=$this->Form->input('roles', array('label' => false, 'div' => false, 'class' => 'form-control', 'size' => 10, 'empty' => 'kies een of meerdere rollen', 'required' => true, 'multiple' => 'multiple', 'type' => 'select'));?>
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
					<?= $this->Form->button(__('Voeg gebruiker toe'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>

		</div>

	</div>
</div>

<hr/>
<?=$this->Html->link('Terug', array('controller' => 'users', 'action' => 'index'))?>

<?php
 //echo '<hr/>';
 //pr($this->request->data);
?>
