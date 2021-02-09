<!-- app/View/Events/add.ctp -->
<h2>Wijzig evenement</h2>
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
					Vergeet onderaan niet op "Voeg evenement toe" te klikken!
				</p>
		  </div>
		</div>

		<div class="games form">
			<?=$this->Form->create('Event', array('class' => 'form-horizontal'))?>
			<?=$this->Form->input('name', array('type' => 'hidden', 'default' => 'nieuw-evenement'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Titel</label>
				<div class="col-sm-6">
					<?=$this->Form->input('title', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Titel evenement', 'id' => 'focusme', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Ondertitel</label>
				<div class="col-sm-6">
					<?=$this->Form->input('subtitle', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Ondertitel evenement', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Categorie</label>
				<div class="col-sm-6">
					<?=$this->Form->input('category', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $event_categories, 'empty' => '(kies een categorie)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Beschrijving</label>
				<div class="col-sm-6">
					<?=$this->Form->input('content', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'textarea', 'rows' => '10', 'required' => true))?>
				</div>
			</div>

			<?php
			 	// for future use
				// echo $this->Form->input('image_id', array('label' => 'Foto', 'class' => 'inputfield', 'type' => 'select', 'empty' => true));
			?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Doelpubliek</label>
				<div class="col-sm-6">
					<?=$this->Form->input('target_public', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $event_targets, 'empty' => '(voor wie?)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Datum</label>
				<div class="col-sm-6">
					<?=$this->Form->input('event_date_start', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Datum (YYYY-MM-DD)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Einddatum</label>
				<div class="col-sm-6">
					<?=$this->Form->input('event_date_end', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Datum (YYYY-MM-DD)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Om (UU:MM)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('event_time_start', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text', 'title' => 'Tijdstip (UU:MM)'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Tot (UU:MM)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('event_time_end', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text', 'title' => 'Tijdstip (UU:MM)'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Locatie</label>
				<div class="col-sm-6">
					<?=$this->Form->input('event_location', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Waar?', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Prijs</label>
				<div class="col-sm-6">
					<?=$this->Form->input('event_price', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Hoeveel kost het?'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Publiceer op</label>
				<div class="col-sm-6">
					<?=$this->Form->input('publish_date_start', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Publiceer op (YYYY-MM-DD)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Publiceer tot</label>
				<div class="col-sm-6">
					<?=$this->Form->input('publish_date_end', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Publiceer tot (YYYY-MM-DD)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Status</label>
				<div class="col-sm-6">
					<?=$this->Form->input('status', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $event_statuses, 'empty' => '(kies een status)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<div class="checkbox">
						<label title="Met inschrijvingen?">
							<?=$this->Form->input('subscribe_able', array('label' => false, 'hiddenField' => true, 'type' => 'checkbox', 'div'=>false))?>Inschrijvingen
						</label>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Inschrijven van</label>
				<div class="col-sm-6">
					<?=$this->Form->input('subscribe_date_start', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Inschrijvingen van (YYYY-MM-DD)'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Inschrijven tot</label>
				<div class="col-sm-6">
					<?=$this->Form->input('subscribe_date_end', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Inschrijvingen tot (YYYY-MM-DD)'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Maximum aantal</label>
				<div class="col-sm-6">
					<?=$this->Form->input('subscribe_max', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Maximum aantal inschrijvingen'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Inschrijvingen extra (json)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('subscribe_extra', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'textarea', 'rows' => '5'))?>
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
					<?=$this->Form->button(__('Pas evenement aan'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>

<?php
//	if (isset($event)) pr($event);
//	echo '<hr/>';
?>
