<!-- document javascripts -->
<script>
	$(document).ready(function(){
		$('.datepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1 } );
		toggleSpeed = 132;
		$("div#effortsPeriodForm").hide();
		$("#toggleEffortsPeriodForm").click(function() {
			$("div#effortsPeriodForm").toggle(toggleSpeed);
		});
	});
</script>
<!-- app/View/Efforts/listteam.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> prestaties</h2>
<div id="effortsTotals">

	<div class="row">

		<div class="col-md-6">

			<div id="theForm" class="no-well">
				<div class="panel panel-info">
					<div id="toggleEffortsPeriodForm" class="panel-heading">
						<h3 class="panel-title">
							Periode:
							<template v-if="(totPeriod.datefrom && totPeriod.dateto)">
								{{ totPeriod.datefrom }} - {{ totPeriod.dateto }}
							</template>
							<template v-else>
								(stel in)
							</template>
						</h3>
					</div>
					<div id="effortsPeriodForm" class="panel-body" style="display: none;">
						<div class="inputform">
							<?=$this->Form->create('Effort', array('default' => false, 'url' => false))?>
							<?=$this->Form->input('datefrom', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Datum (YYYY-MM-DD)', 'required' => true))?>
							<?=$this->Form->input('dateto', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text', 'title' => 'Datum (YYYY-MM-DD)', 'required' => true))?>
							<br/>
							<?=$this->Form->end(array('label' => 'Haal op', 'id' => 'submitPeriod', 'class' => 'btn btn-primary'))?>
						</div>
					</div>
				</div>
			</div>

		</div>

		<!--
		<div class="col-md-6">
			<div class="panel panel-default">
				<div id="toggleMigrationContact" class="panel-heading">Period shizzle</div>
				<div id="migrationContact" class="panel-body">
					<pre>{{ totPeriod | json }}</pre>
				</div>
			</div>
		</div>
		-->

	</div>

	<div class="row">

		<!--
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-condensed table-hover normalelijst">
					<thead>
						<tr class="groupheader info">
							<th>Persoon</th>
							<th class="text-right">Coaching (#)</th>
							<th class="text-right">Demos (#)</th>
							<th class="text-right">Trainingen (min)</th>
							<th class="text-right">Assistentie (min)</th>
							<th class="text-right">Coördinatie (min)</th>
							<th class="text-right">Andere (min)</th>
						</tr>
					</thead>
					<tbody>
						<tr class="" v-for="(oneTotalKey, oneTotal) in totTotals" v-on:click="listEfforts(oneTotalKey)">
							<td>{{ oneTotal.totals.name }}</td>
							<td class="text-right">{{ oneTotal.totals.coachings }}</td>
							<td class="text-right">{{ oneTotal.totals.demos }}</td>
							<td class="text-right">{{ oneTotal.totals.trainingminutes }}</td>
							<td class="text-right">{{ oneTotal.totals.assistminutes }}</td>
							<td class="text-right">{{ oneTotal.totals.coordminutes }}</td>
							<td class="text-right">{{ oneTotal.totals.otherminutes }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		-->

		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-condensed table-hover normalelijst">
					<thead>
						<tr class="groupheader info">
							<template v-for="totColumn in totColumns">
								<template v-if="(totColumn == 'name')">
									<th>
					          <a href="#" v-on:click="sortTotalsBy(totColumn)">
					            {{ totColumn | capitalize }}
					          </a>
					        </th>
								</template>
								<template v-else>
									<th class="text-right">
					          <a href="#" v-on:click="sortTotalsBy(totColumn)">
					            {{ totColumn | capitalize }}
					          </a>
					        </th>
								</template>
							</template>
						</tr>
					</thead>
					<tbody>
						<tr v-for="oneTotal in totalsArray | orderBy totSortKey totSortOrder" v-on:click="listEfforts(oneTotal.id)">
							<template v-for="totColumn in totColumns">
								<template v-if="(totColumn == 'name')">
									<td>
										{{ oneTotal[totColumn] }}
									</td>
								</template>
								<template v-else>
									<td class="text-right">
										{{ oneTotal[totColumn] }}
									</td>
								</template>
							</template>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<!--
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">Totals array</div>
				<div class="panel-body">
					<pre>{{ totalsArray | json }}</pre>
				</div>
			</div>
		</div>
		-->

	</div>

	<div class="row">

		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-condensed normalelijst">
					<thead>
						<tr class="groupheader info">
							<th>Lid</th>
							<th>Datum</th>
							<th>Taak</th>
							<th class="text-right">Duur</th>
							<th>Opmerking</th>
						</tr>
					</thead>
					<tbody>
						<tr class="" v-for="(oneEffortKey, oneEffort) in onePersonEfforts">
							<td>{{ oneEffort.Member.lastname }} {{ oneEffort.Member.firstname }}</td>
							<td>{{ oneEffort.Effort.taskdate }}</td>
							<td>{{ oneEffort.Effort.taskname }}</td>
							<td class="text-right">{{ oneEffort.Effort.taskduration }}</td>
							<td>{{ oneEffort.Effort.remark }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

	</div>

</div>

<script>
	var totalsapp = new Vue({
		el: '#effortsTotals',
		data: {
			totTitle: 'Totals of the Clubman efforts',
			//totResponse: {}
			totSortKey: 'name',
			totSortOrder: 1,
			totColumns: ['name', 'coachings', 'demos', 'trainingminutes', 'assistminutes', 'coordminutes', 'otherminutes'],
			totTotals: {},
			totPeriod: {},
			totEfforts: [],
			totalsArray: [],
			onePersonEfforts: [],
		},
		ready: function() {
			var self = this;
	    //this.dummy();
			self.logIt("Starting");
			$("#submitPeriod").click(function() {
				self.submitForm();
			});

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
				//alert(logline);
			},
			listEfforts: function (theKey) {
				var self = this;
				self.logIt("Listing efforts for " + theKey);
				self.onePersonEfforts = self.totTotals[theKey].efforts;
			},
			disableButton: function (elementId) {
				$(elementId).attr('class','btn btn-success');
				$(elementId).attr('disabled','disabled');
			},
			submitForm: function () {
				var self = this;
				validForm = $("#EffortPeriodicoverviewForm")[0].checkValidity();
				if (validForm) {
					event.preventDefault();
					$("div#effortsPeriodForm").toggle(toggleSpeed);
					//self.totTotals = {};
					self.onePersonEfforts = [];
					// HERE YOU CAN PUT YOUR AJAX CALL
					self.fetchPeriod();
				}
			},
			fetchPeriod: function () {
				event.preventDefault();
				var self = this;
				var inputs = document.getElementById("EffortPeriodicoverviewForm").elements;
				var datefrom = document.getElementById("EffortDatefrom").value;
				var dateto = document.getElementById("EffortDateto").value;
				self.logIt('Fetching the totals for the period: ' + datefrom + ' - '+ dateto);
				/// AJAX code to submit form
				$.ajax ({
					type: "GET",
					url: "<?=$this->Html->url(array('action' => 'ajfetchperiod'))?>/from:"+datefrom+"/to:"+dateto,
					dataType: 'json',
					success: function(data) {
						//console.log("Success");
						//alert("Success");
						self.logIt('- success: totals fetched');
						//self.totResponse = data;
						self.totPeriod = data.data.period;
						self.totTotals = data.data.totals;
						self.totEfforts = data.meta.cakedata.efforts;
						self.totalsArray = [];
						$.each(self.totTotals, function(key, value) {
							self.logIt('-> ' + value.totals.name + ' = ' + key);
							self.totalsArray.push(value.totals);
						});
					},
					error: function(e) {
						console.log(e);
						//alert("An error occurred: " + e.responseText.message);
					}
				});
				return false;
			},
	    sortTotalsBy: function(newSortKey) {
				var self = this;
				self.logIt("Sort - was: " + self.totSortKey + " will be: " + newSortKey);
				var newSortOrder = 1;
				if (self.totSortKey == newSortKey) {
					var newSortOrder = (self.totSortOrder == 1) ? -1 : 1;
				}
				self.logIt("Order - was: " + self.totSortOrder + " will be: " + newSortOrder);
				self.totSortKey = newSortKey;
				self.totSortOrder = newSortOrder;
	    },
		}
	});
</script>

<?php
	//pr($period);
	//pr($totals);
	//pr($efforts);
	//pr($this->request);
?>
