Team;Naam;E-mail;Licentie;Bouwjaar;RRnummer;Geboren;Tel;Adres;Postcode;Gemeente;Teamprioriteit;Functie;Mama;E-mail mama;Tel mama;Papa;E-mail papa;Tel papa;Voornaam;Achternaam;
<?php
	$currentteam = '';
	foreach($teammembers as $teammember) {
		if ($teammember['Team']['name'] <> $currentteam) {
			$currentteam = $teammember['Team']['name'];
			echo ';"' . $currentteam . '";"' . $teammember['Team']['email'] . '";' . "\n";
		}
		echo '"' . $teammember['Team']['shortname'] . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['name'], "Windows-1252", "UTF-8") . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['email'], "Windows-1252", "UTF-8") . '";';
		echo '"' . $teammember['Member']['licensenumber'] . '";';
		echo '"' . $teammember['Member']['birthyear'] . '";';
		echo '"' . $teammember['Member']['nationalnumber'] . '";';
		echo '"' . $teammember['Member']['birthdate_nice'] . '";';
		echo '"' . $teammember['Member']['tel'] . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['address'], "Windows-1252", "UTF-8") . '";';
		echo '"' . $teammember['Member']['postcode'] . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['city'], "Windows-1252", "UTF-8") . '";';
		echo '"' . $teammember['Teammember']['teampriority'] . '";';
		echo '"' . $teammember['Teammember']['teamfunction'] . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['mom_name'], "Windows-1252", "UTF-8") . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['mom_email'], "Windows-1252", "UTF-8") . '";';
		echo '"' . $teammember['Member']['mom_tel'] . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['dad_name'], "Windows-1252", "UTF-8") . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['dad_email'], "Windows-1252", "UTF-8") . '";';
		echo '"' . $teammember['Member']['dad_tel'] . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['firstname'], "Windows-1252", "UTF-8") . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['lastname'], "Windows-1252", "UTF-8") . '";';
		echo "\n";
	}
?>
