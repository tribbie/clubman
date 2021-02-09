<!-- app/View/Users/reports.ctp -->
<h2>Rapporten: <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> gebruikers</h2>

<?= $this->Html->link('Lijst gebruikers per rol', array('controller' => 'reports', 'action' => 'usersperrole')); ?>
<br/>

<br/>
<hr/>
<?php
// pr($users);
?>
