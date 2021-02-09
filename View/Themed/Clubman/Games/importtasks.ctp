<!-- app/View/Games/importtasks.ctp -->
<h2>Importeer taken voor wedstrijden</h2>
<script>
	function csvhelp() {
			$("#csvhelpwindow").modal('show');
	}
</script>

<div id="csvhelpwindow" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Hulp bij CSV import</h4>
      </div>
      <div class="modal-body">
				<h4>Formaat van de csv-lijnen</h4>
				<ul>
					<li>scheidingsteken: komma of puntkomma of tab</li>
					<li>hoofding lijn: verplicht</li>
					<li>verplichte veld: id</li>
					<li>ook verplicht: een of meer van de volgende: game_referee, game_marker, game_scoreboard</li>
				</ul>
				<h4>Import voorbeeld:</h4>
				<pre><small>id;game_referee;game_marker;game_scoreboard
16000001;Jan Jansens;Peter Peters;Willem Willems</small></pre>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
	<div class="col-xs-12">

		<div class="panel panel-info">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<p>
					Dit formulier dient om <strong>taken</strong> te importeren.<br/>
					Opgelet: dit is nog <strong>experimenteel</strong>!
				</p>
				<p>
					Dit gebeurt in volgende stappen:<br/>
					<ol>
						<li>Kopieer eerst de gegevens van de wedstrijden (uit de csv of uit de spreadsheet).</li>
						<li>Vergeet de hoofdingslijn niet.</li>
						<li>Kies het scheidingsteken dat overeenkomt met dat van je lijst.</li>
						<li>Pas dan kan je importeren door op "Importeer de taken" te klikken.</li>
					</ol>
				</p>
		  </div>
		</div>

		<div class="games form">
			<?=$this->Form->create('GameTask', array('class' => 'form-horizontal'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Lijst van de wedstrijden en namen</label>
				<div class="col-sm-6">
					<?=$this->Form->input('csv', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'textarea', 'required' => true))?>
				</div>
			</div>
			<?=$this->Form->input('json', array('type' => 'hidden'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Scheidingsteken</label>
				<div class="col-sm-6">
					<?=$this->Form->input('separator', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'title' => 'Scheidingsteken', 'options' => $source_separators, 'required' => true, 'empty' => true))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?=$this->Form->button(__('Help'), array('class' => 'btn btn-info', 'type' => 'button', 'name' => 'csvhelpbutton', 'onclick' => 'csvhelp();'))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?=$this->Form->button(__('Importeer de taken'), array('class' => 'btn btn-default', 'type' => 'submit', 'id' => 'importsubmitbutton'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>


<?php
//	pr($this->request->data);
	if (isset($importinput)) pr($importinput);
	if (isset($importtasks)) pr($importtasks);
//	echo '<hr/>';
?>
