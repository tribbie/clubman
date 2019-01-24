<!-- app/View/Efforts/listteam.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> prestaties voor team <?=$team['Team']['name']?></h2>

<div class="row">

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				Foto
			</div>
			<div class="panel-body">
				<?php if (isset($team['Picture']['location'])) : ?>
					<?= $this->Html->image($team['Picture']['location'], array('title' => $team['Team']['name'], 'class' => 'img-responsive')); ?>
				<?php else : ?>
					<?= $this->Html->image('cmstyle/team_placeholder.png', array('title' => 'no image', 'class' => 'img-responsive')); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>

</div>

<?=$this->Html->link('Voeg prestatie toe', array('controller' => 'efforts', 'action' => 'add', $team['Team']['id']))?>
<hr/>

<div class="row">

	<div class="col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-condensed normalelijst">
				<tr class="groupheader info">
					<th>Lid</th>
					<th>Taak</th>
					<th>Team</th>
					<th class="text-right">Datum</th>
					<th class="text-right">Tijd</th>
					<th class="text-right">Duur</th>
					<th>Opmerking</th>
					<th>Aktie</th>
				</tr>
				<?php foreach ($efforts as $effort) : ?>
					<tr>
						<td><?=$this->Html->link($effort['Member']['name'], array('controller' => 'efforts', 'action' => 'listmember', $effort['Member']['id']), array('title' => 'alle prestatie van dit lid'))?></td>
						<td><?=$this->Html->link($effort['Effort']['taskname'], array('controller' => 'efforts', 'action' => 'view', $effort['Effort']['id']))?></td>
						<td><?=$effort['Team']['name']?></td>
						<td class="text-right"><?=$effort['Effort']['taskdate_nice']?></td>
						<td class="text-right"><?=$effort['Effort']['tasktime_nice']?></td>
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
// pr($team);
// pr($efforts);
?>
