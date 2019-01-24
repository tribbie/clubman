<!-- app/View/Efforts/reports.ctp -->
<h2>Overzicht rapporten: <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> prestaties</h2>

<?= $this->Html->link('Lijst alle prestaties', array('controller' => 'reports', 'action' => 'efforts')); ?>
<br/>
<?= $this->Html->link('Lijst prestaties over periode', array('controller' => 'efforts', 'action' => 'periodicoverview')); ?>
<br/>
<!--
<?= $this->Html->link('Lijst prestaties per maand (todo)', array('controller' => 'reports', 'action' => 'effortsbymonth')); ?>
<br/>
<?= $this->Html->link('Lijst prestaties per team (todo)', array('controller' => 'reports', 'action' => 'effortsbyteam')); ?>
<br/>
-->

<br/>
<hr/>
<?php
// pr($efforts);
?>
