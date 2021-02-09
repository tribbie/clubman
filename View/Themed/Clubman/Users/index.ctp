<!-- app/View/Users/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> gebruikers</h2>

<?=$this->Html->link('Nieuwe gebruiker', array('controller' => 'users', 'action' => 'add'))?>
<hr/>

<div class="table-responsive">
	<table class='table table-striped table-condensed normalelijst'>
		<tr class="groupheader info">
			<th>Gebruiker</th>
			<th>Status</th>
			<th>Rol</th>
			<th>Naam</th>
			<th>Email</th>
			<th>Opmerking</th>
			<th>Aktie</th>
		</tr>
		<?php foreach ($users as $user) : ?>
			<tr><!--<?=$user['User']['uuid']?>-->
				<td><?=$this->Html->link($user['User']['username'], array('controller' => 'users', 'action' => 'view', $user['User']['id']))?></td>
				<td><?=(($user['User']['active']) ? '<span style="color: green">actief' : '<span style="color: red" title="deze gebruiker kan niet inloggen">inactief')?></span></td>
				<td><?=$user['User']['role']?></td>
				<td><?=$user['Member']['firstname']?> <?=$user['Member']['lastname']?></td>
				<td><?=$user['Member']['email']?></td>
				<td><?=$user['User']['remark']?></td>
				<td>
					<?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'users', 'action' => 'edit', $user['User']['id']), array('title' => 'wijzig deze gebruiker', 'escape' => false))?>
					<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
						<?=$this->Html->link('<span class="glyphicon glyphicon-asterisk"></span>', array('controller' => 'users', 'action' => 'resetpassword', $user['User']['id']), array('title' => 'reset wachtwoord', 'escape' => false, 'confirm' => 'Ben je zeker dat je het wachtwoord wil resetten?'))?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>


<?php
	//echo '<hr/>';
	//pr($users);
?>
