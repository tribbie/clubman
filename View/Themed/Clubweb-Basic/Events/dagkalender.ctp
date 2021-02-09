<h2>Onze kalender</h2>

<table class='table table-condensed kalenderdag'>
<tr>
	<th class='text-center' colspan='3'>Dagkalender <?= $this->Html->link('('.$dagkalender['meta']['begin']['monthname'].')', array('controller' => 'events', 'action' => 'maandkalender', $dagkalender['meta']['begin']['year'], $dagkalender['meta']['begin']['month']), array('class' => 'boldlink', 'title' => 'naar maandkalender')); ?></th>
</tr>
<tr class='kalnav active'>
	<th width='25%' align='left'>
			<?=$this->Html->link('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>', array('controller' => 'events', 'action' => 'dagkalender', $dagkalender['meta']['prev']['year'], $dagkalender['meta']['prev']['month'], $dagkalender['meta']['prev']['day']), array('title' => 'naar ' . $dagkalender['meta']['prev']['day'] .'/' . $dagkalender['meta']['prev']['month'], 'escape' => false)) ?>
	</th>
	<th class='text-center'>
		<?=$dagkalender['meta']['begin']['dayname']?>
		<?=$dagkalender['meta']['begin']['day']?>/<?=$dagkalender['meta']['begin']['month']?>/<?=$dagkalender['meta']['begin']['year']?>
	</th>
	<th class='text-right' width='25%' align='right'>
		<?=$this->Html->link('<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>', array('controller' => 'events', 'action' => 'dagkalender', $dagkalender['meta']['next']['year'], $dagkalender['meta']['next']['month'], $dagkalender['meta']['next']['day']), array('title' => 'naar ' . $dagkalender['meta']['next']['day'] .'/' . $dagkalender['meta']['next']['month'], 'escape' => false)) ?>
	</th>
</tr>
</table>
<table class='table table-striped table-hover kalenderdag'>
	<thead>
		<tr><th class='text-right' width='10%'>tijd</th><th width='20%'>item</th><th>omschrijving</th></tr>
	</thead>
	<tbody>
	<?php foreach ($dagkalender['content'] as $today) : ?>
		<?php foreach ($today as $itemindex => $item) : ?>
		<tr class="<?=$item['change']?>" <?= (isset($item['change']) ? "title='".$item['change']."'" : '') ?>>
			<td align='right'><?= (isset($item['time']) ? $item['time'] : '-') ?></td>
			<td><?= $item['titleshort'] ?></td>
			<td><?= $item['bubble'] ?></td>
		</tr>
		<?php endforeach; ?>
	<?php endforeach; ?>
	</tbody>
</table>


<?php
// pr($dagkalender);
?>
