<!-- app/View/Members/add.ctp -->
<h2>Nieuw <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> lid</h2>

<div id="membershipadd">

	<div class="row">

		<div class="col-xs-12">
			<!--
			<div class="panel panel-info">
			  <div class="panel-heading">Belangrijke informatie</div>
			  <div class="panel-body">
					<p>
						<font color="red">Gelieve eerst bij de <?=$this->Html->link('inactieve leden', array('action' => 'index', 'inactive'))?> te checken of het geen ex-lid is dat weerkeert.</font><br/>
						In dit geval kan je dat lid best weer actief maken.<br/>
						<br/>
						Gegevens die je nu nog niet hebt laat je maar blank, je kan ze later steeds aanpassen of bijvullen.<br/>
						<br/>
						Vergeet onderaan niet op "Bewaar" te klikken!<br/>
					</p>
			  </div>
			</div>
 			-->
			<div id="membershipAndPersonForm" class="lookupperson form" v-show='! membershipIsSaved'>
				<?=$this->Form->create('Membership', array('class' => 'form-horizontal'))?>

				<?= $this->Form->input('id', array('type' => 'hidden')) ?>
				<?= $this->Form->input('person_id', array('type' => 'hidden')) ?>
				<?= $this->Form->input('active', array('type' => 'hidden', 'value' => true))?>

				<div id="nameData">
					<?=$this->element('membership-form-name')?>
				</div>

				<div id="personData" v-show='((foundPersons.length == 0) || (personIsChosen))'>
					<?=$this->element('membership-form-person')?>
				</div>

				<div class="form-group" v-show='((foundPersons.length == 0) || (personIsChosen))'>
					<div class="col-sm-offset-3 col-sm-6">
						<button class="btn btn-danger" type="button" v-on:click="saveMembership()" title="(Klik om het lid te bewaren)">
							Bewaar lid
						</button>
					</div>
				</div>

				<?=$this->Form->end()?>
			</div>
		</div>

	</div>

	<div class="row">

		<div class="col-xs-6">
			<div id="membershipAndPersonCard" class="panel panel-info" v-show='membershipIsSaved' style="display: none;">
				<div class="panel-heading">
					<h3 class="panel-title">
						Het bewaarde lid: {{ newMembership.Person.firstname }} {{ newMembership.Person.lastname }}
					</h3>
				</div>
			  <div class="panel-body">
					<p>
						<dl class="dl-horizontal">
							<dt>
								Naam
							</dt>
							<dd>
								{{ newMembership.Person.lastname }}
								{{ newMembership.Person.firstname }}
							</dd>
							<dt>
								Licentie
							</dt>
							<dd>
								{{ newMembership.Membership.licensenumber }}
							</dd>
							<dt>
								Geboortedatum
							</dt>
							<dd>
								{{ newMembership.Person.birthdate }}
							</dd>
							<dt>
								Email
							</dt>
							<dd>
								{{ newMembership.Person.email }}
							</dd>
							<dt>
								GSM
							</dt>
							<dd>
								{{ newMembership.Person.mobile }}
							</dd>
							<dt>
								Aka
							</dt>
							<dd>
								{{ newMembership.Person.nickname }}
							</dd>
						</dl>

					</p>
			  </div>
			</div>
		</div>
		<div class="col-xs-6">
			<div id="contactaddressCard" class="panel panel-info" v-show='membershipIsSaved' style="display: none;">
				<div class="panel-heading">
					<h3 class="panel-title">
						Adres:
					</h3>
				</div>
				<div class="panel-body">
					<p>
						<dl class="dl-horizontal">
							<dt>
								Adres
							</dt>
							<dd>
								{{ newMembership.Person.Contactaddress.street }}
								{{ newMembership.Person.Contactaddress.streetnumber }}
								<span v-if='(newMembership.Person.Contactaddress.streetnumbersuffix != '')'>
									/ {{ newMembership.Person.Contactaddress.streetnumbersuffix }}
								</span>
							</dd>
							<dt>
								Gemeente
							</dt>
							<dd>
								{{ newMembership.Person.Contactaddress.postcode }}
								{{ newMembership.Person.Contactaddress.city }}
							</dd>
							<dt>
								Landcode
							</dt>
							<dd>
								{{ newMembership.Person.Contactaddress.countrycode }}
							</dd>
							<dt>
								Vaste lijn
							</dt>
							<dd>
								{{ newMembership.Person.Contactaddress.landline }}
							</dd>
						</dl>
					</p>
			  </div>
				<div class="panel-footer" v-show='! contactaddressShowForm'>
					<h3 class="panel-title">
						<button id='changeContactaddressButton' class="btn btn-primary" type="button" v-on:click="showContactaddressForm()" title="(change contactaddress)">
							Wijzig adres
						</button>
					</h3>
				</div>
			</div>
		</div>

	</div>

	<div class="row" v-show='((foundPersons.length > 0) && (! personIsChosen))'>

		<div id="lookupPersonResult" class="col-xs-6">
			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">
					Gevonden personen:
					<span class="badge">{{ foundPersons.length }}</span>
				</div>
				<div class="panel-body" v-show='foundPersons.length'>
					<p>Klik een lid om meer info te krijgen.</p>
				</div>
				<!-- List group -->
				<div class="list-group" v-for="onePerson in foundPersons">
					<button class="list-group-item" type="button" v-on:click="fetchPerson(onePerson.Person.id)" title="info lid/person {{onePerson.Membership.id}}/{{onePerson.Person.id}}">
						{{ onePerson.Person.lastname }} {{ onePerson.Person.firstname }}
					</button>
				</div>
			</div>
		</div>

		<div id="personMoreInfo" class="col-xs-6">
			<div class="panel panel-default">

				<div class="panel-heading">
					<h3 class="panel-title">Meer info:</h3>
				</div>

				<!--
				<div class="panel-body">
					<img class='img-circle' src='/volley/clubman-cake290/img/{{ selectedPersonInfo.Picture.location}}' title='{{ selectedPersonInfo.Person.lastname }} {{ selectedPersonInfo.Person.firstname }}'>
				</div>
				-->

				<div class="panel-body">
					<dl class="dl-horizontal">
						<dt>
							Naam
						</dt>
						<dd>
							{{ selectedPersonInfo.Person.lastname }}
							{{ selectedPersonInfo.Person.firstname }}
						</dd>
						<dt>
							Geboortedatum
						</dt>
						<dd>
							{{ selectedPersonInfo.Person.birthdate }}
						</dd>
						<dt>
							Email
						</dt>
						<dd>
							{{ selectedPersonInfo.Person.email }}
						</dd>
						<dt>
							GSM
						</dt>
						<dd>
							{{ selectedPersonInfo.Person.mobile }}
						</dd>
						<dt>
							Aka
						</dt>
						<dd>
							{{ selectedPersonInfo.Person.nickname }}
						</dd>
						<dt>
							Adres
						</dt>
						<dd>
							{{ selectedPersonInfo.Contactaddress.address }}<br/>
							{{ selectedPersonInfo.Contactaddress.city }}
						</dd>
					</dl>
				</div>

				<ul class="list-group">
				  <li class="list-group-item list-group-item-danger" v-show='selectedPersonInfo.Membership.active'>
						<p class="list-group-item-text">
							Dit is een bestaand en actief lid.
						</p>
						<button class="btn btn-danger" type="button" v-on:click="knownPersonChosen('edit')" title="(Klik om deze te selecteren)" disabled="disabled">
							Ik wil deze dan editeren (voorlopig disabled)
						</button>
					</li>
					<li class="list-group-item list-group-item-warning" v-show='selectedPersonInfo.Membership.active == false'>
						<p class="list-group-item-text">
							Dit is een bestaand en niet-actief lid.
						</p>
						<button class="btn btn-default" type="button" v-on:click="knownPersonChosen('reactivate')" title="(Klik om deze te selecteren)">
							Her-activeer lid
						</button>
					</li>
					<li class="list-group-item list-group-item-warning" v-show='selectedPersonInfo.Membership.id == null'>
						<p class="list-group-item-text">
							Dit is een bestaand persoon die nog geen lid is.
						</p>
						<button class="btn btn-default" type="button" v-on:click="knownPersonChosen('persontomember')" title="(Klik om deze te selecteren)">
							Maak lid
						</button>
					</li>
				</ul>

			</div>
		</div>

	</div>

	<div class="row">

		<div class="col-xs-12">

			<div id="addressForm" class="lookupaddress form" v-show='membershipIsSaved && contactaddressShowForm && ! contactaddressIsSaved' style="display: none;">
				<?=$this->Form->create('MembershipContactaddress', array('class' => 'form-horizontal'))?>

				<?= $this->Form->input('membership_id', array('type' => 'hidden')) ?>
				<?= $this->Form->input('person_id', array('type' => 'hidden')) ?>

				<div id="addressData">
					<?=$this->element('membership-form-address')?>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<button class="btn btn-danger" type="button" v-on:click="saveMembershipContactaddress()" title="(Klik om het adres te bewaren)">
							Bewaar adres
						</button>
					</div>
				</div>

				<?=$this->Form->end()?>
			</div>

		</div>

	</div>


	<hr/>
	<?= $this->Html->link('Terug', array('action' => 'index'))."\n"; ?>

	<div id="jsonNewData" class="row">
		<hr/>
		<div class="col-xs-12">
			newData
			<pre>{{ newData | json }}</pre>
		</div>
		<!--
		<div id="lookupResult" class="col-xs-5">
			<pre>{{ selectedPersonInfo | json }}</pre>
		</div>
 		-->
	</div>

	<div id="jsonNewMembership" class="row">
		<hr/>
		<div class="col-xs-12">
			newMembership
			<pre>{{ newMembership | json }}</pre>
		</div>
	</div>

