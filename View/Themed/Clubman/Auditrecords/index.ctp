<h2>Users</h2>

<div class="row">
	<div class="col-sm-4 col-sm-offset-4">

		<div class="table-responsive">
			<table class='table table-striped table-condensed normalelijst'>
				<tr class="groupheader info">
					<th>username</th>
					<th class="text-right">akties</th>
					<th class="text-right">recentste</th>
				</tr>
				<?php $totalactions = 0; ?>
				<?php foreach ($records as $record):?>
					<?php $totalactions += $record[0]['akties']; ?>
					<tr>
						<td><?=$this->Html->link(($record['Auditrecord']['username']=='') ? "_null_" : $record['Auditrecord']['username'], array('action' => 'listing', $record['Auditrecord']['username']))?></td>
						<td class="text-right"><?=$record[0]['akties']?></td>
						<td class="text-right"><?=$record[0]['recentste']?></td>
					</tr>
				<?php endforeach; ?>
				<tr class="groupheader info">
					<td>Totalling</td>
					<td class="text-right"><?=$totalactions?></td>
					<td></td>
				</tr>
			</table>
		</div>

	</div>
</div>

<?php
// pr($records);
?>
