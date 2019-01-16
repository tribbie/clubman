<?php
	echo "\"" . (isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman') . ' Prestaties' . "\";\n";
	echo "Lid;Taak;Team;Datum;Tijd;Duur (min);Opmerking;Ingegeven;Laatst gewijzigd;\n";
	foreach ($efforts as $effort) {
		echo "\"" . mb_convert_encoding($effort['Member']['name'], "Windows-1252", "UTF-8") . "\";";
		echo "\"" . $effort['Effort']['taskname'] . "\";";
		echo "\"" . mb_convert_encoding($effort['Team']['name'], "Windows-1252", "UTF-8") . "\";";
		echo "\"" . $effort['Effort']['taskdate'] . "\";";
		echo "\"" . $effort['Effort']['tasktime_nice'] . "\";";
		echo "\"" . $effort['Effort']['taskduration'] . "\";";
		echo "\"" . mb_convert_encoding($effort['Effort']['remark'], "Windows-1252", "UTF-8") . "\";";
		echo "\"" . $effort['Effort']['created'] . "\";";
		echo "\"" . (($effort['Effort']['modified'] <> $effort['Effort']['created']) ? $effort['Effort']['modified'] : '-') . "\";";
		echo "\n";
	}
