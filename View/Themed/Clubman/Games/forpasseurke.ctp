<?php if ($games == 0) : ?>
<h1><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> wedstrijden - kies een team</h1>
<h2>Periode: van <?=$period['datefrom'];?> tot <?=$period['dateto'];?></h2>
<br/>
<table class='cleantable'>
<?php foreach ($teaminfo as $team): ?>
	<tr>
		<td><?=$this->Html->link($team['Team']['name'], array('controller' => 'games', 'action' => 'forpasseurke', $team['Team']['id'], $period['datefrom'], $period['dateto'])); ?></td>
	</tr>
<?php endforeach; ?>
<?php else : ?>
<h1><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> wedstrijden - <?=$teaminfo['Team']['name'];?>: <?=$teaminfo['Team']['competition'];?></h1>
<h2>Periode: van <?=$period['datefrom'];?> tot <?=$period['dateto'];?></h2>
<br/>
<table class='cleantable'>
	<tr>
		<th>Datum</th>
		<th>Tijd</th>
		<th>Wedstrijd</th>
	</tr>
<?php foreach ($games as $game): ?>
	<tr>
		<td><?=date("d/m/Y", strtotime($game['Game']['game_date']))?></td>
		<td><?=substr($game['Game']['game_time'], 0, 5)?></td>
		<td><?=$game['Game']['game_home']?> -- <?=$game['Game']['game_away']?></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</table>
