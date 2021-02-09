<!-- app/View/Games/presences.ctp -->
<h2>Wedstrijd van <?=$game['Team']['name'];?></h2>

<div class="games form presences">
<?php echo $this->Form->create('Game'); ?>
<p>
<?php
	echo 'Wedstrijd van ' . $game['Team']['name'] . '<br/>';
	echo $game['Game']['game_home'] . ' - ' . $game['Game']['game_away'] . '<br/>' . "\n";
	echo $weekdays[$game['Game']['day_of_week']] . ' ' . $game['Game']['game_date_nice'] . ' om ' . $game['Game']['game_time_nice'];
	echo ' (week ' . $game['Game']['week_of_year'] . ')<br/>' . "\n";

?>
</p>

<p>Vergeet onderaan niet op "Pas aanwezigheden aan" te klikken!</p>

<?php

	echo "<small>\n";
	echo $this->Form->hidden('Game.id', array('value' => $game['Game']['id']));
	$coachoptions = $game_coaches;
	$coachattributes = array('value' => $game['Game']['game_coach_id'], 'label' => 'Coach', 'legend' => 'Coaching', 'separator' => '<br/>');
	echo $this->Form->radio('Game.game_coach_id', $coachoptions, $coachattributes);
	echo '<br/>';
	echo "<fieldset>\n";
	echo "<legend>Aanwezigheden</legend>";

		echo '<table width="100%">';
		echo '<tr>';
		echo '<th width="20%">Naam</th>';
		echo '<th width="60%">Status</th>';
		echo '<th width="20%">Opmerking</th>';
		echo '</tr>';

		$mcount = 0;
		foreach ($thepresences as $thepresence) {
			echo '<tr>';
			echo '<td title="'.$thepresence['member_id'].'">' . $thepresence['name'] . '</td>';
			echo '<td>';
			$options = array('aanwezig' => 'Aanwezig', 'afwezig' => 'Afwezig', 'verwittigd' => 'Verwittigd', 'gekwetst' => 'Gekwetst', 'ziek' => 'Ziek', 'telaat' => 'Te laat');
			if ($thepresence['id'] <> '') echo $this->Form->hidden('Gamesteammember.'.$mcount.'.id', array('value' => $thepresence['id']));
			echo $this->Form->hidden('Gamesteammember.'.$mcount.'.game_id', array('value' => $thepresence['game_id']));
			echo $this->Form->hidden('Gamesteammember.'.$mcount.'.season', array('value' => $currentSeason));
			echo $this->Form->hidden('Gamesteammember.'.$mcount.'.teammember_id', array('value' => $thepresence['teammember_id']));
			echo $this->Form->radio('Gamesteammember.'.$mcount.'.status', $options, array('legend' => false, 'value' => $thepresence['status'], 'class' => 'input'));
			echo '</td>';
			echo '<td>';
			echo $this->Form->input('Gamesteammember.'.$mcount.'.remark', array('label' => false, 'class' => 'input', 'value' => $thepresence['remark']));
			echo '</td>';
			echo '</tr>' . "\n";
			$mcount += 1;
		}
		echo '</table>';

	echo "</fieldset>\n";

	echo '<br/>';
	echo $this->Form->input('Game.remark', array('label' => 'Opmerking', 'class' => 'input', 'value' => $game['Game']['remark']));
	echo '<br/>';

	echo "</small>\n";
?>

<?= $this->Form->end(__('Pas aanwezigheden aan'), array('class' => 'button')); ?>
<div class="spacer"></div>
</div>

<hr/>

<?php
//	if (isset($formdata)) pr($formdata);
//	echo '<hr/>';
//	pr($teammembers);
//	pr($game_coaches);
//	pr($teamcoaches);
//	pr($game);
//	pr($gamesteammembers);
//	pr($thepresences);
?>
