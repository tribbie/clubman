<!-- app/View/Members/edit.ctp -->
<h2>Wijzig <?=$part['label'];?> informatie van <?=$member['Member']['name'];?></h2>
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
					Vergeet onderaan niet op "Bewaar" te klikken!
				</p>
		  </div>
		</div>

		<div class="members form">
			<?=$this->Form->create('Member', array('class' => 'form-horizontal'))?>

			<?= $this->Form->input('id', array('type'  => 'hidden')); ?>

			<?php
			if (($part['value'] == 'all') or ($part['value'] == 'general')) {
				echo $this->element('member-form-general');
			}
			if (($part['value'] == 'all') or ($part['value'] == 'team')) {
				echo $this->element('member-form-team');
			}
			if (($part['value'] == 'all') or ($part['value'] == 'contact')) {
				echo $this->element('member-form-contact');
			}
			if (($part['value'] == 'all') or ($part['value'] == 'finance')) {
				echo $this->element('member-form-finance');
			}
			if (($part['value'] == 'all') or ($part['value'] == 'other')) {
				echo $this->element('member-form-other');
			}
			if ($part['value'] == 'picture') {
				echo $this->element('member-form-picture');
			}
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
<?= $this->Html->link('Terug', array('controller' => 'members', 'action' => 'view', $member['Member']['id']))."\n"; ?>


<?php
// pr($member);
?>
