<!-- app/View/Members/birthdays.ctp -->
<h2><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> verjaardagen in de kalender</h2>

<div class="box">
	<div id="birthdayapp">

		<section v-show="members.allmembers.active.length">

			<div class="row">
			  <div class="col-md-2"></div>
			  <div class="col-md-8">
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
							<tr class="" v-for="onemember in members.allmembers.active | filterBy nameFilter in 'Member.name'">
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
			  <div class="col-md-2"></div>
			</div>

		</section>


		<section v-show="members.allmembers.inactive.length">

			<div class="row">
			  <div class="col-md-2"></div>
			  <div class="col-md-8">
					<div class="panel panel-default">
					  <!-- Default panel contents -->
					  <div class="panel-heading">Inactieve Leden</div>
					  <div class="panel-body">
							<form id="searchinactive">
						    Filter op naam <input name="query" v-model="nameFilter">
						  </form>
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
							<tr class="" v-for="onemember in members.allmembers.inactive | filterBy nameFilter in 'Member.name'">
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
			  <div class="col-md-2"></div>
			</div>

		</section>


<!--		<pre>{{{ $data | json }}</pre> -->

	</div> <!-- birthdayapp -->
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

  var birthdayviewmodel = new Vue({
    el: '#birthdayapp',

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

<br/>
<hr/>

<?php
// if (isset($allmembers['active'])) pr($allmembers['active']);
// if (isset($allmembers['inactive'])) pr($allmembers['inactive']);
?>
