<!-- app/View/Members/index.ctp -->
<h2>Overzicht <?=(isset($memberfilter['label']) ? $memberfilter['label'] : '');?> <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden</h2>

<div class="row">
	<div class="col-xs-12">

		<div class="cm-membercolumns">
		<?php $currentfirstletter = ''; ?>
		<?php $newfirstletter = ''; ?>
		<?php foreach ($members as $member) : ?>
			<?php $newfirstletter = strtoupper($member['Member']['lastname'][0]); ?>
			<?php if ($newfirstletter <> $currentfirstletter) : ?>
				<?php $currentfirstletter = $newfirstletter; ?>
						<div class="bg-info">
							<?=$newfirstletter?>
						</div>
			<?php endif ; ?>
			<?php
			 if ($member['Member']['active'] == true) {
				$memberbgclass = 'bg-default';
				$membertitle = 'actief';
			} else {
				$memberbgclass = 'bg-warning';
				$membertitle = 'inactief';
			}
			?>
			<div class="<?=$memberbgclass?>">
				<?= $this->Html->link($member['Member']['name'], array('controller' => 'members', 'action' => 'view', $member['Member']['id']), array('title' => $membertitle)); ?>
			</div>
		<?php endforeach; ?>
		</div>

	</div>
</div>

<?php
// pr($members);
?>
