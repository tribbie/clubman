<!-- app/View/Users/login.ctp -->
<?= $this->Flash->render('auth') ?>

<h2>Clubman login scherm</h2>

<div class="well">
	Welkom beste Clubman gebruiker, gelieve hier in te loggen.<br/>
	Aan alle anderen, deze pagina is enkel voor Clubman gebruiker.<br/>
</div>

<?php if (isset($currentClubman['allowlogin']) and ($currentClubman['allowlogin'] == 'no')) : ?>
	<div class="row">
	  <div class="col-md-2"></div>
	  <div class="col-md-8">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<p>
						Logins zijn momenteel beperkt mogelijk.
					</p>
				</div>
				<div class="panel-body">
					<p>
						Er zijn onderhoudswerken aan de gang.
					</p>
					<p>
						Enkel de hoofdbeheerder kan nu inloggen.
					</p>
					<p>
						Andere gebruikers, gelieve binnen een tijdje opnieuw te proberen.
					</p>
				</div>
			</div>
		</div>
	  <div class="col-md-2"></div>
	</div>
<?php else : ?>
<?php endif; ?>
	<div class="row">
	  <div class="col-md-2"></div>
	  <div class="col-md-8">
			<div class="clubman-form users">
				<?= $this->Form->create('User')?>
					<div class="form-group">
						<?= $this->Form->input('username', array('label' => 'Gebruikersnaam', 'class' => 'form-control', 'placeholder' => 'Gebruikersnaam', 'id' => 'focusme')) ?>
					</div>
					<div class="form-group">
						<?= $this->Form->input('password', array('label' => 'Wachtwoord', 'class' => 'form-control', 'placeholder' => 'Wachtwoord')) ?>
					</div>
				<?= $this->Form->end(array('label' => 'Log in', 'class' => 'btn btn-default')) ?>
			</div>
		</div>
	  <div class="col-md-2"></div>
	</div>
<div class="well">
	Geraak je niet binnen? Ben je je wachtwoord vergeten?<br/>
	Stuur dan een mailtje naar het <a class="boldlink" href="mailto:<?=(isset($cmclub['clubmail']['clubman']['email']) ? $cmclub['clubmail']['clubman']['email'] : 'webmaster@'.(isset($cmclub['domain']) ? $cmclub['domain'] : 'oblivio.be'))?>">Clubman beheerder</a>, en je wachtwoord zal worden gereset.<br/>
	<br/>
	Het Clubman team.<br/>
</div>

<?php
	if (isset($users)) pr($users);
?>
