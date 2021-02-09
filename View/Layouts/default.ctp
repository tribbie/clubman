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
   <?=$this->Html->css('club.main')."\n"?>
  <!-- <?=$this->Html->css('base.css')?> -->
  <!-- <?=$this->Html->css('cake.css')?> -->
  <?=$this->fetch('meta')?>
  <?=$this->fetch('css')?>
  <?=$this->fetch('script')?>
  <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
  <link rel="stylesheet" type="text/css" href="<?=$cmclub['clubweb']['bootstraptheme']?>">
  <!--<link rel="stylesheet" type="text/css" href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css">-->

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
          		<!--<?=$this->element('topmenu');?>-->
          		<!-- tot hier ons menu -->
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
        <?php
          if (isset($cmclub['colors'])) {
            foreach ($cmclub['colors'] as $divcolor) {
              echo '<div style="border: solid 2px '.$divcolor.'"></div>';
            }
          }
        ?>
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
      </div>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
    	$(document).ready(function() {
    		$('#focusme').focus();
    	});
    </script>

</body>
</html>
