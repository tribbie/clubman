<!-- app/View/Elements/member-form-finance.ctp -->
<h3>Lidgeld</h3>

<div class="form-group">
	<label class="col-sm-3 control-label">Lidgeld</label>
	<div class="col-sm-6">
		<?=$this->Form->input('membershipfee', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Volledige bedrag dat het lid normaal zou moeten betalen', 'type' => 'text'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Korting</label>
	<div class="col-sm-6">
		<?=$this->Form->input('membershipfee_discount', array('label' => false, 'div' => false, 'class' => 'form-control', 'title' => 'Korting die dit lid geniet', 'type' => 'text'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Datum voorschot</label>
	<div class="col-sm-6">
		<?=$this->Form->input('membership_advancepaid', array('label' => false, 'div' => false, 'class' => 'form-control birthdatepicker', 'title' => 'Datum betaling voorschot', 'type' => 'text'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Datum saldo</label>
	<div class="col-sm-6">
		<?=$this->Form->input('membership_balancepaid', array('label' => false, 'div' => false, 'class' => 'form-control birthdatepicker', 'title' => 'Datum betaling saldo', 'type' => 'text'))?>
	</div>
</div>

<h3>Kamp</h3>

<div class="form-group">
	<div class="col-sm-offset-3 col-sm-6">
		<div class="checkbox">
			<label>
				<?=$this->Form->input('camp', array('label' => false, 'hiddenField' => true, 'type' => 'checkbox', 'div' => false))?>
				Mee op kamp?
			</label>
		</div>
	</div>
</div>

<div id="camp_info">

	<div class="form-group">
		<label class="col-sm-3 control-label">Kost</label>
		<div class="col-sm-6">
			<?=$this->Form->input('campfee', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'text'))?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label">Datum voorschot</label>
		<div class="col-sm-6">
			<?=$this->Form->input('camp_advance', array('label' => false, 'div' => false, 'class' => 'form-control birthdatepicker', 'title' => 'Datum betaling voorschot kamp', 'type' => 'text'))?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label">Datum saldo</label>
		<div class="col-sm-6">
			<?=$this->Form->input('camp_balance', array('label' => false, 'div' => false, 'class' => 'form-control birthdatepicker', 'title' => 'Datum betaling saldo kamp', 'type' => 'text'))?>
		</div>
	</div>

</div>
