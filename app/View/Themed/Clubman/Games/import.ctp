<!-- app/View/Games/import.ctp -->
<h2>Importeer wedstrijden voor <?=$teaminfo['Team']['name'];?> (<?=$teaminfo['Team']['shortname'];?>) -- <?=$teaminfo['Team']['competition'];?></h2>
<script>

	$(document).ready(function(){
		$('.datepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1 } );
	});

	function csvhelp() {
			$("#csvhelpwindow").modal('show');
	}

	function preimportcheck() {
		$("#preimportcheckresultbody").html('');
		checkcoach();
		checkdateformat()
		checkcsvlines();
		// show the result in a modal dialog
		$("#preimportcheckresult").modal('show');
	}

	function checkcoach() {
		var selectedcoachid = $('#GameImportGameCoachId').val();
		$("#preimportcheckresultbody").append('<h4>Coach:</h4>');
		$("#preimportcheckresultbody").append("<p>");
		if (selectedcoachid == "") {
			$("#preimportcheckresultbody").append("<span style='color: #f00;'>Opgelet: Geen coach geselecteerd!</span><br/>");
			$("#preimportcheckresultbody").append("Dat is toegelaten, maar dan moet deze achteraf wel wedstrijd per wedstrijd ingegeven worden.");
		} else {
			var selectedcoach = $("#GameImportGameCoachId option:selected").text();
			$("#preimportcheckresultbody").append("<span style='color: #090;'>Coach <strong>" + selectedcoach + "</strong> geselecteerd!</span>");
		}
		$("#preimportcheckresultbody").append("</p>");
	}

	function checkdateformat() {
		var selecteddateformatindex = $('#GameImportGameDateFormat').val();
		$("#preimportcheckresultbody").append('<h4>Datum formaat:</h4>');
		$("#preimportcheckresultbody").append("<p>");
		// if (selecteddateformat == "") {
		if (selecteddateformatindex == "") {
			$("#preimportcheckresultbody").append("<span style='color: #f00;'>Opgelet: Geen datum formaat geselecteerd!</span><br/>");
		} else {
			var selecteddateformat = $("#GameImportGameDateFormat option:selected").text();
			$("#preimportcheckresultbody").append("<span style='color: #090;'>Datum formaat <strong>" + selecteddateformat + "</strong> geselecteerd!</span><br/>");
		}
		$("#preimportcheckresultbody").append("</p>");
	}

	function checkcsvlines() {
		var selectedseparator = $('#GameImportGameSeparator').val();
		var jsonstringfromcsv = csvJSON($('#GameImportGamescsv').val(), selectedseparator);
		var jsonfromcsv = jQuery.parseJSON(jsonstringfromcsv);
		var bg = ["#f6f6f6", "#eee"];
		var thisbg, thisfg;
		var errorcount = 0;
		var gamecount = 0;
		console.log("json=[" + jsonstringfromcsv + "]");
		$("#preimportcheckresultbody").append("<h4>Wedstrijden:</h4>");
		if (jsonfromcsv.length > 30) {
			$("#preimportcheckresultbody").append('Te veel wedstrijden (' + jsonfromcsv.length + ')! Gelieve minder wedstrijden te importeren (max 30 per keer).<br/>');
		} else {
			if (jsonfromcsv.length > 0) {
				$("#preimportcheckresultbody").append("<table class='table table-condensed'>");
				for (var i = 0; i < jsonfromcsv.length; i++) {
					var line = jsonfromcsv[i];
					if (line.Wedstrijdnr != "") {
						gamecount += 1;
						$("#preimportcheckresultbody").append("<tr>");
						console.log("checking item #" + i + ".");
						if (validgame(line)) {
							thisfg = "#090";
						} else {
							thisfg = "#f00";
							errorcount += 1;
						}
						var j = 0;
						for (var field in line) {
							j += 1;
							thisbg = j % 2;
							thisstyle = "background-color: "+bg[thisbg]+"; color: "+thisfg;
							$("#preimportcheckresultbody").append("<td style='"+thisstyle+"'>" + line[field] + "</td>");
						}
						$("#preimportcheckresultbody").append("</tr>");
					}
				}
				$("#preimportcheckresultbody").append("</table>");
			}
			$("#preimportcheckresultbody").append("<p>");
			if ((gamecount > 0) && (errorcount == 0)) {
				$('#GameImportGamesinjson').val(jsonstringfromcsv);
				$("#preimportcheckresultbody").append(gamecount + " wedstrijd(en) klaar om te importeren.");
			} else {
				$('#GameImportGamesinjson').val("");
				if (gamecount == 0) {
					$("#preimportcheckresultbody").append("<span style='color: #f00;'>Geen geldige wedstrijden!</span>");
				} else {
					$("#preimportcheckresultbody").append("<span style='color: #f00;'>" + errorcount + " wedstrijd(en) nog niet goed!</span>");
				}
			}
			$("#preimportcheckresultbody").append("</p>");
			$("#preimportcheckresultbody").append("<p>");
			$("#preimportcheckresultbody").append("Als alle wedstrijden groen zijn, kan je ze importeren.<br/>");
			$("#preimportcheckresultbody").append("Zolang 1 wedstrijd rood is, kan je niets importeren!<br/>");
			$("#preimportcheckresultbody").append("</p>");
		}
	}

	// csv contains CSV info with mandatory header line
	function csvJSON(csv, separator) {
		var lines = csv.split("\n");
		var result = [];
		var headers = lines[0].split(separator);
		for (var i=1; i < lines.length; i++) {
			var currentlinecsv = lines[i].trim();
			if (currentlinecsv.length == 0) {
				console.log("Skipping line #" + i + " - empty line.");
			} else {
				console.log("Processing line #" + i + " - [" + currentlinecsv + "]");
				//var currentline=lines[i].split(",");
				var currentlinearray = CSVtoArray(currentlinecsv, separator);
				var obj = {};
		 		for (var j=0; j < headers.length; j++){
					obj[headers[j]] = currentlinearray[j];
				}
				result.push(obj);
			}
		}
		// return result - JavaScript object
		return JSON.stringify(result);
	}

	// Return array of string values, or NULL if CSV string not well formed.
	function original_CSVtoArray(text) {
    var re_valid = /^\s*(?:'[^'\\]*(?:\\[\S\s][^'\\]*)*'|"[^"\\]*(?:\\[\S\s][^"\\]*)*"|[^,'"\s\\]*(?:\s+[^,'"\s\\]+)*)\s*(?:,\s*(?:'[^'\\]*(?:\\[\S\s][^'\\]*)*'|"[^"\\]*(?:\\[\S\s][^"\\]*)*"|[^,'"\s\\]*(?:\s+[^,'"\s\\]+)*)\s*)*$/;
    var re_value = /(?!\s*$)\s*(?:'([^'\\]*(?:\\[\S\s][^'\\]*)*)'|"([^"\\]*(?:\\[\S\s][^"\\]*)*)"|([^,'"\s\\]*(?:\s+[^,'"\s\\]+)*))\s*(?:,|$)/g;
    // Return NULL if input string is not well formed CSV string.
    if (!re_valid.test(text)) return null;
    var a = []; // Initialize array to receive values.
    text.replace(re_value, // "Walk" the string using replace with callback.
      function(m0, m1, m2, m3) {
        // Remove backslash from \' in single quoted values.
        if      (m1 !== undefined) a.push(m1.replace(/\\'/g, "'"));
        // Remove backslash from \" in double quoted values.
        else if (m2 !== undefined) a.push(m2.replace(/\\"/g, '"'));
        else if (m3 !== undefined) a.push(m3);
        return ''; // Return empty string.
      });
    // Handle special case of empty last value.
    if (/,\s*$/.test(text)) a.push('');
    return a;
	};

	// Return array of string values, or NULL if CSV string not well formed.
	function CSVtoArray(text, separator) {
		var re_valid_comma = /^\s*(?:'[^'\\]*(?:\\[\S\s][^'\\]*)*'|"[^"\\]*(?:\\[\S\s][^"\\]*)*"|[^,'"\s\\]*(?:\s+[^,'"\s\\]+)*)\s*(?:,\s*(?:'[^'\\]*(?:\\[\S\s][^'\\]*)*'|"[^"\\]*(?:\\[\S\s][^"\\]*)*"|[^,'"\s\\]*(?:\s+[^,'"\s\\]+)*)\s*)*$/;
		var re_value_comma = /(?!\s*$)\s*(?:'([^'\\]*(?:\\[\S\s][^'\\]*)*)'|"([^"\\]*(?:\\[\S\s][^"\\]*)*)"|([^,'"\s\\]*(?:\s+[^,'"\s\\]+)*))\s*(?:,|$)/g;
		var re_last_comma = /,\s*$/;
		var re_valid_semicolon = /^\s*(?:'[^'\\]*(?:\\[\S\s][^'\\]*)*'|"[^"\\]*(?:\\[\S\s][^"\\]*)*"|[^;'"\s\\]*(?:\s+[^;'"\s\\]+)*)\s*(?:;\s*(?:'[^'\\]*(?:\\[\S\s][^'\\]*)*'|"[^"\\]*(?:\\[\S\s][^"\\]*)*"|[^;'"\s\\]*(?:\s+[^;'"\s\\]+)*)\s*)*$/;
		var re_value_semicolon = /(?!\s*$)\s*(?:'([^'\\]*(?:\\[\S\s][^'\\]*)*)'|"([^"\\]*(?:\\[\S\s][^"\\]*)*)"|([^;'"\s\\]*(?:\s+[^;'"\s\\]+)*))\s*(?:;|$)/g;
		var re_last_semicolon = /;\s*$/;
		if (separator == ",") {
			var re_valid = re_valid_comma;
			var re_value = re_value_comma;
			var re_last = re_last_comma;
		} else {
			var re_valid = re_valid_semicolon;
			var re_value = re_value_semicolon;
			var re_last = re_last_semicolon;
		}
    // Return NULL if input string is not well formed CSV string.
    if (!re_valid.test(text)) return null;
    var a = []; // Initialize array to receive values.
    text.replace(re_value, // "Walk" the string using replace with callback.
      function(m0, m1, m2, m3) {
        // Remove backslash from \' in single quoted values.
        if      (m1 !== undefined) a.push(m1.replace(/\\'/g, "'"));
        // Remove backslash from \" in double quoted values.
        else if (m2 !== undefined) a.push(m2.replace(/\\"/g, '"'));
        else if (m3 !== undefined) a.push(m3);
        return ''; // Return empty string.
      });
    // Handle special case of empty last value.
    if (re_last.test(text)) a.push('');
    return a;
	};

	function validgame(onegame) {
		console.log("checking [" + onegame.Wedstrijdnr + "].");
		// the split gave a problem when multiple dashes were present in the reeks: U11X2-2N3B-0001
		//var tmpgamereeksparts = onegame.Wedstrijdnr.split("-");
		// So we now search for the last dash, and remove the suffix from there)
		var tmpgamereeks = '';
		var n = onegame.Wedstrijdnr.lastIndexOf("-");
		if (n > 0) {
			tmpgamereeks = onegame.Wedstrijdnr.substring(0, n);
		}
		//tmpgamereeks = onegame.Wedstrijdnr.split("-");
		console.log("checking [" + tmpgamereeks + "] =?= [" + '<?=$teaminfo['Team']['competition'];?>' + "].");
		if (tmpgamereeks != '<?=$teaminfo['Team']['competition'];?>') {
			return false;
		}
		console.log("checking existence of Datum: [" + onegame.Datum + "].");
		if (!(onegame.hasOwnProperty('Datum'))) {
			return false;
		}
		console.log("checking existence of Uur: [" + onegame.Uur + "].");
		if (!(onegame.hasOwnProperty('Uur'))) {
			return false;
		}
		return true;
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
					<li>scheidingsteken: komma of puntkomma</li>
					<li>hoofding lijn: verplicht</li>
					<li>verplichte velden: Reeks, Wedstrijdnr, Datum, Uur, Thuis, Bezoekers, Sporthall</li>
					<li>optionele velden: Uitslag, Setstanden, Reserven</li>
					<li>niet-gebruikte velden: alle andere :-)</li>
				</ul>
				<h4>Import van volleyscores:</h4>
				<p>
					Belangrijk: Het eerste deel van het wedstrijdnummer moet matchen met het 'competitie' veld van het team (2PMB in het voorbeeld hieronder).
				</p>
				<h4>Volleyscores voorbeeld:</h4>
				<pre><small>Reeks,Wedstrijdnr,Datum,Uur,Thuis,Bezoekers,Sporthall,Uitslag,Setstanden,Reserven
2de prov.mannen B,2PMB-0003,17/09/2016,19:30,WOLVERTEM,MEISE,"Sportschuur, Wolvertem",,,</small></pre>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="preimportcheckresult" class="modal fade">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Import controle</h4>
      </div>
      <div class="modal-body" id="preimportcheckresultbody">
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
					Dit formulier dient om <strong>competitiewedstrijden</strong> te importeren.
				</p>
				<p>
					Opgelet! Dit gebeurt in volgende stappen:<br/>
					<ol>
						<li>Kopieer eerst de gegevens van de wedstrijden (csv).</li>
						<li>Kies de coach die meestal zal coachen.</li>
						<li>Kies het scheidingsteken dat overeenkomt met dat van in de csv lijst.</li>
						<li>Kies een datum formaat dat overeenkomt met dat van in de csv lijst.</li>
						<li>Copy-paste de <strong>exacte naam</strong> van het thuis-team uit de CSV-gegevens.</li>
						<li>Check de ingevoerde gegevens via "Check wedstrijden".</li>
						<li>Pas dan kan je importeren door op "Importeer deze wedstrijden" te klikken.</li>
					</ol>
				</p>
		  </div>
		</div>

		<div class="games form">
			<?=$this->Form->create('GameImport', array('class' => 'form-horizontal'))?>
			<?=$this->Form->input('team_id', array('type' => 'hidden'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">CSV van de wedstrijden</label>
				<div class="col-sm-6">
					<?=$this->Form->input('gamescsv', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'textarea'))?>
				</div>
			</div>
			<?=$this->Form->input('gamesinjson', array('type' => 'hidden'))?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Coach</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_coach_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'title' => 'Wie coacht', 'options' => $game_coaches, 'empty' => '(kies een coach)'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Scheidingsteken</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_separator', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'title' => 'Scheidingsteken', 'options' => $source_separators, 'empty' => false))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Datum formaat</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_date_format', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'title' => 'Datum formaat', 'options' => $source_date_formats, 'empty' => '(kies een formaat)'))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">Naam thuisploeg (exact)</label>
				<div class="col-sm-6">
					<?=$this->Form->input('game_hometeam', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Thuisploeg'))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?=$this->Form->button(__('Help'), array('class' => 'btn btn-info', 'type' => 'button', 'name' => 'csvhelpbutton', 'onclick' => 'csvhelp();'))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?=$this->Form->button(__('Check wedstrijden'), array('class' => 'btn btn-info', 'type' => 'button', 'name' => 'checkcsvbutton', 'onclick' => 'preimportcheck();'))?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?=$this->Form->button(__('Importeer de wedstrijden'), array('class' => 'btn btn-default', 'type' => 'submit', 'id' => 'importsubmitbutton'))?>
				</div>
			</div>
			<?=$this->Form->end()?>
		</div>

	</div>
</div>

<hr/>


<?php
//	pr($this->request->data);
//	pr($teaminfo);
//	pr($importinput);
//	pr($importgames);
//	pr($game_coaches);
//	pr($source_date_formats);
//	pr($teammembers);
//	pr($teams);
//	echo '<hr/>';
?>
