<h2><?= (isset($cmclub['name']) ? $cmclub['name'] . ' - ' : 'Club') ?> Nieuws</h2>

<div class='row'>
  <div class="col-sm-2"></div>
  <div class="col-sm-8">

    <div class="panel panel-default">

      <div class="panel-heading">
        <?=$cmclub['name']?> nieuwsberichten
      </div>

      <div class="list-group">
        <?php $theSeason = $currentSeason; ?>
        <?php foreach ($newsitems as $newsitem) : ?>
          <?php if ($newsitem['Newsitem']['status'] == "public") : ?>
            <?php if (($newsitem['Newsitem']['season'] <> $currentSeason) and ($newsitem['Newsitem']['season'] <> $theSeason)) : ?>
              <?php $theSeason = $newsitem['Newsitem']['season']; ?>
              <div class='list-group-item list-group-item-info'>
                Seizoen <?=$newsitem['Newsitem']['season']?>
              </div>
            <?php endif; ?>
            <a href="<?=$this->Html->url(array("controller" => "newsitems", "action" => "view", $newsitem['Newsitem']['name']));?>" class="list-group-item">
              <h4 class="list-group-item-heading"><?=$newsitem['Newsitem']['title']?></h4>
              <p class="list-group-item-text"><?=$newsitem['Newsitem']['subtitle']?></p>
              <p class="list-group-item-text text-right small"><?=$newsitem['Newsitem']['author']?> - <?=$newsitem['Newsitem']['itemdate_nice']?></p>
            </a>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>

    </div>

  </div><!-- /.col-sm-8 -->
  <div class="col-sm-2"></div>
</div><!-- /.row -->


<?php
//  pr($newsitems);
?>
