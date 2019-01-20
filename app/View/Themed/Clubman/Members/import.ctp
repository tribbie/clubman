<!-- File: /app/views/Members/import.ctp -->
<h1>Importeer nieuwe ledenlijst</h1>

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
					<strong>Procedure:</strong>
					<ul>
						<li>Kies de CSV van de nieuwe ledenlijst.</li>
						<li>Vernieuw de ledenlijst via de "Importeer" knop.</li>
					</ul>
				</p>
			</div>
			<div class="panel-body bg-warning">
				<p>
					<strong>Belangrijk:</strong><br/>
				</p>
				<p>
					Dit dient enkel om initeel een ledenlijst in Clubman te importeren.<br/>
					Als je deze import doet op een bestaand ledenbestand, worden er mogelijk leden overschreven!
				</p>
				<p>
					De velden in de CSV moeten gescheiden zijn door een puntkomma (en niet door een komma, zoals de bestandsextensie laat vermoeden).
				</p>
		  </div>
		</div>

		<div class="games form">
			<?=$this->Form->create('Member', array('class' => 'form-horizontal'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Kies de CSV</label>
				<div class="col-sm-6">
					<?=$this->Form->input('uploadid', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'options' => $uploadids, 'empty' => '(kies een csv bestand)', 'required' => true))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?=$this->Form->button(__('Importeer'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>


<hr/>
<?php
 	if (isset($thisimport)) pr($thisimport);
	//pr($currentUser);
	//pr($this->data);
?>
