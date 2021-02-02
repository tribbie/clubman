<h2><?= (isset($cmclub['name']) ? $cmclub['name'] . ' - ' : 'Club') ?> Nieuws</h2>

<div class='row'>

  <?php foreach ($newsitems as $newsitem) : ?>
    <?php if ($newsitem['Newsitem']['status'] == "public") : ?>

      <div class="col-sm-6 col-lg-4 card-group">
        <div class="card">
          <a href="<?=$this->Html->url(array("controller" => "newsitems", "action" => "view", $newsitem['Newsitem']['name']));?>">
            <img class="card-img-top" src="https://picsum.photos/253/?random=<?=$newsitem['Newsitem']['id']?>">
          </a>
          <div class="card-body">
            <h4 class="card-title"><?=$newsitem['Newsitem']['title']?></h4>
            <p class="card-text"><?=$newsitem['Newsitem']['subtitle']?></p>
          </div>
          <div class="card-footer">
            <small class="text-muted"><?=$newsitem['Newsitem']['author']?> - <?=$newsitem['Newsitem']['itemdate_nice']?></small>
          </div>
        </div>
      </div>

    <?php endif; ?>
  <?php endforeach; ?>

</div><!-- /.row -->


<?php
//  pr($newsitems);
?>
