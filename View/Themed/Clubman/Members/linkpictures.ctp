<!-- app/View/Members/linkpictures.ctp -->
<h2>Linken <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> foto's: categorie <?=$categorydata[$category]['categorystring'];?></h2>

<?php if (count($linklist) == 0) : ?>

	<div class="panel panel-info">
		<div class="panel-heading">Belangrijke informatie</div>
		<div class="panel-body">
			<p>
				Geen foto's gevonden die in aanmerking komen om te linken in deze categorie.<br/>
				Gelieve eens te proberen met een van onderstaande formaten.
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
				<strong>Pas op!</strong> Alle foto's zijn automatisch al aangevinkt om te linken.<br/>
				Vink de foto's <strong>af</strong> die je <strong>niet</strong> wil linken.
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
		echo '<th width="10%">Juist</th>';
		echo '</tr>';

		$mcount = 0;
		foreach ($linklist as $linkitem) {
			echo '<tr>';
			echo '<td>'.$this->Html->image($linkitem['Member']['image'], array('title' => $linkitem['Member']['image_id'], 'height' => '120')).'</td>';
			echo '<td title="'.$linkitem['Member']['id'].'">' . $linkitem['Member']['membername'] . '</td>';
			echo '<td>';
			echo $this->Form->hidden('Member.'.$mcount.'.id', array('value' => $linkitem['Member']['id']));
			echo $this->Form->hidden('Member.'.$mcount.'.image_id', array('label' => 'test', 'class' => 'inputfield', 'value' => $linkitem['Member']['image_id']));
			echo $this->Form->input('Member.'.$mcount.'.linkok', array('label' => false, 'class' => 'checkpicture', 'type' => 'checkbox', 'checked'=>true));
			echo '</td>';
			echo '</tr>' . "\n";
			$mcount += 1;
		}
		echo '</table>';
	?>
	<p>
		<?php echo $this->Form->end(__('Bewaar'), array('class' => 'button'));?>
	</p>
<div class="crlf"></div>
</div>
<?php endif; ?>


<br/>
<hr/>

<p>
	Gesupporteerde formaten:
	<ul>
	<?php foreach ($formatdata as $formatkey => $formatvalue) : ?>
		<li>
			<?= $this->Html->link($formatvalue['example'], array('controller' => 'members', 'action' => 'linkpictures', $category, $formatkey), array('title' => 'retry with this example')); ?>
		</li>
	<?php endforeach; ?>
	</ul>
</p>


<br/>
<hr/>

<?php
// if (isset($categorydata)) pr($categorydata);
// if (isset($postdata)) pr($postdata);
// if (isset($savedata)) pr($savedata);
// if (isset($pictures)) pr($pictures);
// if (isset($linklist)) pr($linklist);
// if (isset($memberlist)) pr($memberlist);
// if (isset($allmembers)) pr($allmembers);
// if (isset($membernames)) pr($membernames);
?>
