<!-- app/View/Users/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> gebruiker <?=$user['User']['username'];?></h2>

<div class="row">
	<div class="col-md-6">

		<div class="panel panel-info">
			<div class="panel-heading">
				Algemeen
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Gebruiker</dt>	<dd><?=$user['User']['username']?></dd>
					<dt>Naam lid</dt>		<dd><?=$user['Member']['name']?></dd>
					<dt>Rol</dt>				<dd><?=$user['User']['role']?></dd>
					<dt>Vergunning</dt>	<dd><?=$user['Member']['licensenumber']?></dd>
					<dt>E-mail</dt>			<dd><?=$user['Member']['email']?></dd>
					<dt>aka</dt>				<dd><?=$user['Member']['nickname']?></dd>
					<dt>Opmerking</dt>	<dd><?=$user['User']['remark']?></dd>
				</dl>
			</div>
		</div>

	</div>
</div>

<hr/>
<?= $this->Html->link('Terug', array('controller' => 'users', 'action' => 'index'))."\n"; ?>

<?php
// pr($user);
?>
