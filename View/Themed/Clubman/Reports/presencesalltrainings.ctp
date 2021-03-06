<!-- app/View/Reports/presencesalltrainings.ctp -->
<h2>Aanwezigheden op training</h2>
<br/>

<!--
<hr/>
<?= $this->Html->link('Download deze lijst', array('action' => 'presencesalltrainings', 'ext' => 'csv'))."\n"; ?>
<br/>
<br/>
-->

<?php
	$statusstyle = array('aanwezig' => 'color: #090;', 'afwezig' => 'color: #900;', 'verwittigd' => 'color: #666;', 'gekwetst' => 'color: #009;', 'ziek' => 'color: #333;', 'telaat' => 'color: #f90;', '' => 'color: #000;');
?>

<?php
	foreach ($team as $oneTeam) {
		$colCount = count($oneTeam['Teammember']) + 1;
		$trainingCount = count($oneTeam['Training']);
		if (($colCount > 1) and ($trainingCount > 0)) {
			echo '<table>';
			echo '<tr><th title="team '.$oneTeam['Team']['id'].'" colspan="'.$colCount.'">'.$oneTeam['Team']['name'].'</th></tr>';
			echo '<tr><th>Training</th>';
			foreach ($oneTeam['Teammember'] as $oneTeammember) {
				echo '<th title="teammember '.$oneTeammember['id'].'">';
				echo $oneTeammember['Member']['name'];
				echo '</th>';
			}
			echo '</tr>';

			foreach ($oneTeam['Training'] as $oneTraining) {
				if (count($theMatrix[$oneTeam['Team']['id']][$oneTraining['id']]['presence']) > 0) {
					echo '<tr>';
					echo '<th title="training '.$oneTraining['id'].'">';
					echo $oneTraining['start_date_nice'];
					echo '</th>';

					foreach ($oneTeam['Teammember'] as $oneTeammember) {
						$theStatus = (isset($theMatrix[$oneTeam['Team']['id']][$oneTraining['id']]['presence'][$oneTeammember['id']])) ? $theMatrix[$oneTeam['Team']['id']][$oneTraining['id']]['presence'][$oneTeammember['id']] : '';
						echo '<td style="text-align: center;' . $statusstyle[$theStatus] . '">';
						echo $theStatus;
						echo '</td>';
					}

					echo '</tr>';
				}
			}
			echo '</table>';
			echo '<hr/>';
		}
	}
?>


<?php
// pr($theMatrix);
// pr($team);
?>
