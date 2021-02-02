<h2>Mailing <?=$mailing['Mailing']['name']?></h2>
<h3>Categorie: <?=$mailing['Mailing']['category']?></h3>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Mails</h3>
	</div>
	<div class="panel-body">
		<p>
			Momenteel zijn er <?=count($mailing['Mail'])?> mails voor deze mailing.
		</p>
	</div>
	<table class="table table-striped table-condensed">
		<tr class="info">
			<th>Naam</th>
			<th>Mail verzonden</th>
		</tr>
		<?php foreach($mailing['Mail'] as $mail) : ?>
			<tr title="<?=$mail['maillinkuid']?>">
				<td>
					<?=$mail['name']?>
				</td>
				<td>
					<?=(($mail['mailsent'] == null) ? 'Nog niet verzonden' : 'Verzonden op ' . $mail['mailsent'])?>
				</td>
		<?php endforeach ; ?>
	</table>
</div>

<hr/>

<?php if ($mailing['Mailing']['category'] == 'ledenbevraging') : ?>

	<p>
		<?php if ($enqueteSeason == $currentSeason) : ?>
			<?= $this->Html->link('prepareer mails voor allemaal', array('action' => 'preparemails', $mailing['Mailing']['id'], 'all'), array('class' => 'btn btn-sm btn-info', 'role' => 'button', 'title' => 'prepareer mails')) ?>
			<?= $this->Html->link('prepareer mails voor de niet-ingevulde', array('action' => 'preparemails', $mailing['Mailing']['id'], 'empty'), array('class' => 'btn btn-sm btn-info', 'role' => 'button', 'title' => 'prepareer mails')) ?>
			<?= $this->Html->link('prepareer test mails (AAA - * - test)', array('action' => 'preparemails', $mailing['Mailing']['id'], 'test'), array('class' => 'btn btn-sm btn-info', 'role' => 'button', 'title' => 'prepareer test mails')) ?>
		<?php endif ; ?>
	</p>

	<div class="panel panel-info">
	  <div class="panel-heading">
	    <h3 class="panel-title">Ter voorbereiding van de enquetes <strong>[<?=$this->request->params['pass'][1]?>]</strong> van het seizoen <?=$enqueteSeason?></h3>
		</div>
	  <div class="panel-body">
			Voor volgende <?=count($enquetes)?> [<?=$this->request->params['pass'][1]?>] enquetes zullen er mails bij-gegenereerd worden:<br/>
		</div>
		<table class="table table-striped table-condensed">
			<tr class="info">
				<th>Naam</th>
				<th>Enquete ingevuld</th>
			</tr>
			<?php foreach($enquetes as $enquete) : ?>
			<tr title="<?= $enquete['Enquete']['id'] ?>">
				<td><?=$enquete['Enquete']['algemeen_naam']?></td>
				<td><?=(($enquete['Enquete']['modified'] == $enquete['Enquete']['created']) ? 'nog niet' : $enquete['Enquete']['modified'])?></td>
			</tr>
		<?php endforeach ; ?>
		</table>
	</div>

	<hr/>
	<p>
		<?php if ($enqueteSeason == $currentSeason) : ?>
			<?= $this->Html->link('genereer bovenstaande mails', array('action' => 'preparemails', $mailing['Mailing']['id'], $this->request->params['pass'][1], 'generate'), array('class' => 'btn btn-sm btn-info', 'role' => 'button', 'title' => 'genereer mails')) ?>
			<?= $this->Html->link('ga naar de mailing', array('action' => 'view', $mailing['Mailing']['id']), array('class' => 'btn btn-sm btn-info', 'role' => 'button', 'title' => 'naar mailing')) ?>
		<?php endif ; ?>
	</p>
<?php endif ; ?>

<?php
	//echo '<hr/>';
	//pr($enqueteSeason);
	//pr($mailing);
	//pr($enquetes);
	//pr($mails);
	//pr($this->request->params['pass'][1]);
?>
