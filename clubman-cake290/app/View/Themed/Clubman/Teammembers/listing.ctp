<!-- app/View/Teammembers/listing.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> teamleden van <?=$team['Team']['name']?> (<?=$team['Team']['shortname']?>)</h2>

<div class="row">
	<div class="col-xs-12">

		<div class="table-responsive">
			<table class="table table-striped table-condensed normalelijst">
				<tr class="groupheader info">
					<th>Teamlid</th>
					<th>Licentie</th>
					<th>Tel</th>
					<th>Functie</th>
					<th>Rugnr</th>
					<th>Prio</th>
				</tr>
				<?php foreach ($teammembers as $teammember) : ?>
					<tr>
						<td><?=$this->Html->link($teammember['Member']['name'], array('controller' => 'teammembers', 'action' => 'view', $teammember['Teammember']['id']))?></td>
						<td><?=$teammember['Member']['licensenumber']?></td>
						<td><?=$teammember['Member']['tel']?></td>
						<td><?=$teammember['Teammember']['teamfunction']?></td>
						<td style='text-align: right'><?=($teammember['Teammember']['shirtnumber'] > 0 ? $teammember['Teammember']['shirtnumber'] : '-')?></td>
						<td><?=($teammember['Teammember']['teampriority'] == '') ? 'Nog geen prioriteit - gelieve een toe te kennen' : $teampriorities[$teammember['Teammember']['teampriority']]?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>

<?php
// pr($team);
// pr($teammembers);
?>
