<!-- app/View/Efforts/view.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> record</h2>

<div class="row">
	<div class="col-md-6">

		<div class="panel panel-info">
			<div class="panel-heading">
				<?=$record['Auditrecord']['id'];?>
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>id</dt>       <dd><?=$record['Auditrecord']['id']?></dd>
					<dt>created</dt>  <dd><?=$record['Auditrecord']['created']?></dd>
					<dt>userid</dt>   <dd><?=$record['Auditrecord']['userid']?></dd>
					<dt>username</dt> <dd><?=$record['Auditrecord']['username']?></dd>
					<dt>userrole</dt> <dd><?=$record['Auditrecord']['userrole']?></dd>
					<dt>action</dt>   <dd><?=$record['Auditrecord']['action']?></dd>
					<dt>model</dt>    <dd><?=$record['Auditrecord']['model']?></dd>
					<dt>modelid</dt>  <dd><?=$record['Auditrecord']['modelid']?></dd>
					<dt>userip</dt>   <dd><?=$record['Auditrecord']['userip']?></dd>
					<dt>useragent</dt><dd><?=$record['Auditrecord']['useragent']?></dd>
					<dt>remark</dt>   <dd><?=$record['Auditrecord']['remark']?></dd>
					<dt>modified</dt> <dd><?=$record['Auditrecord']['modified']?></dd>
				</dl>
			</div>
		</div>

	</div>
</div>

<?php
// pr($record);
?>
