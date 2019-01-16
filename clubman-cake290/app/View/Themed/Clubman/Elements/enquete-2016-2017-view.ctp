<!-- app/View/Elements/enquete-2016-2017-view.ctp -->

<div class='row'>
  <div class="col-sm-12 col-md-10 col-lg-8">

		<div class="table-responsive">
			<table class='table table-striped table-condensed normalelijst'>

				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>0. algemeen</font></td></tr>
				<tr><td><strong>Seizoen</strong></td><td><?=$enquete['Enquete']['algemeen_seizoen']?></td></tr>
				<tr><td><strong>Naam</strong></td><td><?=$enquete['Enquete']['algemeen_naam']?></td></tr>
				<tr><td><strong>Code</strong></td><td><?=$enquete['Enquete']['id']?></td></tr>


				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>1. nu en volgend seizoen</font></td></tr>
				<tr><td><strong>Huidig team</strong></td><td><?=$enquete['Enquete']['algemeen_ploeg']?></td></tr>
        <tr><td><strong>Blij met huidig team</strong></td><td><?=$enquete['Enquete']['algemeen_ploeg_tevreden']?></td></tr>
				<tr><td><strong>Huidig dubbelteam</strong></td><td><?=$enquete['Enquete']['algemeen_dubbelploeg']?></td></tr>
				<!--<tr><td><strong>Volgend seizoen</strong></td><td><strong><?=$enquete['Enquete']['algemeen_volgendseizoen']?></strong></td></tr>-->
				<tr><td><strong>Team volgend seizoen</strong></td><td><strong><?=$enquete['Enquete']['algemeen_volgendseizoenploeg']?></strong></td></tr>
				<tr><td><strong>Dubbelteam volgend seizoen</strong></td><td><strong><?=$enquete['Enquete']['algemeen_volgendseizoendubbelploeg']?></strong></td></tr>


				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>2. trainingen</font></td></tr>
				<tr><td><strong>Aantal trainingen</strong></td><td><?=$enquete['Enquete']['training_aantal']?></td></tr>
				<tr><td><strong>Ma#1</strong></td><td><?=$enquete['Enquete']['training_ma19002100']?></td></tr>
				<tr><td><strong>Di#1</strong></td><td><?=$enquete['Enquete']['training_di20002200']?></td></tr>
				<tr><td><strong>Wo#1</strong></td><td><?=$enquete['Enquete']['training_wo17001830']?></td></tr>
				<tr><td><strong>Wo#2</strong></td><td><?=$enquete['Enquete']['training_wo18302000']?></td></tr>
				<tr><td><strong>Do#1</strong></td><td><?=$enquete['Enquete']['training_do20002200']?></td></tr>
				<tr><td><strong>Vr#1</strong></td><td><?=$enquete['Enquete']['training_vr17301900']?></td></tr>
				<tr><td><strong>Vr#2</strong></td><td><?=$enquete['Enquete']['training_vr19002100']?></td></tr>
				<!--<tr><td><strong>Za#1</strong></td><td><?=$enquete['Enquete']['training_za09001000']?></td></tr>-->
				<tr><td><strong>Elders</strong></td><td><?=$enquete['Enquete']['locatie_elders']?></td></tr>


				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>3. wedstrijden</font></td></tr>
				<tr><td><strong>Aantal wedstrijden</strong></td><td><?=$enquete['Enquete']['wedstrijd_aantal']?></td></tr>


				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>4. engagement</font></td></tr>
				<tr><td><strong>Steun ouders</strong></td><td><?=$enquete['Enquete']['engagement_steun_ouders']?></td></tr>
				<tr><td><strong>Andere activiteiten</strong></td><td><?=$enquete['Enquete']['engagement_andere_activiteiten']?></td></tr>
				<tr><td><strong>Prioriteit volleybal</strong></td><td><?=$enquete['Enquete']['engagement_prio_volleybal']?></td></tr>


				<!--
					<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>4. studenten</font></td></tr>
					<tr><td><strong>Minder trainen</strong></td><td><?=$enquete['Enquete']['studies_mindertrainen']?></td></tr>
					<tr><td><strong>Op kot</strong></td><td><?=$enquete['Enquete']['studies_opkot']?></td></tr>
					<tr><td><strong>Geen wedstrijden</strong></td><td><?=$enquete['Enquete']['studies_geenwedstrijden']?></td></tr>
					<tr><td><strong>Stage</strong></td><td><?=$enquete['Enquete']['studies_stage']?></td></tr>
					<tr><td><strong>Andere</strong></td><td><?=$enquete['Enquete']['studies_andere']?></td></tr>
				-->
				<!--
					<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>5. Allerjongsten</font></td></tr>
					<tr><td><strong>Training Bengels</strong></td><td><?=$enquete['Enquete']['allerjongsten_training']?></td></tr>
				-->


				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>5. communicatie</font></td></tr>
				<tr><td><strong>Mail</strong></td><td><?=$enquete['Enquete']['mail_ik']?></td></tr>
				<tr><td><strong>Ik check mail</strong></td><td><?=$enquete['Enquete']['mail_ikfrequentie']?></td></tr>
				<tr><td><strong>Mail mama</strong></td><td><?=$enquete['Enquete']['mail_mama']?></td></tr>
				<tr><td><strong>Mama checkt mail</strong></td><td><?=$enquete['Enquete']['mail_mamafrequentie']?></td></tr>
				<tr><td><strong>Mail papa</strong></td><td><?=$enquete['Enquete']['mail_papa']?></td></tr>
				<tr><td><strong>Papa checkt mail</strong></td><td><?=$enquete['Enquete']['mail_papafrequentie']?></td></tr>


				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>6. begeleiding</font></td></tr>
				<tr><td><strong>Mama PV</strong></td><td><?=$enquete['Enquete']['begeleiding_pvmama']?></td></tr>
				<tr><td><strong>Papa PV</strong></td><td><?=$enquete['Enquete']['begeleiding_pvpapa']?></td></tr>
			 	<tr><td><strong>Andere PV</strong></td><td><?=$enquete['Enquete']['begeleiding_pvandere']?></td></tr>


				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>7. organsatie</font></td></tr>
			 	<tr><td><strong>Naam</strong></td><td><?=$enquete['Enquete']['organisatie_naam']?></td></tr>
				<tr><td><strong>Taak</strong></td><td><?=$enquete['Enquete']['organisatie_taak']?></td></tr>


				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>8. volleyleuk</font></td></tr>
				<!--<tr><td><strong>Toekomst</strong></td><td><?=$enquete['Enquete']['volley_toekomst']?></td></tr>-->
				<tr><td><strong>Volley / VCW is leuk</strong></td><td><?=$enquete['Enquete']['volley_leuk']?></td></tr>


				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>9. diversen</font></td></tr>
        <tr><td><strong>Lidgeld hoog</strong></td><td><?=$enquete['Enquete']['diversen_lidgeld_hoog']?></td></tr>
				<tr><td><strong>Vrije tekst</strong></td><td><?=$enquete['Enquete']['diversen_tekst']?></td></tr>

			</table>
		</div>
	</div>
</div>
