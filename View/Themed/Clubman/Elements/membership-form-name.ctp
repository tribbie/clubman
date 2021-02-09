<!-- app/View/Elements/membership-form-person.ctp -->
<h3>Naam</h3>

<div class="form-group">
	<label class="col-sm-3 control-label">Achternaam</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Person.lastname', array('label' => false, 'div' => false, 'class' => 'form-control', 'required' => true, 'v-on:input' =>'lookupPerson()'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Voornaam</label>
	<div class="col-sm-6">
		<?=$this->Form->input('Person.firstname', array('label' => false, 'div' => false, 'class' => 'form-control', 'required' => true, 'v-on:input' => 'lookupPerson()'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Licentie</label>
	<div class="col-sm-6">
		<?=$this->Form->input('licensenumber', array('label' => false, 'div' => false, 'class' => 'form-control', 'required' => false))?>
	</div>
</div>

<!--
	It is probably not needed when adding a new membership - I think that when adding a new membership, it would always be an active membership ...
-->
<!--
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
-->
