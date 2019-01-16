<!-- File: /app/View/Uploads/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> <?=$category?></h2>

<div class="row">

	<div class="col-xs-12">


		<div class="panel panel-info">
			<div class="panel-heading">
				Bestand (<?=$upload['Upload']['season']?>): <?=$upload['Upload']['name']?>
			</div>
			<div class="panel-body">
				<p>
					<?=$upload['Upload']['description']?>
				</p>
				<hr/>
				<?php if ($isPicture) : ?>
					<p>
						<img class="img-responsive" src="<?=$fullLocation?>" title="<?=$upload['Upload']['name']?>" />
					</p>
				<?php else : ?>
					<p>
						<a href="<?=$fullLocation?>">
							<img class="img-responsive" src="<?=$thumbnail['location']?>" title="<?=$thumbnail['title']?>" />
						</a>
					</p>
				<?php endif ; ?>
			</div>
		</div>

	</div>

</div>


<?php
// pr($upload);
?>
