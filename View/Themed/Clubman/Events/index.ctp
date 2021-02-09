<!-- app/View/Events/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> evenementen</h2>

<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
  <?=$this->Html->link("Nieuw evenement", array('controller' => 'events', 'action' => 'add'))?>
<?php endif; ?>

<hr/>

<div class='row'>
  <div class="col-sm-12">

    <div class="table-responsive">
      <table class="table table-striped table-condensed normalelijst">
        <tr class='groupheader info'>
          <th>title</th>
          <th class="text-right">date from</th>
          <th class="text-right">to</th>
          <th>category</th>
          <th class="text-center">for</th>
          <th class="text-right">publish from</th>
          <th class="text-right">to</th>
          <th>status</th>
          <th>subscriptions</th>
          <?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
            <th>action</th>
          <?php endif; ?>
        </tr>
        <?php foreach ($events as $event) : ?>
          <tr id="event-<?=$event['Event']['title']?>">
            <td><?=$this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'view', $event['Event']['name'], $event['Event']['year']), array('class' => 'boldlink'))?></td>
            <td class="text-right"><?=$event['Event']['event_date_start_nice']?></td>
            <td class="text-right"><?=$event['Event']['event_date_end_nice']?></td>
            <td><?=$event['Event']['category']?></td>
            <td class="text-center"><?=$event['Event']['target_public']?></td>
            <td class="text-right"><?=$event['Event']['publish_date_start_nice']?></td>
            <td class="text-right"><?=$event['Event']['publish_date_end_nice']?></td>
            <td><?=$event['Event']['status']?></td>
            <?php if ($event['Event']['subscribe_able']) : ?>
              <td>
                <?=$this->Html->link('<span class="glyphicon glyphicon-list"></span>', array('controller' => 'subscriptions', 'action' => 'listevent', $event['Event']['id']), array('title' => 'toon lijst', 'escape' => false))?>
                <?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
                  <?=$this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span>', array('controller' => 'subscriptions', 'action' => 'subscribe', $event['Event']['id']), array('title' => 'schrijf in', 'escape' => false))?>
                <?php endif; ?>
              </td>
            <?php else : ?>
              <td>
              </td>
            <?php endif ; ?>
            <?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
              <td><?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'events', 'action' => 'edit', $event['Event']['id']), array('title' => 'wijzig dit evenement', 'escape' => false))?></td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>

  </div>
</div>

<?php
//  pr($events);
?>
