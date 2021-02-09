<!-- app/View/Pictures/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> foto's</h2>

<?=$this->Html->link('Voeg foto\'s toe', array('controller' => 'pictures', 'action' => 'add'))?>
<hr/>

<div class="row">

	<div class="col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-condensed normalelijst">
				<tr class="groupheader info">
					<th>Locatie</th>
					<th>Type</th>
					<th>Grootte</th>
					<th>Oplader</th>
					<th>Aktie</th>
				</tr>
				<?php foreach ($pictures as $picture) : ?>
					<tr>
						<td><?=$this->Html->link($picture['Picture']['location'], array('controller' => 'pictures', 'action' => 'view', $picture['Picture']['id']))."\n"; ?></td>
						<td><?=$picture['Picture']['type']?></td>
						<td style='text-align: right'><?=$picture['Picture']['size']?></td>
						<td><?=$picture['Picture']['uploader']?></td>
						<td><?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'pictures', 'action' => 'edit', $picture['Picture']['id']), array('title' => 'wijzig deze foto', 'escape' => false))?></td>
					</tr>
				<?php endforeach ; ?>
			</table>
		</div>
	</div>

</div>

<?php
// pr($pictures);
?>
