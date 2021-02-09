<!-- app/View/Uploads/reports.ctp -->
<h2>Rapporten: <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> bestanden</h2>

<h3>Categoriën</h3>
<div class="row">

	<div class="col-xs-12 col-sm-6 col-md-4">

		<table class="table table-striped table-condensed normalelijst">
			<tr class="groupheader info">
				<th>upload categorie</th>
				<th>aantal uploads</th>
			</tr>
			<?php foreach ($categories as $categorykey => $categoryvalue) : ?>
				<tr>
					<td><?=$this->Html->link($categoryvalue, array('controller' => 'uploads', 'action' => 'category', $categorykey))?></td>
					<td class="text-right"><?=((isset($uploadcategories[$categorykey])) ? $uploadcategories[$categorykey] : '0')?></td>
				</tr>
			<?php endforeach ; ?>
		</table>

	</div>

</div>

<?php
// pr($uploadcategories);
// pr($uploads);
?>
