<?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> Ledenoverzicht;
Datum;"<?=date("M j, Y")?>";
Spelers hoofdteam;"<?=count($teammembersp1)?>";enkel spelers;
Totaal aantal;"<?=count($teammembers)?>";inclusief begeleiding en dubbelaars;

Team;Naam;E-mail;Licentie;Bouwjaar;RRnummer;Geboren;Tel;Adres;Postcode;Gemeente;Teamprioriteit;Functie;Lidgeld;Korting;Voorschot;Saldo;Mama;E-mail mama;Tel mama;Papa;E-mail papa;Tel papa;Kamp;Prijs;Kampvoorschot;Kampsaldo;Voornaam;Achternaam;
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
		echo '"' . $teammember['Member']['membershipfee'] . '";';
		echo '"' . $teammember['Member']['membershipfee_discount'] . '";';
		echo '"' . $teammember['Member']['membership_advancepaid'] . '";';
		echo '"' . $teammember['Member']['membership_balancepaid'] . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['mom_name'], "Windows-1252", "UTF-8") . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['mom_email'], "Windows-1252", "UTF-8") . '";';
		echo '"' . $teammember['Member']['mom_tel'] . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['dad_name'], "Windows-1252", "UTF-8") . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['dad_email'], "Windows-1252", "UTF-8") . '";';
		echo '"' . $teammember['Member']['dad_tel'] . '";';
		echo '"' . $teammember['Member']['camp'] . '";';
		echo '"' . $teammember['Member']['campfee'] . '";';
		echo '"' . $teammember['Member']['camp_advance'] . '";';
		echo '"' . $teammember['Member']['camp_balance'] . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['firstname'], "Windows-1252", "UTF-8") . '";';
		echo '"' . mb_convert_encoding($teammember['Member']['lastname'], "Windows-1252", "UTF-8") . '";';
		echo "\n";
	}
?>
