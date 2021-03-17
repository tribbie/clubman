<!-- app/View/Elements/enquete-2020-2021-view.ctp -->

<div class='row'>
  <div class="col-sm-12 col-md-10 col-lg-8">

    <div class="panel panel-info">
      <div class="panel-heading">
        <h2 class="panel-title">0. inleiding</h2>
      </div>
      <div class="panel-body">
        <dl class="dl-horizontal"><dt>Seizoen</dt><dd><?=$enquete['Enquete']['algemeen_seizoen']?></dd></dl>
        <dl class="dl-horizontal"><dt>Naam</dt><dd><?=$enquete['Enquete']['algemeen_naam']?></dd></dl>
        <dl class="dl-horizontal"><dt>Code</dt><dd><?=$enquete['Enquete']['id']?></dd></dl>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h2 class="panel-title">1. huidig seizoen</h2>
      </div>
      <div class="panel-body">
        <dl class="dl-horizontal"><dt>Huidig team</dt><dd><?=$enquete['Enquete']['algemeen_ploeg']?></dd></dl>
        <dl class="dl-horizontal"><dt>Blij met huidig team</dt><dd><?=$enquete['Enquete']['algemeen_ploeg_tevreden']?></dd></dl>
        <dl class="dl-horizontal"><dt>Score ploegsfeer</dt><dd><?=$enquete['Enquete']['algemeen_score_huidige_ploegsfeer']?></dd></dl>
        <dl class="dl-horizontal"><dt>Score trainer</dt><dd><?=$enquete['Enquete']['algemeen_score_huidige_trainer']?></dd></dl>
        <dl class="dl-horizontal"><dt>Naam trainer</dt><dd><?=$enquete['Enquete']['algemeen_score_huidige_trainer_naam']?></dd></dl>
        <dl class="dl-horizontal"><dt>Score trainer #2</dt><dd><?=$enquete['Enquete']['algemeen_score_huidige_trainer_2']?></dd></dl>
        <dl class="dl-horizontal"><dt>Naam trainer #2</dt><dd><?=$enquete['Enquete']['algemeen_score_huidige_trainer_2_naam']?></dd></dl>
        <dl class="dl-horizontal"><dt>Volgend seizoen</dt><dd><?=$enquete['Enquete']['algemeen_volgendseizoen']?></dd></dl>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h2 class="panel-title">2. volgend seizoen</h2>
      </div>
      <div class="panel-body">
        <dl class="dl-horizontal"><dt>Team volgend seizoen</dt><dd><?=$enquete['Enquete']['algemeen_volgendseizoenploeg']?></dd></dl>
        <dl class="dl-horizontal"><dt>Favoriete positie</dt><dd><?=$enquete['Enquete']['algemeen_positie_keuze_1']?></dd></dl>
        <dl class="dl-horizontal"><dt>Tweede favoriete positie</dt><dd><?=$enquete['Enquete']['algemeen_positie_keuze_2']?></dd></dl>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h2 class="panel-title">3. trainingen</h2>
      </div>
      <div class="panel-body">
        <dl class="dl-horizontal"><dt>Ma-19002100</dt><dd><?=$enquete['Enquete']['training_ma19002100']?></dd></dl>
        <dl class="dl-horizontal"><dt>Di-18302000</dt><dd><?=$enquete['Enquete']['training_di18302000']?></dd></dl>
        <dl class="dl-horizontal"><dt>Di-20002200</dt><dd><?=$enquete['Enquete']['training_di20002200']?></dd></dl>
        <dl class="dl-horizontal"><dt>Wo-16001700</dt><dd><?=$enquete['Enquete']['training_wo16001700']?></dd></dl>
        <dl class="dl-horizontal"><dt>Wo-17001830</dt><dd><?=$enquete['Enquete']['training_wo17001830']?></dd></dl>
        <dl class="dl-horizontal"><dt>Wo-18302000</dt><dd><?=$enquete['Enquete']['training_wo18302000']?></dd></dl>
        <dl class="dl-horizontal"><dt>Do-20002200</dt><dd><?=$enquete['Enquete']['training_do20002200']?></dd></dl>
        <dl class="dl-horizontal"><dt>Vr-17301900</dt><dd><?=$enquete['Enquete']['training_vr17301900']?></dd></dl>
        <dl class="dl-horizontal"><dt>Vr-19002100</dt><dd><?=$enquete['Enquete']['training_vr19002100']?></dd></dl>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h2 class="panel-title">4. engagement</h2>
      </div>
      <div class="panel-body">
        <dl class="dl-horizontal"><dt>Beperkt engagement</dt><dd><?=$enquete['Enquete']['engagement_andere_activiteiten']?></dd></dl>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h2 class="panel-title">5. communicatie</h2>
      </div>
      <div class="panel-body">
        <dl class="dl-horizontal"><dt>Mail</dt><dd><?=$enquete['Enquete']['mail_ik']?></dd></dl>
        <dl class="dl-horizontal"><dt>Ik check mail</dt><dd><?=$enquete['Enquete']['mail_ikfrequentie']?></dd></dl>
        <dl class="dl-horizontal"><dt>Mail mama</dt><dd><?=$enquete['Enquete']['mail_mama']?></dd></dl>
        <dl class="dl-horizontal"><dt>Mama checkt mail</dt><dd><?=$enquete['Enquete']['mail_mamafrequentie']?></dd></dl>
        <dl class="dl-horizontal"><dt>Mail papa</dt><dd><?=$enquete['Enquete']['mail_papa']?></dd></dl>
        <dl class="dl-horizontal"><dt>Papa checkt mail</dt><dd><?=$enquete['Enquete']['mail_papafrequentie']?></dd></dl>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h2 class="panel-title">6. organsatie</h2>
      </div>
      <div class="panel-body">
        <dl class="dl-horizontal"><dt>Naam</dt><dd><?=$enquete['Enquete']['organisatie_naam']?></dd></dl>
        <dl class="dl-horizontal"><dt>Taak</dt><dd><?=$enquete['Enquete']['organisatie_taak']?></dd></dl>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h2 class="panel-title">7. diversen</h2>
      </div>
      <div class="panel-body">
        <dl class="dl-horizontal"><dt>Vrije tekst</dt><dd><?=$enquete['Enquete']['diversen_tekst']?></dd></dl>
      </div>
    </div>

	</div>
</div>
