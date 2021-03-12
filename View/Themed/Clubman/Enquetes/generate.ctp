<!-- app/View/Enquetes/generate.ctp -->
<h2>Genereer enquêtes voor seizoen <?=$currentSeason?></h2>

<div class="panel panel-primary">
	<div class="panel-heading">Belangrijke informatie</div>
	<div class="panel-body">
		<p>
			Gelieve dit formulier enkel te gebruiken om <strong>eenmalig (per seizoen)</strong> de enquêtes te genereren.<br/>
			Dit formulier zal voor elk lid dat je selecteert, een "lege" enquete aanmaken.<br/>
			Bestaat er al een enquete? Dan wordt deze evenwel niet overschreven.
		</p>
		<p>
			Na het genereren van deze enquêtes moet de mailing nog uitgestuurd worden.<br/>
			Dit gedeelte is momenteel nog niet helemaal proper beschikbaar in Clubman.<br/>
		</p>
		<ul>
			Voorlopig moet je:
			<li>een mailing aanmaken, en zorgen dat je in de categorie "ledenbevraging" ingeeft (check die van vorig jaar).</li>
			<li>daarna vanuit de mailing de individuele mails aanmaken. Voor alle gegenereerde enquetes wordt zo een mail voorbereid.</li>
		</ul>
	</div>
</div>

<div class="enquetes form">
	<?= $this->Form->create('Enquete'); ?>

	<?= $this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason)) ?>


	<div class="panel panel-info">
	  <div class="panel-heading">
	    <h4 class="panel-title">Stap 1 - Kies categorieën / teams</h4>
	  </div>
	  <div class="panel-body">
			<p>
				Selecteer de categorieën / teams voor wie je de enquêtes wil genereren, en klik dan op "Toon lijst".<br/>
				Je krijgt dan alle leden die als hoofdteam in één van deze categorieën zitten.<br/>
				In stap 2 kan je dan nog individuele leden afvinken.
			</p>
			<hr/>
			<div class="form-group">
					<div class="checkbox">
						<label>
							<?=$this->Form->input('teamcategories', array('label' => false, 'div' => false, 'type' => 'select', 'multiple' => 'checkbox', 'options' => $teamcategories)) ?>
						</label>
					</div>
			</div>
			<div class="form-group">
					<?=$this->Form->submit('Toon lijst', array('name' => 'preview', 'class' => 'btn btn-default')) ?>
			</div>
	  </div>
	</div>

<div class="panel panel-info">
  <div class="panel-heading">
    <h4 class="panel-title">Stap 2 - Kies leden</h4>
  </div>
  <div class="panel-body">
		<?php if (count($teammemberenquetes) > 0) : ?>
			<p>
				(De)Selecteer de gewenste leden.<br/>Vergeet onderaan niet op "Genereer enquêtes" te klikken!
			</p>
			<hr/>
			<div class="form-group">
					<div class="checkbox">
						<label>
							<?=$this->Form->input('memberlistresult', array('label' => false, 'div' => false, 'type' => 'select', 'multiple' => 'checkbox', 'options' => $memberlist, 'selected' => array_keys($memberlist)))?>
						</label>
					</div>
			</div>
			<div class="form-group">
					<?= $this->Form->submit('Genereer enquêtes', array('name' => 'generate', 'class' => 'btn btn-default')) ?>
			</div>
		<?php endif ; ?>
	</div>
</div>

<?= $this->Form->end(); ?>




<div class="spacer"></div>
</div>

<hr/>

<?php
//	pr($teamcategories);
//	pr($teamcategorielist);
//	echo '<hr/>';
//	pr($memberlist);
//	pr($selectedmembers);
//	pr($generatedenquetes);
//	pr($teammemberenquetes);
//	echo '<hr/>';
//	pr($this->request->data);
?>
