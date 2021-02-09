<!-- app/View/Reports/presencesgames.ctp -->
<h2>Aanwezigheden op wedstrijden van <?=$theteam['name']?></h2>

<!--
<hr/>
<?= $this->Html->link('Download deze lijst', array('action' => 'presencesgames', 'ext' => 'csv'))."\n"; ?>
<br/>
-->

<div class="table-responsive">
	<?php if (!(isset($theteam['members'])) or (count($theteam['members']) == 0) or (count($matrix) == 0)) : ?>
		<?php if (!(isset($theteam['members'])) or (count($theteam['members']) == 0)) : ?>
			<div>
				There are no teammembers for this team.
				No data to display.
			</div>
		<?php else : ?>
			<div>
				No games found for this team.
				No data to display.
			</div>
		<?php endif; ?>
	<?php else : ?>
		<table class="table table-condesed table-striped table-bordered normalelijst">
			<tr class="info">
				<th colspan='4'>Wedstrijd</th>
				<?php foreach ($theteam['members'] as $member) : ?>
					<th style="text-align: center;"><?=$member?></th>
				<?php endforeach; ?>
			</tr>
			<?php
				$statusstyle = array('aanwezig' => 'color: #090;', 'afwezig' => 'color: #900;', 'verwittigd' => 'color: #666;', 'gekwetst' => 'color: #009;', 'ziek' => 'color: #333;', 'telaat' => 'color: #f90;', '' => 'color: #000;');
				$statusclass = array('aanwezig' => 'bg-success', 'afwezig' => 'bg-danger', 'verwittigd' => 'bg-info', 'gekwetst' => 'bg-info', 'ziek' => 'bg-info', 'telaat' => 'bg-warning', '' => '');
			?>
			<?php foreach ($matrix as $game) : ?>
				<tr>
					<td><?=$weekd[$game['day']]?></td>
					<td class="text-right"><?=$game['date']?></td>
					<td class="text-right"><?=$game['time']?></td>
					<td><?=$game['title']?></td>
					<?php foreach ($theteam['members'] as $id => $member) : ?>
						<?php $status = (isset($game['presences'][$id])) ? $game['presences'][$id] : ''; ?>
						<td class="<?=$statusclass[$status]?>" style="text-align: center;<?=$statusstyle[$status]?>"><?=$status?></td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>

<hr/>

<?php
 //pr($theteam);
 //pr($matrix);
 //pr($games);
?>
