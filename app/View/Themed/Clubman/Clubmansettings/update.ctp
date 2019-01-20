<!-- app/View/Clubmansettings/view.ctp -->
<h2>Uw configuratie</h2>

<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
		<div class="clubman-form settings">
			<?= $this->Form->create('Clubmansetting')?>
				<div class="form-group">
					<?= $this->Form->input('settingname', array('label' => 'Setting', 'class' => 'form-control', 'placeholder' => 'Setting', 'id' => 'focusme')) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->input('settingvalue', array('label' => 'Waarde', 'class' => 'form-control', 'placeholder' => 'Waarde')) ?>
				</div>
			<?= $this->Form->end(array('label' => 'Pas aan', 'class' => 'btn btn-default')) ?>
		</div>
	</div>
  <div class="col-md-2"></div>
</div>


<div class="row">
	<div class="col-md-12">

		<div class="panel panel-info">
			<div class="panel-heading">
				Clubman
			</div>
			<div class="panel-body">
				<?php
					pr($clubman);
				?>
			</div>
			<div class="panel-heading">
				Club
			</div>
			<div class="panel-body">
				<?php
					pr($club);
				?>
			</div>
			<div class="panel-heading">
				Request
			</div>
			<div class="panel-body">
				<?php
					pr($req);
				?>
			</div>
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
			echo '<hr/>request data';
			pr($reqdata);
	}
?>


<script>
 $(document).ready(function(){
	 var settingsJSON = <?=json_encode($club)?>;
   $("select#focusme").change(function(){
      var sIndex = $("select#focusme :selected").text();
			var sValue = settingsJSON[sIndex];
      $("input#ClubmansettingSettingvalue").val(sValue);
   });
});
</script>
