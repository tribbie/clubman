<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
	$clubmanWebsite = '/';
	$clubmanTitle = 'clubman';
	$clubmanSubtitle = 'your club management';
	$clubTitle = (isset($cmclub['name']) ? $cmclub['name'] : 'Clubman');
	$clubSubtitle = (isset($cmclub['motto']) ? $cmclub['motto'] : 'club managemnt');
?>
	<?= $this->Html->charset()."\n"; ?>
	<title><?= $clubTitle ?>, <?= $clubSubtitle ?>: <?= $title_for_layout; ?></title>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<?= $this->Html->css('clubman.logoonly')."\n"; ?>
</head>
<body>

	<?php
	 echo $this->Html->image((isset($cmclub['logo']) ? "/img/".$cmclub['logo'] : "/img/sports.png"),  array('id' => 'logo', 'url' => array('controller' => 'pages', 'action' => 'display', 'home'),  'alt' => (isset($cmclub['name']) ? $cmclub['name'] . ' - ' : 'Clubman'), 'width' => '100'));
	 echo $content_for_layout;
	?>

</body>
</html>
