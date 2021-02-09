<div id="membermigrate">
	<div>

		<div class="row">

			<div class="col-md-8">
				<div class="panel panel-default">

				  <div id="toggleMigrationInfo" class="panel-heading">{{ dblTitle }}</div>
			  	<div id="migrationInfo" class="panel-body">
						<p>
							This is the plan-of-attack for the third part of the member migration:
							<ul>
								<li>
									NEXT: post-processing double persons:
									<ul>
										<li>check/merge duplicate persons (mostly parents) into single persons</li>
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
							<button id='fetchDoublePersonsButton' class="btn btn-primary" type="button" v-on:click="fetchDoublePersons()" title="(fetch doubles from database)">
                Fetch doubles
              </button>
						</p>
						<p>
							Step 2:
							<button id='processAllDuplicatePersonsButton' class="btn btn-primary" type="button" v-on:click="processAllDuplicatePersons($event)" title="(process duplicates)">
								Process duplicate persons
							</button>
							<span class="badge">{{ dblPersons.length }} duplicates found</span>
						</p>
						<p>
							Next:
							<?= $this->Html->link("On to the next step", array('controller' => 'migratemembers', 'action' => 'migrate_5_final')); ?>
						</p>
			  	</div>

					<div id="notoggleMigrationTable" class="panel-heading">
						The double persons
						<button id='refetchDoublePersonsButton' type="button" v-on:click="fetchDoublePersons()" title="(refresh Migratemembers from database)">
							Refresh
						</button>
						<button id='toggleMigrationTable' type="button">
							showhide
						</button>
						<span class="badge">{{ dblPersons.length }} stuks</span>
					</div>
					<div class="table-responsive">
						<table id="migrationTable" class="table table-condensed table-striped table-hover">
							<tbody>
								<tr class="" v-for="(itemKey, onePerson) in dblPersons">
									<td>
										<button class='btn btn-default btn-xs' id='preMigrationTablePerson{{ onePerson[0].Person.id }}' type="button" v-on:click="showDouble(itemKey)" title="show">
											{{ itemKey }}
										</button>
										<button class='btn btn-primary btn-xs' id='doublePersonProcess{{ onePerson[0].Person.id }}' type="button" v-on:click="processDoubleId(itemKey)" title="process">
											{{ itemKey }}
										</button>
									</td>
									<td class="" v-for="oneEntry in onePerson" title="{{ oneEntry.Person.metadata }}">
										{{ oneEntry.Person.id }}
										{{ oneEntry.Person.lastname }}
										{{ oneEntry.Person.firstname }}
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
								<pre>{{ dblLog }}</pre>
							</small>
						</div>
			  	</div>

					<div id="toggleDoublePerson" class="panel-heading">Double #{{ dblPerson.itemkey }}</div>
			  	<div id="doublePerson" class="panel-body">
						<div>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success">
									Person -
									{{ dblPerson.persons[0].Person.lastname }}
									{{ dblPerson.persons[0].Person.firstname }}
								</li>

								<li class="list-group-item list-group-item-disabled" v-for="onePerson in dblPerson.persons">
									{{ onePerson.Person.lastname }} {{ onePerson.Person.firstname }}<br/>
									<small>
										{{ onePerson.Person.metadata }}
									</small>
								</li>

							</ul>
						</div>
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
						<pre>{{ dblDebug | json }}</pre>
					</div>

				</div>
			</div>

		</div>

	</div>
</div> <!-- membermigrate -->

