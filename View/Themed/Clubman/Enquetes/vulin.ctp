<!-- app/View/Enquetes/vulin.ctp -->
<?php if ($enqueteSeason == $currentSeason) : ?>

	<?php $enqueteElement = 'enquete-'.$enqueteSeason.'-form'; ?>
	<?=$this->element($enqueteElement);?>

<?php else : ?>

	<?php if (strpos($this->request->data['Enquete']['algemeen_naam'], 'AAA') == 0) : ?>
		<!-- Volgende stuk is volgens mij niet meer relevant -->
		<div class="panel panel-danger">
		  <div class="panel-heading">SPECIMEN</div>
		  <div class="panel-body">ENKEL OM TE BEKIJKEN / TESTEN</div>
		</div>

		<?php $enqueteElement = 'enquete-'.$enqueteSeason.'-form'; ?>
		<?=$this->element($enqueteElement);?>

		<div class="panel panel-danger">
		  <div class="panel-heading">SPECIMEN</div>
		  <div class="panel-body">ENKEL OM TE BEKIJKEN / TESTEN</div>
		</div>

	<?php else : ?>

		<h2>De <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> enquête is afgelopen</h2>
		<br/>
		<div class='attention'>
		De ledenbevraging van <?=$enqueteSeason?> is afgelopen.<br/>
		Je formulier is niet meer ter beschikking.<br/>
		<br/>
		Het <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> bestuur.</br>
		</div>

	<?php endif; ?>

<?php endif; ?>


<?php
//	print("<hr>");
//	pr($enqueteSeason);
//	pr($this->request->data);
//	print("<hr>");
?>
