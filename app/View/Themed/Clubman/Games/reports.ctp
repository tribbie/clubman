<!-- app/View/Games/reports.ctp -->
<h2>Overzicht rapporten: <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> wedstrijden</h2>

<h3>Algemene rapporten</h3>

<?= $this->Html->link('Wedstrijden deze week', array('controller' => 'games', 'action' => 'overview', 'week')); ?>
<br/>
<?= $this->Html->link('Alle wedstrijden', array('controller' => 'games', 'action' => 'shortoverview', 'all')); ?>
<br/>
<?= $this->Html->link('Alle bekerwedstrijden', array('controller' => 'games', 'action' => 'shortoverview', 'beker')); ?>
<br/>
<?= $this->Html->link('Alle jeugdwedstrijden', array('controller' => 'games', 'action' => 'shortoverview', 'jeugd')); ?>
<br/>
<?= $this->Html->link('Alle jeugd bekerwedstrijden', array('controller' => 'games', 'action' => 'shortoverview', 'jeugdbeker')); ?>
<br/>
<?= $this->Html->link('Alle seniors wedstrijden', array('controller' => 'games', 'action' => 'shortoverview', 'seniors')); ?>
<br/>
<?= $this->Html->link('Alle seniors bekerwedstrijden', array('controller' => 'games', 'action' => 'shortoverview', 'seniorsbeker')); ?>
<br/>

<hr/>

<h3>Speciale rapporten</h3>

<?= $this->Html->link('Thuiswedstrijden jeugd (voor scheidsrechterslijst)', array('controller' => 'games', 'action' => 'fortasks', 'jeugdthuis')); ?>
<br/>
<?= $this->Html->link('Alle thuiswedstrijden', array('controller' => 'games', 'action' => 'fortasks', 'allthuis')); ?>
<br/>
<?= $this->Html->link('Alle wedstrijden', array('controller' => 'games', 'action' => 'fortasks', 'all')); ?>
<br/>

<hr/>
