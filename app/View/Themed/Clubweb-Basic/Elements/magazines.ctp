<!-- Weekkalender -->
<?php if (count($shortmagazines) > 0) : ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?=$this->Html->link('clubblad', array('controller' => 'uploads', 'action' => 'presentation', 'magazine'), array("class" => "boldlink", "title" => "naar de magazines"))?>
		</div>
		<div class='list-group'>
	    <?php foreach($shortmagazines as $onemagazine) : ?>
				<?= $this->Html->link($onemagazine['Upload']['name'], "/files/uploads/".$onemagazine['Upload']['location'], array("class" => "list-group-item text-right", "title" => $onemagazine['Upload']['name']))?>
	    <?php endforeach; ?>
	  </div>
	</div>
<?php endif; ?>
