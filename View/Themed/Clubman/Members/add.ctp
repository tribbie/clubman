<!-- app/View/Members/add.ctp -->
<h2>Nieuw <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> lid</h2>
<script>
$(document).ready(function(){
	$('.birthdatepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1, yearRange: "-99:+0", changeMonth: true, changeYear: true } );
	$('.datepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1 } );
//	Set initial state of the "camp" part
	if ($("#MemberCamp").is(":checked")) {
		$("#camp_info").show();
	} else {
		$("#camp_info").hide();
	}
//	Switch "camp" part when clicking
	$("#MemberCamp").click(function() {
		if ($(this).is(":checked")) {
			$("#camp_info").show(200);
		} else {
			$("#camp_info").hide(200);
		}
	});
});
</script>

<div class="row">

	<div class="col-xs-12">
		<div class="panel panel-info">
		  <div class="panel-heading">Belangrijke informatie</div>
		  <div class="panel-body">
				<p>
					<font color="red">Gelieve eerst bij de <?=$this->Html->link('inactieve leden', array('controller' => 'members', 'action' => 'index', 'inactive'))?> te checken of het geen ex-lid is dat weerkeert.</font><br/>
					In dit geval kan je dat lid best weer actief maken.<br/>
					<br/>
					Gegevens die je nu nog niet hebt laat je maar blank, je kan ze later steeds aanpassen of bijvullen.<br/>
					<br/>
					Vergeet onderaan niet op "Bewaar" te klikken!<br/>
				</p>
		  </div>
		</div>

		<div class="members form">
			<?=$this->Form->create('Member', array('class' => 'form-horizontal'))?>

			<!--<?= $this->Form->input('id', array('type'  => 'hidden')); ?>-->

			<?php
				echo$this->element('member-form-general');
				echo$this->element('member-form-team');
				echo$this->element('member-form-contact');
				echo$this->element('member-form-finance');
				echo$this->element('member-form-other');
			?>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<?=$this->Form->button(__('Bewaar'), array('class' => 'btn btn-default', 'type' => 'submit'))?>
				</div>
			</div>
			<?=$this->Form->end()?>

		</div>

	</div>
</div>

<hr/>
<?= $this->Html->link('Terug', array('controller' => 'members', 'action' => 'index'))."\n"; ?>


<?php
// pr($member);
?>
