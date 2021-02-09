<!-- app/View/Reports/presencesallgames.ctp -->
<h2>Aanwezigheden op wedstrijden</h2>
<br/>

<!--
<hr/>
<?= $this->Html->link('Download deze lijst', array('action' => 'presencesgames', 'ext' => 'csv'))."\n"; ?>
<br/>
<br/>
-->

<?php
	$statusstyle = array('aanwezig' => 'color: #090;', 'afwezig' => 'color: #900;', 'verwittigd' => 'color: #666;', 'gekwetst' => 'color: #009;', 'ziek' => 'color: #333;', 'telaat' => 'color: #f90;', '' => 'color: #000;');
?>

<?php
	foreach ($team as $oneTeam) {
		$colCount = count($oneTeam['Teammember']) + 1;
		$gameCount = count($oneTeam['Game']);
		if (($colCount > 1) and ($gameCount > 0)) {
			echo '<table>';
			echo '<tr><th title="team '.$oneTeam['Team']['id'].'" colspan="'.$colCount.'">'.$oneTeam['Team']['name'].'</th></tr>';
			echo '<tr><th>Wedstrijd</th>';
			foreach ($oneTeam['Teammember'] as $oneTeammember) {
				echo '<th title="teammember '.$oneTeammember['id'].'">';
				echo $oneTeammember['Member']['name'];
				echo '</th>';
			}
			echo '</tr>';

			foreach ($oneTeam['Game'] as $oneGame) {
				echo '<tr>';
				echo '<th title="wedstrijd '.$oneGame['id'].'">';
				echo $oneGame['game_date_nice'];
				echo '</th>';

				foreach ($oneTeam['Teammember'] as $oneTeammember) {
					$theStatus = (isset($theMatrix[$oneTeam['Team']['id']][$oneGame['id']]['presence'][$oneTeammember['id']])) ? $theMatrix[$oneTeam['Team']['id']][$oneGame['id']]['presence'][$oneTeammember['id']] : '';
					echo '<td style="text-align: center;' . $statusstyle[$theStatus] . '">';
					echo $theStatus;
					echo '</td>';
				}

				echo '</tr>';
			}
			echo '</table>';
			echo '<hr/>';
		}
	}
?>


<?php
// pr($theMatrix);
// pr($team);
// pr($theteam);
// pr($games);
?>
