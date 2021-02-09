<div id="membermigrate">
	<div>

		<div class="row">

			<div class="col-md-8">
				<div class="panel panel-default">

					<div id="toggleMigrationInfo" class="panel-heading">{{ migTitle }}</div>
					<div id="migrationInfo" class="panel-body">
						<p>
							This is the plan-of-attack for the pre-migrtation part of the member migration:
							<ul>
								<li>Create the new tables</li>
							</ul>
						</p>
			  	</div>

					<div id="toggleMigrationSteps" class="panel-heading">Migration steps</div>
					<div id="migrationSteps" class="panel-body">
						<p>
							Step 1:
							<button id='backupMembersButton' class="btn btn-primary" type="button" v-on:click="backupMembers($event)" title="(backup members table)">
                Backup members table
              </button>
							<span class="badge">{{ tableCount['members'] }} members</span>
							<span class="badge">{{ tableCount['members_backup'] }} members backed up</span>
						</p>
						<p>
							Step 2:
							<button id='dropCreateNewTablesButton' class="btn btn-primary" type="button" v-on:click="dropCreateNewTables($event)" title="(create new tables)">
								Create new tables
							</button>
							<span class="badge">{{ tableCount['migratemembers'] }} migratemembers</span>
							<span class="badge">{{ tableCount['persons'] }} persons</span>
							<span class="badge">{{ tableCount['personparents'] }} personparents</span>
							<span class="badge">{{ tableCount['contactaddresses'] }} contactaddresses</span>
						</p>
						<p>
							Step 3:
							<button id='prepareMigrationButton' class="btn btn-primary" type="button" v-on:click="prepareMigration($event)" title="(empty Persons - Personparents - Contacts)">
								Prepare migration
							</button>
						</p>
						<p>
							Next:
							<?= $this->Html->link("On to the next step", array('controller' => 'migratemembers', 'action' => 'migrate_2_members')); ?>
						</p>

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

				</div>
			</div>

		</div>

		<hr>

		<div class="row">

			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div id="toggleMigrationDebugInfo" class="panel-heading">Debug info</div>
					<div id="migrationDebugInfo" class="panel-body">
						<pre>{{ migDebug | json }}</pre>
					</div>
				</div>
			</div>

		</div>

	</div>
</div> <!-- membermigrate -->

<script>
	var migrateSchemaApp = new Vue({
		el: '#membermigrate',
		data: {
			migTitle: 'Migration of the Clubman schema',
			migLog: '',
			migDebug: '',
			tableCount: {
				members: -1,
				members_backup: -1,
				migratemembers: -1,
				persons: -1,
				personparents: -1,
				contactaddresses: -1,
				memberships: -1
			}
		},
		ready: function() {
	    this.fetchMemberCount();
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
				self.migLog += logLine + "\n";
				//alert(logline);
			},
			disableButton: function (elementId) {
				$(elementId).attr('class','btn btn-success');
				$(elementId).attr('disabled','disabled');
			},
			fetchMemberCount: function() {
				var self = this;
				self.logIt('Fetching record count for the members table');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajfetchmembercount', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.migDebug = data.meta;
						self.tableCount['members'] = data.meta.cakedata.counts.members;
						self.logIt('- done: ' + self.tableCount['members'] + ' members counted');
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
				});
			},
			fetchTableCounts: function() {
				var self = this;
				self.logIt('Fetching record count for the migration tables');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajfetchtablecounts', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.migDebug = data.meta;
						self.tableCount = data.meta.cakedata.counts;
						self.logIt('- done counting some tables');
						self.logIt('--- ' + self.tableCount['members'] + ' members counted');
						self.logIt('--- ' + self.tableCount['members_backup'] + ' members_backup counted');
						self.logIt('--- ' + self.tableCount['migratemembers'] + ' migratemembers counted');
						self.logIt('--- ' + self.tableCount['persons'] + ' persons counted');
						self.logIt('--- ' + self.tableCount['personparents'] + ' personparents counted');
						self.logIt('--- ' + self.tableCount['contactaddresses'] + ' contactaddresses counted');
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
				});
			},
			backupMembers: function(event) {
				var self = this;
				self.logIt('Backing up members table');
				self.disableButton('#'+event.target.id);
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajbackupmemberstable', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.migDebug = data.meta;
						self.tableCount['members_backup'] = data.meta.cakedata['4-count'];
						self.logIt('--- table dropped: ' + data.meta.cakedata['1-drop']);
						self.logIt('--- table created: ' + data.meta.cakedata['2-create']);
						self.logIt('--- records inserted: ' + data.meta.cakedata['3-insert']);
						self.logIt('--- records counted: ' + data.meta.cakedata['4-count']);
						self.logIt('- done backing up');
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
				});
			},
			dropCreateNewTables: function(event) {
				var self = this;
				self.logIt('Creating migration tables');
				self.disableButton('#'+event.target.id);
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajdropcreatenewtables', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.migDebug = data.meta;
						self.tableCount['migratemembers'] = data.meta.cakedata.Migratemembers.count;
						self.logIt('--- table Migratemembers drop-created: ' + data.meta.cakedata.Migratemembers.count + ' records');
						self.tableCount['persons'] = data.meta.cakedata.Persons.count;
						self.logIt('--- table Persons drop-created: ' + data.meta.cakedata.Persons.count + ' records');
						self.tableCount['personparents'] = data.meta.cakedata.Personparents.count;
						self.logIt('--- table Personparents drop-created: ' + data.meta.cakedata.Personparents.count + ' records');
						self.tableCount['contactaddresses'] = data.meta.cakedata.Contactaddresses.count;
						self.logIt('--- table Contactaddresses drop-created: ' + data.meta.cakedata.Contactaddresses.count + ' records');
						self.logIt('- done drop-creating migration tables');
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
				});
			},
			prepareMigration: function (event) {
				var self = this;
				self.logIt('Prepare migration (Persons - Contacts - Parents)');
				self.disableButton('#'+event.target.id);
				self.logIt('Reset Personparents...');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajemptypersonparents', 'ext' => 'json'))?>",
		      dataType: 'json',
		      success: function(data) {
						self.logIt('- success: truncated personparents - ' + data.meta.cakedata);
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
		    });
				self.logIt('Reset Contactaddresses...');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajemptycontactaddresses', 'ext' => 'json'))?>",
		      dataType: 'json',
		      success: function(data) {
						self.logIt('- success: truncated contacts - ' + data.meta.cakedata);
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
		    });
				self.logIt('Reset Persons...');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajemptypersons', 'ext' => 'json'))?>",
		      dataType: 'json',
		      success: function(data) {
						self.logIt('- success: truncated persons - ' + data.meta.cakedata);
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
		      }
		    });
				self.logIt('Reset person_id in Migratemembers...');
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajresetpersonid', 'ext' => 'json'))?>",
					dataType: 'json',
					success: function(data) {
						self.logIt('- success: person_id reset - ' + data.meta.cakedata);
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
