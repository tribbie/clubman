<!-- app/View/Elements/enquete-2020-2021-view.ctp -->

<div class='row'>
  <div class="col-sm-12 col-md-10 col-lg-8">

		<div class="table-responsive">
			<table class='table table-striped table-condensed normalelijst'>

				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>0. algemeen</font></td></tr>
				<tr><td><strong>Seizoen</strong></td><td><?=$enquete['Enquete']['algemeen_seizoen']?></td></tr>
				<tr><td><strong>Naam</strong></td><td><?=$enquete['Enquete']['algemeen_naam']?></td></tr>
				<tr><td><strong>Code</strong></td><td><?=$enquete['Enquete']['id']?></td></tr>

				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>1. huidig seizoen</font></td></tr>
				<tr><td><strong>Huidig team</strong></td><td><?=$enquete['Enquete']['algemeen_ploeg']?></td></tr>
        <tr><td><strong>Blij met huidig team</strong></td><td><?=$enquete['Enquete']['algemeen_ploeg_tevreden']?></td></tr>
        <tr><td><strong>Score huidige ploegsfeer</strong></td><td><?=$enquete['Enquete']['algemeen_score_huidige_ploegsfeer']?></td></tr>
        <tr><td><strong>Score huidige trainer</strong></td><td><?=$enquete['Enquete']['algemeen_score_huidige_trainer']?></td></tr>
        <tr><td><strong>Naam huidige trainer</strong></td><td><?=$enquete['Enquete']['algemeen_score_huidige_trainer_naam']?></td></tr>
        <tr><td><strong>Score huidige trainer #2</strong></td><td><?=$enquete['Enquete']['algemeen_score_huidige_trainer_2']?></td></tr>
        <tr><td><strong>Naam huidige trainer #2</strong></td><td><?=$enquete['Enquete']['algemeen_score_huidige_trainer_2_naam']?></td></tr>
				<tr><td><strong>Huidig dubbelteam</strong></td><td><?=$enquete['Enquete']['algemeen_dubbelploeg']?></td></tr>
        <tr><td><strong>Volgend seizoen</strong></td><td><strong><?=$enquete['Enquete']['algemeen_volgendseizoen']?></strong></td></tr>

        <tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>2. volgend seizoen</font></td></tr>
				<tr><td><strong>Team volgend seizoen</strong></td><td><strong><?=$enquete['Enquete']['algemeen_volgendseizoenploeg']?></strong></td></tr>
        <tr><td><strong>Dubbelteam volgend seizoen</strong></td><td><?=$enquete['Enquete']['algemeen_volgendseizoendubbelploeg']?></td></tr>
        <tr><td><strong>Favoriete positie</strong></td><td><strong><?=$enquete['Enquete']['algemeen_positie_keuze_1']?></strong></td></tr>
        <tr><td><strong>Tweede favoriete positie</strong></td><td><?=$enquete['Enquete']['algemeen_positie_keuze_2']?></td></tr>

				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>3. trainingen</font></td></tr>
				<tr><td><strong>Ma#1</strong></td><td><?=$enquete['Enquete']['training_ma19002100']?></td></tr>
				<tr><td><strong>Di#1</strong></td><td><?=$enquete['Enquete']['training_di18302000']?></td></tr>
        <tr><td><strong>Di#2</strong></td><td><?=$enquete['Enquete']['training_di20002200']?></td></tr>
        <tr><td><strong>Wo#1</strong></td><td><?=$enquete['Enquete']['training_wo16001700']?></td></tr>
				<tr><td><strong>Wo#2</strong></td><td><?=$enquete['Enquete']['training_wo17001830']?></td></tr>
				<tr><td><strong>Wo#3</strong></td><td><?=$enquete['Enquete']['training_wo18302000']?></td></tr>
				<tr><td><strong>Do#1</strong></td><td><?=$enquete['Enquete']['training_do20002200']?></td></tr>
        <tr><td><strong>Vr#1</strong></td><td><?=$enquete['Enquete']['training_vr17301900']?></td></tr>
				<tr><td><strong>Vr#2</strong></td><td><?=$enquete['Enquete']['training_vr19002100']?></td></tr>

				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>4. engagement</font></td></tr>
				<tr><td><strong>Beperkt engagement</strong></td><td><?=$enquete['Enquete']['engagement_andere_activiteiten']?></td></tr>

				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>5. communicatie</font></td></tr>
				<tr><td><strong>Mail</strong></td><td><?=$enquete['Enquete']['mail_ik']?></td></tr>
				<tr><td><strong>Ik check mail</strong></td><td><?=$enquete['Enquete']['mail_ikfrequentie']?></td></tr>
				<tr><td><strong>Mail mama</strong></td><td><?=$enquete['Enquete']['mail_mama']?></td></tr>
				<tr><td><strong>Mama checkt mail</strong></td><td><?=$enquete['Enquete']['mail_mamafrequentie']?></td></tr>
				<tr><td><strong>Mail papa</strong></td><td><?=$enquete['Enquete']['mail_papa']?></td></tr>
				<tr><td><strong>Papa checkt mail</strong></td><td><?=$enquete['Enquete']['mail_papafrequentie']?></td></tr>

				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>6. organsatie</font></td></tr>
			 	<tr><td><strong>Naam</strong></td><td><?=$enquete['Enquete']['organisatie_naam']?></td></tr>
				<tr><td><strong>Taak</strong></td><td><?=$enquete['Enquete']['organisatie_taak']?></td></tr>

				<tr class="groupheader info"><td colspan='2'><font size='+1' color='#0000f0'>7. diversen</font></td></tr>
				<tr><td><strong>Vrije tekst</strong></td><td><?=$enquete['Enquete']['diversen_tekst']?></td></tr>

			</table>
		</div>
	</div>
</div>
