<!-- app/View/Elements/enquete-2020-2021-form.ctp -->
<h1>Formulier voor <?=$this->request->data['Enquete']['algemeen_naam'];?></h1>

<!-- open the form -->
<?= $this->Form->create('Enquete'); ?>

<!-- hidden stuff -->
<div class="hidden">
  <?= $this->Form->input('id', array('type' => 'hidden')); ?>
  <?= $this->Form->input('member_id', array('type' => 'hidden')); ?>
  <?= $this->Form->input('teammember_id', array('type' => 'hidden')); ?>
  <?= $this->Form->input('team_id', array('type' => 'hidden')); ?>
  <?= $this->Form->input('algemeen_seizoen', array('type' => 'hidden')); ?>
  <?= $this->Form->input('algemeen_naam', array('type' => 'hidden')); ?>
  <br/>
</div>

<!-- section 0 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">0. Inleiding</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      Hoi,<br/>
      <br/>
      In het kader van onze voorbereiding van het volgende seizoen vind je hieronder een beknopte vragenlijst.<br/>
      We vragen enkele minuutjes van je tijd om deze, eventueel samen met je ouders, zorgvuldig en eerlijk in te vullen.<br/>
      Wij hebben geprobeerd om de vragenlijst dit keer tot de essentie te beperken en de dingen te bevragen waar we iets aan kunnen doen.<br/>
      Indien jullie andere zaken willen bespreken, kunnen jullie steeds een mailtje sturen of iets vermelden onderaan op de vragenlijst (in het vrij in te vullen tekstvak).<br/>
      In de mate van het mogelijke zullen we met de geleverde antwoorden en suggesties proberen rekening te houden naar volgend seizoen toe.<br/>
      Ook zullen niet alle vragen even relevant zijn voor iedereen.<br/>
      <br/>
      Graag hadden we de ingevulde vragenlijst terug ten laatste op <strong>woensdag 31 maart 2021</strong>.<br/>
      <br/>
      Alvast hartelijk bedankt voor je medewerking!<br/>
      <br/>
      Deze antwoorden worden enkel door Mario, Laure, Jonas en Jens gelezen met als doel het volgende seizoen voor te bereiden en eventuele problemen op te lossen.<br/>
      Alle antwoorden worden als strikt vertrouwelijk beschouwd.<br/>
      Indien je niet wenst dat één van deze personen je antwoorden leest, gelieve dit dan via een <a href="mailto:enquetes@vcwolvertem.be?subject=VCW enquête - reactie <?=$this->request->data['Enquete']['algemeen_naam'];?>">mailtje naar enquetes@vcwolvertem.be</a> door te geven.<br/>
      <br/>
      Het bestuur.<br/>

    </div> <!-- sectie -->
  </div>
</div>

