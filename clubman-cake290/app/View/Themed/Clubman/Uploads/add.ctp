<!-- File: /app/View/Uploads/add.ctp -->
<h2>Opladen bestanden</h2>
<script>
$(document).ready(function() {
	$('.datepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1 } );
	$("#uploadbusy").hide();
	$("form#UploadAddForm").submit(function () {
		$("#uploadbusy").show();
	});
});
</script>
<div class='message' id='uploadbusy'>
Opladen is bezig ... even geduld.<br/>
</div>

<div class="row">
	<div class="col-xs-12">

		<div class="panel panel-info">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<p>
					Opgelet, hou rekening met volgende restricties!<br/>
					<br/>
					Je kan maximum 1 bestand per keer opladen.<br/>
					Bestanden groter dan <?= ini_get('upload_max_filesize') ?> worden niet opgeladen.<br/>
					<!--
					De totale grootte van de geselecteerde foto's mag niet groter zijn dan <?= ini_get('post_max_size') ?>.<br/>
					memory_limit = <?= ini_get('memory_limit') ?><br/>
					-->
				</p>
		  </div>
		</div>

		<div class="uploads form">
			<h4>Laad een bestand op</h4>
			<?=$this->Form->create('Upload', array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal'))?>

			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Titel</label>
				<div class="col-sm-6">
					<?=$this->Form->input('name', array('label' => false, 'div' => false, 'class' => 'form-control', 'required' => true, 'id' => 'focusme'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Categorie</label>
				<div class="col-sm-6">
					<?=$this->Form->input('category', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $categories, 'empty' => true, 'required' => true))?>
				</div>
			</div>

			<input type="hidden" name="MAX_FILE_SIZE" value="25000000" />

			<div class="form-group">
				<label class="col-sm-3 control-label">Kies je bestand</label>
				<div class="col-sm-6">
					<?=$this->Form->input('Files.', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'file', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Beschrijving</label>
				<div class="col-sm-6">
					<?=$this->Form->input('description', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'textarea'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Datum</label>
				<div class="col-sm-6">
					<?=$this->Form->input('stamp', array('label'=> false, 'div'=> false, 'class' => 'form-control datepicker', 'type' => 'text', 'required' => true, 'title' => 'Datum (YYYY-MM-DD)'))?>
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
					<?= $this->Form->button(__('Upload het bestand'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>

		</div>

		<hr/>

	</div>
</div>


<?php
// echo '<br/>this->request->data<br/>';
// pr($this->request->data);
?>

<!--
<pre>
// UPLOAD_ERR_OK         Value: 0; There is no error, the file uploaded with success.
// UPLOAD_ERR_INI_SIZE   Value: 1; The uploaded file exceeds the upload_max_filesize directive in php.ini.
// UPLOAD_ERR_FORM_SIZE  Value: 2; The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.
// UPLOAD_ERR_PARTIAL    Value: 3; The uploaded file was only partially uploaded.
// UPLOAD_ERR_NO_FILE    Value: 4; No file was uploaded.
// UPLOAD_ERR_NO_TMP_DIR Value: 6; Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.
// UPLOAD_ERR_CANT_WRITE Value: 7; Failed to write file to disk. Introduced in PHP 5.1.0.
// UPLOAD_ERR_EXTENSION  Value: 8; File upload stopped by extension. Introduced in PHP 5.2.0.
</pre>
-->
