<!-- app/View/Members/migrate05to06.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> migratie van de database van v0.5 naar v0.6</h2>

<div class="box">
	<div id="migrationapp">

		<section v-show="members.allmembers.length">

			<div class="row">
			  <div class="col-md-1"></div>
			  <div class="col-md-10">
					<div class="panel panel-default">
					  <!-- Default panel contents -->
					  <div class="panel-heading">Actieve Leden</div>
					  <div class="panel-body">
							<form id="searchactive">Filter op naam <input name="query" v-model="nameFilter"></form>
					  </div>
					  <!-- Table -->
						<table class="table table-condensed">
						<thead>
				      <tr>
								<th>Verjaardag</th>
								<th class="text-center">Foto</th>
								<th>Naam</th>
								<th>Geboortedatum</th>
				      </tr>
				    </thead>
				    <tbody>
							<tr class="" v-for="onemember in members.allmembers | filterBy nameFilter in 'Member.name'">
								<td><input id="{{ onemember.Member.id }}" type="checkbox" v-togglebox="onemember.Member.birthday_public"></td>
								<td class="text-center" v-if="onemember.Picture.location">
									<img class="img-circle" :src="'<?=$this->base?>/img/' + onemember.Picture.location" title="foto" height="60" alt="" />
								<td class="text-center" v-else>
									<img class="img-circle" src="<?=$this->base?>/img/cmstyle/no_picture.png" title="foto" height="60" alt="" />
								</td>
								<td>{{ onemember.Member.name }} ({{ onemember.Member.id }}) <!--({{ $index }})--></td>
								<td :class="{ 'private' : ! onemember.Member.birthday_public }">{{ onemember.Member.birthdate_nice }}</td>
							</tr>
						</tbody>
						</table>
					</div>
				</div>
			  <div class="col-md-1"></div>
			</div>

		</section>


		<section v-show="members.allmembers.inactive.length">

		</section>


