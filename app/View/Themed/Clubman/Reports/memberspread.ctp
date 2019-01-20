<!-- app/View/Teammembers/report.ctp -->
<h2>Geografische spreiding actieve <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden</h2>
<div class="table-responsive">
	<table class='table table-striped table-condensed normalelijst'>
		<tr>
			<th>Gemeente</th>
			<th>Actieve leden</th>
			<th>Inactieve leden</th>
		</tr>
		<?php foreach ($memberspreadcity as $city=>$members) : ?>
			<tr>
				<td>
					<?=$this->Html->link($city, array('controller' => 'members', 'action' => 'filter', 'city' => (($city == '(geen)') ? '' : $city)))?>
				</td>
				<td style="text-align:right"><?= (isset($members['active']) ? $members['active'] : 0) ?></td>
				<td style="text-align:right"><?= (isset($members['inactive']) ? $members['inactive'] : 0) ?></td>
			</tr>
		<?php endforeach; ?>
</table>


<?php
// pr($memberspreadcity);
?>
