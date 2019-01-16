<!-- app/View/Teams/arunar.ctp -->
<h2>Rangschikking: <?=$team['Team']['name']?> -- <?=$team['Team']['competition']?></h2>

<div class="teamindex">

<h4>Week <?=$week['yyyyww']?></h4>
< <?=$this->Html->link('week terug', array('controller' => 'teams', 'action' => 'rangschikking', $team['Team']['id'], $week['prev']))?> <
-
> <?=$this->Html->link('week vooruit', array('controller' => 'teams', 'action' => 'rangschikking', $team['Team']['id'], $week['next']))?> >

<?php if (isset($rangschikkingen['error'])) : ?>
	<div class="box simplebox">
	<br/>
	Geen rangschikking gevonden.<br/>
	<small><?=$rangschikkingen['error']?></small>
	<br/>
	</div>
<?php else : ?>
	<table>
	<?php $inH = $inR = false; ?>
	<?php foreach ($rangschikkingen->ROW as $rij) : ?>
		<?php if ($rij->REEKS == $team['Team']['competition']) : ?>
			<?php if (($rij->HR == 'H') and ($inH == false)) : ?>
				<?php $inH = true; ?>
				<tr><th>Hoofd</th></tr>
			<?php endif; ?>
			<?php if ($rij->HR == 'R' and ($inR == false)) : ?>
				<?php $inR = true; ?>
				<tr><th>Reserven</th></tr>
			<?php endif; ?>
			<?php
			 	if (strpos(strtoupper($rij->PLOEGNAAM), 'WOLVERTEM') === false) {
				  $rangrowstyle = '';
				} else {
					$rangrowstyle = 'style = "font-weight: bold;"';
				}
			?>
			<tr <?=$rangrowstyle?>>
				<td class="txttoright"><?=$rij->POSITIE?></td>
				<td><?=$rij->PLOEGNAAM?></td>
				<td class="txttoright"><?=$rij->AW?></td>
				<td class="txttoright"><?=$rij->GW?></td>
				<td class="txttoright"><?=$rij->GW32?></td>
				<td class="txttoright"><?=$rij->VW32?></td>
				<td class="txttoright"><?=$rij->VW?></td>
				<td class="txttoright"><?=$rij->GS?></td>
				<td class="txttoright"><?=$rij->VS?></td>
				<td class="txttoright"><strong><?=$rij->PT?></strong></td>
			</tr>
		<?php endif; ?>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>

<div class='crlf'></div>
<br/>

<hr/>

<?php
// pr($rangschikkingen->ROW[2]);
// pr($rangschikkingen);
// pr($team);
?>