<!--		<pre>{{{ $data | json }}</pre> -->

	</div> <!-- migrationapp -->
</div>


<script>
	Vue.directive('togglebox', {
		twoWay : true,
		bind: function () {
			var self = this;
			var toggle = $(self.el).bootstrapToggle();
			// console.log("Bound to id " + self.el.id);
		},
		update: function (newValue, oldValue) {
			var self = this;
			if ( newValue == 1 ) {
				$(self.el).bootstrapToggle('on');
			} else {
				$(self.el).bootstrapToggle('off');
			}
			// console.log('In update - name:' + this.name + ' - expression:' + this.expression + ' - argument:' + this.arg + ' - modifiers:' + JSON.stringify(this.modifiers) + ' - value:' + newValue);
			// console.log(this.name + " for id #" + self.el.id + ": " + oldValue + " ==> " + newValue);
			$(self.el).change(function() {
				var value = $(self.el).prop('checked');
				self.set(value);
				console.log("Change detected for #" + self.el.id + " to " + value);

				$.ajax({
					type: 'get',
					// die self en value hieronder is nie gekend op moment van php parsing dju!!!
					url: "<?=$this->Html->url(array('action' => 'ajbirthdaypublic'))?>" + '/' + self.el.id + '/' + value + '.json',
					// beforeSend: function(xhr) {
					// 	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					// },
					success: function(response) {
						if (response.error) {
							alert(response.error);
							console.log(response.error);
						}
						if (response.content) {
							// alert(response.content);
							console.log(response.content);
						}
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});

			});
		}
	})

  var migrationviewmodel = new Vue({
    el: '#migrationapp',

    data: {
			nameFilter: '',
			members: <?=json_encode(compact('allmembers'));?>
    },

		methods: {
	    toggleBirthdayPublish: function (id, name, bdpublic) {
	      // `this` inside methods point to the Vue instance
	      alert('Hello ' + name + ' (' + id + ')! Your birthday public: ' + bdpublic)
	    }
  	}
  });
</script>











<hr/>
<hr/>
<hr/>












<div class="box">
	<div>

			<div class="row">
			  <div class="col-md-1"></div>
			  <div class="col-md-10">
					<div class="panel panel-default">
					  <!-- Default panel contents -->
					  <div id='toggleMigrationInfo' class="panel-heading">General info</div>
					  <div id='migrationInfo' class="panel-body">
							Deze migratie migreert volgende:
							<ol>
								<li>member data to persons table</li>
								<li>member address data to contactaddresses table (watch for doubles)</li>
								<li>member mom data to person table (watch for doubles)</li>
								<li>member dad data to person table (watch for doubles)</li>
								<li>member mom address data to contactaddresses table (watch for doubles)</li>
								<li>member dad address data to contactaddresses table (watch for doubles)</li>
							</ol>
					  </div>

						<div id='togglePreMigrationInfo' class="panel-heading">Pre Migration Info</div>
						<div id='preMigrationInfo' class="panel-body">
							<?php
							 $persons = array();
							 $mompersons = array();
							 $dadpersons = array();
							 $addresses = array();
							 foreach ($allmembers as $onemember) {
								 $oneperson = array();
								 $onepersonaddress = array();
								 $onemom = array();
								 $onedad = array();
								 $onemomaddress = array();
								 $onedadaddress = array();
								 /// member person
								 {
									 $oneperson['id']              = null;
									 $oneperson['member_id']       = $onemember['Member']['id'];
									 $oneperson['lastname']        = trim($onemember['Member']['lastname']);
									 $oneperson['firstname']       = trim($onemember['Member']['firstname']);
									 $oneperson['picture_id']      = $onemember['Member']['picture_id'];
									 $oneperson['contact_id']      = null;
									 $oneperson['uniquenumber']    = trim($onemember['Member']['nationalnumber']);
									 $oneperson['gender']          = null;
									 $oneperson['birthdate']       = $onemember['Member']['birthdate'];
									 $oneperson['birthday_public'] = $onemember['Member']['birthday_public'];
									 $oneperson['email']           = trim($onemember['Member']['email']);
									 $oneperson['mobile']          = trim($onemember['Member']['tel']);
									 $oneperson['bankaccount']     = trim($onemember['Member']['bank_account']);
									 $oneperson['nickname']        = trim($onemember['Member']['nickname']);
									 $oneperson['remark']          = trim($onemember['Member']['remark']);
							 	 }
								 $persons[] = $oneperson;
								 /// member address
								 {
									 $onepersonaddress['member_id']   = $onemember['Member']['id'];
									 $onepersonaddress['address']     = $onemember['Member']['address'];
									 $onepersonaddress['postcode']    = $onemember['Member']['postcode'];
									 $onepersonaddress['city']        = $onemember['Member']['city'];
									 $onepersonaddress['countrycode'] = 'be';
									 $onepersonaddress['landline']    = null;
								 }
								 $addresses[] = $onepersonaddress;
								 /// member mom
								 if (trim($onemember['Member']['mom_lastname'] . $onemember['Member']['mom_firstname']) <> '') {
									 $onemom['member_id']   = $onemember['Member']['id'];
									 $onemom['member_name'] = trim($onemember['Member']['lastname']) . ' ' . trim($onemember['Member']['firstname']);
									 $onemom['lastname']    = trim($onemember['Member']['mom_lastname']);
									 $onemom['firstname']   = trim($onemember['Member']['mom_firstname']);
									 $onemom['email']       = trim($onemember['Member']['mom_email']);
									 $onemom['tel']         = trim($onemember['Member']['mom_tel']);
									 $mompersons[] = $onemom;
								 }
							 }
							?>
							Pre-migratie informatie:
							<ol>
								<li>member count: <?=count($allmembers)?></li>
								<li>memberpersons count: <?=count($persons)?></li>
								<li>mom persons count: <?=count($mompersons)?></li>
								<li>dad persons count: <?=count($dadpersons)?></li>
								<li>addresses count: <?=count($addresses)?></li>

							</ol>
					  </div>


						<div id='togglePreMigrationTable' class="panel-heading">Pre Migration table</div>
						<table id='preMigrationTable' class="table table-condensed table-striped table-hover">
							<thead>
					      <tr>
									<th>Lid</th>
									<th>Naam</th>
									<th>Mama</th>
									<th>Papa</th>
								</tr>
					    </thead>
					    <tbody>
								<?php foreach ($allmembers as $onemember) : ?>
								<tr>
									<td>
										<?=$onemember['Member']['id']?>
									</td>
									<td>
										<?=$onemember['Member']['lastname']?> <?=$onemember['Member']['firstname']?>
										<br/>
										<?=$onemember['Member']['address']?> <?=$onemember['Member']['postcode']?> <?=$onemember['Member']['city']?>
									</td>
									<td>
										<?=$onemember['Member']['mom_lastname']?> <?=$onemember['Member']['mom_firstname']?>
										<br/>
										<?=$onemember['Member']['mom_address']?> <?=$onemember['Member']['mom_postcode']?> <?=$onemember['Member']['mom_city']?>
									</td>
									<td>
										<?=$onemember['Member']['dad_lastname']?> <?=$onemember['Member']['dad_firstname']?>
										<br/>
										<?=$onemember['Member']['dad_address']?> <?=$onemember['Member']['dad_postcode']?> <?=$onemember['Member']['dad_city']?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>


						<div id='toggleMigrationStep1' class="panel-heading">Step 1</div>
						<div id='migrationStep1' class="panel-body">
							<?php
							echo $this->Js->link(
							    'Part one',
							    '#',
							    array('async' => true,
							          'update' => 'content',
							                  'id' => 'remanufactured-link'
							        )
							);
							?>
							<div id="content">
							</div>
						</div>



						<div id='toggleMigrationDebugInfo' class="panel-heading">Debug</div>
						<div id='migrationDebugInfo' class="panel-body">
						<?php
							echo 'addresses';
							if (isset($addresses)) pr($addresses);
							echo 'dads';
							if (isset($dadpersons)) pr($dadpersons);
							echo 'moms';
							if (isset($mompersons)) pr($mompersons);
							echo 'persons';
							if (isset($persons)) pr($persons);
							echo 'members';
							if (isset($allmembers)) pr($allmembers);
						?>
						</div>


					</div>
				</div>
			  <div class="col-md-1"></div>
			</div>


			<!-- <pre>{{{ $data | json }}</pre> -->

	</div>
</div>


<br/>
<hr/>



<script>
	$(document).ready(function() {
		$("div#migrationInfo").hide();
		$("#toggleMigrationInfo").click(function() {
			$("div#migrationInfo").toggle('200');
		});
		$("div#preMigrationInfo").hide();
		$("#togglePreMigrationInfo").click(function() {
			$("div#preMigrationInfo").toggle('200');
		});
		$("table#preMigrationTable").hide();
		$("#togglePreMigrationTable").click(function() {
			$("table#preMigrationTable").toggle('200');
		});
		$("div#migrationStep1").hide();
		$("#toggleMigrationStep1").click(function() {
			$("div#migrationStep1").toggle('200');
		});
		$("div#migrationStep1Info").hide();
		$("#toggleMigrationStep1Info").click(function() {
			$("div#migrationStep1Info").toggle('200');
		});
		$("div#migrationStep2").hide();
		$("#toggleMigrationStep2").click(function() {
			$("div#migrationStep2").toggle('200');
		});
		$("div#migrationStep2Info").hide();
		$("#toggleMigrationStep2Info").click(function() {
			$("div#migrationStep2Info").toggle('200');
		});
		$("div#migrationStep3").hide();
		$("#toggleMigrationStep3").click(function() {
			$("div#migrationStep3").toggle('200');
		});
		$("div#migrationStep3Info").hide();
		$("#toggleMigrationStep3Info").click(function() {
			$("div#migrationStep3Info").toggle('200');
		});

		$("div#migrationStep4").hide();
		$("#toggleMigrationStep4").click(function() {
			$("div#migrationStep4").toggle('200');
		});
		$("div#migrationStep4Info").hide();
		$("#toggleMigrationStep4Info").click(function() {
			$("div#migrationStep4Info").toggle('200');
		});
		$("div#migrationStep5").hide();
		$("#toggleMigrationStep5").click(function() {
			$("div#migrationStep5").toggle('200');
		});
		$("div#migrationStep5Info").hide();
		$("#toggleMigrationStep5Info").click(function() {
			$("div#migrationStep5Info").toggle('200');
		});

		$("div#migrationDebugInfo").hide();
		$("#toggleMigrationDebugInfo").click(function() {
			$("div#migrationDebugInfo").toggle('200');
		});
	});
</script>
