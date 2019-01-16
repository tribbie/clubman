<!-- app/View/Enquetes/toon.ctp -->
<h2>Antwoorden van <?=$enquete['Enquete']['algemeen_naam'];?> - seizoen <?=$enqueteSeason;?></h2>
<br/>

<?= $this->Html->link("terug naar de lijst", array('action' => 'lijst', $enqueteSeason)); ?>

<br/>
<?php $enqueteElement = 'enquete-'.$enqueteSeason.'-view'; ?>
<?=$this->element($enqueteElement);?>

<?= $this->Html->link("terug naar de lijst", array('action' => 'lijst', $enqueteSeason)); ?>


<?php
//	print("<hr>");
//	pr($enqueteSeason);
//	pr($enquete);
//	print("<hr>");
?>
