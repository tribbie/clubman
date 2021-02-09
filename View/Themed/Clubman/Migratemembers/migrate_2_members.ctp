<div id="membermigrate">
	<div>

		<div class="row">

			<div class="col-md-8">
				<div class="panel panel-default">
				  <div id="toggleMigrationInfo" class="panel-heading">{{ migTitle }}</div>
					<div id="migrationInfo" class="panel-body">
						<p>
							This is the plan-of-attack for the member migration:
							<ul>
								<li>
									FIRST: todo for every member:
									<ul>
								  	<li>
											member
											<ul>
										  	<li>add membername to persons</li>
										  	<li>fill person_id into member</li>
										  	<li>add memberaddres to contacts</li>
										  	<li>fill contact_id into (member)person</li>
											</ul>
										</li>
									</ul>
								</li>
								<li>
									THEN: todo for every member:
									<ul>
										<li>
										  memberMOM
											<ul>
										  	<li>if not exists add MOM to persons</li>
												<li>add MOM to personparents</li>
										  	<li>if not exists add MOMaddress to contacts</li>
										  	<li>fill contact_id into (MOM)person</li>
											</ul>
										</li>
										<li>
									  	memberDAD
											<ul>
												<li>if not exists add DAD to persons</li>
										  	<li>add DAD to personparents</li>
										  	<li>if not exists add DADaddress to contacts</li>
										  	<li>fill contact_id into (DAD)person</li>
											</ul>
										</li>
									</ul>
								</li>
								<li>
									FINALLY: post-processing (part 2):
									<ul>
										<li>merge duplicate addresses into (member)person</li>
										<li>check/merge duplicate persons</li>
										<li>clean up migration-remarks</li>
										<li>reduce the members table</li>
									</ul>
								</li>
							</ul>
						</p>
			  	</div>

					<div id="toggleMigrationSteps" class="panel-heading">Migration steps</div>
			  	<div id="migrationSteps" class="panel-body">
						<p>
							Step 1:
							<button id='migrateMembersToPersonsButton' class="btn btn-primary" type="button" v-on:click="allMembersToPersons($event)" title="(create a person for every member)">
								Migratemembers to persons
							</button>
							<span class="badge">{{ migData.newPersons.length }} done</span>
						</p>
						<p>
							Step 2:
							<button id='fetchMigratemembersButton' class="btn btn-primary" type="button" v-on:click="fetchMigrateMembers()" title="(refresh Migratemembers from database)">
								Refetch migratemembers
							</button>
							<button id='migrateMembersToContactaddressesButton' class="btn btn-primary" type="button" v-on:click="allMembersToContactaddress($event)" title="(create a contactaddress for every member)">
								Migratemembers to contactaddresses
							</button>
							<span class="badge">{{ migData.newContactaddresses.length }} done</span>
						</p>
						<p>
							Step 3:
							<button id='migrateMomsButton' class="btn btn-primary" type="button" v-on:click="migrateAllMoms($event)" title="(migrate all moms)">
								Migrate all moms
							</button>
							<span class="badge">{{ migData.newMigratedMoms.length }} done</span>
						</p>
						<p>
							Step 4:
							<button id='migrateDadsButton' class="btn btn-primary" type="button" v-on:click="migrateAllDads($event)" title="(migrate all dads)">
								Migrate all dads
							</button>
							<span class="badge">{{ migData.newMigratedDads.length }} done</span>
						</p>
						<p>
							Next:
							<?= $this->Html->link("On to the next step", array('controller' => 'migratemembers', 'action' => 'migrate_3_double_addresses')); ?>
						</p>

			  	</div>

					<div id="notoggleMigrationTable" class="panel-heading">
						The members
						<button id='refetchMigratemembersButton' type="button" v-on:click="fetchMigrateMembers()" title="(refresh Migratemembers from database)">
							Refresh
						</button>
						<button id='toggleMigrationTable' type="button">
							showhide
						</button>
						<span class="badge">{{ migMembers.data.members.length }} stuks</span>
					</div>

					<div class="table-responsive">
						<table id="migrationTable" class="table table-condensed table-striped table-hover">
							<thead>
					      <tr>
									<th>Lid</th>
									<th>Naam</th>
									<th>Mama</th>
									<th>Papa</th>
								</tr>
					    </thead>
							<tbody>
								<tr class="" v-for="onemember in migMembers.data.members | filterBy nameFilter in 'Migratemember.name'">
									<td>
										<button id='preMigrationTableMember{{ onemember.Migratemember.id }}' type="button" v-on:click="fetchMember(onemember.Migratemember.id)">
											{{ onemember.Migratemember.id }}
										</button>
									</td>
									<td>
										<strong v-if="onemember.Migratemember.active">
											<span title='active'>{{ onemember.Migratemember.name ? onemember.Migratemember.name : 'noname' }}</span>
										</strong>
										<em v-else>
											<span title='inactive'>{{ onemember.Migratemember.name ? onemember.Migratemember.name : 'noname' }}</span>
										</em>
										<ul>
											<li>
												<small>{{ onemember.Migratemember.address }}</small>
											</li>
											<li>
												<small>{{ onemember.Migratemember.postcode }} {{ onemember.Migratemember.city }}</small>
											</li>
											<li>
												<small>{{ onemember.Migratemember.tel }}</small>
											</li>
											<li>
												<small>{{ onemember.Migratemember.email }}</small>
											</li>
										</ul>
									</td>
									<td>
										{{ onemember.Migratemember.mom_lastname ? onemember.Migratemember.mom_lastname : '--'  }} {{ onemember.Migratemember.mom_firstname ? onemember.Migratemember.mom_firstname : '--' }}
										<ul>
											<li>
												<small>{{ onemember.Migratemember.mom_address }}</small>
											</li>
											<li>
												<small>{{ onemember.Migratemember.mom_postcode }} {{ onemember.Migratemember.mom_city }}</small>
											</li>
											<li>
												<small>{{ onemember.Migratemember.mom_tel }}</small>
											</li>
											<li>
												<small>{{ onemember.Migratemember.mom_email }}</small>
											</li>
										</ul>
									</td>
									<td>
										{{ onemember.Migratemember.dad_lastname ? onemember.Migratemember.dad_lastname : '--'  }} {{ onemember.Migratemember.dad_firstname ? onemember.Migratemember.dad_firstname : '--' }}
										<ul>
											<li>
												<small>{{ onemember.Migratemember.dad_address }}</small>
											</li>
											<li>
												<small>{{ onemember.Migratemember.dad_postcode }} {{ onemember.Migratemember.dad_city }}</small>
											</li>
											<li>
												<small>{{ onemember.Migratemember.dad_tel }}</small>
											</li>
											<li>
												<small>{{ onemember.Migratemember.dad_email }}</small>
											</li>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="panel panel-default">

					<div id="toggleMigrationLog" class="panel-heading">Migration log</div>
					<div id="migrationLog" class="panel-body">
						<div>
							<small>
								<pre>{{ migLog }}</pre>
							</small>
						</div>
			  	</div>

					<div id="toggleMigrationMember" class="panel-heading">Member #{{ migMember.meta.cakedata.member.Migratemember.id }} - {{ migMember.meta.cakedata.member.Migratemember.name }}</div>
					<div id="migrationMember" class="panel-body">
						<div>
							<ul class="list-group">
								<li class="list-group-item list-group-item-info">
									BEFORE - Member -
									{{ migMember.meta.cakedata.member.Migratemember.lastname }}
									{{ migMember.meta.cakedata.member.Migratemember.firstname }}
									<br/>
									<small>
										{{ migMember.meta.cakedata.member.Migratemember.address }}
										<br/>
										{{ migMember.meta.cakedata.member.Migratemember.postcode }}
										{{ migMember.meta.cakedata.member.Migratemember.city }}
										<br/>
										(tel {{ migMember.meta.cakedata.member.Migratemember.tel }})
									</small>
								</li>
								<li class="list-group-item list-group-item-disabled">
									MOM -
									{{ migMember.meta.cakedata.member.Migratemember.mom_lastname }}
									{{ migMember.meta.cakedata.member.Migratemember.mom_firstname }}
									<br/>
									<small>
										{{ migMember.meta.cakedata.member.Migratemember.mom_address }}
										<br/>
										{{ migMember.meta.cakedata.member.Migratemember.mom_postcode }}
										{{ migMember.meta.cakedata.member.Migratemember.mom_city }}
										<br/>
										(tel {{ migMember.meta.cakedata.member.Migratemember.mom_tel }})
									</small>
								</li>
								<li class="list-group-item list-group-item-disabled">
									DAD -
									{{ migMember.meta.cakedata.member.Migratemember.dad_lastname }}
									{{ migMember.meta.cakedata.member.Migratemember.dad_firstname }}
									<br/>
									<small>
										{{ migMember.meta.cakedata.member.Migratemember.dad_address }}
										<br/>
										{{ migMember.meta.cakedata.member.Migratemember.dad_postcode }}
										{{ migMember.meta.cakedata.member.Migratemember.dad_city }}
										<br/>
										(tel {{ migMember.meta.cakedata.member.Migratemember.dad_tel }})
									</small>
								</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success">
									AFTER - Person -
									{{ migMember.meta.cakedata.member.Person.lastname }}
									{{ migMember.meta.cakedata.member.Person.firstname }}
									<br/>
									<small>
										(mob {{ migMember.meta.cakedata.member.Person.mobile }})
										<div v-if="oneparent.Parent.Contactaddress.id">
											<hr>
											(tel {{ migMember.meta.cakedata.member.Person.Contactaddress.landline }})
											<br/>
											{{ migMember.meta.cakedata.member.Person.Contactaddress.address }}
											<br/>
											{{ migMember.meta.cakedata.member.Person.Contactaddress.postcode }}
											{{ migMember.meta.cakedata.member.Person.Contactaddress.city }}
										</div>
									</small>
								</li>


								<li class="list-group-item list-group-item-disabled" v-for="oneparent in migMember.meta.cakedata.member.Person.Personparent">
									{{ oneparent.type }} -
									{{ oneparent.Parent.lastname }}
									{{ oneparent.Parent.firstname }}
									<br/>
									<small>
										(mob {{ oneparent.Parent.mobile }})
										<div v-if="oneparent.Parent.Contactaddress.id">
											<hr>
											(tel {{ oneparent.Parent.Contactaddress.landline }})
											<br/>
											{{ oneparent.Parent.Contactaddress.address }}
											<br/>
											{{ oneparent.Parent.Contactaddress.postcode }}
											{{ oneparent.Parent.Contactaddress.city }}
										</div>
									</small>
								</li>

							</ul>
						</div>
			  	</div>

					<div id="toggleMigrationMemberComplete" class="panel-heading">Complete Member #{{ migMember.meta.cakedata.member.Migratemember.id }} - {{ migMember.meta.cakedata.member.Migratemember.name }}</div>
			  	<div id="migrationMemberComplete" class="panel-body">
						<div>
							<pre>{{ migMember.meta.cakedata.member | json }}</pre>
						</div>
			  	</div>

				</div>
			</div>

		</div>

		<hr>

		<div class="row">

			<div class="col-md-6">
				<div class="panel panel-default">
				  <div id="toggleMigrationPerson" class="panel-heading">Person shizzle</div>
			  	<div id="migrationPerson" class="panel-body">
						<pre>{{ migData.newPersons | json }}</pre>
			  	</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-default">
				  <div id="toggleMigrationContact" class="panel-heading">Contact shizzle</div>
			  	<div id="migrationContact" class="panel-body">
						<pre>{{ migData.newContactaddresses | json }}</pre>
			  	</div>
				</div>
			</div>

		</div>

		<hr>

		<div class="row">

			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">

					<div id="toggleMigrationDebugInfo" class="panel-heading">Debug info</div>
					<div id="migrationDebugInfo" class="panel-body">
						<pre>{{ migMembers.data | json }}</pre>
					</div>

				</div>
			</div>

		</div>

	</div>
