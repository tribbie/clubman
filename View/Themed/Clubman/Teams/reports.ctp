<!-- app/View/Teams/reports.ctp -->
<h2>Overzicht rapporten: <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> teams</h2>

<?= $this->Html->link('Lijst alle aanwezigheden op wedstrijden', array('controller' => 'reports', 'action' => 'presencesallgames', 'all')); ?>
<br/>
<?= $this->Html->link('Lijst alle aanwezigheden op trainings', array('controller' => 'reports', 'action' => 'presencesalltrainings', 'all')); ?>
<br/>

<br/>
<hr/>
<?php
// pr($teams);
?>
