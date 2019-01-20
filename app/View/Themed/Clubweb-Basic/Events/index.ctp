<h2><?= (isset($cmclub['name']) ? $cmclub['name'] . ' - ' : 'Club') ?> Evenementen</h2>

<div class='row'>
  <div class="col-sm-2"></div>
  <div class="col-sm-8">

    <div class="panel panel-default">

      <div class="panel-heading">
        <?=$cmclub['name']?> evenementen
      </div>

      <div class="list-group">
        <?php $theSeason = $currentSeason; ?>
        <?php foreach ($events as $event) : ?>
          <?php if ($event['Event']['status'] == "public") : ?>
            <?php if (($event['Event']['season'] <> $currentSeason) and ($event['Event']['season'] <> $theSeason)) : ?>
              <?php $theSeason = $event['Event']['season']; ?>
              <div class='list-group-item list-group-item-info'>
                Seizoen <?=$event['Event']['season']?>
              </div>
            <?php endif; ?>
            <a href="<?=$this->Html->url(array("controller" => "events", "action" => "view", $event['Event']['name'], $event['Event']['year']));?>" class="list-group-item">
              <h4 class="list-group-item-heading"><?=$event['Event']['title']?></h4>
              <p class="list-group-item-text"><?=$event['Event']['subtitle']?></p>
            </a>
            <?php if ($loggedIn) : ?>
              --
              (<?=$this->Html->link('overzicht inschrijvingen', array('controller' => 'subscriptions', 'action' => 'listevent', $event['Event']['id']), array('class' => 'boldlink'))?>)
            <?php endif ; ?>
          <?php endif ; ?>
        <?php endforeach; ?>
      </div>

    </div>

  </div><!-- /.col-sm-8 -->
  <div class="col-sm-2"></div>
</div><!-- /.row -->

<?php
//  pr($events);
?>
