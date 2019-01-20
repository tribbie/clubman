<!-- app/View/Members/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> lid: <?=$member['Member']['name'];?></h2>
<?php if ($member['Member']['active'] == false) : ?>
	<h3>Opgelet! Dit lid is momenteel NIET MEER actief!</h3>
<?php endif ; ?>

<div class='blockview memberview' id='memberimages'>
	<h4>Foto's
		<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin', 'memberfinance', 'memberedit']))) : ?>
			<span class='actionright'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'picture'))."\n"; ?></span>
		<?php endif ; ?>
	</h4>

	<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin', 'memberfinance', 'memberedit']))) : ?>
		<?php if (isset($member['Picture']['location'])) : ?>
			<?= $this->Html->image($member['Picture']['location'], array('title' => $member['Member']['name'], 'class' => 'imgright', 'height' => '160')); ?>
		<?php else : ?>
			<?= $this->Html->image('cmstyle/no_picture.png', array('title' => 'no image', 'class' => 'imgright', 'height' => '160')); ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php if (isset($member['Picturelicense']['location'])) : ?>
		<?= $this->Html->image($member['Picturelicense']['location'], array('title' => 'VVB licentie', 'class' => 'imgright', 'height' => '160')); ?>
	<?php else : ?>
		<?= $this->Html->image('cmstyle/no_license_scan.png', array('title' => 'no image', 'class' => 'imgright', 'height' => '160')); ?>
	<?php endif; ?>
</div>

<div class='blockview memberview' id='membergeneralinfo'>
	<h4>Algemeen
		<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin', 'memberfinance', 'memberedit']))) : ?>
			<span class='actionright'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'general'))."\n"; ?></span>
		<?php endif ; ?>
	</h4>
	<dl class="dl-horizontal">
		<dt>Naam</dt>				<dd><?=$member['Member']['name'];?></dd>
		<dt>Geboren</dt>		<dd><?=$member['Member']['birthdate_nice'];?></dd>
		<dt>E-mail</dt>			<dd><?=$member['Member']['email'];?></dd>
		<dt>Telefoon</dt>		<dd><?=$member['Member']['tel'];?></dd>
		<dt>Adres</dt>			<dd><?=$member['Member']['address'];?></dd>
		<dt>Gemeente</dt>		<dd><?=$member['Member']['postcode'];?> <?=$member['Member']['city'];?></dd>
		<dt>RR nummer</dt>	<dd><?=$member['Member']['nationalnumber'];?></dd>
		<dt>Actief</dt>			<dd><?=($member['Member']['active'] ? 'yep' : 'nope');?></dd>
		<dt>aka</dt>				<dd><?=$member['Member']['nickname'];?></dd>
	</dl>
</div>

<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin', 'memberfinance', 'memberedit']))) : ?>
	<div class='blockview memberview' id='memberteaminfo'>
		<h4>Team info
			<?php if($loggedIn) : ?>
				<span class='actionright'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'team'))."\n"; ?></span>
			<?php endif ; ?>
		</h4>
		<dl class="dl-horizontal">
			<dt>Licentie</dt>	<dd><?=$member['Member']['licensenumber'];?></dd>
			<?php if(count($member['Teammember']) > 0) : ?>
				<?php foreach ($member['Teammember'] as $teammember) : ?>
					<?php if ($teammember['season'] == $currentSeason) : ?>
						<!--		<dt>Team <?=$teammember['teampriority'];?></dt><dd><?=$teammember['Team']['name'];?> (<?=$teammember['teamfunction'];?>)</dd> -->
						<dt><?=$teammember['teamfunction'];?></dt><dd><?=$teammember['Team']['shortname'];?><span class='floatright'><?=$teampriorities[$teammember['teampriority']];?></span></dd>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php else : ?>
				<dt>Team</dt>		<dd>-</dd>
			<?php endif; ?>
		</dl>
	</div>
<?php endif; ?>

<div class='crlf'></div>

