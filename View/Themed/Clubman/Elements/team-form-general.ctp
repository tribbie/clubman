<h4>Algemeen</h4>

<div class="form-group">
	<label class="col-sm-3 control-label">Type team</label>
	<div class="col-sm-6">
		<?=$this->Form->input('teamtype', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'id' => 'focusme', 'required' => true))?>
	</div>
</div>

<!--
<div class="form-group">
	<label class="col-sm-3 control-label">Periode</label>
	<div class="col-sm-6">
		<?=$this->Form->input('period', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>
-->

<div class="form-group">
	<label class="col-sm-3 control-label">Categorie</label>
	<div class="col-sm-6">
		<?=$this->Form->input('category', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'required' => true))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Geslacht</label>
	<div class="col-sm-6">
		<?=$this->Form->input('gender', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'required' => true))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Volgnummer</label>
	<div class="col-sm-6">
		<?=$this->Form->input('number', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Korte naam</label>
	<div class="col-sm-6">
		<?=$this->Form->input('shortname', array('label' => false, 'div' => false, 'class' => 'form-control', 'required' => true))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Mini naam</label>
	<div class="col-sm-6">
		<?=$this->Form->input('mininame', array('label' => false, 'div' => false, 'class' => 'form-control', 'required' => true))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Reeks</label>
	<div class="col-sm-6">
		<?=$this->Form->input('series', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'empty' => true))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Competitiecode</label>
	<div class="col-sm-6">
		<?=$this->Form->input('competition', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Thuiswedstrijd</label>
	<div class="col-sm-6">
		<?=$this->Form->input('homegame', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select'))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Team e-mail</label>
	<div class="col-sm-6">
		<?=$this->Form->input('email', array('label' => false, 'div' => false, 'class' => 'form-control'))?>
	</div>
</div>
