<!-- app/View/Teams/listing.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> Teams</h2>

<?=$this->Html->link('Nieuw team', array('controller' => 'teams', 'action' => 'add'))?>
<hr/>

<div class="table-responsive">
	<table class="table table-striped table-condensed normalelijst">
		<tr class="groupheader info">
			<th>Naam</th>
			<th>Korte naam</th>
			<th>Mini</th>
			<th>Nr</th>
			<th>E-mail</th>
			<th>Geslacht</th>
			<th>Type</th>
			<th>Categorie</th>
			<th>Serie</th>
			<th>Competitie</th>
			<th>Opmerking</th>
			<th>Volgorde</th>
			<th>Aktie</th>
		</tr>
		<?php foreach ($teams as $team) : ?>
			<tr>
				<td><?=$this->Html->link($team['Team']['name'], array('controller' => 'teams', 'action' => 'view', $team['Team']['id']))?></td>
				<td><?=$team['Team']['shortname']?></td>
				<td><?=$team['Team']['mininame']?></td>
				<td><?=$team['Team']['number']?></td>
				<td><?=$team['Team']['email']?></td>
				<td><?=$team['Team']['gender']?></td>
				<td><?=$team['Team']['teamtype']?></td>
				<td><?=$team['Team']['category']?></td>
				<td><?=$team['Team']['series']?></td>
				<td><?=$team['Team']['competition']?></td>
				<td><?=$team['Team']['remark']?></td>
				<td><?=$team['Team']['display_order']?></td>
				<td>
					<?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'teams', 'action' => 'edit', $team['Team']['id']), array('title' => 'wijzig dit team', 'escape' => false))?>
					<?php if ($team['Team']['competition'] !== '') : ?>
						<?=$this->Html->link('<span class="glyphicon glyphicon-th-list"></span>', array('controller' => 'teams', 'action' => 'rangschikking', $team['Team']['id']), array('title' => 'rangschikking', 'escape' => false))?>
					<?php endif ; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<?php
// pr($teams);
?>
