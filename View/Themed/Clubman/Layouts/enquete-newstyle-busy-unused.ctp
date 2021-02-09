<!DOCTYPE html>
<html lang="nl" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="<?=(isset($cmclub['title']) ? $cmclub['title'] : 'Clubman')?>">
  <meta name="author" content="Bart Seghers">
  <meta name="keyword" content="clubman<?=(isset($cmclub['metatags']) ? ', ' . $cmclub['metatags'] : '')?>">
  <meta name="robots" content="noarchive,noindex,nofollow">
  <link rel="icon" href="<?=$this->base?>/<?=(isset($cmclub['favicon']) ? $cmclub['favicon'] : 'favicon.ico')?>">

	<title><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?>:<?=$title_for_layout?></title>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<?=$this->Html->meta('icon')?>
  <?=$this->Html->css('clubman.main')."\n"?>
  <?=$this->fetch('meta')?>
  <?=$this->fetch('css')?>
  <?=$this->fetch('script')?>

	<style type="text/css" id="includedfromcakephp">
		span.pageheader { font-size: 250%; padding-bottom: 5px; margin: auto;}
		div.attention { border: solid 2px #c55; padding: 10px; }
		div.attention span.valop { color: #c55; }
	</style>

  <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
  <link rel="stylesheet" type="text/css" href="<?=$cmclub['clubman']['bootstraptheme']?>">
  <link rel="stylesheet" type="text/css" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.12/vue.min.js"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#focusme').focus();
    });
  </script>

</head>
<body style="padding-top: 70px;">

  <!-- Page Content -->
  <div class="container">

		<?=$this->Html->image((isset($cmclub['logo']) ? $cmclub['logo'] : "clubman_sports.png"), array("width" => "72", "alt" => $cmclub['name'], 'url' => '/'))?>
		<span class='pageheader' style='padding-left: 15px;'><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> Enquête</span> van seizoen <?=$enqueteSeason?>

		<?php if (isset($cmclub['colors'])) : ?>
	    <?php foreach ($cmclub['colors'] as $divcolor) : ?>
	      <div style="border: solid 2px <?=$divcolor?>"></div>
	    <?php endforeach; ?>
	  <?php else : ?>
	    <hr/>
	  <?php endif; ?>

    <?=$this->Flash->render();?>
		<?=$this->fetch('content')?>

		<?php if (isset($cmclub['colors'])) : ?>
	    <?php foreach ($cmclub['colors'] as $divcolor) : ?>
	      <div style="border: solid 2px <?=$divcolor?>"></div>
	    <?php endforeach; ?>
	  <?php else : ?>
	    <hr/>
	  <?php endif; ?>

  </div>
  <!-- /.container -->

</body>
</html>
