<!-- File: /app/View/Uploads/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> <?=$category;?></h2>

<div class="row">

	<div class="col-md-6">

		<div class="panel panel-info">
			<div class="panel-heading">
				Algemeen
				<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'memberadmin']))) : ?>
					<span class='pull-right'><?= $this->Html->link('wijzig', array('controller' => 'uploads', 'action' => 'edit', $upload['Upload']['id'])) ?></span>
				<?php endif ; ?>
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Categorie</dt>		<dd><?=$upload['Upload']['category']?></dd>
					<dt>Seizoen</dt>			<dd><?=$upload['Upload']['season']?></dd>
					<dt>Naam</dt>					<dd><?=$upload['Upload']['name']?></dd>
					<dt>Beschrijving</dt>	<dd><?=$this->Markdown->transform($upload['Upload']['description'])?></dd>
					<dt>Locatie</dt>			<dd><?=$upload['Upload']['location']?></dd>
					<dt>Type</dt>					<dd><?=$upload['Upload']['type']?></dd>
					<dt>Grootte</dt>			<dd><?=$upload['Upload']['size']?></dd>
					<dt>Datum</dt>				<dd><?=$upload['Upload']['stamp_nice']?></dd>
					<dt>Oplader</dt>			<dd><?=$upload['Upload']['uploader']?></dd>
					<dt>Status</dt>				<dd><?=$upload['Upload']['status']?></dd>
					<dt>Zoektermen</dt>		<dd><?=$upload['Upload']['tags']?></dd>
				</dl>
			</div>
		</div>

	</div>



	<div class="col-md-6">

		<?php if ($isPicture) : ?>

			<div class="panel panel-info">
				<div class="panel-heading">
					Foto: <?=$upload['Upload']['location']?>
				</div>
				<div class="panel-body">
					<p>
						<img class="img-responsive" src="<?=$fullLocation?>" title="<?=$upload['Upload']['name']?>" />
					</p>
				</div>
			</div>

		<?php else : ?>

			<div class="panel panel-info">
				<div class="panel-heading">
					Bestand: <?=$upload['Upload']['location']?>
				</div>
				<div class="panel-body">
					<p>
						<a href="<?=$fullLocation?>">
							<img class="img-responsive" src="<?=$thumbnail['location']?>" title="<?=$thumbnail['title']?>" />
						</a>
					</p>
				</div>
			</div>

		<?php endif ; ?>
	</div>

</div>

<hr/>
<?php
if ($loggedIn) {
	echo $this->Html->link('Wijzig upload', array('controller' => 'uploads', 'action' => 'edit', $upload['Upload']['id']))."\n";
	echo '<br/>'."\n";
	echo $this->Html->link('Terug naar overzicht', array('controller' => 'uploads', 'action' => 'index'))."\n";
}
?>

<?php
// pr($upload);
?>
