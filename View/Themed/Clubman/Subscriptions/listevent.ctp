<font size='+2'><?=$event['Event']['title']?> <?=$event['Event']['season']?></font><br />
<font size='+1'>Inschrijvingen</font>
<br />
<hr/>
<?= $this->Html->link('Download deze lijst', array('action' => 'listevent', $event['Event']['id'], 'ext' => 'csv')) ?>
<br/>
<table class='table table-striped table-condensed normalelijst'>
  <tr class="groupheader info">
    <!--<th>Evenement</th>-->
    <!--<th>Seizoen</th>-->
    <!--<th>Titel</th>-->
    <!--<th>Hash</th>-->
    <th>Naam</th>
    <th>E-mail</th>
    <th>Inschrijving</th>
    <th>Bevestigd</th>
    <th>Op</th>
    <?php if ((date('Y-m-d') <= $event['Event']['event_date_end']) and $loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
      <th>Aktie</th>
    <?php endif; ?>
    <?php $extrafields = json_decode($event['Event']['subscribe_extra']); ?>
    <?php foreach ($extrafields as $extrafield) : ?>
      <th><?=mb_convert_encoding(ucfirst($extrafield->code), "Windows-1252", "UTF-8")?></th>
    <?php endforeach; ?>
    <th>Opmerking</th>
  </tr>
  <?php foreach ($event['Subscription'] as $subscription) : ?>
    <tr>
      <!--<td><?=$event['Event']['name']?></td>-->
      <!--<td><?=$event['Event']['season']?></td>-->
      <!--<td><?=$subscription['substitle']?></td>-->
      <!--<td><?=$subscription['subshash']?></td>-->
      <td><?=$subscription['subsname']?></td>
      <td><?=$subscription['subsemail']?></td>
      <td><?=$subscription['created']?></td>
      <!--<td><?=($subscription['confirmed']) ? 'ja' : 'neen'?></td>-->
      <td class="text-center"><?=($subscription['confirmed']) ? '<span class="glyphicon glyphicon-check icon-success"></span>' : ''?></td>
      <td><?=$subscription['confirmed_stamp']?></td>
      <?php if ((date('Y-m-d') <= $event['Event']['event_date_end']) and $loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
        <td>
          <?php if ($subscription['confirmed'] == true) : ?>
            <?=$this->Html->link('Annuleer', array('controller' => 'subscriptions', 'action' => 'cancelSubscription', $subscription['id'], $subscription['subshash']), array('class' => 'boldlink'))?>
          <?php else : ?>
            <?=$this->Html->link('Bevestig', array('controller' => 'subscriptions', 'action' => 'reconfirmSubscription', $subscription['id'], $subscription['subshash']), array('class' => 'boldlink'))?>
          <?php endif; ?>
        </td>
      <?php endif; ?>
      <!--<td><?=$subscription['extra']?></td>-->
      <?php $extras = json_decode($subscription['extra']); ?>
      <?php foreach ($extras as $extrakey => $extravalue) : ?>
        <td><?=mb_convert_encoding($extravalue, "Windows-1252", "UTF-8")?></td>
      <?php endforeach; ?>
      <td><?=$subscription['remark']?></td>
    </tr>
  <?php endforeach; ?>
</table>
<br/>
<?php
 //pr($event);
 //pr($extras);
?>
