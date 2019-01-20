<h1>Mailing "<?=$mailing['Mailing']['name']?>"</h1>

<h2>Voorbeeld</h2>
<div class='box' style='border: solid 1px #333; padding: 10px;'>
<?php
	$clubmanid = 0;
	echo '<h3>Van: ' . $mailing['Mail'][$clubmanid]['mailfrom'] . '</h3>';
	echo '<h3>Aan: ' . $mailing['Mail'][$clubmanid]['mailto'] . '</h3>';
	echo '<h3>Ook: ' . $mailing['Mail'][$clubmanid]['mailcc'] . '</h3>';
	echo '<h3>Onderwerp: ' . $mailing['Mailing']['name'] . '</h3>';

	echo '</div>';
	echo "<div class='box' style='border: solid 1px #333; padding: 10px;'>";

	$bodyofmail = $mailing['Mailing']['body'];
	$bodyofmail = str_replace("%%name%%", $mailing['Mail'][$clubmanid]['name'], $bodyofmail);
	$bodyofmail = str_replace("%%maillinkurl%%", $mailing['Mail'][$clubmanid]['maillinkurl'], $bodyofmail);
	$bodyofmail = str_replace("%%maillinkuid%%", $mailing['Mail'][$clubmanid]['maillinkuid'], $bodyofmail);

	$bodyofmail = explode("\n", $bodyofmail);
	foreach ($bodyofmail as $line):
		echo '<p> ' . $line . "</p>\n";
	endforeach;

//	echo $bodyofmail;
	echo '</div>';
?>

<br/>

<h2>Voorbereide mails</h2>

<div class='row'>
  <div class="col-xs-12">

		<div class="table-responsive">
			<table class='table table-striped table-condensed normalelijst'>
				<tr class="groupheader info">
					<th>Id</th>
					<th>Name</th>
					<th>To/Cc</th>
					<th>Sent</th>
					<th>Action</th>
				</tr>
				<!-- Here is where we loop through our $mails array, printing out info -->
				<?php foreach ($mailing['Mail'] as $mail):?>
				<tr>
					<td><?=$mail['id']?></td>
					<td><?=$mail['name']?></td>
					<td><?=$mail['mailto']?><br/><?=$mail['mailcc']?></td>
					<td><?=$mail['mailsent']?></td>
					<td>
						<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
							<?= $this->Html->link('stuur mail nu', array('controller' => 'mails', 'action' => 'sendonemail', $mail['id'], 'send'), array('title' => 'Stuur deze mail')) ?>
							-
							<?= $this->Html->link('bekijk', array('controller' => 'mails', 'action' => 'view', $mail['id'], 'send'), array('title' => 'Stuur deze mail')) ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>

<hr/>
<?php if ($enqueteSeason == $currentSeason) : ?>
	<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
		<p>
			<?= $this->Html->link('stuur alle mails', array('controller' => 'mails', 'action' => 'sendmanymails', $mailing['Mailing']['id'], 'all', 'send'), array('class' => 'btn btn-sm btn-info', 'role' => 'button', 'title' => 'stuur mails')) ?>
			<?= $this->Html->link('stuur alle nog niet verzonden mails', array('controller' => 'mails', 'action' => 'sendmanymails', $mailing['Mailing']['id'], 'unsent', 'send'), array('class' => 'btn btn-sm btn-info', 'role' => 'button', 'title' => 'stuur mails')) ?>
		</p>
	<?php endif ; ?>
<?php endif ; ?>

<?php
	//pr($mailing);
?>
