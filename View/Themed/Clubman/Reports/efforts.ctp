<!-- app/View/Reports/efforts.ctp -->
<h2>Uw <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> Prestaties</h2>

<hr/>
<?=$this->Html->link('Download deze lijst', array('action' => 'efforts', 'ext' => 'csv'))?>
<br/>
<br/>

<div class="table-responsive">
	<table class='table table-striped table-condensed normalelijst'>

		<tr class="groupheader info">
			<th>Lid</th>
			<th>Taak</th>
			<th>Team</th>
			<th class='text-right'>Datum</th>
			<th class='text-right'>Tijd</th>
			<th class='text-right'>Duur</th>
			<th>Opmerking</th>
			<th class='text-right'>Ingegeven</th>
			<th class='text-right'>Laatst gewijzigd</th>
		</tr>

		<?php foreach ($efforts as $effort) : ?>
			<tr>
				<td><?= $effort['Member']['name']; ?></td>
				<td><?= $this->Html->link($effort['Effort']['taskname'], array('controller' => 'efforts', 'action' => 'view', $effort['Effort']['id']))."\n"; ?></td>
				<td><?= $effort['Team']['name']; ?></td>
				<td class='text-right'><?= $effort['Effort']['taskdate']; ?></td>
				<td class='text-right'><?= $effort['Effort']['tasktime_nice']; ?></td>
				<td class='text-right'><?= $effort['Effort']['taskduration']; ?></td>
				<td><?= $effort['Effort']['remark']; ?></td>
				<td class='text-right'><?= $effort['Effort']['created']; ?></td>
				<td class='text-right'>
					<?= (($effort['Effort']['modified'] <> $effort['Effort']['created']) ? $effort['Effort']['modified'] : '-'); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<hr/>

<?php
// pr($efforts);
// pr($this->request);
?>
