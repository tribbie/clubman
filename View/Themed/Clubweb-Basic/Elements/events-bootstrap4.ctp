<!-- Evenementen -->
<?php if (count($shortevents) > 0) : ?>
	<div class="card">
		<div class="card-header">
			<?=$this->Html->link('evenementen', array('controller' => 'events', 'action' => 'index'), array("class" => "boldlink", 'title' => 'onze evenementen'))?>
		</div>
		<div class='list-group'>
			<?php foreach($shortevents as $oneevent) : ?>
				<?= $this->Html->link($oneevent['Event']['title'], array('controller' => 'events', 'action' => 'view', $oneevent['Event']['name'], $oneevent['Event']['year']), array("class" => "list-group-item list-group-item-action text-right", "title" => $oneevent['Event']['title'] . ' - ' . $oneevent['Event']['year']))?>
	    <?php endforeach; ?>
	  </div>
	</div>
<?php endif; ?>

<?php
//pr($shortevents);
?>
