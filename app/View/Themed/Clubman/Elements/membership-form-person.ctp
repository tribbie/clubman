<!-- app/View/Elements/membership-form-general.ctp -->
<h3>Persoon</h3>

<?= $this->Form->input('Person.id', array('type' => 'hidden')) ?>

<div class="form-group">
	<label class="col-sm-3 control-label">Geboortedatum</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Person.birthdate', array('label' => false, 'div' => false, 'class' => 'form-control birthdatepicker', 'type' => 'text'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Rijksregisternummer</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Person.nationalnumber', array('label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => 'enkel cijfers, geen streepjes'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">E-mail adres</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Person.email', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">GSM</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Person.mobile', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Aka</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Person.nickname', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'also known as'))?>
	</div>
</div>
