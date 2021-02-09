<!-- app/View/Uploads/presentation.ctp -->
<h2><?=$title;?></h2>

<div class="itemindex">

	<div class="row">

		<?php foreach ($uploads as $upload) : ?>

			<div class="col-xs-6 col-md-4 thumb">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?=$upload['Upload']['name']?>
					</div>
					<div class="panel-body">
						<?php if ($upload['Upload']['type'] == 'application/pdf') : ?>
							<a class="thumbnail" href="<?=$this->base.'/files/uploads/'.$upload['Upload']['location']?>" target="_blank">
								<?=$this->Html->image($thumbnails[$category], array('class' => 'img-responsive', 'title' => $upload['Upload']['name']))?>
							</a>
						<?php else : ?>
							<a class="thumbnail" href="<?=$this->Html->url(array('controller' => 'uploads', 'action' => 'view', $upload['Upload']['category'], $upload['Upload']['id']))?>">
								<?=$this->Html->image('cmstyle/press_128.png', array('class' => 'img-responsive', 'title' => $upload['Upload']['name']))?>
							</a>
						<?php endif ; ?>
						<?=$upload['Upload']['description']?>
					</div>
				</div>
			</div>

		<?php endforeach; ?>

	</div>

</div>

<hr/>

<?php
//	pr($category);
//	pr($images);
//	pr($uploads);
?>
