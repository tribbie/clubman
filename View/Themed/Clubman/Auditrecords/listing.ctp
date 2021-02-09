<h2>Records of <?=$filter['username']?> (<?=count($records)?>)</h2>

<?=$this->Html->link('Terug', array('controller' => 'auditrecords', 'action' => 'index'))?>
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
						<td class="text-right"><?=$this->Html->link($record['Auditrecord']['id'], array('action' => 'view', $record['Auditrecord']['id']))?></td>
						<td class="text-right"><?=$record['Auditrecord']['created']?></td>
						<td class="text-right"><?=$record['Auditrecord']['userid']?></td>
						<td><?=$record['Auditrecord']['username']?></td>
						<td><?=$record['Auditrecord']['userrole']?></td>
						<td><?=$this->Html->link($record['Auditrecord']['action'], array('action' => 'list', 'a' => $record['Auditrecord']['action'], 'm' => $record['Auditrecord']['model']))?></td>
						<td><?=$this->Html->link($record['Auditrecord']['model'], array('action' => 'list', 'm' => $record['Auditrecord']['model']))?></td>
						<td class="text-right"><?=$record['Auditrecord']['modelid']?></td>
						<td><?=$record['Auditrecord']['userip']?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>
