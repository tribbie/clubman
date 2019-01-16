<h2>Onze kalender</h2>

<table class='table table-border kalendermaand' cellspacing='0'>
<tr>
	<th class='text-center' colspan='7'>Maandkalender</th>
</tr>
<tr class='active'>
	<th colspan='2'>
		<?=$this->Html->link('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>', array('controller' => 'events', 'action' => 'maandkalender', $maandkalender['meta']['prev']['year'], $maandkalender['meta']['prev']['month']), array('title' => 'naar ' . $maandkalender['meta']['prev']['monthname'] . ' ' . $maandkalender['meta']['prev']['year'], 'escape' => false)) ?>
	</th>
	<th class='text-center' colspan='3'>
		<?=$maandkalender['meta']['begin']['monthname']?> <?=$maandkalender['meta']['begin']['year']?>
	</th>
	<th class='text-right' colspan='2'>
		<?=$this->Html->link('<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>', array('controller' => 'events', 'action' => 'maandkalender', $maandkalender['meta']['next']['year'], $maandkalender['meta']['next']['month']), array('title' => 'naar ' . $maandkalender['meta']['next']['monthname'] . ' ' . $maandkalender['meta']['next']['year'], 'escape' => false)) ?>
	</th>
</tr>

<tr class='weekdagen'><th>maandag</th><th>dinsdag</th><th>woensdag</th><th>donderdag</th><th>vrijdag</th><th>zaterdag</th><th>zondag</th></tr>

<?php
$dim = cal_days_in_month(CAL_GREGORIAN, $maandkalender['meta']['begin']['month'], $maandkalender['meta']['begin']['year']);
$cursor = 0;

## first, open first row
echo "<tr>";
## next, the previous-month days of the first week
if ($maandkalender['meta']['begin']['dow'] > 1) {
	for ($i = 1; $i < $maandkalender['meta']['begin']['dow']; $i++) {
		$cursor++;
		echo "<td></td>";
	}
}

## next, the month
for ($dag = 1; $dag <= $dim; $dag++) {
		if (($dag % 2) == 0) $dagclass = 'even';
		else $dagclass = 'odd';
		if (($maandkalender['meta']['begin']['month'] == date("n")) and ($dag == date("j"))) $dagclass = 'vandaag';
		$dagcontent = "<li class='hoeveelste'>$dag</li>";
		$datumindex = $maandkalender['meta']['begin']['year'] . '-' . $maandkalender['meta']['begin']['month'] . '-' . str_pad($dag, 2, "0", STR_PAD_LEFT);
		if (isset($maandkalender['content'][$datumindex])) {
			foreach ($maandkalender['content'][$datumindex] as $item) {
				$dagcontent .= "<li class='" . $item['class'] . " " . $item['change'] . "' title='" . $item['bubble'] . "'>";
				$dagcontent .= $this->Html->link($item['titlemini'], array('controller' => 'events', 'action' => 'dagkalender', $item['year'], $item['month'], $item['day']), array("class" => $item['change']));
				$dagcontent .= "</li>";
			}
		} else {
		}

		$cursor++;
    if (($cursor % 7) == 1) echo "<tr>";
		echo "<td class='" .  $dagclass . "'><ul>" . $dagcontent . "</ul></td>";
    if (($cursor % 7) == 0) echo "</tr>\n";
}

## next, the next-month days of the last week
if (($cursor % 7) <> 0) {
	for ($i = ($cursor % 7); $i < 7; $i++) {
		$cursor++;
		echo "<td></td>";
	}
}

## finally, close last row
echo "</tr>";

?>

</table>


<?php
// pr($maandkalender);
?>
