<!-- app/View/Users/profile.ctp -->
<h2>Uw gebruikersprofiel (<?=$currentUser['username'];?>)</h2>

<?php
/// first, define all links
$cmLinks = array(
				'chgpwd' => array('linktext' => 'Verander je wachtwoord', 'linkoptions' => array('controller' => 'users', 'action' => 'changepassword', $currentUser['id'])),
				//'settings' => array('linktext' => 'Bekijk de instellingen', 'linkoptions' => array('controller' => 'clubmansettings', 'action' => 'view')),
				'logout' => array('linktext' => 'Log uit', 'linkoptions' => array('controller' => 'users', 'action' => 'logout')),
			);
/// then, define who will get which links
$cmLinkIdsPerRole = array(
				'root'           => array('chgpwd', 'logout'),
				'admin'          => array('chgpwd'),
				'teamadmin'      => array('chgpwd'),
				'gameadmin'      => array('chgpwd'),
				'memberadmin'    => array('chgpwd'),
				'trainerfinance' => array('chgpwd'),
				'memberfinance'  => array('chgpwd'),
				'memberedit'     => array('chgpwd'),
				'memberview'     => array('chgpwd'),
				'trainer'        => array('chgpwd'),
				'member'         => array('chgpwd')
			);
/// finally, show them links
if ($loggedIn) {
	/// Merge for cumulated roles
	$mergedLinkIdsToShow = $this->Link->mergeLinkIds($cmLinkIdsPerRole, $cmCurrentRoles);
	echo $this->Link->showLinks($cmLinks, $mergedLinkIdsToShow);
}
?>
<hr/>


<div class="row">
	<div class="col-md-6">

		<div class="panel panel-info">
			<div class="panel-heading">
				Algemeen
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Gebruiker</dt><dd><?=$currentUser['username']?></dd>
					<dt>Naam lid</dt><dd><?=$currentUser['Member']['name']?></dd>
					<dt>Rol(len)</dt><dd><?=$currentUser['role']?></dd>
					<dt>Vergunning</dt><dd><?=$currentUser['Member']['licensenumber']?></dd>
					<dt>E-mail</dt><dd><?=$currentUser['Member']['email']?></dd>
					<dt>aka</dt><dd><?=$currentUser['Member']['nickname']?></dd>
				</dl>
			</div>
		</div>

	</div>
</div>


<?php
	//if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) {
	//	echo '<pre>';
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
	//	echo '</pre>';
	//}
?>
