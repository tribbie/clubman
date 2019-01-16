<!-- app/View/Enquetes/index.ctp -->
<h2>Enquetes</h2>

<?php foreach ($enqueteSeasons as $enqueteSeason) : ?>

	<?php if ($enqueteSeason['Enquete']['season'] == $currentSeason) : ?>
		<?= $this->Html->link('Toon de lijst van seizoen ' . $enqueteSeason['Enquete']['season'] . ' (huidig seizoen)', array('action' => 'lijst', $enqueteSeason['Enquete']['season']), array('title' => 'Toon de lijst van '.$enqueteSeason['Enquete']['season'])); ?>
	 - <?= $this->Html->link('meer uitleg', array('controller' => 'help', 'action' => 'mailing_enquete_2018'), array('title' => 'Tribbie-uitleg')); ?>
	<?php else : ?>
		<?= $this->Html->link('Toon de lijst van seizoen ' . $enqueteSeason['Enquete']['season'], array('action' => 'lijst', $enqueteSeason['Enquete']['season']), array('title' => 'Toon de lijst van '.$enqueteSeason['Enquete']['season'])); ?>
	<?php endif ; ?>
	<br/>

<?php endforeach ; ?>

<hr/>

<?= $this->Html->link('Genereer de enquetes van dit seizoen', array('action' => 'generate'), array('title' => 'Genereer de enquetes')); ?>

<hr/>

<!-- ANCIENT STUFF -->
<!--
<?= $this->Html->link('Toon de lijst van dit seizoen', array('action' => 'lijst'), array('title' => 'Toon de lijst')); ?> - <?= $this->Html->link('meer uitleg', array('controller' => 'pages', 'action' => 'vcw_mailing_enquete_2014'), array('title' => 'Toon de uitleg')); ?>
<br/>
<?= $this->Html->link('Toon de enquetes van 2012-2013', array('controller' => 'enquete1213s', 'action' => 'lijst'), array('title' => 'Toon de enquetes van 2012-2013')); ?> - <?= $this->Html->link('meer uitleg', array('controller' => 'pages', 'action' => 'vcw_mailing_enquete_2013'), array('title' => 'Toon de uitleg')); ?>
<br/>
<?= $this->Html->link('Toon de enquetes van 2011-2012', array('controller' => 'enquete1112s', 'action' => 'lijst'), array('title' => 'Toon de enquetes van 2011-2012')); ?> - <?= $this->Html->link('meer uitleg', array('controller' => 'pages', 'action' => 'vcw_mailing_enquete_2012'), array('title' => 'Toon de uitleg')); ?>
<br/>
<?= $this->Html->link('Toon de enquetes van 2010-2011', array('controller' => 'enquete1011s', 'action' => 'lijst'), array('title' => 'Toon de enquetes van 2010-2011')); ?> - <?= $this->Html->link('meer uitleg', array('controller' => 'pages', 'action' => 'vcw_mailing_enquete_2011'), array('title' => 'Toon de uitleg')); ?>
<br/>
-->


<?php
	//pr($enqueteSeasons);
	//print("<hr>");
?>