<script>
	var migrateDoublePersonsApp = new Vue({
		el: '#membermigrate',
		data: {
			dblTitle: 'Migration of the Clubman doubles',
			dblLog: '',
			dblDebug: '',
			dblPersons: {},
			dblPerson: {
				itemkey: null,
				persons: []
			},
			dblData: {
				persons: [],
        personsDuplicates: [],
			},
		},
		ready: function() {
	    this.fetchDoublePersons();
		},
		methods: {
			dummy: function (event) {
				// `this` inside methods points to the Vue instance
				alert('Hello from dummy -- ' + this.name + '!');
				console.log('Hello from dummy -- ' + this.name + '!');
				// `event` is the native DOM event
				if (event) {
					alert(event.target.id)
				}
			},
			logIt: function (logLine) {
				var self = this;
				console.log(logLine);
				self.dblLog += logLine + "\n";
				//alert(logline);
			},
			disableButton: function (elementId) {
				$(elementId).attr('class', 'btn btn-success');
				$(elementId).attr('disabled', 'disabled');
			},
			fetchDoublePersons: function(event) {
				var self = this;
				self.logIt('Fetching the double persons');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajfetchdoublepersons', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.logIt('- done: ' + data.meta.cakedata.doubles.length + ' distinct persons fetched');
						self.dblPersons = data.meta.cakedata.doubles;
						self.logIt('- converting meta to json');
						self.dblPersons.forEach(self.metadataToJson);
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});
			},
			metadataToJson: function(double) {
				var self = this;
				double.forEach((oneEntry) => {
					console.log('Person #' + oneEntry['Person']['id'] + ': ' + oneEntry['Person']['lastname'] + ' ' + oneEntry['Person']['firstname'] + ' - meta: ' + oneEntry['Person']['metadata']);
					if (oneEntry['Person']['metadata']) {
						oneEntry['Person']['metajson'] = JSON.parse(oneEntry['Person']['metadata']);
						//console.log('--- metadata: ' + oneEntry['Person']['metadata']);
					} else {
						console.log('--- NO metadata --- whut?? This should not be happening ---');
					}
				});
			},
			showDouble: function(doubleId) {
				var self = this;
				self.logIt('Showing double #' + doubleId );
				self.dblPerson.itemkey = doubleId;
				self.dblDebug = self.dblPersons[doubleId];
				self.dblPerson.persons = self.dblPersons[doubleId];
			},
			processAllDuplicatePersons: function(event) {
				var self = this;
				self.disableButton('#'+event.target.id);
				self.logIt('Proccessing all the double persons');
				self.dblPersons.forEach(self.processDoublePerson);

			},
			processDoubleId: function(doubleId) {
				/*
				This needs to be done:
				- from the doubles, check if there is one originating from a member (see metadata)
					- if there is exact one      => choose this one as the remaining person
				  - if there is none           => choose any other one as the remaining person
					- if there is more then one  => DO NOT MERGE (this is better merged manually)
				- the merging itself
				  - in the related records of the disappearing
				*/
				var self = this;
				self.logIt('Processing double #' + doubleId );
				self.dblPerson.itemkey = doubleId;
				self.dblDebug = self.dblPersons[doubleId];
				self.processDoublePerson(self.dblPersons[doubleId], doubleId);
			},
			processDoublePerson: function(doublePerson, doubleId) {
				/*
				This needs to be done:
				- from the doubles, check if there is one originating from a member (see metadata)
					- if there is exact one      => choose this one as the remaining person
				  - if there is none           => choose any other one as the remaining person
					- if there is more then one  => DO NOT MERGE (this is better merged manually)
				- the merging itself
				  - in the related records of the disappearing
				*/
				var self = this;
				self.logIt('Processing double person');
				var thisMerge = {
													'mainPerson': null,
													'mergePersons': [],
													'mergeData': {
																				'fromMemberCount': 0,
																				'fromParentCount': 0,
																				'tasks': []
																			 }
												};
				self.dblPerson.persons = doublePerson;
				self.logIt('Preparing the merge of the doubleperson (' + doubleId + ')');
				var oneEntry;
				var mergeThisEntry = false;
				for (oneEntry of self.dblPerson.persons) {
					self.logIt('Person #' + oneEntry['Person']['id'] + ': ' + oneEntry['Person']['lastname'] + ' ' + oneEntry['Person']['firstname'] + ' - meta: ' + oneEntry['Person']['metadata']);
					if (oneEntry['Person']['metajson']) {
						if (oneEntry['Person']['metajson']['source']['member']) {
							thisMerge['mainPerson'] = oneEntry;
							self.logIt('--- source was member #' + oneEntry['Person']['metajson']['source']['member']);
							thisMerge['mergeData']['fromMemberCount'] += 1;
							thisMerge['mergeData']['mainPersonId'] = oneEntry['Person']['id'];
						} else {
							self.logIt('--- source was NOT a member');
							if (oneEntry['Person']['metajson']['source']['mom_of_member']) {
								oneEntry['Person']['parenttype'] = 'mother';
								oneEntry['Person']['gender'] = 'female';
								self.logIt('--- source was mother of member: ' + oneEntry['Person']['metajson']['source']['mom_of_member']);
								thisMerge['mergeData']['tasks'].push({
																									'taskType': 'moveParent',
																									'taskDescription': 'Personparent ==> set parent_id to "newParentId" where type is "parentType" and person_id is "personId"',
																									'parentType': 'mother',
																									'forPersonId': oneEntry['Person']['metajson']['source']['mom_of_person'],
																									'newParentId': 'mainPerson.id',
																									'oldParentId': oneEntry['Person']['id']
																								});
							}
							if (oneEntry['Person']['metajson']['source']['dad_of_member']) {
								oneEntry['Person']['parenttype'] = 'father';
								oneEntry['Person']['gender'] = 'male';
								self.logIt('--- source was father of member: ' + oneEntry['Person']['metajson']['source']['dad_of_member']);
								thisMerge['mergeData']['tasks'].push({
																									'taskType': 'moveParent',
																									'taskDescription': 'Personparent ==> set parent_id to "newParentId" where type is "parentType" and person_id is "personId"',
																									'parentType': 'father',
																									'forPersonId': oneEntry['Person']['metajson']['source']['dad_of_person'],
																									'newParentId': 'mainPerson.id',
																									'oldParentId': oneEntry['Person']['id']
																								});
							}
							thisMerge['mergeData']['tasks'].push({
																									'taskType': 'moveContactaddress',
																									'taskDescription': 'Person ==> set contactaddress_id to "newContactaddressId" where id is "personId" and contactaddress_id is null',
																									'personId': 'mainPerson.id',
																									'newContactaddressId': oneEntry['Person']['contactaddress_id'],
																									'oldContactaddressId': 'mainPerson.contactaddress_id'
																								});
							thisMerge['mergeData']['tasks'].push({
																									'taskType': 'mergePersonData',
																									'taskDescription': 'set Person.data to "mergePerson".data where Person.id is "mainPerson".id and Person.data is null',
																									'personId': 'mainPerson.id',
																									'email': oneEntry['Person']['email'],
																									'mobile': oneEntry['Person']['mobile'],
																									'gender': oneEntry['Person']['gender']
																								});
							thisMerge['mergeData']['tasks'].push({
																									'taskType': 'removeMergePerson',
																									'taskDescription': 'Person: remove where id is "personId"',
																									'personId': oneEntry['Person']['id']
																								});
							thisMerge['mergeData']['fromParentCount'] += 1;
							thisMerge['mergePersons'].push(oneEntry);
						}
					} else {
						self.logIt('--- NO metajson --- whut?? This should not happen ---');
					}
				}
				self.logIt('Checking merge perparation for the doubleperson (' + doubleId + ')');
				if (thisMerge['mergeData']['fromMemberCount'] > 1) {
					self.logIt('NOMERGE: The doubleperson #' + doubleId + ' has ' + thisMerge['mergeData']['fromMemberCount'] + ' member sources -- please investigate');
					self.logIt('Please check if a double member exists (2 members with the same name) ...');
				} else if ((thisMerge['mergeData']['fromMemberCount'] == 0) && (thisMerge['mergeData']['fromParentCount'] > 1)) {
					self.logIt('--- there was no member as source - only mom or dad -- setting the first one as the main person');
					thisMerge['mainPerson'] = thisMerge['mergePersons'][0];
					thisMerge['mergeData']['mainPersonId'] = thisMerge['mergePersons'][0]['Person']['id'];
					self.logIt('MERGE: Requesting the merge of the doubleperson (' + doubleId + ')');
					mergeThisEntry = true;
				} else {
					if (thisMerge['mergeData']['fromParentCount'] < 1) {
						self.logIt('NOMERGE: The doubleperson #' + doubleId + ' has ' + thisMerge['mergeData']['fromMemberCount'] + ' parent sources -- please investigate');
						self.logIt('This should never happen...');
					} else {
						self.logIt('MERGE: Requesting the merge of the doubleperson (' + doubleId + ')');
						mergeThisEntry = true;
					}
				}
				if (mergeThisEntry == true) {
					self.logIt('Firing up the merger...');
					//self.logIt(JSON.stringify(thisMerge, null, 3));
					$.ajax({
						type: 'POST',
						url: "<?=$this->Html->url(array('action' => 'ajmergeperson', 'ext' => 'json'))?>",
						data: thisMerge,
						dataType: 'json',
						success: function(response) {
							//self.logIt('- success: merged person #' + response.meta.cakedata.person.Person.id + ' - ' + response.meta.cakedata.person.Person.firstname + ' ' + response.meta.cakedata.person.Person.lastname + ' - ' + response.meta.result.status + ' - ' + response.meta.result.detail);
							self.logIt('- success: merged person');
						},
						error: function(e) {
							alert("An error occurred: " + e.responseText.message);
							console.log(e);
						}
					});
				}

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
		//$("div#doublePerson").hide();
		$("#toggleDoublePerson").click(function() {
			$("div#doublePerson").toggle(toggleSpeed);
		});

	});
</script>
