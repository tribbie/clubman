<h1>Alle metingen van <?=$member['Member']['firstname'];?> <?=$member['Member']['lastname'];?></h1>

<?php if (isset($member['Picture']['location'])) : ?>
	<?= $this->Html->image($member['Picture']['location'], array('title' => $member['Member']['name'], 'class' => 'imgright', 'height' => '160')); ?>
<?php else : ?>
	<?= $this->Html->image('cmstyle/no_picture.png', array('title' => 'no image', 'class' => 'imgright', 'height' => '160')); ?>
<?php endif; ?>


<table class='normalelijst'>
	<tr>
<!--		<th>id</th> -->
		<th>Datum meting</th>
		<th>Opmerking</th>
	</tr>
<!-- Here is where we loop through our $meterings array, printing out metering info -->

<?php foreach ($meterings as $metering):?>
	<tr>
<!--		<td><?php echo $this->Html->link($metering['Metering']['id'], array('action' => 'edit', $metering['Metering']['id']), array('title' => 'wijzig deze meting'));?></td> -->
		<td><?php echo $this->Html->link($metering['Metering']['metering_date'], array('action' => 'view', $metering['Metering']['id']), array('title' => 'bekijk deze meting'));?></td>
		<td><?php echo $metering['Metering']['remark'];?></td>
	</tr>
<?php endforeach; ?>

</table>
<br/>
<?php
	echo $this->Html->link("voeg een meting toe", array('action' => 'add', $metering['Metering']['member_id']), array('title' => 'voeg een nieuwe meting toe voor '.$member['Member']['firstname'].' '.$member['Member']['lastname']));
	echo "<br />";
	echo $this->Html->link("terug naar overzicht", array('action' => 'index'), array('title' => 'terug naar het overzicht'));	
?>
<br/>

<br/>

<?php
//	pr($member);
//	pr($meterings);
?>

