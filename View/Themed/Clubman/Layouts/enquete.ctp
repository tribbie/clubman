<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?=$this->Html->charset()?>
	<title><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?>:<?=$title_for_layout?></title>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<?=$this->Html->meta('icon')?>
	<?=$this->Html->css('clubman.enquete')?>
	<?=$this->fetch('meta')?>
	<?=$this->fetch('css')?>
	<?=$this->fetch('script')?>
	<style type="text/css" id="includedfromcakephp">
		body { width: 80%; margin: auto;}
		span.pageheader { font-size: 300%; color: #558; padding-bottom: 5px; margin: auto;}
		div.sectie { border: solid 2px #eef; padding: 10px; }
		h1 { font-size: 200%; border-top: solid 5px #558; color: #558; background-color: #eef; margin-top: 5px; }
		h2 { font-size: 150%; border-top: solid 10px #ff7; color: #66a; background-color: #eef; margin-top: 10px; margin-bottom: 0; padding-left: 10px; }
		div.select label { float: left; width: 380px; margin-right: 10px; }
		div.attention { border: solid 2px #c55; padding: 10px; }
		div.attention span.valop { color: #c55; }
	</style>
</head>
<body>
	<?=$this->Html->image((isset($cmclub['logo']) ? $cmclub['logo'] : "clubman_sports.png"), array("width" => "72", "alt" => $cmclub['name'], 'url' => '/'))?>
	<span class='pageheader' style='padding-left: 15px;'><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> Enquête</span> van seizoen <?=$enqueteSeason?>
	<?=$content_for_layout?>

</body>
</html>