<div class='blockview memberview' id='membercontactinfo'>
	<h4>Contact mama
		<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin', 'memberfinance', 'memberedit']))) : ?>
			<span class='actionright'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'contact'))."\n"; ?></span>
		<?php endif ; ?>
	</h4>
	<dl class="dl-horizontal">
		<dt>Naam</dt>		<dd><?=$member['Member']['mom_name'];?></dd>
		<dt>E-mail</dt>		<dd><?=$member['Member']['mom_email'];?></dd>
		<dt>Telefoon</dt>	<dd><?=$member['Member']['mom_tel'];?></dd>
		<dt>Adres</dt>		<dd><?=$member['Member']['mom_address'];?></dd>
		<dt>Gemeente</dt>	<dd><?=$member['Member']['mom_postcode'];?> <?=$member['Member']['mom_city'];?></dd>
	</dl>
	<h4>Contact papa
		<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin', 'memberfinance', 'memberedit']))) : ?>
			<span class='actionright'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'contact'))."\n"; ?></span>
		<?php endif ; ?>
	</h4>
	<dl class="dl-horizontal">
		<dt>Naam</dt>		<dd><?=$member['Member']['dad_name'];?></dd>
		<dt>E-mail</dt>		<dd><?=$member['Member']['dad_email'];?></dd>
		<dt>Telefoon</dt>	<dd><?=$member['Member']['dad_tel'];?></dd>
		<dt>Adres</dt>		<dd><?=$member['Member']['dad_address'];?></dd>
		<dt>Gemeente</dt>	<dd><?=$member['Member']['dad_postcode'];?> <?=$member['Member']['dad_city'];?></dd>
	</dl>
</div>

<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin', 'memberfinance', 'memberedit']))) : ?>
	<div class='blockview memberview' id='memberfinanceinfo'>
		<h4>Financieel
			<?php if($loggedIn) : ?>
				<span class='actionright'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'finance'))."\n"; ?></span>
			<?php endif ; ?>
		</h4>
		<dl class="dl-horizontal">
			<dt>Lidgeld</dt>	<dd><?=$member['Member']['membershipfee'];?></dd>
			<dt>Korting</dt>	<dd><?=$member['Member']['membershipfee_discount'];?></dd>
			<dt>Voorschot</dt>	<dd><?=$member['Member']['membership_advancepaid_nice'];?></dd>
			<dt>Saldo</dt>		<dd><?=$member['Member']['membership_balancepaid_nice'];?></dd>
		</dl>
		<h4>Kamp
			<?php if($loggedIn) : ?>
				<span class='actionright'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'finance'))."\n"; ?></span>
			<?php endif ; ?>
		</h4>
		<dl class="dl-horizontal">
			<dt>Op kamp</dt>	<dd><?=($member['Member']['camp'] ? 'yep' : 'nope');?></dd>
			<dt>Kampprijs</dt>	<dd><?=$member['Member']['campfee'];?></dd>
			<dt>Voorschot</dt>	<dd><?=$member['Member']['camp_advance_nice'];?></dd>
			<dt>Saldo</dt>		<dd><?=$member['Member']['camp_balance_nice'];?></dd>
		</dl>
	</div>
<?php endif ; ?>

<div class='crlf'></div>
<br/ >

<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin', 'memberfinance', 'memberedit']))) : ?>
	<div class='blockview memberview' id='memberotherinfo'>
		<h4>Andere
			<?php if($loggedIn) : ?>
				<span class='actionright'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'other'))."\n"; ?></span>
			<?php endif ; ?>
		</h4>
		<dl class="dl-horizontal">
			<dt>Opmerking</dt>	<dd><?=$member['Member']['remark'];?></dd>
		</dl>
	</div>
<?php endif ; ?>

<div class='crlf'></div>
<br/>

<hr/>
<?php
if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin', 'memberfinance', 'memberedit']))) {
	if ($member['Member']['active']) {
		echo $this->Html->link('Maak het lid inactief', array('controller' => 'members', 'action' => 'inactivate', $member['Member']['id']), array(), "Ben je zeker dat je het lid op inactief wil zetten?")."\n";
		echo '<br/>'."\n";
	}
	echo $this->Html->link('Wijzig lid', array('controller' => 'members', 'action' => 'edit', $member['Member']['id']))."\n";
	echo '<br/>'."\n";
}
echo $this->Html->link('Terug naar overzicht', array('controller' => 'members', 'action' => 'index'))."\n";
?>

<?php
// pr($member);
?>
