<?php
	$recordkeys = array_keys($enquetes[0]['Enquete']);
	$recordcsv = implode(';', $recordkeys);
	echo $recordcsv . "\n";
	foreach ($enquetes as $enquete) {
//		Loop through every value in a row 
		foreach ($enquete['Enquete'] as &$value) { 
//			Apply opening and closing text delimiters to every value 
			$value = "\"" . addslashes($value) . "\""; 
		} 
		$recordvalues = array_values($enquete['Enquete']);
		$recordcsv = implode(';', $recordvalues);
		echo $recordcsv . ";\n";
	}
?>
