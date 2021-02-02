<!DOCTYPE html>
<html lang="nl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="<?=(isset($cmclub['title']) ? $cmclub['title'] : 'Clubman')?>">
  <meta name="author" content="Bart Seghers">
  <meta name="keyword" content="clubman<?=(isset($cmclub['metatags']) ? ', ' . $cmclub['metatags'] : '')?>">
  <meta name="robots" content="index, follow">
  <link rel="icon" href="<?=$this->base?>/<?=(isset($cmclub['favicon']) ? $cmclub['favicon'] : 'favicon.ico')?>">

  <title><?=(isset($cmclub['name']) ? $cmclub['name'] : 'Clubman')?></title>
  <?=$this->Html->css('clubman.main')."\n"?>
  <?=$this->fetch('meta')?>
  <?=$this->fetch('css')?>
  <?=$this->fetch('script')?>
  <!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">-->
  <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css">
  <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?=$cmclub['clubman']['bootstraptheme']?>">
  <link rel="stylesheet" type="text/css" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">

  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.12/vue.min.js"></script>-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.28/vue.min.js"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <!-- Summernote - embeddable wysiwyg editor -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#focusme').focus();
    });
  </script>

</head>
<body style="padding-top: 70px;">

  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <span>
                  <span>
                    <a class="pull-left" href="<?=$this->base?>/" title="naar de hoofdpagina">
                      <img class="clubman-navlogo" src="<?= (isset($cmclub['logo']) ? $this->base."/img/".$cmclub['logo'] : $this->base."/img/sports.png") ?>" alt="logo" height="50">
                    </a>
                    <a class="navbar-brand" href="<?=$this->base?>/" title="<?=$cmclub['motto']?>">
                      <?= (isset($cmclub['name']) ? $cmclub['name'] : "Clubman") ?>
                    </a>
                  </span>
              </span>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- vanaf hier ons menu -->
            <?=$this->element('topmenu');?>
            <!-- tot hier ons menu -->
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container -->
      <?php if (isset($cmclub['colors'])) : ?>
        <?php foreach ($cmclub['colors'] as $divcolor) : ?>
            <div style="border: solid 2px <?=$divcolor?>"></div>
        <?php endforeach; ?>
      <?php endif; ?>
  </nav>
  <!-- /.navbar -->


  <!-- Page Content -->
  <div class="container">

    <?=$this->Flash->render();?>
		<?=$this->fetch('content')?>

  </div>
  <!-- /.container -->

  <?php if (isset($cmclub['colors'])) : ?>
    <?php foreach ($cmclub['colors'] as $divcolor) : ?>
      <div style="border: solid 2px <?=$divcolor?>"></div>
    <?php endforeach; ?>
  <?php else : ?>
    <hr/>
  <?php endif; ?>
  <div class="container text-muted" id="footer">
      <span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span> Clubman
      -
      seizoen: <?=$currentSeason?>
      -
      user: <?= ($loggedIn) ? $currentUser['username'] . ' = ' . $currentUser['role'] : 'not logged in'; ?>
  </div>



<?php
  // echo('<hr/>');
  // echo('<hr/>current user<br/>');
  // pr($currentUser);
  // echo('<hr/>current acl<br/>');
  // pr($cmaclrequest);
  // pr($currentClub);
  // pr($cmmenuMerged);
  // pr($clubmanteams);
  // pr($magazines);
  // echo "<div class='well'>version: " . $cakeversion ."</div>";
?>

</body>
</html>
