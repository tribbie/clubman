<!-- app/View/Teammembers/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> Teamlid - <?=$teammember['Member']['name']?></h2>

<div class="row">

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				Foto's <?=$teammember['Member']['name'];?>
				<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) : ?>
					<span class='pull-right'><?=$this->Html->link('wijzig', array('controller' => 'members', 'action' => 'edit', $teammember['Teammember']['member_id'], 'picture'))?></span>
				<?php endif ; ?>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-8">
						<?php if (isset($teammember['Member']['Picturelicense']['location'])) : ?>
							<?=$this->Html->image($teammember['Member']['Picturelicense']['location'], array('title' => 'VVB licentie', 'class' => 'img-responsive'))?>
						<?php else : ?>
							<?=$this->Html->image('cmstyle/no_license_scan.png', array('title' => 'no image', 'class' => 'img-responsive', 'height' => 160))?>
						<?php endif; ?>
					</div>
					<div class="col-sm-4">
						<?php if (isset($teammember['Member']['Picture']['location'])) : ?>
							<?=$this->Html->image($teammember['Member']['Picture']['location'], array('title' => $teammember['Member']['name'], 'class' => 'img-responsive'))?>
						<?php else : ?>
							<?=$this->Html->image('cmstyle/no_picture.png', array('title' => 'no image', 'class' => 'img-responsive', 'height' => 160))?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<?=$teammember['Member']['name']?>
					<?php if($loggedIn) : ?>
						<span class='pull-right'><?=$this->Html->link('wijzig', array('controller' => 'teammembers', 'action' => 'edit', $teammember['Teammember']['id']))?></span>
					<?php endif ; ?>
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Team</dt>				<dd><?=$teammember['Team']['name']?></dd>
					<dt>Functie</dt>		<dd><?=$teammember['Teammember']['teamfunction']?></dd>
					<dt>Rugnummer</dt>	<dd><?= ($teammember['Teammember']['shirtnumber'] > 0 ? $teammember['Teammember']['shirtnumber'] : '-')?></dd>
					<dt>Prioriteit</dt>	<dd><?=$teampriorities[$teammember['Teammember']['teampriority']]?></dd>
					<dt>Opmerking</dt>	<dd><?=$teammember['Teammember']['remark']?></dd>
				</dl>
			</div>
		</div>
	</div>

</div>

<hr/>
<?php
if ($loggedIn) {
	echo $this->Html->link('Wijzig teamlid', array('controller' => 'teammembers', 'action' => 'edit', $teammember['Teammember']['id']))."\n";
}
?>

<?php
// pr($teammember);
?>
