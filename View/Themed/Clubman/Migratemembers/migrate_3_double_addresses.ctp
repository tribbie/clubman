<div id="membermigrate">
	<div>

		<div class="row">

			<div class="col-md-8">
				<div class="panel panel-default">

				  <div id="toggleMigrationInfo" class="panel-heading">{{ dblTitle }}</div>
			  	<div id="migrationInfo" class="panel-body">
						<p>
							This is the plan-of-attack for the second part of the member migration:
							<ul>
								<li>
									NEXT: post-processing double addresses:
									<ul>
										<li>merge duplicate addresses into (member)person</li>
									</ul>
								</li>
							</ul>
						</p>
			  	</div>

					<div id="toggleMigrationSteps" class="panel-heading">Migration steps</div>
			  	<div id="migrationSteps" class="panel-body">
						<p>
							Step 1:
							<button id='fetchDoubleAddressesButton' class="btn btn-primary" type="button" v-on:click="fetchDoubleAddresses()" title="(fetch duplicates from database)">
                Fetch duplicate addresses
              </button>
							<span class="badge">{{ dblAddresses.length }} duplicates found</span>
						</p>
						<p>
							Step 2:
							<button id='processAllDoubleAddressesButton' class="btn btn-primary" type="button" v-on:click="processAllDoubleAddresses($event)" title="(process duplicates)">
								Merge all duplicate addresses
							</button>
							<span class="badge">{{ dblAddressMergeCount }} addresses merged</span>
						</p>
						<p>
							Next:
              <?= $this->Html->link("On to the next step", array('controller' => 'migratemembers', 'action' => 'migrate_4_double_persons')); ?>
            </p>
			  	</div>

					<div id="notoggleMigrationTable" class="panel-heading">
						The double addresses
						<button id='refetchDoubleAddressesButton' type="button" v-on:click="fetchDoubleAddresses()" title="(refresh double addresses)">
							Refresh
						</button>
						<button id='toggleMigrationTable' type="button">
							showhide
						</button>
						<span class="badge">{{ dblAddresses.length }} stuks</span>
					</div>
					<div class="table-responsive">
						<table id="migrationTable" class="table table-condensed table-striped table-hover">
							<tbody>
								<tr class="" v-for="(itemKey, oneAddress) in dblAddresses">
									<td>
										<button class='btn btn-default btn-xs' id='preMigrationTableAddress{{ oneAddress[0].Contactaddress.id }}' type="button" v-on:click="showDoubleAddress(itemKey)" title="show">
											{{ itemKey }}
										</button>
										<button class='btn btn-primary btn-xs' id='doubleAddressProcess{{ oneAddress[0].Contactaddress.id }}' type="button" v-on:click="processDoubleAddress(itemKey)" title="process">
											{{ itemKey }}
										</button>
									</td>
									<td class="" v-for="oneItem in oneAddress">
										<span title='id {{ oneItem.Contactaddress.id }}'>
											{{ oneItem.Contactaddress.address }}
											{{ oneItem.Contactaddress.postcode }}
										</span>
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

					<div id="toggleDoubleAddress" class="panel-heading">Double #{{ dblAddress.itemkey }}</div>
			  	<div id="doubleAddress" class="panel-body">
						<div>
								<ul class="list-group">
									<li class="list-group-item list-group-item-success">
										Address -
										{{ dblAddress.addresses[0].Contactaddress.address }}
										{{ dblAddress.addresses[0].Contactaddress.postcode }}
									</li>
									<li class="list-group-item list-group-item-disabled" v-for="oneAddress in dblAddress.addresses">
										{{ oneAddress.Contactaddress.address }} {{ oneAddress.Contactaddress.postcode }}<br/>
										<small>
											ID={{ oneAddress.Contactaddress.id }}
											-
											{{ oneAddress.Contactaddress.metadata }}
											(remark={{ oneAddress.Contactaddress.remark }})
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
	var migrateDoubleAddressesApp = new Vue({
		el: '#membermigrate',
		data: {
			dblTitle: 'Migration of the Clubman double addresses',
			dblLog: '',
			dblDebug: '',
			dblAddresses: {},
			dblAddress: {
				itemkey: null,
				addresses: []
			},
			dblAddressMergeCount: 0,
		},
		ready: function() {
	    this.fetchDoubleAddresses();
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
				$(elementId).attr('class','btn btn-success');
				$(elementId).attr('disabled','disabled');
			},
			fetchDoubleAddresses: function() {
				var self = this;
				/// when refetching - reinitialize the address in the panel
				self.dblAddress.itemkey = null;
				self.dblAddress.addresses = [];
				self.logIt('Fetching the double addresses (same street, number, postcode)');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajfetchdoubleaddresses', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.logIt('- done: ' + data.meta.cakedata.doubleaddresses.length + ' distinct addresses with doubles fetched');
						self.dblAddresses = data.meta.cakedata.doubleaddresses;
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
				});
			},
			showDoubleAddress: function(doubleId) {
				var self = this;
				self.logIt('Showing given double address #' + doubleId );
				self.dblAddress.itemkey = doubleId;
				self.dblDebug = self.dblAddresses[doubleId];
				self.dblAddress.addresses = self.dblAddresses[doubleId];
			},
			processAllDoubleAddresses: function(event) {
				var self = this;
				self.disableButton('#'+event.target.id);
				self.logIt('Merging all double addresses into the first one');
				for (i = 0; i < self.dblAddresses.length; i++) {
					self.processDoubleAddress(i);
				}
			},
			processDoubleAddress: function(doubleId) {
				var self = this;
				self.logIt('Merging given double address #' + doubleId );
				self.dblAddress.itemkey = doubleId;
				self.dblDebug = '';
				self.dblAddress.addresses = self.dblAddresses[doubleId];
				var i;
				var theContactaddressId;
				var thePersonId;
				for (i = 0; i < self.dblAddress.addresses.length; i++) {
					if (i == 0) {
						/// grab the first "master" contactaddress id
						theContactaddressId = self.dblAddress.addresses[i].Contactaddress.id
					} else {
						/// the others (doubles) will be merged and removed
						thePersonId = self.dblAddress.addresses[i].Contactaddress.remark;
						self.dblDebug += i + " -- merging address " + theContactaddressId + " to person " + thePersonId + "\n";
						self.linkContactaddressToPerson(theContactaddressId, thePersonId);
						self.removeContactaddress(self.dblAddress.addresses[i].Contactaddress.id);
					}
    			self.dblDebug += i + " -- id=" + self.dblAddress.addresses[i].Contactaddress.id + " - " + self.dblAddress.addresses[i].Contactaddress.metadata + "\n";
				}
				self.dblAddressMergeCount += 1;
			},
			linkContactaddressToPerson: function(contactaddressId, personId) {
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
			removeContactaddress: function(contactaddressId) {
				var self = this;
				var thisContactaddress = {};
				self.logIt('Removing the contactaddressid (' + contactaddressId + ') from the database');
				thisContactaddress = {
										'Contactaddress':
											{
												'id': contactaddressId,
											}
										};
				$.ajax({
					type: 'POST',
					url: "<?=$this->Html->url(array('action' => 'ajremovecontactaddress', 'ext' => 'json'))?>",
					data: thisContactaddress,
					dataType: 'json',
					success: function(response) {
						self.logIt('- success: removed contactaddress #' + response.meta.cakedata.theRemovedId + ' from the database - ' + response.meta.result.status + ' - ' + response.meta.result.detail);
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
		//$("div#doubleAddress").hide();
		$("#toggleDoubleAddress").click(function() {
			$("div#doubleAddress").toggle(toggleSpeed);
		});

	});
</script>
