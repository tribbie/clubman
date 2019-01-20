<h2>Metingen</h2>

<?=$this->Html->link("Nieuwe meting", array('controller' => 'meterings', 'action' => 'add'))?>
<hr/>

<table class='table table-striped table-condensed normalelijst'>
	<tr>
		<th width="5%">Lidnr</th>
		<th width="45%">Lid</th>
		<th width="20%">Datum laatste meting</th>
		<th width="10%">Aantal metingen</th>
		<th width="10%">Nieuwe meting</th>
	</tr>
<!-- Here is where we loop through our $meterings array, printing out metering info -->

<?php foreach ($meterings as $metering):?>
	<tr>
<!--		<td><?php echo $this->Html->link($metering['Metering']['id'], array('action' => 'edit', $metering['Metering']['id']), array('title' => 'wijzig deze meting'));?></td> -->
<!--		<td class="rightalign"><?php echo $this->Html->link($metering['Metering']['member_id'], array('controller' => 'members', 'action' => 'view', $metering['Metering']['member_id']), array('title' => 'info lid'));?></td> -->
		<td class="rightalign"><?= $metering['Metering']['member_id'];?></td>
		<td><?php echo $this->Html->link($metering['0']['lid'], array('action' => 'viewmember', $metering['Metering']['member_id']), array('title' => 'bekijk de metingen van dit lid'));?></td>
<!--		<td class="rightalign"><?php echo $this->Html->link($metering['0']['laatste'], array('action' => 'graphmember', $metering['Metering']['member_id']), array('title' => 'bekijk de metingen van dit lid'));?></td> -->
		<td class="rightalign"><?php echo $metering['0']['laatste'];?></td>
		<td class="rightalign"><?php echo $metering['0']['aantal'];?></td>
		<td class="rightalign"><?php echo $this->Html->link('meet', array('action' => 'add', $metering['Metering']['member_id']), array('title' => 'voeg een nieuwe meting toe voor '.$metering['0']['lid']));?></td>
	</tr>
<?php endforeach; ?>

</table>


<?php
//	pr($meterings);
?>