</div> <!-- membermigrate -->

<script>
	var migrateMembersApp = new Vue({
		el: '#membermigrate',
		data: {
			migTitle: 'Migration of the Clubman members',
			migLog: '',
	    migMembers: {},
			migMember: {},
			migData: {
				newParents: [],
				newContactaddresses: [],
				newPersons: [],
				newMigratedMoms: [],
				newMigratedDads: [],
				newDads: [],
				newMoms: [],
				foundContactaddresses: {}
			},
		},
		ready: function() {
	    this.fetchMigrateMembers();
		},
		methods: {
			dummy: function (event) {
				// `this` inside methods points to the Vue instance
				alert('Hello from dummy -- ' + this.migTitle + '!');
				console.log('Hello from dummy -- ' + this.migTitle + '!');
				// `event` is the native DOM event
				if (event) {
					alert(event.target.id)
				}
			},
			logIt: function (logLine) {
				var self = this;
				console.log(logLine);
				self.migLog += logLine + "\n";
				//alert(logline);
			},
			disableButton: function (elementId) {
				$(elementId).attr('class','btn btn-success');
				$(elementId).attr('disabled','disabled');
			},
			fetchMigrateMembers: function () {
				var self = this;
				self.logIt('Fetching the members');
		    $.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajfetchall', 'ext' => 'json'))?>",
		      dataType: 'json',
		      success: function(data) {
						self.logIt('- done: ' + data.data.members.length + ' migratemembers fetched');
		        self.migMembers = data;
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
		    });
		  },
			fetchMember: function (memberId) {
				var self = this;
				self.logIt('Fetching given member #' + memberId );
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajfetchmember', 'ext' => 'json'))?>" + '?id=' + memberId,
		      dataType: 'json',
					success: function(response) {
						if (response.error !== undefined) {
							alert('Error: ' + response.error);
							console.log('Error: ' + response.error);
						}
						self.logIt('- success: member #' + memberId + " fetched" );
						self.migMember = response;
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});
			},
			allMembersToPersons: function (event) {
				var self = this;
				self.disableButton('#'+event.target.id);
				self.migMembers.data.members.forEach(self.memberToPerson);
			},
			memberToPerson: function (member) {
				var self = this;
				var thisPerson = {};
				var thisMember = member;
				self.logIt('Make person of member #' + thisMember.Migratemember.id + ' - ' + thisMember.Migratemember.firstname);
				if ((thisMember.Migratemember.nationalnumber !== null) && (thisMember.Migratemember.nationalnumber != '')) {
					if (thisMember.Migratemember.nationalnumber.substr(8,1) % 2) {
						thisGender = 'male';
					}
					else {
						thisGender = 'female';
					}
				}
				else {
					thisGender = null;
				}
				thisPerson = {
					 						'Person':
												{
													'picture_id':        thisMember.Migratemember.picture_id,
													'contactaddress_id': null,
													'uniquenumber':      ''.concat(thisMember.Migratemember.nationalnumber).trim(),
													'lastname':          ''.concat(thisMember.Migratemember.lastname).trim(),
													'firstname':         ''.concat(thisMember.Migratemember.firstname).trim(),
													'gender':            thisGender,
													'birthdate':         thisMember.Migratemember.birthdate,
													'birthday_public':   thisMember.Migratemember.birthday_public,
													'email':             ''.concat(thisMember.Migratemember.email).trim(),
													'mobile':            ''.concat(thisMember.Migratemember.tel).trim(),
													'bankaccount':       ''.concat(thisMember.Migratemember.bank_account).trim(),
													'nickname':          ''.concat(thisMember.Migratemember.nickname).trim(),
													'metadata':          '{"source": {"member": ' + thisMember.Migratemember.id + '}}',
													'remark':            thisMember.Migratemember.id,
												}
											};
				$.ajax({
				  type: 'POST',
					url: "<?=$this->Html->url(array('action' => 'ajmembertoperson', 'ext' => 'json'))?>",
					data: thisPerson,
					dataType: 'json',
					success: function(response) {
						self.logIt('- success: member #' + response.meta.cakedata.person.Person.remark + ': person #' + response.meta.cakedata.person.Person.id + ' - ' + response.meta.cakedata.person.Person.firstname + ' added - ' + response.meta.result.status + ' - ' + response.meta.result.detail);
						self.migData.newPersons.push(response.meta.cakedata.person);
						// insert the Person id into the member we just processed (I have put the member_id into the Person.remark field)
						self.linkPersonToMember(response.meta.cakedata.person.Person.id, response.meta.cakedata.person.Person.remark);
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
				});
			},
			linkPersonToMember: function (personid, memberId) {
				var self = this;
				var thisLink = {};
				self.logIt('Linking the person #' + personid + ' to the member #' + memberId);
				thisLink = {
					 					'Migratemember':
											{
												'id': memberId,
												'person_id': personid
											}
										};
				$.ajax({
				  type: 'POST',
					url: "<?=$this->Html->url(array('action' => 'ajlinkpersontomember', 'ext' => 'json'))?>",
					data: thisLink,
					dataType: 'json',
					success: function(response) {
						self.logIt('- success: linked person #' + response.meta.cakedata.member.Person.id + ' - ' + response.meta.cakedata.member.Person.firstname + ' to member #' + response.meta.cakedata.member.Migratemember.id + ' - ' + response.meta.cakedata.member.Migratemember.firstname + ' - ' + response.meta.result.status + ' - ' + response.meta.result.detail);
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
				});
			},
			allMembersToContactaddress: function (event) {
				var self = this;
				self.disableButton('#'+event.target.id);
				self.migMembers.data.members.forEach(self.memberToContactaddress);
			},
			memberToContactaddress: function (member) {
				var self = this;
				var thisMember = member;
				self.logIt('Migrating address for member #' + thisMember.Migratemember.id + ' - ' + thisMember.Migratemember.firstname + ' (is person #' + thisMember.Migratemember.person_id + ')');
				var thisContactaddress = {};
				/// add contact (if not already exists)
				/// This (the looking up of a contact address) is not good in an asynchronous environment.
				/// So we do not do that here
				//self.logIt('looking up address ' + member.Migratemember.address + ' '  + member.Migratemember.postcode + ' ' + member.Migratemember.city);
				//self.findContactaddresses(member);
				/// register contactaddress_id into the correct person(s)
				thisContactaddress = {
					 						'Contactaddress':
												{
													'address':     ''.concat(thisMember.Migratemember.address).trim(),
													'postcode':    ''.concat(thisMember.Migratemember.postcode).trim(),
													'city':        ''.concat(thisMember.Migratemember.city).trim(),
													'countrycode': 'be',
													'landline':    null,
													'metadata':    '{"source": {"member": ' + thisMember.Migratemember.id + ', "person": ' + thisMember.Person.id + '}}',
													'remark':      thisMember.Person.id,
												}
											};
				$.ajax({
				  type: 'POST',
					url: "<?=$this->Html->url(array('action' => 'ajmembertocontactaddress', 'ext' => 'json'))?>",
					data: thisContactaddress,
					dataType: 'json',
					success: function(response) {
						self.logIt('- success: person #' + response.meta.cakedata.contactaddress.Contactaddress.remark + ' - added contactaddress #' + response.meta.cakedata.contactaddress.Contactaddress.id + ' - ' + response.meta.cakedata.contactaddress.Contactaddress.address + ' - ' + response.meta.result.status + ' - ' + response.meta.result.detail);
						self.migData.newContactaddresses.push(response.meta.cakedata.contactaddress);
						/// insert the Contactaddress id we just processed into the person (I have put the person_id into the Contactaddress.remark field)
						self.linkContactaddressToPerson(response.meta.cakedata.contactaddress.Contactaddress.id, response.meta.cakedata.contactaddress.Contactaddress.remark);
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
				});
			},
			linkContactaddressToPerson: function (contactaddressId, personId) {
				var self = this;
				var thisLink = {};
				self.logIt('Linking the contactaddressid (' + contactaddressId + ') into the person (' + personId + ')');
				thisLink = {
					 					'Person':
											{
												'id': personId,
												'contactaddress_id': contactaddressId
											}
										};
				$.ajax({
				  type: 'POST',
					url: "<?=$this->Html->url(array('action' => 'ajlinkcontactaddresstoperson', 'ext' => 'json'))?>",
					data: thisLink,
					dataType: 'json',
					success: function(response) {
						self.logIt('- success: linked contactaddress #' + response.meta.cakedata.person.Contactaddress.id + ' to person #' + response.meta.cakedata.person.Person.id + ' - ' + response.meta.cakedata.person.Person.firstname + ' - ' + response.meta.result.status + ' - ' + response.meta.result.detail);
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
				});
			},
			migrateAllMoms: function (event) {
				var self = this;
				self.disableButton('#'+event.target.id);
				self.logIt('Migrating all the moms - serverside');
		    $.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajmigrateallmoms', 'ext' => 'json'))?>",
		      dataType: 'json',
		      success: function(data) {
		        self.migData.newMigratedMoms = data.meta.cakedata.migratedmoms;
						self.logIt('- done: ' + data.meta.cakedata.migratedmoms.length + ' moms migrated');
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
		    });
			},
			migrateAllDads: function (event) {
				var self = this;
				self.disableButton('#'+event.target.id);
				self.logIt('Migrating all the dads - serverside');
		    $.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajmigratealldads', 'ext' => 'json'))?>",
		      dataType: 'json',
		      success: function(data) {
		        self.migData.newMigratedDads = data.meta.cakedata.migrateddads;
						self.logIt('- done: ' + data.meta.cakedata.migrateddads.length + ' dads migrated');
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
		    });
			},
		}
	});
