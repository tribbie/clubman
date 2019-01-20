<!-- app/View/Elements/member-form-general.ctp -->
<h3>Overige</h3>

<div class="form-group">
	<label class="col-sm-3 control-label">Rekeningnummer</label>
	<div class="col-sm-6">
		<?=$this->Form->input('bank_account', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'rekeningnummer'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Type auto</label>
	<div class="col-sm-6">
		<?=$this->Form->input('car_type', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'merk / type auto'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Nummerplaat</label>
	<div class="col-sm-6">
		<?=$this->Form->input('car_license', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'nummerplaat auto'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Opmerking</label>
	<div class="col-sm-6">
		<?=$this->Form->input('remark', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'opmerking'))?>
	</div>
</div>
