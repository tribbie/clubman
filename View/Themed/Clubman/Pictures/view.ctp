<!-- File: /app/View/Pictures/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> <?=$category?></h2>

<div class="row">

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				Foto: <?=$picture['Picture']['location'];?>
			</div>
			<div class="panel-body">
				<?=$this->Html->image($picture['Picture']['location'], array('title' => $picture['Picture']['location'], 'class' => 'img-responsive'))?>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				Algemeen
					<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin', 'teamadmin', 'memberadmin']))) : ?>
						<span class='pull-right'><?=$this->Html->link('wijzig', array('controller' => 'pictures', 'action' => 'edit', $picture['Picture']['id']))?></span>
					<?php endif ; ?>
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Categorie</dt>		<dd><?=$picture['Picture']['category']?></dd>
					<dt>Locatie</dt>			<dd><?=$picture['Picture']['location']?></dd>
					<dt>Beschrijving</dt>	<dd><?=$picture['Picture']['description']?></dd>
					<dt>Type</dt>					<dd><?=$picture['Picture']['type']?></dd>
					<dt>Grootte</dt>			<dd><?=$picture['Picture']['size']?></dd>
					<dt>Oplader</dt>			<dd><?=$picture['Picture']['uploader']?></dd>
					<dt>Opgeladen</dt>		<dd><?=$picture['Picture']['created']?></dd>
				</dl>
			</div>
		</div>
	</div>

</div>

<hr/>
<?=$this->Html->link('Wijzig foto', array('controller' => 'pictures', 'action' => 'edit', $picture['Picture']['id']))?>


<?php // pr($picture); ?>
