<!-- app/View/Users/configure.ctp -->
<h2>Uw configuratie</h2>

<div class="row">
	<div class="col-md-12">

		<div class="panel panel-info">
			<div class="panel-heading">
				Clubman
			</div>
			<div class="panel-body">
				<?php
					pr($currentClubman);
				?>
			</div>
			<div class="panel-heading">
				Club
			</div>
			<div class="panel-body">
				<?php
					pr($currentClub);
				?>
			</div>
		</div>

		<hr/>
		<?php
		// first, define all links
		$cmLinks = array(
						'config' => array('linktext' => 'Configureer', 'linkoptions' => array('controller' => 'clubmansettings', 'action' => 'configure'))
					);
		// then, define who will get which links
		$cmLinkIdsPerRole = array(
						'root'           => array('config'),
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
