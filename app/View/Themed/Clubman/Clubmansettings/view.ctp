<!-- app/View/Clubmansettings/view.ctp -->
<h2>Clubman configuratie</h2>

<?php
// first, define all links
$cmLinks = array(
				'configlogin' => array('linktext' => 'Zet logins aan/af', 'linkoptions' => array('controller' => 'clubmansettings', 'action' => 'setlogins')),
				'configseason' => array('linktext' => 'Kies seizoen', 'linkoptions' => array('controller' => 'clubmansettings', 'action' => 'setseason')),
				'configclub'   => array('linktext' => 'Configureer Club', 'linkoptions' => array('controller' => 'clubmansettings', 'action' => 'configure')),
			);
// then, define who will get which links
$cmLinkIdsPerRole = array(
				'root'           => array('configlogin', 'configseason'),
				'admin'          => array(),
				'teamadmin'      => array(),
				'gameadmin'      => array(),
				'memberadmin'    => array(),
				'trainerfinance' => array(),
				'memberfinance'  => array(),
				'memberedit'     => array(),
				'memberview'     => array(),
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

<div class="row">
	<div class="col-md-12">

		<div class="panel panel-info">
			<div class="panel-heading">
				Clubman
			</div>
			<div class="panel-body">
				<?php
					//pr($clubman);
				?>
				<dl>
				<?php foreach ($clubman as $oneclubmankey => $oneclubmanesetting) : ?>
					<dt>
						<?=$oneclubmankey?>
					</dt>
					<dd>
						<?=$oneclubmanesetting?>
					</dd>
				<?php endforeach; ?>
				<dl>
			</div>
		</div>

		<!--
		<div class="panel panel-info">
			<div class="panel-heading">
				Club
			</div>
			<div class="panel-body">
				<?php
					pr($club);
				?>
			</div>
		</div>
		-->

	</div>
</div>


<?php
	if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) {
		//	echo '<br/>';
		//	pr($user);
		//	echo '<hr/>currentUser';
		//	pr($currentUser);
		//	echo '<hr/>Clubman';
		//	pr($currentClubman);
		//	echo '<hr/>Club';
		//	pr($currentClub);
		//	echo '<hr/>cmCompleteConfig';
		//	pr($cmcompleteConfig);
		//	echo '<hr/>cmaclMerged';
		//	pr($cmaclMerged);
		//	echo '<hr/>cmmenuMerged';
		//	pr($cmmenuMerged);
		//	echo '<hr/>cmmenu';
		//	pr($cmmenu);
	}
?>
