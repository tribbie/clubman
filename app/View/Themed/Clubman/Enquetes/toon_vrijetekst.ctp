<!-- app/View/Enquetes/toon_vrijetekst.ctp -->
<h2>Vrije tekst van de enquetes van <?=$enqueteSeason?></h2>


<div class='row'>
  <div class="col-sm-12">

		<div class="table-responsive">
			<table class='table table-striped table-condensed normalelijst'>
				<tr class="groupheader info">
					<th>Naam</th>
					<th>Vrije tekst</th>
				</tr>
				<?php foreach ($enquetes as $enquete) : ?>
					<?php if (trim($enquete['Enquete']['diversen_tekst']) != '') : ?>
						<tr>
							<td><?=$enquete['Enquete']['algemeen_naam']?><br/><?=$enquete['Enquete']['modified']?></td>
							<td><?=nl2br($enquete['Enquete']['diversen_tekst'])?></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>

<?= $this->Html->link("terug naar de lijst", array('action' => 'lijst', $enqueteSeason)); ?>

<?php
// pr($enquetes);
?>
