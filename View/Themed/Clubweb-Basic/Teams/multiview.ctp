<!-- app/View/Teams/multiview.ctp -->
<div class="teamindex">
	<?php foreach ($teams as $team) : ?>
		<?=$this->element('oneteam',  array("team" => $team));?>
	<?php endforeach; ?>
</div>

<div class='crlf'></div>
<br/>

<hr/>

<?php
	//pr($team['Teammember']);
	// pr($namedparameters);
	// pr($teams);
?>
