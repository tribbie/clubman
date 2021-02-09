<p>
  Hallo <?=$subscription['Subscription']['subsname']?>,
</p>

<p>
  Je krijgt deze mail omdat je jezelf hebt ingeschreven voor het <?= (isset($clubconfig['shortname']) ? $clubconfig['shortname'] : 'club') ?> evenement:<br/>
  <font size="+1"><?=$subscription['Subscription']['substitle']?></font>
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
<?php endif ; ?>

<hr>

<p>
  Gelieve op volgende link te klikken om je inschrijving te bevestigen:<br/>
  <?= $this->Html->link('Bevestig je inschrijving', array('controller' => 'subscriptions', 'action' => 'confirm', $subscription['Subscription']['subshash'], 'full_base' => true), array('class' => 'button'));?>.<br/>
  <font size="-1">Je bevestigingscode ter informatie: <?=$subscription['Subscription']['subshash']?></font>
</p>

<p>
  Groetjes,<br/>
  <?= (isset($clubconfig['name']) ? $clubconfig['name'] : 'De club') ?>
</p>
