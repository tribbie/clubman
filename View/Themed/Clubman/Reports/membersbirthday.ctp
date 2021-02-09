<hr/>
<?= $this->Html->link('Download deze lijst - csv', array('action' => 'membersbirthday', 'ext' => 'csv'))."\n"; ?>
<br/>
<br/>
<div class="table-responsive">
	<table id='excelledenoverzicht' class='table table-striped table-condensed normalelijst excellijst'>
		<tr><th colspan="7"><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> Ledenoverzicht - verjaardagen</th></tr>
		<tr class="headerrow">
			<th>Voornaam</th>
			<th>Naam</th>
			<th>Geboren</th>
			<th>Bouwmaand</th>
			<th>Bouwdag</th>
			<th>Bouwjaar</th>
			<th>actief</th>
		</tr>
		<?php foreach($members as $member): ?>
			<tr>
				<td class="simplevalue"><?=$member['Member']['firstname']?></td>
				<td class="simplevalue"><?=$member['Member']['lastname']?></td>
				<td class="simplevalue"><?=$member['Member']['birthdate_nice']?></td>
				<td class="simplevalue"><?=$member['Member']['birthmonth']?></td>
				<td class="simplevalue"><?=$member['Member']['birthday']?></td>
				<td class="simplevalue"><?=$member['Member']['birthyear']?></td>
				<td class="simplevalue"><?=$member['Member']['active']?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<?php
// pr($members);
?>
