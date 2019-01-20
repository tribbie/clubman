<!-- app/View/Uploads/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> bestanden</h2>

<?=$this->Html->link('Laad bestand op', array('controller' => 'uploads', 'action' => 'add'))?>
<hr/>

<div class="table-responsive">
	<table class="table table-striped table-condensed normalelijst">
		<tr class="groupheader info">
			<th>Naam</th>
			<th>Categorie</th>
			<th>Seizoen</th>
			<th class='text-center'>Status</th>
			<th>Type</th>
			<!--<th>Locatie</th>-->
			<th class='text-right'>Grootte</th>
			<th>Oplader</th>
			<!-- <th>Aktie</th> -->
		</tr>
		<?php foreach ($uploads as $upload) : ?>
			<tr>
				<td><?= $this->Html->link($upload['Upload']['name'], array('controller' => 'uploads', 'action' => 'view', $upload['Upload']['category'], $upload['Upload']['id']))."\n"; ?></td>
				<td><?= $upload['Upload']['category']; ?></td>
				<td><?= $upload['Upload']['season']; ?></td>
				<td class='text-center' title='<?=$upload['Upload']['status']?>'>
					<?php if ($upload['Upload']['status'] == 'hidden') : ?>
						<spen class="text-danger"><span class="glyphicon glyphicon-remove"></span></span>
					<?php elseif ($upload['Upload']['status'] == 'private') : ?>
						<spen class="text-danger"><span class="glyphicon glyphicon-lock"></span></span>
					<?php elseif ($upload['Upload']['status'] == 'public') : ?>
						<spen class="text-success"><span class="glyphicon glyphicon-ok"></span></span>
					<?php elseif ($upload['Upload']['status'] == 'test') : ?>
						<spen class="text-warning"><span class="glyphicon glyphicon-asterisk"></span></span>
					<?php else : ?>
						<spen class="text-warning"><span class="glyphicon glyphicon-question-sign"></span></span>
					<?php endif; ?>
				</td>
				<td><?=$upload['Upload']['type']?></td>
				<!--<td><?= $upload['Upload']['location']; ?></td>-->
				<td class='text-right'><?= $upload['Upload']['size']; ?></td>
				<td><?= $upload['Upload']['uploader']; ?></td>
				<!--<td><?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'uploads', 'action' => 'edit', $upload['Upload']['id']), array('title' => 'wijzig deze upload', 'escape' => false))?></td>-->
			</tr>
		<?php endforeach ; ?>
	</table>
</div>

<?php
// pr($uploads);
?>
