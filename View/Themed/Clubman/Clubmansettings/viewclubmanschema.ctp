<!-- app/View/Clubmansettings/view.ctp -->
<h2>Uw configuratie</h2>

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
		</div>

	</div>
</div>


<?php
	if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) {
		//echo '<hr/>currentUser';
		//pr($currentUser);
		//echo '<hr/>cmaclMerged';
		//pr($cmaclMerged);
		echo '<hr/>Schema';
		pr($clubmanschema);
	}
?>
