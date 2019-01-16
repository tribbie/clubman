<!-- app/View/Enquetes/vulin.ctp -->
<?php if ($enqueteSeason == $currentSeason) : ?>

	<?php $enqueteElement = 'enquete-'.$enqueteSeason.'-form'; ?>
	<?=$this->element($enqueteElement);?>

<?php else : ?>

	<?php if ($this->request->data['Enquete']['id'] == '00000000000000000000002015201600') : ?>

		<div style="background: red;" class="alert alert-danger" role="alert">SPECIMEN -- ENKEL OM TE BEKIJKEN</div>
		<div style="background: red;" class="alert alert-danger" role="alert">SPECIMEN -- NIET BEWAREN AUB</div>

		<?php $enqueteElement = 'enquete-'.$enqueteSeason.'-form'; ?>
		<?=$this->element($enqueteElement);?>

		<div style="background: red;" class="alert alert-danger" role="alert">SPECIMEN -- ENKEL OM TE BEKIJKEN</div>
		<div style="background: red;" class="alert alert-danger" role="alert">SPECIMEN -- NIET BEWAREN AUB</div>

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
