<hr/>
<?= $this->Html->link('Download deze lijst - xls', array('action' => 'members4mgmt', 'ext' => 'xls')).'<br/>'."\n"; ?>
<?= $this->Html->link('Download deze lijst - csv', array('action' => 'members4mgmt', 'ext' => 'csv'))."\n"; ?>
<br/>
<br/>

<div class="table-responsive">
	<table class="table table-condensed table-striped table-bordered">
		<tr class="groupheader info">
			<th colspan="4"><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> Ledenoverzicht - versie bestuur</th>
		</tr>
		<tr class="groupheader info">
			<td colspan="2" style="text-align:right"><strong>Datum:</strong></td>
			<td colspan="2"><?=date("M j, Y")?></td>
		</tr>
		<tr title="enkel spelers">
			<td colspan="2" style="text-align:right"><strong>Spelers hoofdteam:</strong></td>
			<td colspan="2" style="text-align:left"><?=count($teammembersp1)?></td>
		</tr>
		<tr title="inclusief begeleiding en dubbelaars">
			<td colspan="2" style="text-align:right"><strong>Totaal aantal:</strong></td>
			<td colspan="2" style="text-align:left"><?=count($teammembers)?></td>
		</tr>
		<tr></tr>
		<tr class="groupheader info">
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
			<th title="TeamPrioriteit">TP</th></th>
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
			<th>Kamp?</th>
			<th>Prijs</th>
			<th>KampVoorschot</th>
			<th>KampSaldo</th>
			<th>Voornaam</th>
			<th>Achternaam</th>
		</tr>
		<?php $currentteam = ''; ?>
		<?php foreach($teammembers as $teammember) : ?>
			<?php if ($teammember['Team']['name'] <> $currentteam) : ?>
				<?php $currentteam = $teammember['Team']['name']; ?>
				<tr class="groupheader info">
					<td><strong><?=$teammember['Team']['shortname']?></strong></td>
					<td><strong><?=$currentteam?></strong></td>
					<td><strong><?=$teammember['Team']['email']?></strong></td>
					<?=str_repeat("<td></td>", 26)?>
				</tr>
			<?php endif ; ?>
			<tr>
				<td class="simplevalue"><?=$teammember['Team']['shortname']?></td>
				<td class="simplevalue"><?=$teammember['Member']['name']?></td>
				<td class="simplevalue"><?=$teammember['Member']['email']?></td>
				<td class="simplevalue"><?=$teammember['Member']['licensenumber']?></td>
				<td class="simplevalue"><?=$teammember['Member']['birthyear']?></td>
				<td class="simplevalue"><?=$teammember['Member']['nationalnumber']?></td>
				<td class="simplevalue"><?=$teammember['Member']['birthdate_nice']?></td>
				<td class="simplevalue"><?=$teammember['Member']['tel']?></td>
				<td class="simplevalue"><?=$teammember['Member']['address']?></td>
				<td class="simplevalue"><?=$teammember['Member']['postcode']?></td>
				<td class="simplevalue"><?=$teammember['Member']['city']?></td>
				<td class="simplevalue"><?=$teammember['Teammember']['teampriority']?></td>
				<td class="simplevalue"><?=$teammember['Teammember']['teamfunction']?></td>
				<td class="simplevalue"><?=$teammember['Member']['membershipfee']?></td>
				<td class="simplevalue"><?=$teammember['Member']['membershipfee_discount']?></td>
				<td class="simplevalue"><?=$teammember['Member']['membership_advancepaid']?></td>
				<td class="simplevalue"><?=$teammember['Member']['membership_balancepaid']?></td>
				<td class="simplevalue"><?=$teammember['Member']['mom_name']?></td>
				<td class="simplevalue"><?=$teammember['Member']['mom_email']?></td>
				<td class="simplevalue"><?=$teammember['Member']['mom_tel']?></td>
				<td class="simplevalue"><?=$teammember['Member']['dad_name']?></td>
				<td class="simplevalue"><?=$teammember['Member']['dad_email']?></td>
				<td class="simplevalue"><?=$teammember['Member']['dad_tel']?></td>
				<td class="simplevalue"><?=$teammember['Member']['camp']?></td>
				<td class="simplevalue"><?=$teammember['Member']['campfee']?></td>
				<td class="simplevalue"><?=$teammember['Member']['camp_advance']?></td>
				<td class="simplevalue"><?=$teammember['Member']['camp_balance']?></td>
				<td class="simplevalue"><?=$teammember['Member']['firstname']?></td>
				<td class="simplevalue"><?=$teammember['Member']['lastname']?></td>
			</tr>
		<?php endforeach ; ?>
	</table>
</div>

<?php
// pr($teammembers);
// pr($teammembersp1);
?>