</script>

<script>
	$(document).ready(function() {
		toggleSpeed = 132;
		$("div#migrationInfo").hide();
		$("#toggleMigrationInfo").click(function() {
			$("div#migrationInfo").toggle(toggleSpeed);
		});
		//$("div#migrationsteps").hide();
		$("#toggleMigrationSteps").click(function() {
			$("div#migrationSteps").toggle(toggleSpeed);
		});
		//$("table#migrationTable").hide();
		$("#toggleMigrationTable").click(function() {
			$("table#migrationTable").toggle(toggleSpeed);
		});

		$("div#migrationLog").hide();
		$("#toggleMigrationLog").click(function() {
			$("div#migrationLog").toggle(toggleSpeed);
		});
		//$("div#migrationMember").hide();
		$("#toggleMigrationMember").click(function() {
			$("div#migrationMember").toggle(toggleSpeed);
		});
		$("div#migrationMemberComplete").hide();
		$("#toggleMigrationMemberComplete").click(function() {
			$("div#migrationMemberComplete").toggle(toggleSpeed);
		});
		$("div#migrationPerson").hide();
		$("#toggleMigrationPerson").click(function() {
			$("div#migrationPerson").toggle(toggleSpeed);
		});
		$("div#migrationContact").hide();
		$("#toggleMigrationContact").click(function() {
			$("div#migrationContact").toggle(toggleSpeed);
		});

		$("div#migrationDebugInfo").hide();
		$("#toggleMigrationDebugInfo").click(function() {
			$("div#migrationDebugInfo").toggle(toggleSpeed);
		});
	});
</script>
