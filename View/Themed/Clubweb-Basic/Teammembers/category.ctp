<!-- app/View/Teammembers/listing.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> <?= $category ?></h2>

<div class="row">
	<div class="col-xs-12">

		<div class="table-responsive">
			<table class="table table-striped table-condensed normalelijst">
				<tr class="groupheader info">
					<th>Teamlid</th>
					<th class="text-right">Licentie</th>
					<th>Team</th>
					<th>Functie</th>
				</tr>
				<?php foreach ($teammembers as $teammember) : ?>
					<tr>
						<td><?=$teammember['Member']['name']?></td>
						<td class="text-right"><?=$teammember['Member']['licensenumber']?></td>
						<td><?=$teammember['Team']['shortname']?></td>
						<td><?=$teammember['Teammember']['teamfunction']?></td>
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
