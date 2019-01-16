<!-- app/View/Members/unlinkpictures.ctp -->
<h2>Loskoppelen <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> foto's: categorie <?=$categorydata[$category]['categorystring'];?></h2>

<?php if (count($linklist) == 0) : ?>

	<div class="panel panel-info">
		<div class="panel-heading">Belangrijke informatie</div>
		<div class="panel-body">
			<p>
				Geen foto's gevonden die in aanmerking komen om los te koppelen in deze categorie.<br/>
			</p>
		</div>
	</div>

<?php else : ?>

<div class="pictures form">
<?php echo $this->Form->create('Member');?>

	<div class="panel panel-info">
		<div class="panel-heading">Belangrijke informatie</div>
		<div class="panel-body">
			<p>
				<strong>Pas op!</strong> Alle foto's zijn automatisch al aangevinkt om los te koppelen.<br/>
				Vink de foto's <strong>af</strong> die je <strong>niet</strong> wil loskoppelen.
			</p>
			<p>
				Vergeet niet te bewaren.
			</p>
		</div>
	</div>

	<?php
		echo '<table width="100%">';
		echo '<tr>';
		echo '<th width="20%">Foto</th>';
		echo '<th width="50%">Naam</th>';
		echo '<th width="10%">Maak los</th>';
		echo '</tr>';

		$mcount = 0;
		foreach ($linklist as $linkitem) {
			echo '<tr>';
			echo '<td>'.$this->Html->image($linkitem['Member']['image'], array('title' => $linkitem['Member']['image_id'], 'height' => '120')).'</td>';
			echo '<td title="'.$linkitem['Member']['id'].'">' . $linkitem['Member']['membername'] . '</td>';
			echo '<td>';
			echo $this->Form->hidden('Member.'.$mcount.'.id', array('value' => $linkitem['Member']['id']));
			echo $this->Form->hidden('Member.'.$mcount.'.image_id', array('label' => 'test', 'class' => 'inputfield', 'value' => $linkitem['Member']['image_id']));
			echo $this->Form->input('Member.'.$mcount.'.unlinkok', array('label' => false, 'class' => 'checkpicture', 'type' => 'checkbox', 'checked'=>true));
			echo '</td>';
			echo '</tr>' . "\n";
			$mcount += 1;
		}
		echo '</table>';
	?>
	<p>
		<?php echo $this->Form->end(__('Ontkoppel'), array('class' => 'button'));?>
	</p>
<div class="crlf"></div>
</div>
<?php endif; ?>


<br/>
<hr/>

<?php
// if (isset($categorydata)) pr($categorydata);
// if (isset($postdata)) pr($postdata);
// if (isset($savedata)) pr($savedata);
// if (isset($linklist)) pr($linklist);
// if (isset($allmembers)) pr($allmembers);
?>
