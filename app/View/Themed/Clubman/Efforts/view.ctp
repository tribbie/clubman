<!-- app/View/Efforts/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> prestatie</h2>

<?= $this->Html->link('Wijzig prestatie', array('controller' => 'efforts', 'action' => 'edit', $effort['Effort']['id']))."\n"; ?>
<hr/>

<div class="row">

	<div class="col-md-6">

		<div class="panel panel-info">
			<div class="panel-heading">
				<?=$effort['Member']['name'];?>
				<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'memberadmin']))) : ?>
					<span class='pull-right'><?= $this->Html->link('wijzig', array('controller' => 'efforts', 'action' => 'edit', $effort['Effort']['id'])) ?></span>
				<?php endif ; ?>
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Taak</dt>			<dd><?=$effort['Effort']['taskname'];?></dd>
					<dt>Team</dt>			<dd><?=$effort['Team']['name'];?></dd>
					<dt>Datum</dt>		<dd><?=$effort['Effort']['taskdate_nice'];?></dd>
					<dt>Tijd</dt>			<dd><?=$effort['Effort']['tasktime_nice'];?></dd>
					<dt>Duur</dt>			<dd><?=$effort['Effort']['taskduration'];?> minuten</dd>
					<dt>Opmerking</dt><dd><?=$effort['Effort']['remark'];?></dd>
				</dl>
			</div>
		</div>

	</div>

</div>

<?php
// pr($effort);
?>
