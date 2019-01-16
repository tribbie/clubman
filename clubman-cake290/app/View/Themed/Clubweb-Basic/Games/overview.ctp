<h1><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?>  wedstrijden - <?=$team['Team']['name']?>: <?=$team['Team']['competition']?></h1>
<h2>Periode: van <?=$period['datefrom']?> tot <?=$period['dateto']?></h2>
<!--<hr/>-->

<div class="table-responsive">
	<table class='wedstrijdlijst table table-condensed table-bordered normalelijst'>
		<tr class="info">
			<th class="text-right">Datum</th>
			<th class="text-right">Tijd</th>
			<?php if (($team['Team']['name'] == 'allemaal') or ($team['Team']['name'] == 'jeugd') or ($team['Team']['name'] == 'seniors')) : ?>
				<th>Team</th>
				<?php $colspanspelers = '4'; ?>
			<?php else : ?>
				<?php $colspanspelers = '3'; ?>
			<?php endif; ?>
			<th>Thuisploeg</th>
			<th>Bezoekers</th>
			<th>Coach</th>
			<!--<th>Locatie</th>-->
		</tr>
		<?php foreach ($games as $game) : ?>
			<?php
				$trtitle = $game['Game']['game_code'];
				if ($game['Game']['game_change'] == '') {
					$trclass = "gameregular";
				} elseif ($game['Game']['game_change'] == 'afgelast') {
					$trclass = "gamecancel";
					$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
				} elseif ($game['Game']['game_change'] == 'te verplaatsen') {
					$trclass = "gametochange";
					$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
				} else {
					$trclass = "gamechange";
					$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
				}
				if ($game['Game']['game_code'] == 'competitie') {
					$gamesuffix = "";
				} else {
					$gamesuffix = " (" . substr($game['Game']['game_code'], 0, 1) . ")";
				}
			?>
			<!-- De wedstrijd -->
			<tr title="<?=$trtitle?>" class="<?=$trclass?>">
				<td style="text-align:right"><?=$weekd[$game['Game']['day_of_week']]?>&nbsp;<?=date("j/m/Y", strtotime($game['Game']['game_date']))?></td>
				<td style="text-align:right"><?=substr($game['Game']['game_time'], 0, 5)?></td>
				<?php if (($team['Team']['name'] == 'allemaal') or ($team['Team']['name'] == 'jeugd') or ($team['Team']['name'] == 'seniors')) : ?>
					<td><?=$game['Team']['shortname']?><?=$gamesuffix?></td>
				<?php endif; ?>
				<td><?=$game['Game']['game_home']?></td>
				<td><?=$game['Game']['game_away']?></td>
				<?php if (isset($game['Coach']['Member'])) : ?>
					<td><?=$game['Coach']['Member']['name']?></td>
				<?php else : ?>
					<td>?</td>
				<?php endif; ?>
				<!--<td><?=$game['Game']['game_hall']?></td>-->
			</tr>
			<!-- De spelers -->
			<?php
				$realplayers = array();
				foreach ($game['Gamesteammember'] as $gamemember) {
						if ($gamemember['Teammember']['teampriority'] <> 99) {
							$realplayers[] = $gamemember;
						}
				}
			?>
			<tr title="<?=$trtitle?>" class="<?=$trclass?>">
				<th colspan="2" class="text-right spelersheader"><?=count($realplayers)?> spelers</th>
				<td colspan="<?=$colspanspelers?>" class="spelerslijst">
					<?php
						$gamememberlist = array();
						foreach ($realplayers as $gamemember) {
							$onemember = $gamemember['Teammember']['Member']['name'];
							//$onemember .= '(' . $gamemember['status'] . ')(' . $gamemember['Teammember']['teampriority'] . ')';
							$gamememberlist[] = $onemember;
						}
					?>
					<?=join($gamememberlist, ', ')?>
				</td>
			</tr>
			<!-- De taken (als er zijn) -->
			<?php
				$tasks = array();
				if (trim($game['Game']['game_referee']) != '') $tasks[] = 'scheidsrechter: ' . trim($game['Game']['game_referee']);
				if (trim($game['Game']['game_marker']) != '') $tasks[] = 'markeerder: ' . trim($game['Game']['game_marker']);
				if (trim($game['Game']['game_scoreboard']) != '') $tasks[] = 'scorebord: ' . trim($game['Game']['game_scoreboard']);
			?>
			<?php if (count($tasks) > 0) : ?>
				<tr title="<?=$trtitle?>" class="<?=$trclass?>">
					<th colspan="2" class="text-right spelersheader">taken</th>
					<td colspan="<?=$colspanspelers?>" class="spelerslijst">
						<?=join($tasks, ' - ')?>
					</td>
				</tr>
			<?php endif; ?>
			<!-- De opmerking (als er een is) -->
			<?php if (trim($game['Game']['remark']) != '') : ?>
				<tr title="<?=$trtitle?>" class="<?=$trclass?>">
					<th colspan="2" class="text-right spelersheader">opmerking</th>
					<td colspan="<?=$colspanspelers?>" class="spelerslijst">
					<?=$game['Game']['remark']?>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</table>
</div>



<?php
	if ($loggedIn and (in_array($currentUser['role'], array('root')))) {
		//pr($period);
		//pr($players);
		//pr($team);
		pr($games);
	}
?>
