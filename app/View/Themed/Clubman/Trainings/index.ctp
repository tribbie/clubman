<!-- app/View/Trainings/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> trainingen</h2>

<?php
// first, define all links
$cmLinks = array(
				'addone'  => array('linktext' => 'Voeg 1 training toe', 'linkoptions' => array('controller' => 'trainings', 'action' => 'add')),
				'addlots' => array('linktext' => 'Voeg een hoop trainingen toe', 'linkoptions' => array('controller' => 'trainings', 'action' => 'generate'))
			);
// then, define who will get which links
$cmLinkIdsPerRole = array(
				'root'           => array('addone', 'addlots'),
				'admin'          => array('addone', 'addlots'),
				'teamadmin'      => array('addone', 'addlots'),
				'gameadmin'      => array('addone', 'addlots'),
				'memberadmin'    => array(),
				'trainerfinance' => array(),
				'memberfinance'  => array(),
				'trainer'        => array('addone'),
				'member'         => array()
			);
//// no longer needed - adding should be done from the team view
//// finally, show them links
if ($loggedIn) {
	/// Merge for cumulated roles
	$mergedLinkIdsToShow = $this->Link->mergeLinkIds($cmLinkIdsPerRole, $cmCurrentRoles);
	echo $this->Link->showLinks($cmLinks, $mergedLinkIdsToShow);
}
?>
<hr/>

<div class='row'>
  <div class="col-sm-12">

		<div class="table-responsive">
			<table class="table table-striped table-condensed normalelijst">
				<tr class="groupheader info">
					<th>Datum</th>
					<th>Moment</th>
					<th>Week</th>
					<th>Van</th>
					<th>Tot</th>
					<th>Team</th>
					<th>Data</th>
					<th>Locatie</th>
					<th>Opmerking</th>
					<th>Aktie</th>
				</tr>
				<?php foreach ($trainings as $training) : ?>
					<tr>
						<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin']))) : ?>
							<td><?=$this->Html->link($training['Training']['start_date'], array('controller' => 'trainings', 'action' => 'presences', $training['Training']['id']))?></td>
						<?php else : ?>
							<td><?=$training['Training']['start_date']?></td>
						<?php endif; ?>
						<td><?=$training['Trainingmoment']['name']?></td>
						<td><?=$training['Training']['week_of_year']?></td>
						<td><?=$training['Training']['start_time_nice']?></td>
						<td><?=$training['Training']['end_time_nice']?></td>
						<td><?=$training['Team']['name']?></td>
						<td><?=(count($training['Trainingsteammember']) == 0) ? '' : count($training['Trainingsteammember'])?></td>
						<td><?=$training['Training']['location']?></td>
						<td><?=$training['Training']['remark']?></td>
						<td><?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'trainings', 'action' => 'edit', $training['Training']['id']), array('title' => 'wijzig deze training', 'escape' => false))?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>

<?php
// pr($trainings);
?>
