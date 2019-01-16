<!-- app/View/Uploads/edit.ctp -->
<h2>Wijzig upload "<?=$this->request['data']['Upload']['name']?>"</h2>
<script>
$(document).ready(function() {
	$('.datepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1 } );
});
</script>

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

		<div class="uploads form">
			<h4>Wijzig upload</h4>
			<?=$this->Form->create('Upload', array('class' => 'form-horizontal'))?>

			<?=$this->Form->input('id', array('type' => 'hidden'))?>
			<?=$this->Form->input('location', array('type' => 'hidden'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Titel</label>
				<div class="col-sm-6">
					<?=$this->Form->input('name', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'focusme', 'required' => true))?>
				</div>
			</div>

<!-- als de categorie wijzigt, moet het bestand gemoved worden !!!! -->
<!--
			<div class="form-group">
				<label class="col-sm-3 control-label">Categorie</label>
				<div class="col-sm-6">
					<?=$this->Form->input('category', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $categories, 'empty' => true, 'required' => true))?>
				</div>
			</div>
-->

			<div class="form-group">
				<label class="col-sm-3 control-label">Seizoen</label>
				<div class="col-sm-6">
					<?=$this->Form->input('season', array('label' => false, 'div' => false, 'class' => 'form-control', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Beschrijving</label>
				<div class="col-sm-6">
					<?=$this->Form->input('description', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'textarea'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Status</label>
				<div class="col-sm-6">
					<?=$this->Form->input('status', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $statuses, 'empty' => false, 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Datum</label>
				<div class="col-sm-6">
					<?=$this->Form->input('stamp', array('label'=> false, 'div'=> false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Datum (YYYY-MM-DD)'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Zoektermen</label>
				<div class="col-sm-6">
					<?=$this->Form->input('tags', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
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
					<?= $this->Form->button(__('Bewaar'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>

		</div>

		<hr/>
		<?= $this->Html->link('Terug', array('controller' => 'uploads', 'action' => 'index'))."\n"; ?>

	</div>
</div>

<?php
// pr($upload);
?>
