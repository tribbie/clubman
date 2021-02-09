<!-- app/View/Memberships/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden</h2>

<div class="row">
	<div class="col-xs-12">
			<?= $this->Html->link('Nieuw lid', array('controller' => 'memberships', 'action' => 'add'), array('title' => 'nieuw lid')); ?>
			<hr/>
	</div>
</div>


<div class="row">
	<div class="col-xs-12">

		<div class="cm-membercolumns">
		<?php $currentfirstletter = ''; ?>
		<?php $newfirstletter = ''; ?>
		<?php foreach ($memberships as $membership) : ?>
			<?php $newfirstletter = strtoupper($membership['Person']['lastname'][0]); ?>
			<?php if ($newfirstletter <> $currentfirstletter) : ?>
				<?php $currentfirstletter = $newfirstletter; ?>
						<div class="bg-info">
							<?=$newfirstletter?>
						</div>
			<?php endif ; ?>
			<?php
			 if ($membership['Membership']['active'] == true) {
				$membershipbgclass = 'bg-default';
				$membershiptitle = 'actief';
			} else {
				$membershipbgclass = 'bg-warning';
				$membershiptitle = 'inactief';
			}
			?>
			<div class="<?=$membershipbgclass?>">
				<?= $this->Html->link($membership['Person']['lastname'] . ' ' . $membership['Person']['firstname'], array('controller' => 'memberships', 'action' => 'view', $membership['Membership']['id']), array('title' => $membershiptitle)); ?>
			</div>
		<?php endforeach; ?>
		</div>

	</div>
</div>

<?php
	pr($memberships);
?>
