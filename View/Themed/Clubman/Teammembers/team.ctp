<!-- app/View/Teammembers/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> teamleden van <?=$team['Team']['name']?> (<?=$team['Team']['shortname']?>)</h2>

<?=$this->Html->link('Nieuw lid voor ' . $team['Team']['name'], array('controller' => 'teammembers', 'action' => 'add', 'team' => $team['Team']['id']))?>
<hr/>

<div class="row">
	<div class="col-xs-12">

		<div class="table-responsive">

			<table class="table table-striped table-condensed normalelijst">
				<tr class="groupheader info">
					<th>Foto</th>
					<th>Lic</th>
					<th>Teamlid</th>
					<th>Functie</th>
					<th class="text-right">Rugnr</th>
					<th>Prio</th>
					<th>Opmerking</th>
					<th>Actie</th>
				</tr>

				<?php foreach ($teammembers as $teammember) : ?>
					<tr>
						<?php if (isset($teammember['Member']['Picture']['location'])) : ?>
							<td><?=$this->Html->image($teammember['Member']['Picture']['location'], array('title' => $teammember['Member']['name'], 'class' => 'smallthumb', 'height' => '24'))?></td>
						<?php else : ?>
							<td><?=$this->Html->image('cmstyle/no_picture.png', array('title' => 'no image', 'class' => 'smallthumb', 'height' => '16'))?></td>
						<?php endif; ?>
						<?php if (isset($teammember['Member']['Picturelicense']['location'])) : ?>
							<td><?=$this->Html->image($teammember['Member']['Picturelicense']['location'], array('title' => 'VVB licentie', 'class' => 'smallthumb', 'height' => '16'))?></td>
						<?php else : ?>
							<td><?=$this->Html->image('cmstyle/no_license_scan.png', array('title' => 'no image', 'class' => 'smallthumb', 'height' => '16'))?></td>
						<?php endif; ?>
						<td><?=$this->Html->link($teammember['Member']['name'], array('controller' => 'teammembers', 'action' => 'view', $teammember['Teammember']['id']))?></td>
						<td><?=$teammember['Teammember']['teamfunction']?></td>
						<td class="text-right"><?=($teammember['Teammember']['shirtnumber'] > 0 ? $teammember['Teammember']['shirtnumber'] : '-')?></td>
						<td><?=($teammember['Teammember']['teampriority'] == '') ? 'Nog geen prioriteit - gelieve een toe te kennen' : $teampriorities[$teammember['Teammember']['teampriority']]?></td>
						<td><?=$teammember['Teammember']['remark']?></td>
						<td><?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'teammembers', 'action' => 'edit', $teammember['Teammember']['id']), array('title' => 'wijzig dit teamlid', 'escape' => false))?></td>
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
