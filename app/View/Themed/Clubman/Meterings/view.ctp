<h1 title="meting <?php echo $metering['Metering']['id'];?>">Meting van <?= $metering['Member']['firstname'];?> <?= $metering['Member']['lastname'];?> op <?= $metering['Metering']['metering_date'];?></h1>

<?php if (isset($metering['Member']['Picture']['location'])) : ?>
	<?= $this->Html->image($metering['Member']['Picture']['location'], array('title' => $metering['Member']['name'], 'class' => 'imgright', 'height' => '160')); ?>
<?php else : ?>
	<?= $this->Html->image('cmstyle/no_picture.png', array('title' => 'no image', 'class' => 'imgright', 'height' => '160')); ?>
<?php endif; ?>

<br/>
<table class='normalelijst'>
	<tr><th>Item</th><th>Waarde</th></tr>
<!--	<tr><td>Id</td><td><?= $metering['Metering']['id'];?></td></tr> -->
<!--	<tr><td>Naam</td><td><?= $metering['Member']['full_name'];?></td></tr> -->
<!--	<tr><td>Datum</td><td><?= $metering['Metering']['metering_date'];?></td></tr> -->
	<tr><td>Lengte</td><td><?= $metering['Metering']['length'];?> cm</td></tr>
	<tr><td>Gewicht</td><td><?= $metering['Metering']['weight'];?> kg</td></tr>

	<tr><td>Aanvalshoogte</td><td><?= $metering['Metering']['attack_height'];?> cm</td></tr>
	<tr><td>Blockhoogte</td><td><?= $metering['Metering']['block_height'];?> cm</td></tr>

	<tr><td>Suicide</td><td><?= $metering['Metering']['suicide'];?> sec</td></tr>

	<tr><td>Aanwezigheden</td><td><?= $meteringvalues['score_presence']['options'][$metering['Metering']['score_presence']];?></td></tr>
	<tr><td>Inzet</td>        <td><?= $meteringvalues['score_effort']['options'][$metering['Metering']['score_effort']];?></td></tr>
	<tr><td>Ambitie</td>      <td><?= $meteringvalues['score_ambition']['options'][$metering['Metering']['score_ambition']];?></td></tr>
	
	<tr><td>Bovenhands</td>   <td><?= $meteringvalues['score_overhand']['options'][$metering['Metering']['score_overhand']];?></td></tr>
	<tr><td>Onderhands</td>   <td><?= $meteringvalues['score_underhand']['options'][$metering['Metering']['score_underhand']];?></td></tr>
	<tr><td>Slag</td>         <td><?= $meteringvalues['score_stroke']['options'][$metering['Metering']['score_stroke']];?></td></tr>
	<tr><td>Voetenwerk</td>   <td><?= $meteringvalues['score_feetwork']['options'][$metering['Metering']['score_feetwork']];?></td></tr>
	<tr><td>Aanloop</td>      <td><?= $meteringvalues['score_runup']['options'][$metering['Metering']['score_runup']];?></td></tr>

	<tr><td>Opslag</td>       <td><?= $meteringvalues['score_serve']['options'][$metering['Metering']['score_serve']];?></td></tr>
	<tr><td>Receptie</td>     <td><?= $meteringvalues['score_pass']['options'][$metering['Metering']['score_pass']];?></td></tr>
	<tr><td>Pas</td>          <td><?= $meteringvalues['score_set']['options'][$metering['Metering']['score_set']];?></td></tr>
	<tr><td>Aanval</td>       <td><?= $meteringvalues['score_attack']['options'][$metering['Metering']['score_attack']];?></td></tr>
	<tr><td>Blok</td>         <td><?= $meteringvalues['score_block']['options'][$metering['Metering']['score_block']];?></td></tr>
	<tr><td>Verdediging</td>  <td><?= $meteringvalues['score_defense']['options'][$metering['Metering']['score_defense']];?></td></tr>

	<tr><td>Opmerking</td><td><?= nl2br($metering['Metering']['remark']);?></td></tr>
</table>

<br/>
<?php 
	echo $this->Html->link("overzicht lid", array('action' => 'viewmember', $metering['Metering']['member_id']), array('title' => 'terug naar het overzicht van '.$metering['Member']['firstname'].' '.$metering['Member']['lastname']));
	echo "<br />";
	echo $this->Html->link("terug naar overzicht", array('action' => 'index'), array('title' => 'terug naar het overzicht'));	
//	echo "<br />";
//	echo $this->Html->link("wijzig deze meting", array('action' => 'edit', $metering['Metering']['id']), array('title' => 'wijzig deze meting'));
?>

<br/>

<?php
//	pr($metering);
//	pr($meteringvalues);
?>
