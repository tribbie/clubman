<!DOCTYPE html>
<html lang="nl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="<?=(isset($cmclub['title']) ? $cmclub['title'] : 'ClubWeb')?>">
  <meta name="author" content="Bart Seghers">
  <meta name="keyword" content="clubweb<?=(isset($cmclub['metatags']) ? ', ' . $cmclub['metatags'] : '')?>">
  <meta name="robots" content="index, follow">
  <link rel="icon" href="<?=$this->base?>/<?=(isset($cmclub['favicon']) ? $cmclub['favicon'] : 'favicon.ico')?>">

  <title><?=(isset($cmclub['name']) ? $cmclub['name'] : 'Clubman')?></title>
  <?=$this->Html->css('club.main.bootstrap4')."\n"?>
  <?=$this->fetch('meta')?>
  <?=$this->fetch('css')?>
  <?=$this->fetch('script')?>
  <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
  <!--<link rel="stylesheet" type="text/css" href="<?=$cmclub['clubweb']['bootstraptheme']?>">-->
  <!--<link rel="stylesheet" type="text/css" href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css">-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

  <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
      <div class="container">
        <a class="navbar-brand" href="<?=$cmclub['clubweb']['home']?>/" title="naar de hoofdpagina">
          <img class="d-inline-block align-top clubman-navlogo" src="<?= (isset($cmclub['logo']) ? $this->base."/img/".$cmclub['logo'] : $this->base."/img/sports.png") ?>" alt="logo" height="50">
          <?= (isset($cmclub['name']) ? $cmclub['name'] : "Clubman") ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-clubman-main" aria-controls="navbar-clubman-main" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-clubman-main">

          <!-- vanaf hier ons menu -->
          <?=$this->element('topmenu-bootstrap4');?>
          <!-- tot hier ons menu -->

        </div>
      </div>
    </nav>
  <!-- /.navbar -->

  <!-- Page Content -->
    <div class="container">

      <div class="row">
        <div class="col-md-9">
          <div id="mainblock">
            <?=$this->Flash->render()?>
      			<?=$this->fetch('content')?>
          </div><!-- mainblock -->
        </div>
        <div class="col-md-3">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
              <?=$this->element('weekcalendar-bootstrap4');?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
              <?=$this->element('events-bootstrap4');?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
              <!--
              next line also lists the individual newsitems, but they are already shown on the main screen
              this->element('news')
              -->
              <!-- Only a link to all newsitems -->
              <div class="card">
                <div class="card-header">
                  <a href="<?=$this->base?>/nieuws" class="boldlink" title="al ons nieuws">nieuws</a>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
              <?=$this->element('magazines-bootstrap4');?>
            </div>
          </div>
        </div>
      </div>

    </div>
  <!-- /.container -->

  <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <!-- Bootstrap Core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<?php
  // pr($cmmenuMerged);
  // pr($clubmanteams);
  // pr($magazines);
  // echo "<div class='well'>version: " . $cakeversion ."</div>";
?>

</body>
</html>
