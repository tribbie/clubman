<!-- Newsitems -->
<?php if ($displaytype == 'accordeon') : ?>
	<div class="panel-group" id="newsaccordion">

		<?php foreach($shortnewsitems as $oneitem) : ?>
			<div class="panel panel-default">
				<div class="panel-heading text-center">
					<div class="small">
						<?=$oneitem['Newsitem']['subtitle']?>
					</div>
					<div class="clubman-newstitle">
						<a data-toggle="collapse" data-parent="#newsaccordion" href="#collapse<?=$oneitem['Newsitem']['id']?>">
							<?=$oneitem['Newsitem']['title']?>
						</a>
					</div>
				</div>
				<div id="collapse<?=$oneitem['Newsitem']['id']?>" class="panel-collapse collapse out">
					<div class="panel-body">
						<?php if (trim($oneitem['Newsitem']['image_url']) != '') : ?>
							<div class='newsitemview imgright'>
							  <p align='center'>
							    <img src='<?=$this->base."/files/uploads/".$oneitem['Newsitem']['image_url']?>' class='imgright' height='240' title='<?= (isset($cmclub['shortname']) ? $cmclub['shortname'] . ' - ' : 'Clubman') ?>' alt='foto'/>
							  </p>
							</div>
						<?php endif; ?>
						<div class='newsitemview'>
						  <?=$this->Markdown->transform(str_replace('[wwwbase]', $this->base, $oneitem['Newsitem']['content']))?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

	</div>
<?php endif; ?>

<?php if ($displaytype == 'list') : ?>
	<?php foreach($shortnewsitems as $oneitem) : ?>
		<div class="clubman-newsblock well well-sm text-center">
			<div class="clubman-newssubtitle small"><?=$oneitem['Newsitem']['subtitle']?></div>
			<div class="clubman-newstitle">
				<a class="clubman-newslink" href="<?=$this->Html->url(array('controller' => 'newsitems', 'action' => 'view', $oneitem['Newsitem']['name'], $oneitem['Newsitem']['season']))?>">
					<?=$oneitem['Newsitem']['title']?>
				</a>
			</div>
		</div>
	<?php endforeach; ?>

<?php endif; ?>

<?php
// pr($shortnewsitems);
?>
