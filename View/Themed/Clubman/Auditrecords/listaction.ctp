<h2>Records</h2>

Model: <?=$filter['model']?> - Action: <?=$filter['action']?> - records found: <?=count($records)?>.
<hr/>

<div class="row">
	<div class="col-xs-12">

		<div class="table-responsive">
			<table class='table table-striped table-condensed normalelijst'>
				<tr>
					<th class="text-right">id</th>
					<th class="text-right">created</th>
					<th class="text-right">userid</th>
					<th>username</th>
					<th>userrole</th>
					<th>action</th>
					<th>model</th>
					<th class="text-right">modelid</th>
					<th>userip</th>
				</tr>
				<?php foreach ($records as $record):?>
					<tr>
						<td class="text-right"><?=$record['Auditrecord']['id']?></td>
						<td class="text-right"><?=$this->Html->link($record['Auditrecord']['created'], array('action' => 'view', $record['Auditrecord']['id']))?></td>
						<td class="text-right"><?=$record['Auditrecord']['userid']?></td>
						<td><?=$record['Auditrecord']['username']?></td>
						<td><?=$record['Auditrecord']['userrole']?></td>
						<td><?=$record['Auditrecord']['action']?></td>
						<td><?=$record['Auditrecord']['model']?></td>
						<td class="text-right"><?=$record['Auditrecord']['modelid']?></td>
						<td><?=$record['Auditrecord']['userip']?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>
