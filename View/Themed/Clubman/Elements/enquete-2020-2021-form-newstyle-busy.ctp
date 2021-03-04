<!-- app/View/Elements/enquete-2020-2021-form.ctp -->
<h1>Formulier voor <?=$this->request->data['Enquete']['algemeen_naam'];?></h1>

<!-- open the form -->
<?= $this->Form->create('Enquete'); ?>

<!-- hidden stuff -->
<?= $this->Form->input('id', array('type' => 'hidden')); ?>
<?= $this->Form->input('member_id', array('type' => 'hidden')); ?>
<?= $this->Form->input('teammember_id', array('type' => 'hidden')); ?>
<?= $this->Form->input('team_id', array('type' => 'hidden')); ?>
<?= $this->Form->input('algemeen_seizoen', array('type' => 'hidden')); ?>
<?= $this->Form->input('algemeen_naam', array('type' => 'hidden')); ?>
<br/>

<!-- section 0 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">0. inleiding</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      Hoi,<br/>
      <br/>
      In het kader van onze voorbereiding van het volgende seizoen vind je hieronder een beknopte vragenlijst.<br/>
      We vragen een vijftal minuutjes van je tijd om deze, eventueel samen met je ouders, zorgvuldig en eerlijk in te vullen.<br/>
      In de mate van het mogelijke zullen we met de geleverde antwoorden en suggesties proberen rekening te houden naar volgend seizoen toe.<br/>
      Let op! Vragen en/of verlangens die alvast niet in aanmerking komen zijn o.a.:<br/>
      <ul>
       <li>Mag ik te laat komen op training?</li>
       <li>Mag ik mijn GSM bij mij houden tijdens de training?</li>
       <li>Mag ik mij minder inzetten?</li>
       <li>...</li>
      </ul>
      Ook zullen niet alle vragen even relevant zijn voor iedereen.<br/>
      <br/>
      Graag hadden we de ingevulde vragenlijst terug ten laatste op <strong>zondag 17 maart 2021</strong>.<br/>
      <br/>
      Alvast hartelijk bedankt voor je medewerking!<br/>
      <br/>
      Het bestuur.<br/>

    </div> <!-- sectie -->
  </div>
</div>


