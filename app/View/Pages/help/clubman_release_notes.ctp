<h1>The Clubman release notes</h1>
<br>

<script>
function showhide(id) {
	if (document.getElementById) {
		obj = document.getElementById(id);
		if (obj.style.display == "none") {
			obj.style.display = "";
		} else {
			obj.style.display = "none";
		}
	}
}
</script>

<hr/>


<div class="panel panel-info">
	<div class="panel-heading">
		<a href="#" title="Version 0.6" onclick="showhide('release06'); return(false)">v0.6 - Release for season 2017-2018</a>
	</div>
	<div class="panel-body" style='display: none;' id='release06'>
		<dl class="dl-horizontal">
			<dt>General</dt>
				<dd>General changes:
					<ul>
						<li>
							Properly normalize the members schema
							<?=$this->Html->link('(database migration)', array('controller' => 'pages', 'action' => 'help', 'clubman-v06-database-migration'), array('title' => 'database migratie'))?><br/>
						</li>
						<li>Change some reports</li>
						<li>Make Events a main menu topic</li>
						<li>Make Clubman configuration editable through form</li>
					</ul>
				</dd>
			<dt>Members</dt>
				<dd>
					Newly normalized schema
					<ul>
						<li>Introduce Persons table</li>
						<li>Parents through new relations table</li>
						<li>Payments through new transactions table</li>
					</ul>
				</dd>
		</dl>

		<div class="panel panel-info">
			<div class="panel-heading">
				<a href="#" title="Extra" onclick="showhide('release06x'); return(false)">Extra - schema</a>
			</div>
			<div class="panel-body" style='display: none;' id='release06x'>
				<dl class="dl-horizontal">

					<dt>Person</dt>
					<dd>
						<ul>
							<li>Person.id</li>
							<li>Person.picture_id</li>
							<li>Person.address_id</li>
							<li>Person.lastname</li>
							<li>Person.firstname</li>
							<li>Person.birthdate</li>
							<li>Person.birthdate_public</li>
							<li>Person.nationalnumber</li>
							<li>Person.email</li>
							<li>Person.tel</li>
							<li>Person.nickname</li>
							<li>Person.bankaccount</li>
							<li>Person.remark</li>
						</ul>
					</dd>

					<dt>Address</dt>
					<dd>
						<ul>
							<li>Address.id</li>
							<li>Address.street</li>
							<li>Address.housenumber</li>
							<li>Address.postal</li>
							<li>Address.city</li>
							<li>Address.country</li>
							<li>Address.remark</li>
						</ul>
					</dd>

					<dt>Member</dt>
					<dd>
						<ul>
							<li>Member.id</li>
							<li>Member.person_id</li>
							<li>Member.picturelicense_id</li>
							<li>Member.primary_contact_id (to Person)</li>
							<li>Member.secondary_contact_id (to Person)</li>
							<li>Member.licensenumber</li>
							<li>Member.active</li>
							<li>Member.remark</li>
						</ul>
					</dd>

					<dt>Shizzle</dt>
					<dd>
						<ul>
							<li>Shizzle.id</li>
							<li>Shizzle.model</li>
							<li>Shizzle.model_id</li>
							<li>Shizzle.name</li>
							<li>Shizzle.value</li>
							<li>Shizzle.remark</li>
						</ul>
					</dd>

					<dt>Relation</dt>
					<dd>
						<ul>
							<li>Relation.id</li>
						</ul>
					</dd>

				</dl>
			</div>
		</div>


	</div>
</div>


<div class="panel panel-info">
	<div class="panel-heading">
		<a href="#" title="Version 0.5" onclick="showhide('release05'); return(false)">v0.5 - Release for season 2016-2017</a>
	</div>
	<div class="panel-body" style='display: none;' id='release05'>
		<dl class="dl-horizontal">
			<dt>General</dt>
			<dd>General changes:
				<ul>
					<li>Implemented Bootstrap styling</li>
					<li>Implemented events and newsitems on website</li>
				</ul>
			</dd>
			<dt>News items</dt>
			<dd>No longer through separate hardcoded sections, but through newsitems table (with form)</dd>
			<dt>Events</dt>
			<dd>No longer through separate ctp files, but through events table (with form)</dd>
		</dl>
	</div>
</div>


<div class="panel panel-info">
	<div class="panel-heading">
		<a href="#" title="Version 0.4" onclick="showhide('release04'); return(false)">v0.4 - Release for season 2015-2016</a>
	</div>
	<div class="panel-body" style='display: none;' id='release04'>
		<dl class="dl-horizontal">
			<dt>General</dt>
				<dd>
					<ul>
						<li>Used bij VC Wolvertem</li>
						<li>No Bootstrap yet</li>
						<li>Removed VC Wolvertem hard coded shizzle</li>
					</ul>
				</dd>
		</dl>
	</div>
</div>


<div class="panel panel-info">
	<div class="panel-heading">
		<a href="#" title="Version 0.1" onclick="showhide('release01'); return(false)">v0.1 - Release for seasons before 2015-2016</a>
	</div>
	<div class="panel-body" style='display: none;' id='release01'>
		<dl class="dl-horizontal">
			<dt>General</dt>
				<dd>
					<ul>
						<li>Used bij VC Wolvertem</li>
						<li>VC Wolvertem hard coded everywhere.</li>
					</ul>
				</dd>
		</dl>
	</div>
</div>


<hr/>
