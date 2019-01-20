<p>
  Hallo <?=$subscription['Subscription']['subsname']?>,
</p>

<p>
  Je inschrijving voor het <?= (isset($clubconfig['shortname']) ? $clubconfig['shortname'] : 'club') ?> evenement "<?=$subscription['Subscription']['substitle']?>" ...<br/>
  <font size="+2">... is nu bevestigd.</font>
</p>

<hr>

<p>
  Dit zijn de gegevens die je daar hebt ingegeven:<br/>
  <ul>
    <li>Naam: <?=$subscription['Subscription']['subsname']?></li>
    <li>E-mail: <?=$subscription['Subscription']['subsemail']?></li>
  </ul>
</p>

<?php if ($subscription['Subscription']['extrafields']) : ?>
  <p>
  Volgende extra informatie werd meegegeven:<br/>
    <ul>
    <?php foreach($subscription['Subscription']['extrafields'] as $extrakey => $extravalue) : ?>
      <li><?=$extrakey?>: <?=$extravalue?></li>
    <?php endforeach ; ?>
    </ul>
  </p>
<?php endif; ?>

<hr>

<p>
  <?=$this->Html->link('Naar het evenement', array('controller' => 'events', 'action' => 'view', 'id' => $subscription['Subscription']['event_id'], 'full_base' => true), array('class' => 'button'))?>.<br/>
  <font size="-1">Je bevestigingscode ter informatie: <?=$subscription['Subscription']['subshash']?></font>
</p>

<p>
  Groetjes,<br/>
  <?=(isset($clubconfig['name']) ? $clubconfig['name'] : 'De club')?>
</p>
