<!-- app/View/Efforts/listmember.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> prestaties van <?=$member['Member']['name']?></h2>

<?=$this->Html->link('Voeg prestatie toe', array('controller' => 'efforts', 'action' => 'add'))?>
<hr/>

<?php if ($member['Member']['name'] <> 'iedereen') : ?>
<div class="row">

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				Foto
			</div>
			<div class="panel-body">
				<?php if (isset($member['Picture']['location'])) : ?>
					<?= $this->Html->image($member['Picture']['location'], array('title' => $member['Member']['name'], 'class' => 'img-responsive')); ?>
				<?php else : ?>
					<?= $this->Html->image('cmstyle/no_picture.png', array('title' => 'no image', 'class' => 'img-responsive')); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>

</div>
<?php endif; ?>

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
						<td><?=$effort['Member']['name']?></td>
						<td><?=$this->Html->link($effort['Effort']['taskname'], array('controller' => 'efforts', 'action' => 'view', $effort['Effort']['id']))?></td>
						<td><?=$this->Html->link($effort['Team']['name'], array('controller' => 'efforts', 'action' => 'listteam', $effort['Team']['id']), array('title' => 'alle prestatie voor dit team'))?></td>
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
// pr($member);
// pr($efforts);
?>
