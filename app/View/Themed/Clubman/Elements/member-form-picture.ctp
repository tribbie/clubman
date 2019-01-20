<!-- app/View/Elements/member-form-picture.ctp -->
<h4>Beeldjes</h4>

<div class="form-group">
	<label class="col-sm-3 control-label">Foto</label>
	<div class="col-sm-6">
		<?=$this->Form->input('picture_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'empty' => true))?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Licentie</label>
	<div class="col-sm-6">
		<?=$this->Form->input('picturelicense_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'type' => 'select', 'empty' => true))?>
	</div>
</div>
