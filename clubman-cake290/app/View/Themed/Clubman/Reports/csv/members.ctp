<?php
	echo "\"" . 'ledenlijst ' . (isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman') . " - seizoen " . $currentSeason . "\"\n";
	$currentteam = '';
	foreach ($teammembers as $teammember) {
		if ($teammember['Team']['name'] <> $currentteam) {
			$currentteam = $teammember['Team']['name'];
			echo "\"Team: " . mb_convert_encoding($currentteam, "Windows-1252", "UTF-8") . "\";" . "\n";
		}
		echo "\"" . mb_convert_encoding($teammember['Member']['name'], "Windows-1252", "UTF-8") . "\";";
		echo "\"" . mb_convert_encoding($teammember['Team']['name'], "Windows-1252", "UTF-8") . "\";";
		echo "\"" . mb_convert_encoding($teammember['Teammember']['teamfunction'], "Windows-1252", "UTF-8") . "\";";
		echo "\"" . $teammember['Teammember']['teampriority'] . "\";";
		echo "\n";
	}
