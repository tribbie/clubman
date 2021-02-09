<h1><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> wedstrijden - <?=$team['Team']['name']?>: <?=$team['Team']['competition']?></h1>
<h2>Periode: van <?=$report_meta['period']['datefrom']?> tot <?=$report_meta['period']['dateto']?></h2>

<table class='wedstrijdlijst'>
	<tr>
		<th style="text-align:right">Datum</th>
		<th style="text-align:right">Tijd</th>
		<?php if (($team['Team']['name'] == 'allemaal') or ($team['Team']['name'] == 'jeugd') or ($team['Team']['name'] == 'seniors')) : ?>
			<th>Team</th>
			<?php $colspanspelers = '4'; ?>
		<?php else : ?>
			<?php $colspanspelers = '3'; ?>
		<?php endif; ?>
		<th>Thuisploeg</th>
		<th>Bezoekers</th>
		<th>Coach</th>
		<?php if ($report_meta['category'] == 'jeugdthuis') : ?>
			<th>Scheidsrechter</th>
		<?php endif; ?>
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
				$trclass = " class='gametochange'";
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
		 		<td><?=$game['Team']['mininame']?><?=$gamesuffix?></td>
	 		<?php endif; ?>
			<td><?=$game['Game']['game_home']?></td>
			<td><?=$game['Game']['game_away']?></td>
			<?php if (isset($game['Coach']['Member'])) : ?>
				<td><?=$game['Coach']['Member']['name']?></td>
			<?php else : ?>
				<td>?</td>
			<?php endif; ?>
			<?php if ($report_meta['category'] == 'jeugdthuis') : ?>
				<td><?=$game['Game']['game_referee']?></td>
			<?php endif; ?>
		</tr>
		<!-- De opmerking (als er een is) -->
		<?php if (trim($game['Game']['remark']) != '') : ?>
			<tr title="<?=$trtitle?>" class="<?=$trclass?>" style="text-decoration: none">
				<th colspan="2" class="spelersheader">opmerking</th>
				<td colspan="<?=$colspanspelers?>" class="spelerslijst">
					<?=$game['Game']['remark']?>
				</td>
			</tr>
		<?php endif; ?>
	<?php endforeach; ?>
</table>

<?php
	// pr($report_meta);
	//pr($team);
	//pr($games);
?>
