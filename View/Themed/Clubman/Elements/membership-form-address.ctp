<!-- app/View/Elements/membership-form-address.ctp -->
<h3>Adres</h3>

<!-- tijdelijk even hier - om sneller te kunnen testen -->
<div class="form-group">
	<label class="col-sm-3 control-label">unieke Straat</label>
	<div class="col-sm-6">
		<input class="form-control" maxlength="128" type="text" id="ContactaddressStreet" list="uniqueStreets" name="data[Contactaddress][street]" v-on:input='lookupStreet()')>
		<datalist id="uniqueStreets">
		</datalist>
	</div>
</div>

<!--
<div class="form-group">
	<label class="col-sm-3 control-label">Straat</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Contactaddress.street', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>
 -->

<div class="form-group">
	<label class="col-sm-3 control-label">Nummer</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Contactaddress.streetnumber', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Rest</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Contactaddress.streetnumbersuffix', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Postcode</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Contactaddress.postcode', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Gemeente</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Contactaddress.city', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Telefoon</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Contactaddress.landline', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>