<!-- section 1 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">1. Huidig seizoen</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      Eerst en vooral even terugblikken.<br/>
      <br/>

      <?= $this->Form->input('algemeen_ploeg', array('label' => 'Je ploeg nu', 'class' => 'form-control')); ?>
      <?= $this->Form->input('algemeen_ploeg_tevreden', array('label' => 'Ben je blij bij je huidige team', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'ja' => 'ja', 'eerder wel' => 'eerder wel', 'eerder niet' => 'eerder niet', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('algemeen_score_huidige_ploegsfeer', array('label' => 'Tevredenheid over de ploegsfeer', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'))); ?>
      <?= $this->Form->input('algemeen_score_huidige_trainer', array('label' => 'Tevredenheid over de huidge (hoofd)trainer', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'))); ?>
      <?= $this->Form->input('algemeen_score_huidige_trainer_naam', array('label' => 'Naam van de (hoofd)trainer', 'class' => 'form-control')); ?>
      <?= $this->Form->input('algemeen_score_huidige_trainer_2', array('label' => 'Tevredenheid over de huidge 2de trainer (als je die hebt)', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'))); ?>
      <?= $this->Form->input('algemeen_score_huidige_trainer_2_naam', array('label' => 'Naam van de 2de trainer', 'class' => 'form-control')); ?>

      <h3>Volgend seizoen ...</h3>
      <?= $this->Form->input('algemeen_volgendseizoen', array('label' => 'Het belangrijkste ...', 'class' => 'form-control', 'type' => 'select', 'options' => array('BLIJF' => 'ik blijf bij VCW', 'STOP' => 'ik stop met volleybal', 'ELDERS' => 'ik stop bij VCW'))); ?>
      <br/>

      <div class='panel panel-warning'>
        <div class="panel-heading">Opgelet!</div>
        <div class="panel-body">
          Indien je blijft, gelieve dan onderstaande secties ook nog in te vullen.<br/>
          <br/>
          In het andere geval ben je klaar.<br/>
          <span class='valop text-danger'>Je mag dan gerust in de laatste sectie invullen wat je nog kwijt wil.</span>.<br/>
          <span class='valop text-danger'><strong>Vergeet ook niet om je enquête te bewaren (helemaal onderaan)!</strong></span><br/>
        </div>
      </div>

    </div> <!-- sectie -->
  </div>
</div>

<!-- section 2 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">2. Volgend seizoen</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      <h3>Hoera! Je blijft!</h3>
      Dan zouden we nog een aantal dingen willen vragen.<br/>
      <br/>

      <?= $this->Form->input('algemeen_volgendseizoenploeg', array('label' => 'Je eerst keuze qua ploeg ...', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'U11' => 'U11', 'U13' => 'U13', 'U15' => 'U15', 'U17' => 'U17', 'U19' => 'U19', 'seniors' => 'Dames / Heren'))); ?>
      <br/>
      Vermits we bij VCW pas vanaf U17 met vaste posities spelen, zijn de volgende 2 vragen eigenlijk enkel in te vullen als je U17, U19 of Seniors (dames/heren) hebt gekozen.<br/>
      <br/>
      <?= $this->Form->input('algemeen_positie_keuze_1', array('label' => 'Mijn voorkeurpositie', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'libero' => 'libero', 'middenblok' => 'middenblok', 'setter' => 'setter', 'opposite' => 'opposite', 'receptie-hoek' => 'receptie-hoek'))); ?>
      <?= $this->Form->input('algemeen_positie_keuze_2', array('label' => 'Mijn tweede voorkeurpositie', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'libero' => 'libero', 'middenblok' => 'middenblok', 'setter' => 'setter', 'opposite' => 'opposite', 'receptie-hoek' => 'receptie-hoek'))); ?>
      <br/>

    </div> <!-- sectie -->
  </div>
</div>

<!-- section 3 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">3. Trainingen</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      We gaan ervan uit dat iedereen een engagement aangaat van 2 maal trainen per week.<br/>
      Indien er spelers of speelsters in aanmerking komen tot dubbelen of extra trainingen, dan nemen wij persoonlijk contact op om dit te bespreken.<br/>

      <h3>Tijdstippen trainingen</h3>
      Hieronder vind je de momenten waarop onze club de zaal ter beschikking heeft. Gelieve <strong>zeker</strong> aan te geven welke momenten <strong>absoluut niet</strong> kunnen om te trainen.<br/>
      <br/>
      <?= $this->Form->input('training_ma19002100', array('label' => 'maandag 19:00-21:00 (Meise)', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'nee' => 'absoluut niet'))); ?>
      <?= $this->Form->input('training_di18302000', array('label' => 'dinsdag 18:30-20:00 (Meise)', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'nee' => 'absoluut niet'))); ?>
      <?= $this->Form->input('training_di20002200', array('label' => 'dinsdag 20:00-22:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'nee' => 'absoluut niet'))); ?>
      <?= $this->Form->input('training_wo16001700', array('label' => 'woensdag 16:00-17:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'nee' => 'absoluut niet'))); ?>
      <?= $this->Form->input('training_wo17001830', array('label' => 'woensdag 17:00-18:30', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'nee' => 'absoluut niet'))); ?>
      <?= $this->Form->input('training_wo18302000', array('label' => 'woensdag 18:30-20:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'nee' => 'absoluut niet'))); ?>
      <?= $this->Form->input('training_do20002200', array('label' => 'donderdag 20:00-22:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'nee' => 'absoluut niet'))); ?>
      <?= $this->Form->input('training_vr17301900', array('label' => 'vrijdag 17:30-19:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'nee' => 'absoluut niet'))); ?>
      <?= $this->Form->input('training_vr19002100', array('label' => 'vrijdag 19:00-21:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'nee' => 'absoluut niet'))); ?>

    </div> <!-- sectie -->
  </div>
</div>

<!-- section 4 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">4. Engagement</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      We rekenen erop dat al onze jeugdspelers een engagement zullen aangaan van 2 trainingen en 1 competitiewedstrijd.<br/>
      Spelers die in aanmerking komen voor een uitgebreider programma (bv. dubbelen) worden persoonlijk gecontacteerd.<br/>
      Indien je denkt dit engagement niet te kunnen geven (andere hobby's, ...), laat je het hieronder weten:<br/>
      <br/>
      <?= $this->Form->input('engagement_andere_activiteiten', array('label' => 'Beperkt engagement wegens', 'class' => 'form-control')); ?>

    </div> <!-- sectie -->
  </div>
</div>

<!-- section 5 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">5. Communicatie</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      <?= $this->Form->input('mail_ik', array('label' => 'mijn e-mail adres', 'class' => 'form-control')); ?>
      <?= $this->Form->input('mail_ikfrequentie', array('label' => 'Ik check mijn mails', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'dagelijks' => 'dagelijks', 'wekelijks' => 'wekelijks'))); ?>
      <?= $this->Form->input('mail_mama', array('label' => 'e-mail adres van mama', 'class' => 'form-control')); ?>
      <?= $this->Form->input('mail_mamafrequentie', array('label' => 'Zij checkt haar mails', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'dagelijks' => 'dagelijks', 'wekelijks' => 'wekelijks'))); ?>
      <?= $this->Form->input('mail_papa', array('label' => 'e-mail adres van papa', 'class' => 'form-control')); ?>
      <?= $this->Form->input('mail_papafrequentie', array('label' => 'Hij checkt zijn mails', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'dagelijks' => 'dagelijks', 'wekelijks' => 'wekelijks'))); ?>

    </div> <!-- sectie -->
  </div>
</div>

<!-- section 6 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">6. Organsatie</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      In deze enquête richten wij ons ook tot mensen die graag een stapje verder willen gaan en een helpende hand willen zijn binnen de algemene organisatie van VCW.
      Vele handen maken namelijk licht werk.<br/>
      Heb je 1 van volgende talenten en wil je die inzetten bij VCW of ken je iemand die ervoor geknipt zou zijn en ons team wil aanvullen?<br/>
      <?php
        $organisatie_functies = [
          'redactie' => [
            'name' => 'Redacteurs & redactrices',
            'description' => 'Facebook posts en Instagramstories maken. Wil je meewerken om af en toe een verslag/verhaal te maken om te publiceren? Voel je je aangesproken? Niet twijfelen dan.'
          ],
          'trainer' => [
            'name' => 'Train(st)er',
            'description' => 'Gezien het groeiend aantal jonge, enthousiaste volleyballertjes binnen onze club, zijn nieuwe train(st)ers steeds welkom! Ons huidig trainerscorps zal hun zeker wegwijs maken in het reilen en zeilen van VCW.'
          ],
          'assistent-trainer' => [
            'name' => 'Assistent-train(st)er',
            'description' => 'Het is vanzelfsprekend dat onze trainers, met groepen van 10 tot 30 kinderen, assistent-trainers met plezier zien komen. Voel je je geroepen om onze kinderen mee te begeleiden, aarzel dan niet ons dit te melden!'
          ],
          'jeugdscheidsrechter' => [
            'name' => 'Jeugdscheidsrechter',
            'description' => 'Indien je bereid bent om af en toe een thuiswedstrijd te leiden, kunnen wij dit enkel toejuichen, dus laat het ons vooral weten. Je kan zeker rekenen op een voorafgaande uitleg/opleiding indien nodig.'
          ],
          'officielescheidsrechter' => [
            'name' => 'Officiële scheidsrechter',
            'description' => 'Wil jij of één van je ouders, je zus of broer graag een "echte" scheidsrechter worden, volledig in tenue? Ook dat kunnen wij enkel toejuichen, dus laat het ons vooral weten. Wederom kan je rekenen op een voorafgaande uitleg/opleiding indien nodig.'
          ],
          'markeerder' => [
            'name' => 'Markeerder',
            'description' => 'Wil je graag bij seniorenwedstrijden "het blad" doen? Je krijgt je eigen tafel! Dat zouden wij zeer graag hebben. Wederom kan je rekenen op een voorafgaande uitleg/opleiding indien nodig.'
          ],
          'viscoordinator' => [
            'name' => 'VIS-coördinator',
            'description' => 'Er is iemand nodig die vol enthousiasme zorgt voor onze gouden medailles op de VIS-demotornooien. Hij/zij is de motor achter het hele gebeuren en zorgt voor de uitnodigingen, het motiveren van spelers en trainers om te komen, de tijdige officiële inschrijving en op de dag zelf voor het superviseren dat alles vlot verloopt met onze VCW-ertjes. Het spreekt vanzelf dat uitgebreide hulp in het begin beschikbaar zal zijn!'
          ],
          'jeugdcoordinator' => [
            'name' => 'Jeugdcoördinator',
            'description' => 'Wil je de spil worden van het jeugdgebeuren aarzel dan niet ons te contacteren. Wij geven graag een woordje extra uitleg.'
          ],
          'jeugdsecretaris' => [
            'name' => 'Jeugdsecretaris',
            'description' => 'Je helpt de cel jeugd met het administratieve reilen en zeilen van alles wat onze toekomstige talentjes aan belangt.'
          ],
          'sponsorverantwoordelijke' => [
            'name' => 'Sponsorverantwoordelijke',
            'description' => 'Tja zonder deze toponderhandelaar zouden wij van het volleybal bij VCW een minder democratiche sport moeten maken. Ben jij iemand die graag eens binnenspringt bij de lokale handel, dan is dit echt iets voor jou.'
          ],
          'feestcomite' => [
            'name' => 'Feestcomité',
            'description' => 'Extra activiteiten zijn onontbeerlijk in een club. Zonder fuiven en eetfestijnen en dergelijke zou het lidgeld gevoelig hoger liggen. Wil je graag het feestcomité vervoegen? Laat het dan weten.'
          ],
          'voorzitter' => [
            'name' => 'Voorzitter',
            'description' => 'Den baas zoals ze zeggen. Je bent de persoon die helpt onze club op organisatorisch en financieel vlak op het goede spoor te houden. Over het sportieve hoef je je geen zorgen te maken.'
          ]
        ];
        $organisatie_vacatures = [
          'redactie',
          'trainer',
          'assistent-trainer',
          'officielescheidsrechter'
        ];
      ?>
      <ul>
        <?php
          $vacature_options = array('' => '');
          foreach ($organisatie_vacatures as $vacaturekey) {
            echo '	<li><strong>'.$organisatie_functies[$vacaturekey]['name'].':</strong><br/>'.$organisatie_functies[$vacaturekey]['description'].'</li>';
            $vacature_options[$vacaturekey] = $organisatie_functies[$vacaturekey]['name'];
          }
        ?>
      </ul>
      <br/>
      <?= $this->Form->input('organisatie_naam', array('label' => 'Volgende persoon wil een taak op zich nemen', 'class' => 'form-control')); ?>
      <?= $this->Form->input('organisatie_taak', array('label' => 'En wel deze taak', 'class' => 'form-control', 'type' => 'select', 'options' => $vacature_options)); ?>

    </div> <!-- sectie -->
  </div>
</div>

<!-- section 7 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">7. Diversen</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      Hier mogen jullie alles ingeven wat jullie eventueel nog kwijt willen.<br/>
      <ul>
      <li>Je hebt lichte twijfels over volgend seizoen en wil die graag nog eens bespreken met iemand van VCW voor je besluit.</li>
      <li>Je vindt VCW supercool en hebt enkele ideeën of voorstellen naar volgend seizoen toe (je kent een sponsor die zijn/haar logo nog op broekjes wil, kampplaats, kampthema, ...).</li>
      <li>Andere opmerkingen of suggesties.</li>
      </ul>
      Wij verwelkomen elke input.<br/>
      <br/>
      <?= $this->Form->input('diversen_tekst', array('label' => 'Het volgende wil ik nog kwijt', 'class' => 'form-control', 'rows' => '10')); ?>

    </div> <!-- sectie -->
  </div>
</div>

<!-- close the form -->
<?= $this->Form->end('Bewaar enquete'); ?>
<br/>
