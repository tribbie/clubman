<!-- app/View/Trainingmoments/edit.ctp -->
<h2>Wijzig trainingmoment</h2>
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
					Vergeet onderaan niet op "Bewaar het trainingsmoment" te klikken!
				</p>
		  </div>
		</div>

		<div class="trainingmoments form">
			<h4>Wijzig een trainingsmoment</h4>
			<?=$this->Form->create('Trainingmoment', array('class' => 'form-horizontal'))?>

			<?= $this->Form->input('id', array('type' => 'hidden')); ?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Naam</label>
				<div class="col-sm-6">
					<?=$this->Form->input('name', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Naam', 'id' => 'focusme', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Weekdag</label>
				<div class="col-sm-6">
					<?=$this->Form->input('weekday', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Weekdag', 'empty' => true, 'type' => 'select', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Van (UU:MM)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('start_time', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text', 'title' => 'Uur van (UU:MM)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Tot (UU:MM)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('end_time', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text', 'title' => 'Uur tot (UU:MM)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Locatie</label>
				<div class="col-sm-6">
					<?=$this->Form->input('location', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Locatie', 'required' => true))?>
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
					<?= $this->Form->button(__('Bewaar het trainingsmoment'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>

		</div>

	</div>
</div>

<hr/>
