<!-- app/View/Pictures/edit.ctp -->
<h2>Wijzig foto "<?=$this->request['data']['Picture']['name']?>"</h2>

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

		<div class="pictures form">
			<h4>Wijzig foto</h4>
			<?=$this->Form->create('Picture', array('class' => 'form-horizontal'))?>

			<?= $this->Form->input('id', array('type' => 'hidden')); ?>
			<?= $this->Form->input('location', array('type' => 'hidden')); ?>

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
					<?=$this->Form->input('category', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $categories, 'empty' => true))?>
				</div>
			</div>
-->

			<div class="form-group">
				<label class="col-sm-3 control-label">Seizoen</label>
				<div class="col-sm-6">
					<?=$this->Form->input('season', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Beschrijving</label>
				<div class="col-sm-6">
					<?=$this->Form->input('description', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'textarea'))?>
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

	</div>
</div>

<hr/>
<?= $this->Html->link('Terug', array('controller' => 'pictures', 'action' => 'index'))."\n"; ?>


<?php
// pr($picture);
?>
