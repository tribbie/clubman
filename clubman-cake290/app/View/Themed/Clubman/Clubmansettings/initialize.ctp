<!-- app/View/Users/configure.ctp -->
<h2>Uw configuratie</h2>

<div class="row">
	<div class="col-md-6">

		<div class="panel panel-info">
			<div class="panel-heading">
				Algemeen
			</div>
			<div class="panel-body">
				<?php
					echo 'Clubman';
					pr($currentClubman);
					echo '<hr/>';
					echo 'Club';
					pr($currentClub);
				?>
			</div>
		</div>

		<hr/>
		<?php
		// first, define all links
		$cmlinks = array(
						'config' => array('linktext' => 'Configureer', 'linkoptions' => array('controller' => 'users', 'action' => 'configure'))
					);
		// then, define who will get which links
		$cmshowlinks = array(
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
			foreach ($cmshowlinks[$currentUser['role']] as $cmlinkid) {
				echo $this->Html->link($cmlinks[$cmlinkid]['linktext'], $cmlinks[$cmlinkid]['linkoptions'])."<br/>\n";
			}
		}
		?>

	</div>
</div>


<div style="position:fixed;height:100%;width:100%;margin:0px;">

    <iframe src="http://www.volleyscores.be/integrate/club/VB-1072" style="margin:0px;border:1px solid #000;width:100%;height:100%" />

</div>

<?php
	if ($loggedIn and (in_array($currentUser['role'], array('root')))) {
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
