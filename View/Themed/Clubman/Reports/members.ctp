<!-- app/View/Teammembers/report.ctp -->
<h2>Lijst <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden - seizoen <?=$currentSeason?></h2>

<hr/>
<?=$this->Html->link('Download deze lijst', array('action' => 'members', 'ext' => 'csv'))?>
<br/>
<br/>

<div class="table-responsive">
	<table class='table table-striped table-condensed normalelijst'>
		<?php $currentteam = ''; ?>
		<?php foreach ($teammembers as $teammember) : ?>
			<?php if ($teammember['Team']['name'] <> $currentteam) : ?>
				<?php $currentteam = $teammember['Team']['name']; ?>
				<tr class='groupheader info'>
					<th>Teamleden <?= $currentteam; ?></th>
					<!--<th>Team</th>-->
					<th>Functie</th>
					<th>Prio</th>
				</tr>
			<?php endif ; ?>
			<tr>
				<td><?=$teammember['Member']['name']?></td>
				<!--<td><?=$teammember['Team']['name']?></td>-->
				<td><?=$teammember['Teammember']['teamfunction']?></td>
				<td><?=$teammember['Teammember']['teampriority']?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<?php
// pr($teammembers);
?>
