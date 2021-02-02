<?php
	echo "\"" . (isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman') . ' Prestaties van ' . $period['datefrom'] . " tot " . $period['dateto'] . "\";\n";
	echo "Lid;Naam;Coachings;Demos;TrainingMin;AssistMin;CoordinatieMin;AndereMin;Prestaties;\n";
	foreach ($totals as $total) {
		echo "\"" . $total['totals']['id'] . "\";";
		echo "\"" . mb_convert_encoding($total['totals']['name'], "Windows-1252", "UTF-8") . "\";";
		//echo "\"" . $total['totals']['name'] . "\";";
		echo "\"" . $total['totals']['coachings'] . "\";";
		echo "\"" . $total['totals']['demos'] . "\";";
		//echo "\"" . $total['totals']['trainings'] . "\";";
		echo "\"" . $total['totals']['trainingminutes'] . "\";";
		//echo "\"" . $total['totals']['assists'] . "\";";
		echo "\"" . $total['totals']['assistminutes'] . "\";";
		//echo "\"" . $total['totals']['coords'] . "\";";
		echo "\"" . $total['totals']['coordminutes'] . "\";";
		//echo "\"" . $total['totals']['others'] . "\";";
		echo "\"" . $total['totals']['otherminutes'] . "\";";
		echo "\"" . $total['totals']['effortcount'] . "\";";
		//echo "\"" . $total['totals']['amount'] . "\";";
		// $totals[$memberid]['efforts'][] = $effort;
		echo "\n";
	}
	// foreach ($efforts as $effort) {
	// 	echo "\"" . mb_convert_encoding($effort['Member']['name'], "Windows-1252", "UTF-8") . "\";";
	// 	echo "\"" . $effort['Effort']['taskname'] . "\";";
	// 	echo "\"" . mb_convert_encoding($effort['Team']['name'], "Windows-1252", "UTF-8") . "\";";
	// 	echo "\"" . $effort['Effort']['taskdate'] . "\";";
	// 	echo "\"" . $effort['Effort']['tasktime_nice'] . "\";";
	// 	echo "\"" . $effort['Effort']['taskduration'] . "\";";
	// 	echo "\"" . mb_convert_encoding($effort['Effort']['remark'], "Windows-1252", "UTF-8") . "\";";
	// 	echo "\"" . $effort['Effort']['created'] . "\";";
	// 	echo "\"" . (($effort['Effort']['modified'] <> $effort['Effort']['created']) ? $effort['Effort']['modified'] : '-') . "\";";
	// 	echo "\n";
	// }
