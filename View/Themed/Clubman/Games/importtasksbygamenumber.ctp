<!-- app/View/Games/importtasks.ctp -->
<?php if (isset($feedback['import'])) : ?>
	<div class="panel panel-default">
		<!-- List group -->
		<ul class="list-group">
			<li class="list-group-item list-group-item-success">Valid for import</li>
			<?php foreach ($feedback['import'] as $importitem) : ?>
				<li class="list-group-item">
					<font size="-1">
						Game: <?=$importitem['game_number']?> (id: <?=$importitem['id']?>)<br/>
					</font>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
<?php if ((isset($feedback['noimport'])) and (count($feedback['noimport']) > 0)) : ?>
	<div class="panel panel-default">
		<!-- List group -->
		<ul class="list-group">
			<li class="list-group-item list-group-item-warning">Invalid for import</li>
			<?php foreach ($feedback['noimport'] as $noimportitem) : ?>
				<li class="list-group-item">
					<font size="-1">
						Game: <?=$noimportitem['game_number']?> (reason: <?=$noimportitem['reason']?>)<br/>
					</font>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<h2>Importeer taken voor wedstrijden via game_number</h2>
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
					<li>verplichte veld: game_number</li>
					<li>ook verplicht: een of meer van de volgende: game_referee, game_marker, game_scoreboard</li>
					<li>andere velden zijn niet toegestaan</li>
				</ul>
				<h4>Import voorbeeld:</h4>
				<pre><small>game_number;game_referee;game_marker;game_scoreboard
U11M2PE-0010;Jan Jansens;Peter Peters;Willem Willems</small></pre>
				<h4>Import voorbeeld:</h4>
				<pre><small>game_number;game_referee
1PM-0002;Jan Jansens
1PM-0099;Piet Pieters</small></pre>
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
					<?=$this->Form->submit(__('Simuleer'), array('name'=>'do_simulate', 'class' => 'btn btn-default'))?>
					<?=$this->Form->submit(__('Importeer de taken'), array('name'=>'do_import', 'class' => 'btn btn-default'))?>
				</div>
			</div>

			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>


<?php
	//pr($this->request->data);
	//if (isset($importinput)) pr($importinput);
	//if (isset($importcsv)) pr($importcsv);
	//if (isset($importtasks)) pr($importtasks);
	//if (isset($invalidforimport)) pr($invalidforimport);
	//if (isset($foundrecords)) pr($foundrecords);
	//echo '<hr/>';
?>
