<!-- app/View/Teams/index.ctp -->
<h2>Uw <?= (isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman') ?> Teams</h2>

<div class="teamindex">
<?php foreach ($teams as $team) : ?>
	<div class='oneteam'>
		<div class='oneteamtitle'><?= $team['Team']['name']; ?> (<?= $team['Team']['shortname']; ?>)</div>
		<div class="oneteampicture">
		<p>
		<?php if (isset($team['Picture']['location'])) : ?>
			<?= $this->Html->image($team['Picture']['location'], array('title' => $team['Team']['name'] . ' (' . $team['Team']['competition'] . ')', 'url' => array('controller' => 'teams', 'action' => 'view', $team['Team']['id']))); ?>
		<?php else : ?>
			<?= $this->Html->image('cmstyle/team_placeholder.png', array('title' => $team['Team']['name'] . ' (' . $team['Team']['competition'] . ')', 'url' => array('controller' => 'teams', 'action' => 'view', $team['Team']['id']))); ?>
		<?php endif; ?>
		</p>
		</div>
	</div>
<?php endforeach; ?>
</div>

<div class='crlf'></div>
<br/>

<hr/>

<?php
if ($loggedIn) {
//	echo $this->Html->link('Voeg team toe', array('controller' => 'teams', 'action' => 'add'))."\n";
}
?>

<?php
// echo '<br/><br/>';
// pr($memberteams);
// pr($teams);
// pr($currentUser);
?>