<!-- section 1 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">1. Wat volgend seizoen?</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      Eerst en vooral het belangrijkste.<br/>
      <br/>

      <?= $this->Form->input('algemeen_ploeg', array('label' => 'Je ploeg nu', 'class' => 'form-control')); ?>
      <?= $this->Form->input('algemeen_ploeg_tevreden', array('label' => 'Ben je blij bij je huidige team', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'ja' => 'ja', 'eerder wel' => 'eerder wel', 'eerder niet' => 'eerder niet', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('algemeen_score_huidige_ploegsfeer', array('label' => 'Tevredenheid over de ploegsfeer', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'))); ?>
      <?= $this->Form->input('algemeen_score_huidige_trainer', array('label' => 'Tevredenheid over de huidge trainer', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'))); ?>
      <?= $this->Form->input('algemeen_dubbelploeg', array('label' => 'Je dubbelploeg (als je er een hebt)', 'class' => 'form-control')); ?>

      <h3>Volgend seizoen ...</h3>
      <?= $this->Form->input('algemeen_volgendseizoenploeg', array('label' => 'Je eerst keuze qua ploeg ...', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'U11' => 'U11', 'U13' => 'U13', 'U15' => 'U15', 'U17' => 'U17', 'U19' => 'U19', 'seniors' => 'Dames / Heren'))); ?>
      <br/>
      Als je graag wil dubbelen kan je dit hier aangeven. Dubbelen geeft meer speelkansen, meer trainingen en snellere vooruitgang.<br/>
      <?= $this->Form->input('algemeen_volgendseizoendubbelploeg', array('label' => 'Je gewenste dubbelploeg ...', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'U11' => 'U11', 'U13' => 'U13', 'U15' => 'U15', 'U17' => 'U17', 'U19' => 'U19', 'seniors' => 'Dames / Heren'))); ?>
      <br/>
      Vermits we bij VCW pas vanaf U17 met vaste posities spelen, zijn de volgende 2 vragen eigenlijk enkel in te vullen als je U17, U19 of Seniors (dames/heren) hebt gekozen.<br/>
      <br/>
      <?= $this->Form->input('algemeen_positie_keuze_1', array('label' => 'Mijn voorkeurpositie', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'libero' => 'libero', 'middenblok' => 'middenblok', 'setter' => 'setter', 'opposite' => 'opposite', 'receptie-hoek' => 'receptie-hoek'))); ?>
      <?= $this->Form->input('algemeen_positie_keuze_2', array('label' => 'Mijn tweede voorkeurpositie', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'libero' => 'libero', 'middenblok' => 'middenblok', 'setter' => 'setter', 'opposite' => 'opposite', 'receptie-hoek' => 'receptie-hoek'))); ?>
      <br/>
      <div class='panel panel-warning'>
        <div class="panel-heading">Opgelet!</div>
        <div class="panel-body">
          Indien je een ploeg gekozen hebt, gelieve dan onderstaande secties ook nog in te vullen.<br/>
          <br/>
          In het andere geval ben je klaar.<br/>
          <span class='valop text-danger'>Je mag dan gerust in sectie 9 invullen wat je nog kwijt wil.</span>.<br/>
          <span class='valop text-danger'><strong>Vergeet ook niet om je enquête te bewaren (helemaal onderaan)!</strong></span><br/>
        </div>
      </div>

    </div> <!-- sectie -->
  </div>
</div>


<!-- section 2 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">2. trainingen</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      <font size='+3'>Hoera! Je blijft!</font><br/>
      Dan zouden we nog een aantal dingen willen vragen.<br/>
      Eerst wat over de trainingen.<br/>
      </br>

      <h3>Aantal en tijdstip</h3>
      <?= $this->Form->input('training_aantal', array('label' => 'Aantal keer trainen per week', 'class' => 'form-control', 'type' => 'select', 'options' => array('1' => '1', '2' => '2', '3' => '3'))); ?>
      Hieronder vind je de momenten waarop onze club de zaal ter beschikking heeft. Gelieve voor <strong>alle</strong> mogelijkheden aan te geven of het voor jou (eventueel) zou passen om te trainen.<br/>
      <br/>
      <?= $this->Form->input('training_ma19002100', array('label' => 'maandag 19:00-21:00 (Meise)', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'eventueel' => 'eventueel', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('training_di20002200', array('label' => 'dinsdag 20:00-22:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'eventueel' => 'eventueel', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('training_wo16001700', array('label' => 'woensdag 16:00-17:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'eventueel' => 'eventueel', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('training_wo17001830', array('label' => 'woensdag 17:00-18:30', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'eventueel' => 'eventueel', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('training_wo18302000', array('label' => 'woensdag 18:30-20:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'eventueel' => 'eventueel', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('training_do20002200', array('label' => 'donderdag 20:00-22:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'eventueel' => 'eventueel', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('training_vr17301900', array('label' => 'vrijdag 17:30-19:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'eventueel' => 'eventueel', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('training_vr19002100', array('label' => 'vrijdag 19:00-21:00', 'class' => 'form-control', 'type' => 'select', 'options' => array('-' => '', 'ja' => 'ja', 'eventueel' => 'eventueel', 'nee' => 'nee'))); ?>

      <h3>Verplaatsing</h3>
      Over je verplaatsing van en naar de trainingen hadden we ook graag jullie toestand geweten.<br/>
      <br/>
      <?= $this->Form->input('training_verplaatsing', array('label' => 'mijn verplaatsing', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'tevoet' => 'ik kom te voet', 'fiets' => 'ik kom met de fiets', 'autozelf' => 'ik kom zelf met de auto', 'autotaxi' => 'ik rijd met iemand mee', 'autoouders' => 'ik word gebracht door mijn ouders', 'openbaarvervoer' => 'ik kom met het openbaar vervoer', 'moeite' => 'ik ondervind veel moeilijkheden'))); ?>
      <br/>
      Dit puntje kan gebruikt worden om eventueel car-pooling te suggereren of te organiseren, moest dit nodig en mogelijk zijn.

    </div> <!-- sectie -->
  </div>
</div>


<!-- section 3 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">3. wedstrijden</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      Indien je nog in aanmerking komt voor jeugdvolleybal (18 jaar op 1/1/2020) en om iedereen zoveel mogelijk speelkansen te geven, bestaat er de mogelijkheid om in bepaalde omstandigheden 2 wedstrijden per weekend te spelen.<br/>
      Wil jij dit doen?<br/>
      <br/>
      <?= $this->Form->input('wedstrijd_aantal', array('label' => 'Aantal wedstrijden', 'class' => 'form-control', 'type' => 'select', 'options' => array('1' => '1', 'soms 2' => 'soms 2', '2' => '2'))); ?>

    </div> <!-- sectie -->
  </div>
</div>


<!-- section 4 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">4. engagement</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      Mijn mate van engagement:<br/>
      <br/>
      <?= $this->Form->input('engagement_steun_ouders', array('label' => 'Voel jij je gesteund door je ouders?', 'class' => 'form-control', 'type' => 'select', 'options' => array('ja' => 'ja', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('engagement_andere_activiteiten', array('label' => 'Doe je nog andere naschoolse activiteiten buiten volleybal?', 'class' => 'form-control')); ?>
      <?= $this->Form->input('engagement_prio_volleybal', array('label' => 'Op welke plaats komt de volleybal?', 'class' => 'form-control', 'type' => 'select', 'options' => array(1 => 'eerste', 2 => 'tweede'))); ?>

    </div> <!-- sectie -->
  </div>
</div>


<!-- section 5 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">5. communicatie</h2>
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
    <h2 class="panel-title">6. begeleiding</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      Zoals ieder seizoen zijn wij op zoek naar ouders die de o zo noodzakelijke praktische zaken/taken binnen een ploeg op zich willen nemen, m.a.w. we zoeken nog steeds 'ploegverantwoordelijken' of PV's.<br/>
      In de praktijk houdt een PV zich bezig met de NIET-sportieve zaken binnen de ploeg, zoals het markeren van de wedstrijden, het verdelen van kaarten voor eetfestijnen, de opvolging van de beurtrol voor het wassen van de uitrustingen, het fungeren als tussenpersoon naar het bestuur toe, alsook de rol van ombudsman/-vrouw van de spelers of speelsters.<br/>
      Het is dus een leuke taak als rechterhand van de trainer :-).<br/>
      Nu hij/zij dit gelezen heeft, ...<br/>
      <br/>
      <?= $this->Form->input('begeleiding_pvmama', array('label' => '... wil mama wel PV worden', 'class' => 'form-control', 'type' => 'select', 'options' => array('nee' => 'nee', 'ja' => 'ja'))); ?>
      <?= $this->Form->input('begeleiding_pvpapa', array('label' => '... wil papa wel PV worden', 'class' => 'form-control', 'type' => 'select', 'options' => array('nee' => 'nee', 'ja' => 'ja'))); ?>
      <?= $this->Form->input('begeleiding_pvandere', array('label' => '... wil iemand anders wel, namelijk (vul hieronder de naam in)', 'class' => 'form-control')); ?>

    </div> <!-- sectie -->
  </div>
</div>


<!-- section 7 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">7. organsatie</h2>
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
            'description' => 'wil je meewerken om af en toe een verslag/verhaal te maken om te publiceren op Facebook of onze website? Voel je je aangesproken? Niet twijfelen dan.'
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
            'description' => 'Wil je graag een "echte" scheidsrechter worden, volledig in tenue? Ook dat kunnen wij enkel toejuichen, dus laat het ons vooral weten. Wederom kan je rekenen op een voorafgaande uitleg/opleiding indien nodig.'
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
          'markeerder',
          'officielescheidsrechter',
          'jeugdscheidsrechter',
          'jeugdcoordinator',
          'sponsorverantwoordelijke',
          'feestcomite'
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


<!-- section 8 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">8. volley is leuk</h2>
  </div>
  <div class="panel-body">
    <div class='sectie'>

      Gelieve aan te vullen.<br/>
      <br/>
      <?= $this->Form->input('volley_leuk', array('label' => 'Ik vind VCW en volleybal leuk omdat ...', 'class' => 'form-control', 'rows' => '5')); ?>

    </div> <!-- sectie -->
  </div>
</div>


<!-- section 9 -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h2 class="panel-title">9. diversen</h2>
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
      <?= $this->Form->input('diversen_lidgeld_hoog', array('label' => 'Is het bedrag van het lidgeld te hoog?', 'class' => 'form-control', 'type' => 'select', 'options' => array('' => '', 'ja' => 'ja', 'nee' => 'nee'))); ?>
      <?= $this->Form->input('diversen_tekst', array('label' => 'Het volgende wil ik nog kwijt', 'class' => 'form-control', 'rows' => '10')); ?>

    </div> <!-- sectie -->
  </div>
</div>

<!-- close the form -->
<?= $this->Form->end('Bewaar enquete'); ?>
<br/>
