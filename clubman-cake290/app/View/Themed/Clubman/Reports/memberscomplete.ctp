<!-- app/View/Reports/memberscomplete.ctp -->
<h2>Complete lijst <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden</h2>

<hr/>
<?=$this->Html->link('Download deze lijst met ALLE LEDEN', array('action' => 'memberscomplete', 'ext' => 'csv'))?>
<br/>
<?=$this->Html->link('Download deze lijst met ENKEL ACTIEVE LEDEN', array('action' => 'memberscomplete', 'ext' => 'csv', 'active'))?>
<br/>
<?=$this->Html->link('Download deze lijst met ENKEL INACTIEVE LEDEN', array('action' => 'memberscomplete', 'ext' => 'csv', 'inactive'))?>
<br/>
<br/>

<?php if (count($members) > 0) : ?>

	<?php foreach ($members[0]['Member'] as $memberkey => $membervalue) : ?>
		<?=$memberkey?>;
	<?php endforeach; ?>
	<br/>

	<?php foreach ($members as $member) : ?>
		<?php foreach ($member['Member'] as $memberkey => $membervalue) : ?>
			<?=$membervalue?>;
		<?php endforeach; ?>
		<br/>
	<?php endforeach; ?>

<?php endif; ?>

<?php
// pr($members);
?>
