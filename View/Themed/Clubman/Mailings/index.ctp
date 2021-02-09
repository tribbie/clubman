<h2>Mailings</h2>

<div class="table-responsive">
	<table class='table table-striped table-condensed normalelijst'>
		<tr>
			<th>Id</th>
			<th>Season</th>
			<th>Name</th>
			<th>Category</th>
			<th>Adressees</th>
			<th>Actions</th>
		</tr>
		<!-- Here is where we loop through our $mailings array, printing out info -->
		<?php foreach ($mailings as $mailing):?>
			<tr>
				<td><?= $mailing['Mailing']['id'] ?></td>
				<td><?= $mailing['Mailing']['season'] ?></td>
				<td><?= $this->Html->link($mailing['Mailing']['name'], array('action' => 'view', $mailing['Mailing']['id'])) ?></td>
				<td><?= $mailing['Mailing']['category'] ?></td>
				<td><?= count($mailing['Mail']) ?></td>
				<td>
				<?php if ($mailing['Mailing']['season'] == $currentSeason) : ?>
					<?= $this->Html->link('maak mails', array('action' => 'preparemails', $mailing['Mailing']['id'], 'all'), array('title' => 'bereid mails voor')) ?>
				<?php endif ; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>
<?php
//	pr($mailings);
?>
