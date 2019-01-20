<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<title><?=$title_for_layout?></title>
</head>
<body>
	<img src="<?=FULL_BASE_URL?><?=$this->base?>/img/club_logo.png">
	<div class="container">
	<?=$this->fetch('content')?>
	</div>
</body>
</html>
