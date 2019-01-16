<!-- app/View/Members/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> lid: <?=$member['Member']['name']?></h2>

<?php if ($member['Member']['active'] == false) : ?>
	<h3>Opgelet! Dit lid is momenteel NIET MEER actief!</h3>
<?php endif ; ?>

<div class="row">

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) : ?>
					Foto's
					<span class='pull-right'><?=$this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'picture'))?></span>
				<?php else : ?>
					Licentie
				<?php endif ; ?>
			</div>
			<div class="panel-body">
				<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) : ?>
					<div class="row">
						<div class="col-sm-8">
							<?php if (isset($member['Picturelicense']['location'])) : ?>
								<?= $this->Html->image($member['Picturelicense']['location'], array('title' => 'VVB licentie', 'class' => 'img-responsive'))?>
							<?php else : ?>
								<?= $this->Html->image('cmstyle/no_license_scan.png', array('title' => 'no image', 'class' => 'img-responsive'))?>
							<?php endif; ?>
						</div>
						<div class="col-sm-4">
							<?php if (isset($member['Picture']['location'])) : ?>
								<?=$this->Html->image($member['Picture']['location'], array('title' => $member['Member']['name'], 'class' => 'img-responsive'))?>
							<?php else : ?>
								<?=$this->Html->image('cmstyle/no_picture.png', array('title' => 'no image', 'class' => 'img-responsive'))?>
							<?php endif; ?>
						</div>
					</div>
				<?php else : ?>
					<?php if (isset($member['Picturelicense']['location'])) : ?>
						<?=$this->Html->image($member['Picturelicense']['location'], array('title' => 'VVB licentie', 'class' => 'img-responsive'))?>
					<?php else : ?>
						<?=$this->Html->image('cmstyle/no_license_scan.png', array('title' => 'no image', 'class' => 'nonono-img-responsive'))?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				Algemeen
					<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) : ?>
						<span class='pull-right'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'general'))?></span>
					<?php endif ; ?>
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Naam</dt>				<dd><?=$member['Member']['name']?></dd>
					<dt>Geboren</dt>		<dd><?=$member['Member']['birthdate_nice']?></dd>
					<dt>E-mail</dt>			<dd><?=$member['Member']['email']?></dd>
					<dt>Telefoon</dt>		<dd><?=$member['Member']['tel']?></dd>
					<dt>Adres</dt>			<dd><?=$member['Member']['address']?></dd>
					<dt>Gemeente</dt>		<dd><?=$member['Member']['postcode'];?> <?=$member['Member']['city']?></dd>
					<dt>RR nummer</dt>	<dd><?=$member['Member']['nationalnumber']?></dd>
					<dt>Actief</dt>			<dd><?=($member['Member']['active'] ? 'yep' : 'nope')?></dd>
					<dt>aka</dt>				<dd><?=$member['Member']['nickname']?></dd>
				</dl>
			</div>
		</div>
	</div>

</div>

<div class="row">

	<div class="col-md-6">
		<div class="panel panel-info">
		  <div class="panel-heading">
				Contact mama
					<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) : ?>
						<span class='pull-right'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'contact'))?></span>
					<?php endif ; ?>
			</div>
		  <div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Naam</dt>			<dd><?=$member['Member']['mom_name']?></dd>
					<dt>E-mail</dt>		<dd><?=$member['Member']['mom_email']?></dd>
					<dt>Telefoon</dt>	<dd><?=$member['Member']['mom_tel']?></dd>
					<dt>Adres</dt>		<dd><?=$member['Member']['mom_address']?></dd>
					<dt>Gemeente</dt>	<dd><?=$member['Member']['mom_postcode']?> <?=$member['Member']['mom_city']?></dd>
				</dl>
		  </div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-info">
		  <div class="panel-heading">
				Contact papa
					<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) : ?>
						<span class='pull-right'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'contact'))?></span>
					<?php endif ; ?>
			</div>
		  <div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Naam</dt>			<dd><?=$member['Member']['dad_name']?></dd>
					<dt>E-mail</dt>		<dd><?=$member['Member']['dad_email']?></dd>
					<dt>Telefoon</dt>	<dd><?=$member['Member']['dad_tel']?></dd>
					<dt>Adres</dt>		<dd><?=$member['Member']['dad_address']?></dd>
					<dt>Gemeente</dt>	<dd><?=$member['Member']['dad_postcode']?> <?=$member['Member']['dad_city']?></dd>
				</dl>
		  </div>
		</div>
	</div>

