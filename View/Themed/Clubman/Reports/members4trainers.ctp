<!-- app/View/Teammembers/report.ctp -->
<h2>Contactlijst <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden - seizoen <?=$currentSeason?></h2>

<hr/>
<?=$this->Html->link('Download deze lijst - csv', array('action' => 'members4trainers', 'ext' => 'csv'))?>
<br/>
<br/>
<div class="table-responsive">
	<table class="table table-condensed table-striped table-bordered">
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
			<th>Mama</th>
			<th>E-mail mama</th>
			<th>Tel mama</th>
			<th>Papa</th>
			<th>E-mail papa</th>
			<th>Tel papa</th>
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
					<?=str_repeat("<td></td>", 18)?>
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
				<td class="simplevalue"><?=$teammember['Member']['mom_name']?></td>
				<td class="simplevalue"><?=$teammember['Member']['mom_email']?></td>
				<td class="simplevalue"><?=$teammember['Member']['mom_tel']?></td>
				<td class="simplevalue"><?=$teammember['Member']['dad_name']?></td>
				<td class="simplevalue"><?=$teammember['Member']['dad_email']?></td>
				<td class="simplevalue"><?=$teammember['Member']['dad_tel']?></td>
				<td class="simplevalue"><?=$teammember['Member']['firstname']?></td>
				<td class="simplevalue"><?=$teammember['Member']['lastname']?></td>
			</tr>
		<?php endforeach ; ?>
	</table>
</div>

<?php
// pr($teammembers);
?>
