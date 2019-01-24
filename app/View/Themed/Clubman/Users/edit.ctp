<!-- app/View/Users/edit.ctp -->
<h2>Pas <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> gebruiker <?=$user['User']['username'];?> aan</h2>
<script>
	$(document).ready(function() {
		// $('.datepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1 } );
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
					ALTER TABLE cm_users ADD uuid CHAR(36) after id;
				</p>
		  </div>
		</div>
		-->

		<?php if ($user['User']['role'] == 'root') : ?>

			<div class="panel panel-info">
			  <div class="panel-heading">Belangrijke informatie</div>
			  <div class="panel-body">
					<p>
						De gebruiker "<?=$user['User']['username']?>" is een speciale gebruiker, die niet aangepast kan worden.
					</p>
					<p>
						Indien er toch iets mis mee zou zijn, gelieve dan de <a href="mailto:webmaster@<?=(isset($cmclub['domain']) ? $cmclub['domain'] : 'oblivio.be')?>">webmaster van deze website</a> te verwittigen.
					</p>
			  </div>
			</div>

		<?php else : ?>

			<div class="panel panel-info">
			  <div class="panel-heading">Belangrijke informatie</div>
			  <div class="panel-body">
					<p>
						Vergeet onderaan niet op "Bewaar" te klikken!
					</p>
			  </div>
			</div>

			<div class="users form">
				<h4>Pas een gebruiker aan</h4>
				<?=$this->Form->create('User', array('class' => 'form-horizontal'))?>

				<?=$this->Form->input('id', array('type' => 'hidden'))?>

				<div class="form-group">
					<label class="col-sm-3 control-label">Gebruikersnaam</label>
					<div class="col-sm-6">
						<?=$this->Form->input('username', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'focusme', 'required' => true, 'placeholder' => "letters en cijfers - geen blanko's", 'pattern' => "[a-zA-Z0-9]*"))?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">(Multi-)Rol op de website</label>
					<div class="col-sm-6">
						<?=$this->Form->input('roles', array('label' => false, 'div' => false, 'class' => 'form-control', 'size' => 10, 'empty' => 'kies hieronder een of meerdere rollen (max 5)', 'required' => true, 'multiple' => 'multiple', 'type' => 'select'));?>
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
						<div class="checkbox">
							<label>
								<?=$this->Form->input('active', array('label' => false, 'hiddenField' => true, 'type' => 'checkbox', 'div' => false))?>
								Gebruiker actief
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<?= $this->Form->button(__('Bewaar'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
					</div>
				</div>
				<?=$this->Form->end()?>

			</div>

		<?php endif ; ?>

	</div>
</div>

<hr/>
<?=$this->Html->link('Terug', array('controller' => 'users', 'action' => 'index'))?>

<?php
	//echo '<hr/>';
	//pr($shizzle);
	//echo '<hr/>';
	//pr($this->request->data);
	//echo '<hr/>';
?>
