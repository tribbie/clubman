<!-- app/View/Uploads/index.ctp -->
<div class='container'>
<h2>
	Lijst inschrijvingen <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> evenement<br/>
	"<?=$event['Event']['title']?> - <?=$event['Event']['season']?>"
</h2>

<table class='table'>
<tr>
	<th>Naam</th>
	<th>Email</th>
	<th>Extra</th>
	<th>Datum</th>
	<th>Bevestigd</th>
</tr>
<?php foreach ($event['Subscription'] as $subscription) : ?>
<tr>
	<td><?=$subscription['subsname']?></td>
	<td><?=$subscription['subsemail']?></td>
	<td><?=$subscription['extra']?></td>
	<td><?=$subscription['created_nice']?></td>
	<td><?=(($subscription['confirmed']) ? "yep" : "nope")?></td>
<!--	<td style='text-align: right'><?=(($subscription['confirmed']) ? "yep" : "nope")?></td> -->
</tr>
<?php endforeach ; ?>
</table>

<hr/>
</div>
<?php
// pr($event);
?>
