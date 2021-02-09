<!-- app/View/Members/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> lid: <?= $membership['Person']['lastname'] ?> <?= $membership['Person']['firstname'] ?></h2>

<?php if ($membership['Membership']['active'] == false) : ?>
	<h3>Opgelet! Dit lid is momenteel NIET MEER actief!</h3>
<?php endif ; ?>

<div class="row">

	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="panel panel-info">
			<div class="panel-heading">
				Membership <?= $membership['Membership']['id'] ?> - <?= $membership['Person']['lastname'] ?> <?= $membership['Person']['firstname'] ?>
			</div>
			<div class="panel-body">
				blah
			</div>
			<div class="panel-body">
				<?= pr($membership) ?>
			</div>
		</div>
	</div>
	<div class="col-md-1"></div>

</div>