</div>


<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'memberadmin', 'trainer']))) : ?>
	<div class="row">

		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					Team info
					<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) : ?>
						<span class='pull-right'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'team'))?></span>
					<?php endif ; ?>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Licentie</dt>	<dd><?=$member['Member']['licensenumber'];?></dd>
						<?php if(count($member['Teammember']) > 0) : ?>
							<?php foreach ($member['Teammember'] as $teammember) : ?>
								<?php if ($teammember['season'] == $currentSeason) : ?>
									<!--<dt>Team <?=$teammember['teampriority'];?></dt><dd><?=$teammember['Team']['name'];?> (<?=$teammember['teamfunction'];?>)</dd> -->
									<dt><?=$teammember['teamfunction'];?></dt><dd><?=$teammember['Team']['shortname'];?><span class='pull-right'><?=$teampriorities[$teammember['teampriority']]?></span></dd>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else : ?>
							<dt>Team</dt><dd>-</dd>
						<?php endif; ?>
					</dl>
				</div>
			</div>
		</div>

		<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'memberadmin']))) : ?>
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
						Andere
							<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) : ?>
								<span class='pull-right'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'other'))?></span>
							<?php endif ; ?>
					</div>
					<div class="panel-body">
						<dl class="dl-horizontal">
							<dt>Rekeningnummer</dt><dd><?=$member['Member']['bank_account']?></dd>
							<dt>Type auto</dt>     <dd><?=$member['Member']['car_type']?></dd>
							<dt>Nummerplaat</dt>   <dd><?=$member['Member']['car_license']?></dd>
							<dt>Opmerking</dt>     <dd><?=$member['Member']['remark']?></dd>
						</dl>
					</div>
				</div>
			</div>
		<?php endif ; ?>

	</div>

<?php endif ; ?>


<div class="row">

	<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) : ?>

		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					Financieel
					<?php if($loggedIn) : ?>
						<span class='pull-right'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'finance'))?></span>
					<?php endif ; ?>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Lidgeld</dt>	<dd><?=$member['Member']['membershipfee']?></dd>
						<dt>Korting</dt>	<dd><?=$member['Member']['membershipfee_discount']?></dd>
						<dt>Voorschot</dt><dd><?=$member['Member']['membership_advancepaid_nice']?></dd>
						<dt>Saldo</dt>		<dd><?=$member['Member']['membership_balancepaid_nice']?></dd>
					</dl>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					Kamp
					<?php if($loggedIn) : ?>
						<span class='pull-right'><?= $this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $member['Member']['id'], 'finance'))?></span>
					<?php endif ; ?>
				</div>
				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>Op kamp</dt>	<dd><?=($member['Member']['camp'] ? 'yep' : 'nope')?></dd>
						<dt>Kampprijs</dt><dd><?=$member['Member']['campfee']?></dd>
						<dt>Voorschot</dt><dd><?=$member['Member']['camp_advance_nice']?></dd>
						<dt>Saldo</dt>		<dd><?=$member['Member']['camp_balance_nice']?></dd>
					</dl>
				</div>
			</div>
		</div>

	<?php endif ; ?>

</div>


<hr/>
<?php
	if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) {
		if ($member['Member']['active']) {
			echo $this->Html->link('Maak het lid inactief', array('controller' => 'members', 'action' => 'inactivate', $member['Member']['id']), array(), "Ben je zeker dat je het lid op inactief wil zetten?")."\n";
			echo '<br/>'."\n";
		} else {
			echo $this->Html->link('Maak het lid opnieuw actief', array('controller' => 'members', 'action' => 'reactivate', $member['Member']['id']), array(), "Ben je zeker dat je het lid opnieuw actief wil zetten?")."\n";
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
