<!-- app/View/Elements/member-form-general.ctp -->
<h3>Algemeen</h3>

<div class="form-group">
	<label class="col-sm-3 control-label">Achternaam</label>
	<div class="col-sm-6">
		<?=$this->Form->input('lastname', array('label' => false, 'div' => false, 'class' => 'form-control', 'id' => 'focusme', 'required' => true))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Voornaam</label>
	<div class="col-sm-6">
		<?=$this->Form->input('firstname', array('label' => false, 'div' => false, 'class' => 'form-control', 'required' => true))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Geboortedatum</label>
	<div class="col-sm-6">
		<?=$this->Form->input('birthdate', array('label' => false, 'div' => false, 'class' => 'form-control birthdatepicker', 'type' => 'text'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Rijksregisternummer</label>
	<div class="col-sm-6">
		<?=$this->Form->input('nationalnumber', array('label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => 'enkel cijfers, geen streepjes'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">E-mail adres</label>
	<div class="col-sm-6">
		<?=$this->Form->input('email', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Telefoon</label>
	<div class="col-sm-6">
		<?=$this->Form->input('tel', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Adres</label>
	<div class="col-sm-6">
		<?=$this->Form->input('address', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Postcode</label>
	<div class="col-sm-6">
		<?=$this->Form->input('postcode', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Gemeente</label>
	<div class="col-sm-6">
		<?=$this->Form->input('city', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Aka</label>
	<div class="col-sm-6">
		<?=$this->Form->input('nickname', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'also known as'))?>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-3 col-sm-6">
		<div class="checkbox">
			<label>
				<?=$this->Form->input('active', array('label' => false, 'hiddenField' => true, 'type' => 'checkbox', 'div' => false))?>
				Actief lid
			</label>
		</div>
	</div>
</div>
