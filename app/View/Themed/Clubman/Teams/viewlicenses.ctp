<!-- app/View/Teams/viewlicenses.ctp -->
<h2>Licenties <?=$team['Team']['shortname']?></h2>

	<?php $itemcount = 0; ?>
	<?php foreach ($team['Teammember'] as $teammember) : ?>
		<?php if ($teammember['teampriority'] <> 99) : ?>
			<?php $itemcount += 1; ?>
			<?php if (($itemcount % 2) == 0) : ?>
				<div class="row">
			<?php endif; ?>
			<div class="col-md-6">
				<div class="panel panel-info">
				  <div class="panel-heading">
						<?=$teammember['Member']['name']?> (<?=$teammember['teamfunction']?>)
					</div>
					<ul class="list-group">
						<li class="list-group-item">
							<?php if (isset($teammember['Member']['Picturelicense']['location'])) : ?>
								<?=$this->Html->image($teammember['Member']['Picturelicense']['location'], array('title' => $teammember['Member']['name'], 'class' => 'img-responsive center-block'))?>
							<?php else : ?>
								<?=$this->Html->image('cmstyle/no_license_scan.png', array('title' => 'no image', 'class' => 'img-responsive center-block'))?>
							<?php endif; ?>
						</li>
					</ul>
				</div>
			</div>
			<?php if (($itemcount % 2) == 0) : ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>

<hr/>

<?php
// pr($team['Teammember']);
?>
