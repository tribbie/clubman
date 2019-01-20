<!-- app/View/Teams/overview.ctp -->
<h3>Team "<?=$team['Team']['name']?>" aka "<?=$team['Team']['shortname']?>"</h3>

<hr/>

<h4>Algemeen</h4>
<dl class="dl-horizontal">
	<dt>Naam</dt>
	<dd><?=$team['Team']['name']?> (aka <?=$team['Team']['shortname']?> aka <?=$team['Team']['mininame']?>)</dd>
	<dt>Reeks</dt>
	<dd><?=$team['Team']['series']?></dd>
	<dt>E-mail adres</dt>
	<dd><?=$team['Team']['email']?></dd>
</dl>


<hr/>

<h4>Team</h4>
<div class='table-responsive'>
	<table class='table table-striped table-condensed normalelijst'>
		<tr class="groupheader info">
			<th>Naam</th>
			<th>Voornaam</th>
			<th class="text-right">Licentie</th>
			<th class="text-right">Geboren</th>
			<th>E-mail</th>
			<th>GSM</th>
			<th>Functie</th>
			<th>Prioriteit</th>
		</tr>
		<?php foreach ($team['Teammember'] as $teammember) : ?>
			<tr>
				<td><?=$teammember['Member']['lastname']?></td>
				<td><?=$teammember['Member']['firstname']?></td>
				<td class="text-right"><?=$teammember['Member']['licensenumber']?></td>
				<td class="text-right"><?=$teammember['Member']['birthdate_nice']?></td>
				<td><?=$teammember['Member']['email']?></td>
				<td><?=$teammember['Member']['tel']?></td>
				<td><?=$teammember['teamfunction']?></td>
				<td><?=$teammember['teampriority']?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<hr/>
<?=$this->Html->link('Terug naar overzicht', array('controller' => 'teams', 'action' => 'view', $team['Team']['id']))?>

<!--
<pre>
<?php
// pr($team);
?>
</pre>
-->
