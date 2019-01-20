<!-- app/View/Teammembers/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> teamleden</h2>

<?=$this->Html->link('Nieuw teamlid', array('controller' => 'teammembers', 'action' => 'add'))?>
<hr/>

<div class="row">
	<div class="col-xs-12">

		<div class="table-responsive">
			<table class="table table-striped table-condensed normalelijst">

			<?php $currentteam = ''; ?>
			<?php foreach ($teammembers as $teammember) : ?>
				<?php if ($teammember['Team']['name'] <> $currentteam) : ?>
					<?php $currentteam = $teammember['Team']['name']; ?>
					<tr class='groupheader info'>
						<th class="text-center" colspan='5'><?= $currentteam; ?></th>
						<td colspan='1'><?=$this->Html->link('<span class="glyphicon glyphicon-plus"></span>', array('controller' => 'teammembers', 'action' => 'add', 'team' => $teammember['Team']['id']), array('title' => 'voeg lid toe bij ' . $currentteam, 'escape' => false))?></td>
					</tr>

					<tr class="info">
						<th>Foto</th>
						<th>Lic</th>
						<th>Teamlid</th>
						<!--	<th>Team</th> -->
						<th>Functie</th>
						<th>Prio</th>
						<th>Actie</th>
					</tr>

				<?php endif ; ?>

				<tr>
					<?php if (isset($teammember['Member']['Picture']['location'])) : ?>
						<td><?= $this->Html->image($teammember['Member']['Picture']['location'], array('title' => $teammember['Member']['name'], 'class' => 'smallthumb', 'height' => '24')); ?></td>
					<?php else : ?>
						<td><?= $this->Html->image('cmstyle/no_picture.png', array('title' => 'no image', 'class' => 'smallthumb', 'height' => '16')); ?></td>
					<?php endif; ?>
					<?php if (isset($teammember['Member']['Picturelicense']['location'])) : ?>
						<td><?= $this->Html->image($teammember['Member']['Picturelicense']['location'], array('title' => 'VVB licentie', 'class' => 'smallthumb', 'height' => '16')); ?></td>
					<?php else : ?>
						<td><?= $this->Html->image('cmstyle/no_license_scan.png', array('title' => 'no image', 'class' => 'smallthumb', 'height' => '16')); ?></td>
					<?php endif; ?>
					<td><?= $this->Html->link($teammember['Member']['name'], array('controller' => 'teammembers', 'action' => 'view', $teammember['Teammember']['id']))."\n"; ?></td>
					<!--	<td><?= $teammember['Team']['name']; ?></td> -->
					<td><?= $teammember['Teammember']['teamfunction']; ?></td>
					<td><?= ($teammember['Teammember']['teampriority'] == '') ? 'Nog geen prioriteit - gelieve een toe te kennen' : $teampriorities[$teammember['Teammember']['teampriority']]; ?></td>
					<td><?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'teammembers', 'action' => 'edit', $teammember['Teammember']['id']), array('title' => 'wijzig dit teamlid', 'escape' => false))?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>

<?php
// pr($teammembers);
?>