</div>


<script>
	var newMembershipapp = new Vue({
		el: '#membershipadd',
		data: {
			newTitle: 'A new Clubman membership',
			newLog: '',
			newMembership: {},
			foundPersons: [],
			selectedPersonInfo: {},
			personIsSelected: false,
			personIsChosen: false,
			memberIsNew: true,
			personIsNew: true,
			membershipIsSaved: false,
			contactaddressShowForm: false,
			contactaddressIsSaved: false,
			newData: {}
		},
		ready: function() {
	    //this.fetchMemberships();
		},
		methods: {
			dummy: function(event) {
				// `this` inside methods points to the Vue instance
				alert('Hello from dummy -- ' + this.newTitle + '!');
				console.log('Hello from dummy -- ' + this.newTitle + '!');
				// `event` is the native DOM event
				if (event) {
					alert(event.target.id);
				}
			},
			logIt: function(logLine) {
				var self = this;
				console.log(logLine);
				self.newLog += logLine + "\n";
			},
			lookupPerson: function() {
				var self = this;
				self.logIt('Looking up persons');
				var thisLastname = $('#PersonLastname').val().trim();
				var thisFirstname = $('#PersonFirstname').val().trim();
				var minChars = 2;
				self.logIt('Resetting selected person info');
				if (self.personIsSelected) {
					self.selectedPersonInfo = {};
					self.personIsSelected = false;
				}
				if ((thisLastname.length >= minChars) || (thisFirstname.length >= minChars)) {
					var thisLookup = { 'lastname': thisLastname, 'firstname': thisFirstname };
					$.ajax({
						type: 'GET',
						url: "<?=$this->Html->url(array('action' => 'ajlookupperson', 'ext' => 'json'))?>",
						data: thisLookup,
						dataType: 'json',
						success: function(data) {
							self.logIt('- done: ' + data.meta.cakedata.persons.length + ' persons fetched');
							self.foundPersons = data.meta.cakedata.persons;
							self.newData = data;
						},
						error: function(e) {
							alert("An error occurred: " + e.responseText.message);
							console.log(e);
						}
					});
				}
				else if ((thisLastname.length < minChars) && (thisFirstname.length < minChars)) {
					self.logIt('Too little characters - cleaning up results');
					self.foundPersons = [];
					self.selectedPersonInfo = {};
				}
				else {
					self.logIt('We need some more characters before looking up persons');
				}
			},
			fetchPerson: function(personId) {
				var self = this;
				self.logIt('Fetching given person #' + personId );
				$.ajax({
					type: 'GET',
					url: "<?=$this->Html->url(array('action' => 'ajfetchperson', 'ext' => 'json'))?>" + '?id=' + personId,
					dataType: 'json',
					success: function(response) {
						if (response.error !== undefined) {
							alert('Error: ' + response.error);
							console.log('Error: ' + response.error);
						}
						self.logIt('- success: person #' + personId + " fetched" );
						self.selectedPersonInfo = response.meta.cakedata.person;
						self.newData = response.meta.cakedata.person;
						//self.newData = response;
						self.personIsSelected = true;
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});
			},
			knownPersonChosen: function(personAction) {
				var self = this;
				self.logIt('Known person [' + self.selectedPersonInfo.Person.id + '] chosen [' + personAction + '] - no new person will be added');
				$('#PersonLastname').val(self.selectedPersonInfo.Person.lastname);
				$('#PersonFirstname').val(self.selectedPersonInfo.Person.firstname);
				//$('#MembershipActive').val(1);
				//$('#MembershipActive').prop('checked', true);
				self.personIsChosen = true;
				self.transferPersonInfoToForm();
				//self.transferMembershipInfoToForm();
			},
			transferPersonInfoToForm: function() {
				var self = this;
				self.logIt('Transfer info to form');
				self.logIt('- disable some fields (note: they need to be re-enabled to serialize)');
				$('#PersonLastname').prop('disabled', true);
				$('#PersonFirstname').prop('disabled', true);
				//$('#MembershipActive').prop('disabled', true);
				self.logIt('- add additional membership info into form');
				$('#MembershipId').val(self.selectedPersonInfo.Membership.id);
				$('#MembershipPersonId').val(self.selectedPersonInfo.Person.id);
				$('#MembershipLicensenumber').val(self.selectedPersonInfo.Membership.Licensenumber);
				self.logIt('- transfer person info into form');
				$('#PersonId').val(self.selectedPersonInfo.Person.id);
				$('#PersonBirthdate').val(self.selectedPersonInfo.Person.birthdate);
				$('#PersonNationalnumber').val(self.selectedPersonInfo.Person.nationalnumber);
				$('#PersonEmail').val(self.selectedPersonInfo.Person.email);
				$('#PersonMobile').val(self.selectedPersonInfo.Person.mobile);
				$('#PersonNickname').val(self.selectedPersonInfo.Person.nickname);
			},
			// submitTheForm: function() {
			// 	$('form#MembershipAddForm').submit();
			// },
			saveMembership: function() {
				var self = this;
				self.logIt('Save membership clicked');
				self.logIt('- re-enable disabled fields (for serialize to pick them up)');
				$('#PersonLastname').prop('disabled', false);
				$('#PersonFirstname').prop('disabled', false);
				//$('#MembershipActive').prop('disabled', false);
				self.logIt('- serializing the form fields');
				var thisMembership = $('#MembershipAddForm').serializeArray();
				//console.log(JSON.stringify(thisMembership));
				self.logIt('- saving the membership (ajax)');
				$.ajax({
					type: 'POST',
					url: "<?=$this->Html->url(array('action' => 'ajsavemembership', 'ext' => 'json'))?>",
					data: thisMembership,
					dataType: 'json',
					success: function(response) {
						self.logIt('- success: membership for ' + response.meta.cakedata.member.Person.firstname + ' ' + response.meta.cakedata.member.Person.lastname + ' [' + response.meta.cakedata.member.Membership.id + '] saved');
						self.newMembership = response.meta.cakedata.member;
						self.membershipIsSaved = true;
						if (self.newMembership.Person.contactaddress_id == null) {
							self.logIt('- no address yet for ' + response.meta.cakedata.member.Person.firstname + ' ' + response.meta.cakedata.member.Person.lastname);
							self.contactaddressShowForm = true
						} else {
							self.logIt('- address [' + self.newMembership.Person.contactaddress_id + '] found for ' + response.meta.cakedata.member.Person.firstname + ' ' + response.meta.cakedata.member.Person.lastname);
						}
						// $('#MembershipContactaddressMembershipId').val(self.newMembership.Membership.id);
						// $('#MembershipContactaddressPersonId').val(self.newMembership.Person.id);
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});
			},
			lookupStreet: function() {
				var self = this;
				self.logIt('Looking up streets');
				var thisStreet = $('#ContactaddressStreet').val().trim();
				var minChars = 3;
				self.logIt('Resetting selected street info');
				if (thisStreet.length >= minChars) {
					var thisLookup = { 'street': thisStreet };
					$.ajax({
						type: 'GET',
						url: "<?=$this->Html->url(array('action' => 'ajlookupstreet', 'ext' => 'json'))?>",
						data: thisLookup,
						dataType: 'json',
						success: function(data) {
							self.logIt('- done: ' + data.meta.cakedata.streets.length + ' streets fetched');
							var dropdown = $('#uniqueStreets').find('option').remove().end();
							$.each( data.meta.cakedata.uniqueStreets, function( key, value ) {
								dropdown.append($("<option />").val(key).text(value));
							});
							self.newData = data;
						},
						error: function(e) {
							alert("An error occurred: " + e.responseText.message);
							console.log(e);
						}
					});
				}
				else if (thisStreet.length < minChars) {
					self.logIt('Too little characters - cleaning up results');
					$('#uniqueStreets').find('option').remove().end();
				}
				else {
					self.logIt('We need some more characters before looking up streets');
				}
			},
			saveMembershipContactaddress: function() {
				var self = this;
				self.logIt('Save address clicked');
				self.logIt('- serializing the form fields');
				var thisMembershipContactaddress = $('#MembershipContactaddressAddForm').serializeArray();
				self.logIt('- saving the address (ajax)');
				$.ajax({
					type: 'POST',
					url: "<?=$this->Html->url(array('action' => 'ajsavemembershipcontactaddress', 'ext' => 'json'))?>",
					data: thisMembershipContactaddress,
					dataType: 'json',
					success: function(response) {
						self.newData = response;
						self.logIt('- success: address saved for person [' + response.meta.cakedata.member.Person.firstname + ' ' + response.meta.cakedata.member.Person.lastname + ']');
						self.newMembership = response.meta.cakedata.member;
						self.contactaddressIsSaved = true;
					},
					error: function(e) {
						alert("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});
			},
			showContactaddressForm: function() {
				var self = this;
				self.contactaddressShowForm = true
			},
		},
	});
</script>


<script>
	$(document).ready(function(){
		$('.birthdatepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1, yearRange: "-99:+0", changeMonth: true, changeYear: true } );
		$('.datepicker').datepicker( { dateFormat: "yy-mm-dd", firstDay: 1 } );
		/// Hide what needs to be hidden
		/// -- this does not remove the 'flashing' of the divs when document is loaded ...
		/// -- ... so we will do it with inline style
		// $("#personData").hide();
		// $("#addressData").hide();

		// /// Set initial state of the "camp" part
		// if ($("#MemberCamp").is(":checked")) {
		// 	$("#camp_info").show();
		// } else {
		// 	$("#camp_info").hide();
		// }
		// /// Switch "camp" part when clicking
		// $("#MemberCamp").click(function() {
		// 	if ($(this).is(":checked")) {
		// 		$("#camp_info").show(200);
		// 	} else {
		// 		$("#camp_info").hide(200);
		// 	}
		// });
	});
</script>
