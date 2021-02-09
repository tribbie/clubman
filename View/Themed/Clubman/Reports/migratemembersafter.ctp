<!-- app/View/Reports/migratemembersafter.ctp -->
<h2>Complete lijst <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden</h2>

<hr/>

<div class="row">

	<div class="table-responsive">
		<?php if (count($migratemembers) > 0) : ?>
		<table class='table table-striped'>
			<tr>
				<th>id</th>
				<th>lastname</th>
				<th>firstname</th>
				<th>birthdate</th>
				<th>tel</th>
				<th>email</th>
			</tr>
			<?php foreach ($migratemembers as $migratemember) : ?>
				<tr>
					<td><?=$migratemember['Migratemember']['id']?></td>
					<td><?=$migratemember['Migratemember']['lastname']?></td>
					<td><?=$migratemember['Migratemember']['firstname']?></td>
					<td><?=$migratemember['Migratemember']['birthdate']?></td>
					<td><?=$migratemember['Migratemember']['tel']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
					<td><?=$migratemember['Migratemember']['email']?></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php endif; ?>
	</div>

</div>

<?php
	pr($migratemembers);
?>
