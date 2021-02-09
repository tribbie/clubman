<!-- app/View/Members/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> lid: <?=$member['Migratemember']['name']?></h2>

<?php if ($member['Migratemember']['active'] == false) : ?>
	<h3>Opgelet! Dit lid is momenteel NIET MEER actief!</h3>
<?php endif ; ?>

<div class="row">

	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="panel panel-info">
			<div class="panel-heading">
				Migratemember <?= $member['Migratemember']['id'] ?> - <?= $member['Migratemember']['name'] ?>
			</div>
			<div class="panel-body">
<?= pr($member) ?>
			</div>
		</div>
	</div>
	<div class="col-md-1"></div>
	
</div>
