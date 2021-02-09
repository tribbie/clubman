<!-- Newsitems -->
<?php if (count($shortnewsitems) > 0) : ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?=$this->Html->link('nieuws', array('controller' => 'newsitems', 'action' => 'index'), array("class" => "boldlink", 'title' => 'ons nieuws'))?>
		</div>
		<div class='list-group'>
			<?php foreach($shortnewsitems as $oneitem) : ?>
	      <a
	        class="list-group-item text-right"
	        href="<?=$this->Html->url(array('controller' => 'newsitems', 'action' => 'view', $oneitem['Newsitem']['name'], $oneitem['Newsitem']['season']))?>"
	        title="<?=$oneitem['Newsitem']['title']?>">
	          <?=$oneitem['Newsitem']['title']?>
	          <br/>
	          <small><?=$oneitem['Newsitem']['subtitle']?></small>
	      </a>
	    <?php endforeach; ?>
	  </div>
	</div>
<?php endif; ?>

<?php
//pr($shortnewsitems);
?>
