<h2>Lijst van de enquetes van <?=$enqueteSeason;?></h2>
Verwerking:
<?php if ($enqueteSeason == $currentSeason) : ?>
<?= $this->Html->link('exporteer naar csv', array('action' => 'export.csv'), array('title' => 'voor naar de spreadsheet')) ?>
 ---
<?php endif ; ?>
<?= $this->Html->link('toon vrije tekst', array('action' => 'toon_vrijetekst', $enqueteSeason), array('title' => 'enkel wat is ingevuld')) ?>
<br/>

<div class="table-responsive">
	<table class='table table-striped table-condensed normalelijst'>
		<tr class="groupheader info">
      <?php $tablecolumns = 4; ?>
  		<th>Naam</th>
      <th>Team</th>
  		<th>Laatst gewijzigd</th>
      <th>&nbsp;</th>
      <?php if (($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) and ($enqueteSeason == $currentSeason)) : ?>
        <th>Actie</th>
        <?php $tablecolumns += 1; ?>
      <?php endif ; ?>
  	</tr>

    <?php
    	$completed = 0;
      $prevnaam = '';
    ?>
    <?php foreach ($enquetes as $enquete) : ?>
      <tr>
    		<td><?=$this->Html->link($enquete['Enquete']['algemeen_naam'], array('action' => 'toon', $enquete['Enquete']['id'], $enqueteSeason))?></td>
        <td><?=$enquete['Enquete']['algemeen_ploeg']?></td>
        <?php if ($enquete['Enquete']['modified'] <> $enquete['Enquete']['created']) : ?>
    			<?php $completed += 1; ?>
          <td><?=$enquete['Enquete']['modified']?></td>
        <?php else : ?>
          <td>&nbsp;</td>
    		<?php endif; ?>
        <?php if ($enquete['Enquete']['algemeen_naam'] == $prevnaam) : ?>
          <td>mogelijke dubbel</td>
        <?php else : ?>
          <td>&nbsp;</td>
        <?php endif; ?>
        <?php if (($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) and ($enqueteSeason == $currentSeason)) : ?>
          <td><?=$this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $enquete['Enquete']['id']), array('title' => 'verwijder deze enquete', 'escape' => false))?></td>
        <?php endif; ?>
  		</tr>
      <?php $prevnaam = $enquete['Enquete']['algemeen_naam']; ?>
		<?php endforeach; ?>

    <tr class="groupheader info">
  	  <th>Totaal: <?=count($enquetes)?></th>
      <th colspan="<?=($tablecolumns - 1)?>">Ingevuld: <?=$completed?> stuks</th>
  	</tr>
	</table>
</div>

<?php if ($enqueteSeason == $currentSeason) : ?>
  <?= $this->Html->link('Mailing', array('controller' => 'mailings', 'action' => 'index'), array('title' => 'Mailing')) ?>
<?php endif ; ?>

<?php
// pr($enquetes);
?>
