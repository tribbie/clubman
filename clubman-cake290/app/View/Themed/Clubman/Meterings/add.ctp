<script>
	$(document).ready(function() {
//	the tabs and accordions
		$("#tabs").tabs();
		$('.datepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1 } );
//		$("#accordion").accordion({ collapsible: true, active: false });
});
</script>
<h1>Nieuwe meting
<?php
if (isset($this->data['Metering']['member_id']) and ($this->data['Metering']['member_id'] <> '')) {
	echo 'voor ' . $members[$this->data['Metering']['member_id']];
}
?>
</h1>

<div class="meterings form">
<?php
	echo $this->Form->create('Metering');
?>

	<div id="tabs">
		<ul>
			<li><a href="#tab1">Lid</a></li>
			<li><a href="#tab2">Engagement</a></li>
			<li><a href="#tab3">Basis</a></li>
			<li><a href="#tab4">Specifiek</a></li>
		</ul>
<!-- -------------------------------------------------------------------------------------------------------------------------- -->
	<!-- Begin tab 1 -->
		<div id="tab1">
			<div class="simplebox">

<?php
	echo $this->Form->input('id', array('type' => 'hidden'));
	echo $this->Form->input('season', array('type' => 'hidden', 'default' => $currentSeason));
	if (!isset($this->data['Metering']['member_id']) or ($this->data['Metering']['member_id'] == '')) {
		echo $this->Form->input('member_id', array('class' => 'inputfield', 'empty' => true));
	} else {
		echo $this->Form->input('member_id', array('type' => 'hidden'));
	}
	echo $this->Form->input('metering_date', array('class' => 'inputfield datepicker', 'type' => 'text', 'value' => $meteringdate));
	echo $this->Form->input('length', array('label' => 'Lengte (cm)', 'class' => 'inputfield', 'type' => 'text'));
	echo $this->Form->input('weight', array('label' => 'Gewicht (kilogram)', 'class' => 'inputfield', 'type' => 'text'));
	echo $this->Form->input('attack_height', array('label' => 'Reikwijdte aanval (cm)', 'class' => 'inputfield', 'type' => 'text'));
	echo $this->Form->input('block_height', array('label' => 'Reikwijdte blok (cm)', 'class' => 'inputfield', 'type' => 'text'));
	echo $this->Form->input('suicide', array('label' => 'Suicide (seconden)', 'class' => 'inputfield', 'type' => 'text'));
?>
			</div> <!-- simplebox -->
		</div> <!-- tab1 -->

	<!-- Begin tab 2 -->
		<div id="tab2">
			<div class="simplebox">
<?php
	echo $this->Form->input('score_presence', 
				array(
					'label' => $meteringvalues['score_presence']['label'],
					'options' => $meteringvalues['score_presence']['options'],
					'empty' => $meteringvalues['score_presence']['empty']
				));
	echo $this->Form->input('score_effort',
				array(
					'label' => $meteringvalues['score_effort']['label'],
					'options' => $meteringvalues['score_effort']['options'],
					'empty' => $meteringvalues['score_effort']['empty']
				));
	echo $this->Form->input('score_ambition',
				array(
					'label' => $meteringvalues['score_ambition']['label'],
					'options' => $meteringvalues['score_ambition']['options'],
					'empty' => $meteringvalues['score_ambition']['empty']
				));
?>
			</div> <!-- simplebox -->
		</div> <!-- tab2 -->

	<!-- Begin tab 3 -->
		<div id="tab3">
			<div class="simplebox">
<?php
	echo $this->Form->input('score_overhand', 
				array(
					'label' => $meteringvalues['score_overhand']['label'],
					'options' => $meteringvalues['score_overhand']['options'],
					'empty' => $meteringvalues['score_overhand']['empty']
				));
	echo $this->Form->input('score_underhand',
				array(
					'label' => $meteringvalues['score_underhand']['label'],
					'options' => $meteringvalues['score_underhand']['options'],
					'empty' => $meteringvalues['score_underhand']['empty']
				));
	echo $this->Form->input('score_stroke',
				array(
					'label' => $meteringvalues['score_stroke']['label'],
					'options' => $meteringvalues['score_stroke']['options'],
					'empty' => $meteringvalues['score_stroke']['empty']
				));
	echo $this->Form->input('score_feetwork',
				array(
					'label' => $meteringvalues['score_feetwork']['label'],
					'options' => $meteringvalues['score_feetwork']['options'],
					'empty' => $meteringvalues['score_feetwork']['empty']
				));
	echo $this->Form->input('score_runup',
				array(
					'label' => $meteringvalues['score_runup']['label'],
					'options' => $meteringvalues['score_runup']['options'],
					'empty' => $meteringvalues['score_runup']['empty']
				));
?>
			</div> <!-- simplebox -->
		</div> <!-- tab3 -->

	<!-- Begin tab 4 -->
		<div id="tab4">
			<div class="simplebox">
<?php
	echo $this->Form->input('score_serve',
				array(
					'label' => $meteringvalues['score_serve']['label'],
					'options' => $meteringvalues['score_serve']['options'],
					'empty' => $meteringvalues['score_serve']['empty']
				));
	echo $this->Form->input('score_pass',
				array(
					'label' => $meteringvalues['score_pass']['label'],
					'options' => $meteringvalues['score_pass']['options'],
					'empty' => $meteringvalues['score_pass']['empty']
				));
	echo $this->Form->input('score_set',
				array(
					'label' => $meteringvalues['score_set']['label'],
					'options' => $meteringvalues['score_set']['options'],
					'empty' => $meteringvalues['score_set']['empty']
				));
	echo $this->Form->input('score_attack',
				array(
					'label' => $meteringvalues['score_attack']['label'],
					'options' => $meteringvalues['score_attack']['options'],
					'empty' => $meteringvalues['score_attack']['empty']
				));
	echo $this->Form->input('score_block',
				array(
					'label' => $meteringvalues['score_block']['label'],
					'options' => $meteringvalues['score_block']['options'],
					'empty' => $meteringvalues['score_block']['empty']
				));
	echo $this->Form->input('score_defense',
				array(
					'label' => $meteringvalues['score_defense']['label'],
					'options' => $meteringvalues['score_defense']['options'],
					'empty' => $meteringvalues['score_defense']['empty']
				));
?>
			</div> <!-- simplebox -->
		</div> <!-- tab4 -->

<br/>
<!-- Remark field and closing the form -->
		<div class="simplebox">
<?php
	echo $this->Form->input('remark', array('label' => 'Opmerking', 'class' => 'inputfield'));
	echo $this->Form->end('Bewaar meting');
?>
		</div> <!-- simplebox -->
</div>


<?php
//	echo pr($this->data);
//	echo pr($members);
?>
