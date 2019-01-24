<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> wedstrijden - <?=$team['Team']['name']?>: <?=$team['Team']['competition']?></h2>
<h3>Periode: van <?=$period['datefrom']?> tot <?=$period['dateto']?></h3>

<div class="table-responsive">
	<table class='wedstrijdlijst table table-condensed normalelijst'>
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
		</tr>
		<?php foreach ($games as $game) : ?>
			<?php
				$trtitle = $game['Game']['game_code'];
				if ($game['Game']['game_change'] == '') {
					$trclass = "";
				} elseif ($game['Game']['game_change'] == 'afgelast') {
					$trclass = " class='gamecancel'";
					$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
				} elseif ($game['Game']['game_change'] == 'te verplaatsen') {
					$trclass = " class='gametochange'";
					$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
				} else {
					$trclass = " class='gamechange'";
					$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
				}
				if ($game['Game']['game_code'] == 'competitie') {
					$gamesuffix = "";
				} else {
					$gamesuffix = " (" . substr($game['Game']['game_code'], 0, 1) . ")";
				}
			?>
			<!-- De wedstrijd -->
			<tr title="<?=$trtitle?> " <?=$trclass?>>
				<td class="text-right"><?=$weekd[$game['Game']['day_of_week']]?>&nbsp;<?=date("j/m/Y", strtotime($game['Game']['game_date']))?></td>
				<td class="text-right"><?=substr($game['Game']['game_time'], 0, 5)?></td>
				<?php if (($team['Team']['name'] == 'allemaal') or ($team['Team']['name'] == 'jeugd') or ($team['Team']['name'] == 'seniors')) : ?>
					<td><?=$game['Team']['mininame']?><?=$gamesuffix?></td>
			 	<?php endif; ?>
				<td><?=$game['Game']['game_home']?></td>
				<td><?=$game['Game']['game_away']?></td>
				<?php if (isset($game['Coach']['Member'])) : ?>
					<td><?=$game['Coach']['Member']['name']?></td>
				<?php else : ?>
					<td>?</td>
				<?php endif; ?>
			</tr>
			<!-- De opmerking (als er een is) -->
			<?php	if (trim($game['Game']['remark']) != '') : ?>
				<tr title="<?=$trtitle?>" <?=$trclass?>>
					<th colspan="2" class="text-right spelersheader">opmerking</th>
					<td colspan="<?=$colspanspelers?>" class='spelerslijst'>
						<?=$game['Game']['remark']?>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</table>
</div>

<?php
	if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) {
		//pr($period);
		//pr($team);
		//pr($games);
	}
?>
