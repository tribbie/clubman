<!-- app/View/Trainingmoments/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> trainingsmomenten</h2>

<?php
// first, define all links
$cmLinks = array(
				'addone'  => array('linktext' => 'Nieuw trainingsmoment', 'linkoptions' => array('controller' => 'trainingmoments', 'action' => 'add'))
			);
// then, define who will get which links
$cmLinkIdsPerRole = array(
				'root'           => array('addone'),
				'admin'          => array('addone'),
				'teamadmin'      => array('addone'),
				'gameadmin'      => array(),
				'memberadmin'    => array(),
				'trainerfinance' => array(),
				'memberfinance'  => array(),
				'trainer'        => array(),
				'member'         => array()
			);
// finally, show them links
if ($loggedIn) {
	/// Merge for cumulated roles
	$mergedLinkIdsToShow = $this->Link->mergeLinkIds($cmLinkIdsPerRole, $cmCurrentRoles);
	echo $this->Link->showLinks($cmLinks, $mergedLinkIdsToShow);
}
?>
<hr/>

<table class="table table-striped table-condensed normalelijst">
	<tr class="groupheader info">
		<th>Naam</th>
		<th>Dag</th>
		<th>Start</th>
		<th>Einde</th>
		<th>Locatie</th>
		<th>Opmerking</th>
		<th>Aktie</th>
	</tr>
	<?php foreach ($trainingmoments as $trainingmoment) : ?>
		<tr>
			<td><?=$trainingmoment['Trainingmoment']['name']?></td>
			<td><?=$weekdays[$trainingmoment['Trainingmoment']['weekday']]?></td>
			<td><?=$trainingmoment['Trainingmoment']['start_time']?></td>
			<td><?=$trainingmoment['Trainingmoment']['end_time']?></td>
			<td><?=$trainingmoment['Trainingmoment']['location']?></td>
			<td><?=$trainingmoment['Trainingmoment']['remark']?></td>
			<td><?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'trainingmoments', 'action' => 'edit', $trainingmoment['Trainingmoment']['id']), array('title' => 'wijzig dit trainingsmoment', 'escape' => false))?></td>
		</tr>
	<?php endforeach; ?>
</table>

<?php
// pr($trainingmoments);
?>
