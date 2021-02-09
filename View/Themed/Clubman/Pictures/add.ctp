<!-- File: /app/View/Pictures/add.ctp -->
<h2>
	Foto's
	<?=((isset($this->request->data['Picture']['category'])) ? "voor categorie '" . $categories[$this->request->data['Picture']['category']] . "'" : '')?>
</h2>

<script>
$(document).ready(function() {
	$("#uploadbusy").hide();
	$("form#PictureAddForm").submit(function () {
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
					Je kan maximum <?=ini_get('max_file_uploads')?> foto's per keer opladen.<br/>
					Foto's groter dan <?=ini_get('upload_max_filesize')?> worden niet opgeladen.<br/>
					De totale grootte van de geselecteerde foto's mag niet groter zijn dan <?=ini_get('post_max_size')?>.<br/>
					<!--
					memory_limit = <?= ini_get('memory_limit') ?><br/>
					-->
				</p>
		  </div>
		</div>

		<div class="pictures form">
			<h4>Voeg een of meer foto's toe</h4>
			<?=$this->Form->create('Picture', array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal'))?>

			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Titel</label>
				<div class="col-sm-6">
					<?=$this->Form->input('name', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'focusme', 'required' => true))?>
				</div>
			</div>


			<?php if (isset($this->request->data['Picture']['category'])) : ?>
				<?=$this->Form->input('category', array('type' => 'hidden'))?>
			<?php else : ?>
				<div class="form-group">
					<label class="col-sm-3 control-label">Categorie</label>
					<div class="col-sm-6">
						<?=$this->Form->input('category', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $categories, 'empty' => true, 'required' => true))?>
					</div>
				</div>
			<?php endif ; ?>

			<input type="hidden" name="MAX_FILE_SIZE" value="25000000" />

			<div class="form-group">
				<label class="col-sm-3 control-label">Kies je foto's</label>
				<div class="col-sm-6">
					<?=$this->Form->input('Files.', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'file', 'multiple' => true))?>
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
					<?= $this->Form->button(__('Upload het foto'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>

		</div>

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
