<!-- app/View/Members/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> leden</h2>

<div class="row">
	<div class="col-xs-12">
		<?= $this->Html->link('the new schema', array('controller' => 'help', 'action' => 'clubman-v06-database-migration'), array('title' => 'migrate - schema')); ?>
		<br/>
		<?= $this->Html->link('Report before - the pudding', array('controller' => 'reports', 'action' => 'migratemembersbefore'), array('title' => 'pre-migrate report')); ?>
		<br/>
		<?= $this->Html->link('Migrate step 1 - create new schema', array('controller' => 'migratemembers', 'action' => 'migrate_1_schema'), array('title' => 'migrate')); ?>
		<br/>
		<?= $this->Html->link('Migrate step 2 - to the new schema', array('controller' => 'migratemembers', 'action' => 'migrate_2_members'), array('title' => 'migrate')); ?>
		<br/>
		<?= $this->Html->link('Migrate step 3 - de-double addresses', array('controller' => 'migratemembers', 'action' => 'migrate_3_double_addresses'), array('title' => 'migrate')); ?>
		<br/>
		<?= $this->Html->link('Migrate step 4 - de-double persons', array('controller' => 'migratemembers', 'action' => 'migrate_4_double_persons'), array('title' => 'migrate')); ?>
		<br/>
		<?= $this->Html->link('Migrate step 5 - final shizzle and cleanup', array('controller' => 'migratemembers', 'action' => 'migrate_5_final'), array('title' => 'migrate')); ?>
		<br/>
		<?= $this->Html->link('Report after - the proof of the pudding', array('controller' => 'reports', 'action' => 'migratemembersafter'), array('title' => 'post-migrate report')); ?>
		<br/>
		<?= $this->Html->link('to Memberships', array('controller' => 'memberships', 'action' => 'index'), array('title' => 'memberships')); ?>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">

		<div class="cm-membercolumns">
		<?php $currentfirstletter = ''; ?>
		<?php $newfirstletter = ''; ?>
		<?php foreach ($members as $member) : ?>
			<?php $newfirstletter = strtoupper($member['Migratemember']['lastname'][0]); ?>
			<?php if ($newfirstletter <> $currentfirstletter) : ?>
				<?php $currentfirstletter = $newfirstletter; ?>
						<div class="bg-info">
							<?=$newfirstletter?>
						</div>
			<?php endif ; ?>
			<?php
			 if ($member['Migratemember']['active'] == true) {
				$memberbgclass = 'bg-default';
				$membertitle = 'actief';
			} else {
				$memberbgclass = 'bg-warning';
				$membertitle = 'inactief';
			}
			?>
			<div class="<?=$memberbgclass?>">
				<?= $this->Html->link($member['Migratemember']['name'], array('controller' => 'migratemembers', 'action' => 'view', $member['Migratemember']['id']), array('title' => $membertitle)); ?>
			</div>
		<?php endforeach; ?>
		</div>

	</div>
</div>

<?php
// pr($members);
?>



<!-- EVERYTHING BELOW HERE IS TEST SHIZZLE -->
<!-- EVERYTHING BELOW HERE IS TEST SHIZZLE -->
<!-- EVERYTHING BELOW HERE IS TEST SHIZZLE -->
<!-- EVERYTHING BELOW HERE IS TEST SHIZZLE -->
<!-- EVERYTHING BELOW HERE IS TEST SHIZZLE -->


<hr/>
<div class="row" id="tothetest">
	<div class="col-xs-12" id="migrateTestShizzle">

		<div class="panel panel-default">
			<div id="toggleMigrationInfo" class="panel-heading">Migration shizzle</div>
			<div id="migrationInfo" class="panel-body">
				<div>
					<p>
						<button id='testShizzleButton' class="btn btn-primary" type="button" v-on:click="testShizzle($event)" title="(test some shizzle)">
							Test shizzle
						</button>
						<span class="badge">{{ test.shizzle }} -- shizzle</span>
					</p>
				</div>
				<div>
					<small>
						<pre>{{ test | json }}</pre>
					</small>
				</div>
			</div>
		</div>

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

<script>
	var migrateTestShizzleApp = new Vue({
		el: '#migrateTestShizzle',
		data: {
			migTitle: 'Migration test shizzle',
			migLog: '',
			migDebug: '',
			test: {
				shizzle: '',
			}
		},
		ready: function() {
		},
		methods: {
			dummy: function (event) {
				// `this` inside methods points to the Vue instance
				console.log('Hello from dummy -- ' + this.migTitle + '!');
				alert('Hello from dummy -- ' + this.migTitle + '!');
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
			testShizzle: function (event) {
				var self = this;
				self.logIt('Testing shizzle...');
				//self.dummy(event);
				targetId = event.currentTarget.id;
				self.logIt('- the ID = ' + targetId);
				self.disableButton('#'+event.target.id);
				self.test.shizzle = 'button #' + targetId + ' disabled';
			},
		}
	});
</script>

<script>
	$(document).ready(function() {
		toggleSpeed = 132;
		//$("div#migrationInfo").hide();
		$("#toggleMigrationInfo").click(function() {
			$("div#migrationInfo").toggle(toggleSpeed);
		});
		//$("div#migrationLog").hide();
		$("#toggleMigrationLog").click(function() {
			$("div#migrationLog").toggle(toggleSpeed);
		});

	});
</script>
