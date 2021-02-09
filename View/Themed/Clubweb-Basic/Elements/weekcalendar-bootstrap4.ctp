<!-- Weekkalender -->
<div class="card">
	<div class="card-header">
		<?=$this->Html->link('kalender', '/kalender', array("class" => "boldlink", "title" => "naar de VCW maandkalender"))?>
	</div>
	<div class='list-group'>
    <?php foreach($weekkalender['content'] as $oneday) : ?>
			<?php foreach($oneday as $item) : ?>
				<?= $this->Html->link($item['title'], array('controller' => 'events', 'action' => 'dagkalender', $item['year'], $item['month'], $item['day']), array("class" => implode(" ", ["list-group-item", "list-group-item-action", "text-right", $item['change']])))?>
			<?php endforeach; ?>
    <?php endforeach; ?>
  </div>
<!--
	<?php // echo $this->element('sql_dump'); ?>
	<?php // pr($weekkalender); ?>
-->
</div>
