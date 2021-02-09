<table name='Clubman'>
	<tr><th colspan="4" style="background-color: #ccc; color: #333;"><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> Ledenoverzicht - versie bestuur</th></tr>
	<tr>
		<th colspan="2" style="text-align:right; background-color: #eee; color: #222;"><strong>Datum:</strong></th>
		<td colspan="2" style="background-color: #eee; color: #222;"><?php echo date("M j, Y"); ?></td>
	</tr>
	<tr>
		<th colspan="2" style="text-align:right; background-color: #eee; color: #222"><strong>Spelers hoofdteam:</strong></th>
		<td colspan="2" style="text-align:left; background-color: #eee; color: #222"><?php echo count($teammembersp1);?></td>
		<td>(enkel spelers)</td>
	</tr>
	<tr>
		<th colspan="2" style="text-align:right; background-color: #eee; color: #222"><strong>Totaal aantal:</strong></th>
		<td colspan="2" style="text-align:left; background-color: #eee; color: #222"><?php echo count($teammembers);?></td>
		<td>(inclusief begeleiding en dubbelaars)</td>
	</tr>
	<tr></tr>
	<tr class="headerrow" style="background-color: #ddd; color: #111">
		<th>Team</th>
		<th>Naam</th>
		<th>E-mail</th>
		<th>Licentie</th>
		<th>Bouwjaar</th>
		<th>RR nummer</th>
		<th>Geboren</th>
		<th>Tel</th>
		<th>Adres</th>
		<th>Postcode</th>
		<th>Gemeente</th>
		<th>Teamprioriteit</th></th>
		<th>Functie</th></th>
		<th>Lidgeld</th>
		<th>Korting</th>
		<th>Voorschot</th>
		<th>Saldo</th>
		<th>Mama</th>
		<th>E-mail mama</th>
		<th>Tel mama</th>
		<th>Papa</th>
		<th>E-mail papa</th>
		<th>Tel papa</th>
		<th>Kamp</th>
		<th>Prijs</th>
		<th>KampVoorschot</th>
		<th>KampSaldo</th>
		<th>Voornaam</th>
		<th>Achternaam</th>
	</tr>
<?php
	$currentteam = '';
	$bcteam = array(
				'gemengd'   => '#38ACEC',
				'jongens'   => '#38ACEC',
				'meisjes'   => '#38ACEC',
				'dames'     => '#FFD801',
				'heren'     => '#FFD801'
			);
	foreach($teammembers as $teammember) {
		if ($teammember['Team']['name'] <> $currentteam) {
			$currentteam = $teammember['Team']['name'];
			echo '<tr class="teamheader" style="background-color: '.$bcteam[$teammember['Team']['gender']] .'; color: #444">';
			echo '<td><strong>' . $teammember['Team']['shortname'] . '</strong></td>';
			echo '<td><strong>' . $currentteam . '</strong></td>';
			echo '<td><strong>' . $teammember['Team']['email'] . '</strong></td>';
			echo str_repeat("<td></td>", 25);
			echo('</tr>');
		}
		echo '<tr>';
		echo '<td class="simplevalue">' . $teammember['Team']['shortname'] . '</td>';
		echo '<td class="simplevalue">' . mb_convert_encoding($teammember['Member']['name'], "Windows-1252", "UTF-8") . '</td>';
		echo '<td class="simplevalue">' . mb_convert_encoding($teammember['Member']['email'], "Windows-1252", "UTF-8") . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['licensenumber'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['birthyear'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['nationalnumber'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['birthdate_nice'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['tel'] . '</td>';
		echo '<td class="simplevalue">' . mb_convert_encoding($teammember['Member']['address'], "Windows-1252", "UTF-8") . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['postcode'] . '</td>';
		echo '<td class="simplevalue">' . mb_convert_encoding($teammember['Member']['city'], "Windows-1252", "UTF-8") . '</td>';
		echo '<td class="simplevalue">' . $teammember['Teammember']['teampriority'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Teammember']['teamfunction'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['membershipfee'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['membershipfee_discount'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['membership_advancepaid'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['membership_balancepaid'] . '</td>';
		echo '<td class="simplevalue">' . mb_convert_encoding($teammember['Member']['mom_name'], "Windows-1252", "UTF-8") . '</td>';
		echo '<td class="simplevalue">' . mb_convert_encoding($teammember['Member']['mom_email'], "Windows-1252", "UTF-8") . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['mom_tel'] . '</td>';
		echo '<td class="simplevalue">' . mb_convert_encoding($teammember['Member']['dad_name'], "Windows-1252", "UTF-8") . '</td>';
		echo '<td class="simplevalue">' . mb_convert_encoding($teammember['Member']['dad_email'], "Windows-1252", "UTF-8") . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['dad_tel'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['camp'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['campfee'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['camp_advance'] . '</td>';
		echo '<td class="simplevalue">' . $teammember['Member']['camp_balance'] . '</td>';
		echo '<td class="simplevalue">' . mb_convert_encoding($teammember['Member']['firstname'], "Windows-1252", "UTF-8") . '</td>';
		echo '<td class="simplevalue">' . mb_convert_encoding($teammember['Member']['lastname'], "Windows-1252", "UTF-8") . '</td>';
		echo '</tr>' . "\n";
	}
?>
</table>
