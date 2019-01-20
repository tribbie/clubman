<?php if (count($campmagazines) == 0) : ?>
	<p>
		Nog geen krantjes. Maar ze komen eraan...
	</p>
<?php else : ?>
	<?php foreach($campmagazines as $campmagazine) : ?>
		<?= $this->Html->link($campmagazine['Upload']['name'], "/files/uploads/".$campmagazine['Upload']['location'], array('target'=>'_blank', "title" => $campmagazine['Upload']['name']))?>
		<br/>
	<?php endforeach; ?>
<?php endif ; ?>
