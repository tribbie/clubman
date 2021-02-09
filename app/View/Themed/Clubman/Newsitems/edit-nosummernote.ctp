<!-- app/View/Newsitems/add.ctp -->
<h2>Wijzig nieuwsbericht</h2>
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
					Vergeet onderaan niet op "Pas nieuwsbericht aan" te klikken!
				</p>
		  </div>
		</div>

		<div class="games form">
			<?=$this->Form->create('Newsitem', array('class' => 'form-horizontal'))?>

			<?=$this->Form->input('name', array('type' => 'hidden', 'default' => 'gewijzigd-nieuwsbericht'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Titel</label>
				<div class="col-sm-6">
					<?=$this->Form->input('title', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Titel', 'id' => 'focusme', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Ondertitel</label>
				<div class="col-sm-6">
					<?=$this->Form->input('subtitle', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Ondertitel', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Categorie</label>
				<div class="col-sm-6">
					<?=$this->Form->input('category', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $newsitem_categories, 'empty' => '(kies een categorie)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Bericht</label>
				<div class="col-sm-6">
					<?=$this->Form->input('content', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'textarea', 'rows' => '10', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Datum bericht</label>
				<div class="col-sm-6">
					<?=$this->Form->input('itemdate', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Datum bericht (YYYY-MM-DD)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Auteur</label>
				<div class="col-sm-6">
					<?=$this->Form->input('author', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Auteur'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Publiceer op</label>
				<div class="col-sm-6">
					<?=$this->Form->input('activate', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Publiceer op (YYYY-MM-DD)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Publiceer tot</label>
				<div class="col-sm-6">
					<?=$this->Form->input('expire', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Publiceer tot (YYYY-MM-DD)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Status</label>
				<div class="col-sm-6">
					<?=$this->Form->input('status', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $newsitem_statuses, 'empty' => '(kies een status)', 'required' => true))?>
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
					<?=$this->Form->button(__('Pas nieuwsbericht aan'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>

<?php
	//if (isset($newsitem)) pr($newsitem);
	//pr($currentUser);
?>
