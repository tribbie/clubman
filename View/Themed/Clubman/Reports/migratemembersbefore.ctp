<!-- app/View/Reports/migratemembersbefore.ctp -->
<h2>Complete lijst <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden</h2>

<hr/>
<?=$this->Html->link('Download deze lijst met ALLE LEDEN', array('action' => 'migratemembersbefore', 'ext' => 'csv'))?>
<br/>
<br/>

<?php if (count($migratemembers) > 0) : ?>

	<?php foreach ($migratemembers[0]['Migratemember'] as $migratememberkey => $migratemembervalue) : ?>
		<?=$migratememberkey?>;
	<?php endforeach; ?>
	<br/>

	<?php foreach ($migratemembers as $migratemember) : ?>
		<?php foreach ($migratemember['Migratemember'] as $migratememberkey => $migratemembervalue) : ?>
			<?=$migratemembervalue?>;
		<?php endforeach; ?>
		<br/>
	<?php endforeach; ?>

<?php endif; ?>

<?php
// pr($migratemembers);
?>
