<!-- app/View/Teammembers/listing.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> <?= $category ?></h2>

<div class="row">
	<div class="col-xs-12">

		<div class="table-responsive">
			<table class="table table-striped table-condensed normalelijst">
				<tr class="groupheader info">
					<th>Teamlid</th>
					<th class="text-right">Licentie</th>
					<th>Tel</th>
					<th>Team</th>
					<th>Functie</th>
					<th>Prio</th>
				</tr>
				<?php foreach ($teammembers as $teammember) : ?>
					<tr>
						<td><?=$this->Html->link($teammember['Member']['name'], array('controller' => 'teammembers', 'action' => 'view', $teammember['Teammember']['id']))?></td>
						<td class="text-right"><?=$teammember['Member']['licensenumber']?></td>
						<td><?=$teammember['Member']['tel']?></td>
						<td><?=$teammember['Team']['shortname']?></td>
						<td><?=$teammember['Teammember']['teamfunction']?></td>
						<td><?=($teammember['Teammember']['teampriority'] == '') ? 'Nog geen prioriteit - gelieve een toe te kennen' : $teampriorities[$teammember['Teammember']['teampriority']]?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>

<?php
//	pr($teampriorities);
//	pr($teammembers);
?>
