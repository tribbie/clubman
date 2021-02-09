<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?= $this->Html->charset()."\n" ?>
	<title><?= (isset($cmclub['name']) ? $cmclub['name'] . ' - ' : 'Clubman') ?>, <?= (isset($cmclub['motto']) ? $cmclub['motto'] . ' - ' : 'Club') ?>: <?= $title_for_layout ?></title>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<?= $this->Html->css('clubman.logoonly')."\n"; ?>
</head>
<body>

<?php
// echo $this->Html->image((isset($cmclub['logo']) ? "/img/".$cmclub['logo'] : "/img/sports.png"),  array('id' => 'logo', 'url' => array('controller' => 'pages', 'action' => 'display', 'home'),  'alt' => (isset($cmclub['name']) ? $cmclub['name'] . ' - ' : 'Clubman'), 'width' => '100'));
?>
<a href="<?=$cmclub['clubweb']['home']?>/" title="naar de hoofdpagina">
	<img src="<?= (isset($cmclub['logo']) ? $this->base."/img/".$cmclub['logo'] : $this->base."/img/sports.png") ?>" id="logo" alt="<?= (isset($cmclub['name']) ? $cmclub['name'] : 'Clubman') ?>"  width="100">
</a>
<?php
 echo $content_for_layout;
?>

</body>
</html>
