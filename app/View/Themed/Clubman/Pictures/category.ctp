<!-- app/View/Pictures/category.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> foto's: <?=$category;?></h2>

<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'memberadmin']))) : ?>
	<?=$this->Html->link('Voeg foto\'s toe', array('controller' => 'pictures', 'action' => 'add', $categorycode))?>
<?php endif; ?>
<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'memberadmin']))) : ?>
	<?php if (in_array($categorycode, array('memberid', 'member'))) : ?>
		<br/>
		<?=$this->Html->link('Hang foto\'s aan leden', array('controller' => 'members', 'action' => 'linkpictures', $categorycode))?>
		<br/>
		<?=$this->Html->link('Koppel foto\'s los van leden', array('controller' => 'members', 'action' => 'unlinkpictures', $categorycode))?>
	<?php endif; ?>
<?php endif; ?>
<hr/>

<div class="row">

	<div class="col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-condensed normalelijst">
				<tr class="groupheader info">
					<th>Locatie</th>
					<th>Type</th>
					<th>Grootte</th>
					<th>Oplader</th>
					<th>Aktie</th>
				</tr>
				<?php foreach ($pictures as $picture) : ?>
					<tr>
						<td><?=$this->Html->link($picture['Picture']['location'], array('controller' => 'pictures', 'action' => 'view', $picture['Picture']['id']))?></td>
						<td><?=$picture['Picture']['type']?></td>
						<td style='text-align: right'><?=$picture['Picture']['size']?></td>
						<td><?=$picture['Picture']['uploader']?></td>
						<td><?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'pictures', 'action' => 'edit', $picture['Picture']['id']), array('title' => 'wijzig deze foto', 'escape' => false))?></td>
					</tr>
				<?php endforeach ; ?>
			</table>
		</div>
	</div>

</div>

<hr/>

<?php
// pr($pictures);
?>
