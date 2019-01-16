<!-- app/View/Members/reports.ctp -->
<h2>Overzicht rapporten: <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden</h2>

<hr/>
<h3>Basislijsten</h3>
<?=$this->Html->link('Ledenlijst', array('controller' => 'reports', 'action' => 'members'))?>
<br/>
<?=$this->Html->link('Ledenlijst voor trainers', array('controller' => 'reports', 'action' => 'members4trainers'))?>
<br/>

<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin']))) : ?>
  <?=$this->Html->link('Ledenlijst voor secretariaat', array('controller' => 'reports', 'action' => 'members4mgmt'))?>
  <br/>
<?php endif ;?>

<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin']))) : ?>
  <br/>
  <hr/>
  <h3>Geavanceerde lijsten</h3>
  <!--
  <?=$this->Html->link('Lijst voor mailmerge', array('controller' => 'reports', 'action' => 'mailmerge'))?>
  <br/>
  -->
  <?=$this->Html->link('Complete lijst leden', array('controller' => 'reports', 'action' => 'memberscomplete'))?>
  <br/>
<?php endif ;?>

<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin']))) : ?>
  <br/>
  <hr/>
  <h3>Speciale lijsten</h3>
  <?=$this->Html->link('Geboortedatum Leden', array('controller' => 'reports', 'action' => 'membersbirthday'))?>
  <br/>
  <?=$this->Html->link('Geografische Spreiding', array('controller' => 'reports', 'action' => 'memberspread'))?>
  <br/>
<?php endif ;?>

<hr/>
<?php
// pr($members);
?>
