<div id="membermigrate">
	<div>

		<div class="row">

			<div class="col-md-8">
				<div class="panel panel-default">

					<div id="toggleMigrationInfo" class="panel-heading">
						{{ fnlTitle }}
					</div>
					<div id="migrationInfo" class="panel-body">
						<p>
							This is the plan-of-attack for the last part of the member migration:
						</p>
						<ul>
							<li>
								LAST: post-processing:
								<ul>
									<li>split the contact addresses (number from street)</li>
									<li>create from migratemembers and reduce the memberships table (remove columns)</li>
								</ul>
							</li>
						</ul>
			  	</div>

					<div id="toggleMigrationSteps" class="panel-heading">
						Migration steps
					</div>
					<div id="migrationSteps" class="panel-body">
						<p>
							Step 1:
							<button id='fetchContactaddressesButton' class="btn btn-primary" type="button" v-on:click="fetchAllContactaddresses()" title="(fetch contactaddresses)">
								Fetch the Contactaddresses
							</button>
							<span class="badge">{{ allContactaddresses.length }} stuks</span>
						</p>
						<p>
							Step 2:
							<button id='splitContactaddressesButton' class="btn btn-primary" type="button" v-on:click="splitAllContactaddresses($event)" title="(split contactaddresses)">
								Split the Contactaddresses address field into street and streetnumber
							</button>
							<span class="badge">{{ splitContactaddresses.length }} stuks</span>
						</p>
						<p>
							Step 3:
							<button id='reduceMigratemembersTableButton' class="btn btn-primary" type="button" v-on:click="switchToMembershipsTable($event)" title="(switch to memberships)">
								Switch Migratemembers to Memberships table
							</button>
						</p>
						<!--
						<p>
							Step 4:
							<button id='cleanupRemarksButton' class="btn btn-primary" type="button" v-on:click="cleanupRemarks()" title="(clean up remarks)">
                Clean up remarks (Persons - Contactaddresses - Parentpersons)
              </button>
						</p>
						<p>
							Step 5:
							<button id='fetchGhostContactaddressesButton' class="btn btn-primary" type="button" v-on:click="fetchGhostContactaddresses()" title="(fetch ghost addresses)">
								Fetch ghost contact addresses (not belonging to any person)
							</button>
							<span class="badge">{{ ghostContactaddresses.length }} ghost addresses found</span>
						</p>
						-->
			  	</div>

					<!--
					<div id="notoggleMigrationTable" class="panel-heading">
						The ghosts
						<button id='refetchGhostContactaddressesButton' type="button" v-on:click="fetchGhostContactaddresses()" title="(refresh ghost addresses)">
							Refresh
						</button>
						<button id='toggleMigrationTable' type="button">
							showhide
						</button>
						<span class="badge">{{ ghostContactaddresses.length }} stuks</span>
					</div>
					-->
					<div class="table-responsive">
						<table id="migrationTable" class="table table-condensed table-striped table-hover">
							<tbody>
								<tr class="" v-for="(itemKey, oneContactaddress) in ghostContactaddresses">
									<td>
										<button class='btn btn-default btn-xs' id='preMigrationTableMember{{ oneMember[0].Person.id }}' type="button" v-on:click="showDouble(itemKey)" title="show">
											{{ itemKey }}
										</button>
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
								<pre>{{ fnlLog }}</pre>
							</small>
						</div>
			  	</div>

					<div id="toggleGhostContactaddress" class="panel-heading">Ghost Contactaddress #{{ ghostContactaddress.Contactaddress.id }}</div>
			  	<div id="ghostContactaddress" class="panel-body">
						<div>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success">
									Contactaddress -<br/>
									{{ ghostContactaddress.Contactaddress.address }}<br/>
									{{ ghostContactaddress.Contactaddress.postcode }}
									{{ ghostContactaddress.Contactaddress.city }}
								</li>
							</ul>
						</div>
			  	</div>

				</div>
			</div>

		</div>

		<hr>

		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-default">

					<div id="splitInfo" class="panel-heading">
						Split Addresses steps
						<span class="badge">{{ allContactaddresses.length }} stuks</span>
					</div>
			  	<div id="splitAddresses" class="panel-body">
						These are all the contactaddresses
			  	</div>
					<ul id="splitAddressesList" class="list-group">
					</ul>
					<!--
					<div id="splitDebug" class="panel-footer">
						<small>
							<pre>{{ allContactaddresses | json }}</pre>
						</small>
					</div>
					-->

				</div>
			</div>

		</div>

		<hr>

		<div class="row">

			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div id="toggleMigrationDebugInfo" class="panel-heading">
						Debug info
					</div>
					<div id="migrationDebugInfo" class="panel-body">
						<pre>{{ fnlDebug | json }}</pre>
					</div>
				</div>
			</div>

		</div>

	</div>
