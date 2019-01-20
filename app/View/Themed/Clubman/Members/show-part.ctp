<!-- app/View/Members/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> lid: <?=$member['Member']['name'];?></h2>
<?php if ($member['Member']['active'] == false) : ?>
	<h3>Opgelet! Dit lid is momenteel NIET MEER actief!</h3>
<?php endif ; ?>

<div class='blockview memberview' id='memberlicense'>
	<h4>Licentie</h4>
	<?php if (isset($member['Picturelicense']['location'])) : ?>
		<?= $this->Html->image($member['Picturelicense']['location'], array('title' => 'VVB licentie', 'class' => 'imgright', 'width' => '380')); ?>
	<?php else : ?>
		<?= $this->Html->image('cmstyle/no_license_scan.png', array('title' => 'no image', 'class' => 'imgright', 'width' => '380')); ?>
	<?php endif; ?>
</div>

<div class='crlf'></div>

<div class='blockview memberview' id='membergeneralinfo'>
	<h4>Algemeen</h4>
	<dl class="dl-horizontal">
		<dt>Naam</dt>		<dd><?=$member['Member']['name'];?></dd>
		<dt>Geboren</dt>	<dd><?=$member['Member']['birthdate_nice'];?></dd>
		<dt>E-mail</dt>		<dd><?=$member['Member']['email'];?></dd>
		<dt>Telefoon</dt>	<dd><?=$member['Member']['tel'];?></dd>
		<dt>Adres</dt>		<dd><?=$member['Member']['address'];?></dd>
		<dt>Gemeente</dt>	<dd><?=$member['Member']['postcode'];?> <?=$member['Member']['city'];?></dd>
		<dt>RR nummer</dt>	<dd><?=$member['Member']['nationalnumber'];?></dd>
		<dt>Actief</dt>		<dd><?=($member['Member']['active'] ? 'yep' : 'nope');?></dd>
		<dt>aka</dt>		<dd><?=$member['Member']['nickname'];?></dd>
	</dl>
</div>

<div class='crlf'></div>

<div class='blockview memberview' id='membercontactinfo'>
	<h4>Contact mama</h4>
	<dl class="dl-horizontal">
		<dt>Naam</dt>		<dd><?=$member['Member']['mom_name'];?></dd>
		<dt>E-mail</dt>		<dd><?=$member['Member']['mom_email'];?></dd>
		<dt>Telefoon</dt>	<dd><?=$member['Member']['mom_tel'];?></dd>
		<dt>Adres</dt>		<dd><?=$member['Member']['mom_address'];?></dd>
		<dt>Gemeente</dt>	<dd><?=$member['Member']['mom_postcode'];?> <?=$member['Member']['mom_city'];?></dd>
	</dl>
	<h4>Contact papa</h4>
	<dl class="dl-horizontal">
		<dt>Naam</dt>		<dd><?=$member['Member']['dad_name'];?></dd>
		<dt>E-mail</dt>		<dd><?=$member['Member']['dad_email'];?></dd>
		<dt>Telefoon</dt>	<dd><?=$member['Member']['dad_tel'];?></dd>
		<dt>Adres</dt>		<dd><?=$member['Member']['dad_address'];?></dd>
		<dt>Gemeente</dt>	<dd><?=$member['Member']['dad_postcode'];?> <?=$member['Member']['dad_city'];?></dd>
	</dl>
</div>

<div class='crlf'></div>
<br/ >

<hr/>
<?php
if ($loggedIn) {
	echo $this->Html->link('Terug naar overzicht', array('controller' => 'members', 'action' => 'index'))."\n";
}
?>

<?php
// pr($member);
?>
