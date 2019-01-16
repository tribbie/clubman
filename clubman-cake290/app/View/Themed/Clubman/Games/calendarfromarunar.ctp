<!-- app/View/Teams/arunar.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> Kalender</h2>

<div class="teamindex">

<?php if (!isset($calendar)) : ?>
	<div class="box simplebox">
	<br/>
	Geen kalender gevonden.<br/>
	<br/>
	</div>
<?php else : ?>
	<table>
    <tr><th>Reeks</th><th>Datum</th><th>Uur</th><th>Thuis</th><th>Ploeg</th><th>Bezoekers</th><th>Ploeg</th></tr>
	  <?php foreach ($calendar->ROW as $rij) : ?>
		<tr>
      <td><?=$rij->REEKS?></td>
			<td class="txttoright"><?=$rij->DATUM?></td>
      <td class="txttoright"><?=$rij->UUR?></td>
			<td><?=$rij->THUISPLOEGSTAMNR?></td>
      <td><?=$rij->THUISPLOEGNAAM?></td>
      <td><?=$rij->BEZOEKERSSTAMNR?></td>
      <td><?=$rij->BEZOEKERSNAAM?></td>
		</tr>
	  <?php endforeach; ?>
	</table>
<?php endif; ?>

</div>

<div class='crlf'></div>
<br/>

<hr/>

<?php
 pr($calendar);
?>