</div> <!-- membermigrate -->

<script>
	var migrateFinalApp = new Vue({
		el: '#membermigrate',
		data: {
			fnlTitle: 'Migration of the Clubman ghosts - final shizzle',
			fnlLog: '',
			fnlDebug: '',
			allContactaddresses: {},
			splitContactaddresses: [],
			ghostContactaddresses: {},
			ghostContactaddress: {},
		},
		ready: function () {
			/// we do nothing automatically here
			//this.fetchDoublePersons();
		},
		methods: {
			dummy: function (event) {
				// 'this' inside methods points to the Vue instance
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
				self.fnlLog += logLine + "\n";
				//alert(logline);
			},
			disableButton: function (elementId) {
				$(elementId).attr('class', 'btn btn-success');
				$(elementId).attr('disabled', 'disabled');
			},
			MAYBENOTNEEDEDfetchGhostContactaddresses: function () {
				var self = this;
				self.logIt('THIS IS NOT FINISHED YET - BY FAR');
				self.logIt('Fetching the ghost addresses');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajfetchGhostContactaddresses', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.logIt('- done: ' + data.meta.cakedata.ghosts.length + ' ghost contactaddresses fetched');
						self.ghostContactaddresses = data.meta.cakedata.ghosts;
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});
			},
			MAYBENOTNEEDEDshowGhostContactaddress: function (ghostId) {
				var self = this;
				self.logIt('THIS IS NOT FINISHED YET - BY FAR');
				self.logIt('Showing given ghost address #' + ghostId );
				//self.fnlDebug = self.dblPersons[ghostId];
				self.ghostContactaddress = self.ghostContactaddresses[ghostId];
			},
			MAYBENOTNEEDEDremoveGhostContactaddress: function (ghostId) {
				var self = this;
				self.logIt('THIS IS NOT FINISHED YET - BY FAR');
				self.logIt('Removing given ghost address #' + ghostId );
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajremoveghostcontactaddress', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.logIt('- done: ghost contactaddress ' + data.meta.ghostid + ' removed');
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});
			},
			fetchAllContactaddresses: function () {
				var self = this;
				self.logIt('Fetching all contact addresses');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajfetchallcontactaddresses', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.logIt('- done: ' + data.meta.cakedata.allContactaddresses.length + ' contactaddresses fetched');
						self.allContactaddresses = data.meta.cakedata.allContactaddresses;
						self.allContactaddresses.forEach(self.addOneContactaddress);
					},
					error: function(e) {
						self.logIt('ERROR: Fetching all contact addresses');
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});
			},
			addOneContactaddress: function (contactaddress) {
				var self = this;
				var thisContactaddress = contactaddress;
				self.logIt('Add contactaddress #' + thisContactaddress.Contactaddress.id + ' - ' + thisContactaddress.Contactaddress.address);
				$('#splitAddressesList').append(
    											$('<li>').attr('class', 'list-group-item').attr('id', 'contactaddress-'+thisContactaddress.Contactaddress.id).append(
            											$('<span>').attr('class', 'tab').append(thisContactaddress.Contactaddress.address)
											));
			},
			splitAllContactaddresses: function (event) {
				var self = this;
				self.disableButton('#'+event.target.id);
				self.allContactaddresses.forEach(self.splitOneContactaddressStreetNumber);
			},
			splitOneContactaddressStreetNumber: function (contactaddress) {
				var self = this;
				var splitContactaddress = {};
				var thisContactaddress = contactaddress;
				self.logIt('Splitting contactaddress #' + thisContactaddress.Contactaddress.id + ' - ' + thisContactaddress.Contactaddress.address);
				$('#contactaddress-'+thisContactaddress.Contactaddress.id).addClass('list-group-item-info').append(' - splitting ...');
				var splitStreetAndNumberAndSuffix = self.splitAddress(thisContactaddress.Contactaddress.address);
				splitContactaddress = {
					'Contactaddress':
						{
							'id': thisContactaddress.Contactaddress.id,
							'street': splitStreetAndNumberAndSuffix.street,
							'streetnumber': splitStreetAndNumberAndSuffix.streetnumber,
							'streetnumbersuffix': splitStreetAndNumberAndSuffix.streetnumbersuffix
						}
				};
				$.ajax({
				  type: 'POST',
					url: "<?=$this->Html->url(array('action' => 'ajsavesplitaddress', 'ext' => 'json'))?>",
					data: splitContactaddress,
					dataType: 'json',
					success: function(response) {
						resultSplitContactaddress = response.meta.cakedata.contactaddress;
						self.logIt('- success: address ' + resultSplitContactaddress.Contactaddress.address + ': split into [' + resultSplitContactaddress.Contactaddress.street + '] - [' + resultSplitContactaddress.Contactaddress.streetnumber + ']');
						self.splitContactaddresses.push(resultSplitContactaddress);
						$('#contactaddress-'+resultSplitContactaddress.Contactaddress.id).removeClass('list-group-item-info').addClass('list-group-item-success').append(' - split into ['+resultSplitContactaddress.Contactaddress.street+'] - ['+resultSplitContactaddress.Contactaddress.streetnumber+'] - ['+resultSplitContactaddress.Contactaddress.streetnumbersuffix+']');
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
				});
			},
			splitAddress: function (address) {
				var self = this;
				var splitAddress = {};
				var thisAddress = address.trim();
				if (thisAddress == '') {
					self.logIt('Not splitting empty address');
					splitAddress = {
						'address': thisAddress,
						'street': '',
						'streetnumber': null,
						'streetnumbersuffix': ''
					};
				} else {
					if (thisAddress.search(" ") == -1) {
						self.logIt('Not splitting address without a single space');
						splitAddress = {
							'address': thisAddress,
							'street': thisAddress.trim(),
							'streetnumber': null,
							'streetnumbersuffix': ''
						};
					} else {
						self.logIt('Splitting address ' + thisAddress);
						var theSplit = /(.+?)(\s)(\d+)(.*)/.exec(thisAddress);
						if (theSplit == null) {
							self.logIt('Split was no good');
							splitAddress = {
								'address': thisAddress,
								'street': thisAddress.trim(),
								'streetnumber': null,
								'streetnumbersuffix': ''
							};
						} else {
							splitAddress = {
								'address': thisAddress,
								'street': theSplit[1],
								'streetnumber': theSplit[3],
								'streetnumbersuffix': theSplit[4].trim().replace(/^(\,|\/)/g, '').trim()
							};
						}
					}
				}
				return splitAddress;
			},
			switchToMembershipsTable: function (event) {
				var self = this;
				self.disableButton('#'+event.target.id);
				self.logIt('Swith the Migratemembers table to the Memberships table');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajswitchtomembershipstable', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.logIt('- done switching migratemembers to memberships');
						// self.allContactaddresses = data.meta.cakedata.allContactaddresses;
						// self.allContactaddresses.forEach(self.addOneContactaddress);
					},
					error: function(e) {
						self.logIt('ERROR: reducing migratemembers table');
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});
			}
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
		//$("div#ghostContactaddress").hide();
		$("#toggleGhostContactaddress").click(function() {
			$("div#ghostContactaddress").toggle(toggleSpeed);
		});

	});
</script>
