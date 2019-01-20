<!-- app/View/Efforts/index.ctp -->
<h2>Uw <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> Prestaties</h2>

<?=$this->Html->link("Nieuwe prestatie", array('controller' => 'efforts', 'action' => 'add'))?>
<hr/>

<div class="row">

	<div class="col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-condensed normalelijst">
				<tr class="groupheader info">
					<th>Lid</th>
					<th class="text-right">Datum</th>
					<th class="text-right">Tijd</th>
					<th>Taak</th>
					<th>Team</th>
					<th class="text-right">Duur</th>
					<th>Opmerking</th>
					<th>Aktie</th>
				</tr>
				<?php foreach ($efforts as $effort) : ?>
					<tr>
						<td><?=$effort['Member']['name']?></td>
						<td class="text-right"><?=$this->Html->link($effort['Effort']['taskdate_nice'], array('controller' => 'efforts', 'action' => 'view', $effort['Effort']['id']))?></td>
						<td class="text-right"><?=$effort['Effort']['tasktime_nice']?></td>
						<td><?=$effort['Effort']['taskname']?></td>
						<td><?=$effort['Team']['name']?></td>
						<td class="text-right"><?=$effort['Effort']['taskduration']?></td>
						<td><?=$effort['Effort']['remark']?></td>
						<td><?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'efforts', 'action' => 'edit', $effort['Effort']['id']), array('title' => 'wijzig deze prestatie', 'escape' => false))?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>

</div>


<?php
// pr($efforts);
?>
