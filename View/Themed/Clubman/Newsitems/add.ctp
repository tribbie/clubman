<!-- app/View/Newsitems/add.ctp -->
<h2>Nieuw nieuwsbericht</h2>
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
					Vergeet onderaan niet op "Voeg nieuwsbericht toe" te klikken!
				</p>
		  </div>
		</div>

		<div class="games form">
			<?=$this->Form->create('Newsitem', array('class' => 'form-horizontal'))?>
			<?=$this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason))?>
			<?=$this->Form->input('name', array('type' => 'hidden', 'default' => 'nieuw-nieuwsbericht'))?>

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
					<?=$this->Form->button(__('Voeg nieuwsbericht toe'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>

<script>
	$(document).ready(function() {
			$('#NewsitemContent').summernote({
				placeholder: 'Je artikel hier...',
				spellCheck: false,
				toolbar: [
					['style', ['style']],
					['font', ['bold', 'italic', 'underline', 'clear']],
					['para', ['ul', 'ol', 'paragraph']],
					['insert', ['link', 'picture']],
					['view', ['fullscreen', 'codeview', 'help']],
				],
				popover: {
					image: [
						['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
						['float', ['floatLeft', 'floatRight', 'floatNone']],
						['remove', ['removeMedia']]
					],
					link: [
						['link', ['linkDialogShow', 'unlink']]
					],
					table: [
						['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
						['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
					],
					air: [
						['color', ['color']],
						['font', ['bold', 'underline', 'clear']],
						['para', ['ul', 'paragraph']],
						['table', ['table']],
						['insert', ['link', 'picture']]
					]
				},
				callbacks: {
						onImageUpload: function(files) {
								for(let i=0; i < files.length; i++) {
										$.uploadImage(files[i]);
								}
						}
				},
				height: 500,
			});
	});

	$.uploadImage = function (file) {
			let thisImageData = new FormData();
			thisImageData.append('imagedata', file, file.name);
			$.ajax({
					method: 'POST',
					url: "<?=$this->Html->url(array('action' => 'ajuploadimage', 'ext' => 'json'))?>",
					contentType: false,
					cache: false,
					processData: false,
					data: thisImageData,
					dataType: 'json',
					success: function (img) {
							console.log(img);
							console.log(img.data.resultdata.rc.uploadimage);
							console.log(img.data.resultdata.url);
							if (img.data.resultdata.rc.uploadimage == 0) {
								var imageUrl = img.data.resultdata.url;
								console.log("Inserting " + imageUrl);
								$('#NewsitemContent').summernote('insertImage', imageUrl);
							} else {
								console.log(img.data.resultdata);
								$('#NewsitemContent').summernote('insertText', img.data.resultdata.error);
							}
							//$('#NewsitemContent').summernote('insertImage', img);
					},
					error: function (jqXHR, textStatus, errorThrown) {
							console.error(textStatus + " " + errorThrown);
					}
			});
	};
</script>

<?php
	//if (isset($newsitem)) pr($newsitem);
	//pr($currentUser);
?>
