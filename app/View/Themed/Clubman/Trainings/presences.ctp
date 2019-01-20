<!-- app/View/Trainings/presences.ctp -->
<h2>Training van <?=$training['Team']['name'];?></h2>

<div class="trainings form presences">
<?php echo $this->Form->create('Training'); ?>
<p>
<?php
	echo "Training van " . $training['Team']['name'] . '<br/>';
	echo $weekdays[$training['Training']['day_of_week']];
	echo " " . $training['Training']['start_date_nice'];
	echo " van " . $training['Training']['start_time_nice'] . " tot " . $training['Training']['end_time_nice'];
	echo " (week " . $training['Training']['week_of_year'] . ")";
?>
</p>

<p>Vergeet onderaan niet op "Pas aanwezigheden aan" te klikken!</p>

<?php

	echo "<small>\n";
	echo "<fieldset>\n";
	echo "<legend>Aanwezigheden</legend>";

		echo '<table width="100%">';
		echo '<tr class="groupheader info">';
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
			if ($thepresence['id'] <> '') echo $this->Form->hidden('Trainingsteammember.'.$mcount.'.id', array('value' => $thepresence['id']));
			echo $this->Form->hidden('Trainingsteammember.'.$mcount.'.training_id', array('value' => $thepresence['training_id']));
			echo $this->Form->hidden('Trainingsteammember.'.$mcount.'.season', array('value' => $currentSeason));
			echo $this->Form->hidden('Trainingsteammember.'.$mcount.'.teammember_id', array('value' => $thepresence['teammember_id']));
//			echo $this->Form->radio('Trainingsteammember.'.$mcount.'.status', $options, array('legend' => false, 'value' => $thepresence['status'], 'class' => 'input'));
			echo $this->Form->select('Trainingsteammember.'.$mcount.'.status', $options, array('legend' => false, 'value' => $thepresence['status'], 'class' => 'input'));
			echo '</td>';
			echo '<td>';
			echo $this->Form->input('Trainingsteammember.'.$mcount.'.remark', array('label' => false, 'class' => 'input', 'value' => $thepresence['remark']));
			echo '</td>';
			echo '</tr>' . "\n";
			$mcount += 1;
		}
		echo '</table>';


	echo "</fieldset>\n";

	echo '<br/>';
	echo $this->Form->hidden('Training.id', array('value' => $training['Training']['id']));
	echo $this->Form->input('Training.remark', array('label' => 'Opmerking', 'class' => 'input', 'value' => $training['Training']['remark']));
	echo '<br/>';

	echo "</small>\n";
?>

<?= $this->Form->end(__('Pas aanwezigheden aan'), array('class' => 'button')); ?>
<div class="spacer"></div>
</div>

<hr/>

<?php
//	pr($formdata);
//	pr($training);
//	echo '<hr/>';
//	pr($teammembers);
//	pr($trainingsteammembers);
//	pr($thepresences);
?>
