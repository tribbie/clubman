
<h3>Procedure mailing enquete 2021 - CLUBMAN</h3>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">In het kort:</h4>
  </div>
  <div class="panel-body">
    Dit zijn de te nemen stappen.
  </div>
  <ul class="list-group">
    <li class="list-group-item">
      <h4 class="list-group-item-heading">--1-- PREPARE ENQUETES --</h4>
      <p class="list-group-item-text">
        <ul>
          <li>We proberen steeds dezelfde tabel te gebruiken. Velden mogen bijkomen - verwijderen doen we niet (deze tonen we gewoon niet)</li>
          <li>Genereer de enquetes vooraf met de gekende gegevens (naam, email adressen en zo ...)</li>
        </ul>
      </p>
    </li>
    <li class="list-group-item">
      <h4 class="list-group-item-heading">--2-- MAILING TABLES --</h4>
      <p class="list-group-item-text">
        <ul>
          <li>create mailings table -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks 1 record bij)</li>
          <li>create mails table -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks de nodige records bij)</li>
          <li>Vul ze (cfr volgende stap)</li>
        </ul>
      </p>
    </li>
    <li class="list-group-item">
      <h4 class="list-group-item-heading">--3-- Create MAILING and MAILS --</h4>
      <p class="list-group-item-text">
        <ul>
          <li>via Clubman</li>
        </ul>
      </p>
    </li>
    <li class="list-group-item">
      <h4 class="list-group-item-heading">--4-- DO THE MAIL --</h4>
      <p class="list-group-item-text">
        <ul>
          <li>via Clubman</li>
        </ul>
      </p>
    </li>
    <li class="list-group-item">
      <h4 class="list-group-item-heading">--5-- CHECK --</h4>
      <p class="list-group-item-text">
        <ul>
          <li>Check the mailings@vcwolvertem.be mailbox</li>
        </ul>
      </p>
    </li>
  </ul>
</div>

<div class="panel panel-info">
  <div class="panel-heading">
    <h4 class="panel-title">--1-- PREPARE ENQUETES --</h4>
  </div>
  <div class="panel-body">
    Preparing some Clubman pages and Enquete (schema and / or records)
  </div>
  <ul class="list-group">
    <li class="list-group-item">
      <h4>Wijzigingen aan enquete-vragen (indien nodig)</h4>
      In de database:
      <ul>
        <li>
          Altijd alleen nieuwe velden toevoegen<br/>
          In 2021 toegevoegd (of een voorbeeld als er niets is toegevoegd):<br/>
          <code>alter table cm_enquetes add algemeen_score_huidige_trainer_naam char(50) DEFAULT '' after algemeen_score_huidige_trainer;<br/></code>
          <code>alter table cm_enquetes add algemeen_score_huidige_trainer_2 char(2) DEFAULT '' after algemeen_score_huidige_trainer_naam;<br/></code>
          <code>alter table cm_enquetes add algemeen_score_huidige_trainer_2_naam char(50) DEFAULT '' after algemeen_score_huidige_trainer_2;<br/></code>
          <code>alter table cm_enquetes add training_di18302000 char(10) DEFAULT '' after training_di17301900;<br/></code>
        </li>
        <li>
          Nooit velden weghalen (deze tonen we gewoon niet) -- anders gooi je info van vorige jaren weg
        </li>
      </ul>
    </li>
    <li class="list-group-item">
      <h4>Nieuwe formulier en bekijk-pagina maken</h4>
      In de code:
      <ul>
        <li>
          file Elements/enquete-2020-2021-view.ctp
        </li>
        <li>
          file Elements/enquete-2020-2021-form.ctp
          <ul>
            <li>ten laatste antwoord tegen 31 maart 2021</li>
            <li>Wedstrijden: 18 jaar op 1/01/2021 ipv 1/1/2020</li>
            <li>Hier staan mogelijk nog enkele seizoensgebonden strings in</li>
            <li>Hier ook eventuele nieuwe vragen toevoegen / oude vragen weglaten</li>
          </ul>
        </li>
        <li>
          file EnquetesController.php - function export
          <ul>
            <li>Enkel als er vragen/velden gewijzigd zijn</li>
          </ul>
        </li>
      </ul>
    </li>
    <li class="list-group-item">
      <h4>Add test-entries - (for Tribbie en enquete-guys)</h4>
      In clubman:
      <ul>
        <li>Via speciaal "Curieuzeneuzen" (enquêteurs) team -> dan Clubman / Extra / enquetes / generate</li>
        <li>Eventueel wel de naam aanpassen (rechtstreeks in de database)<br/>
          <code>update cm_enquetes set algemeen_naam = concat("AAA - ", algemeen_naam, " - test") where season="2020-2021";<br/></code>
          <ul>
            <li>Bart Seghers --> AAA - Bart Seghers - test</li>
          </ul>
        </li>
      </ul>
      Laat ze goed testen!<br/>
    </li>
    <li class="list-group-item">
      <h4>Genereren</h4>
      In clubman:<br/>
      Vraag aan de enqueteurs wie de enquete allemaal moet krijgen<br/>
      <ul>
        <li>Dit zit nu reeds in Clubman: onder enquetes / genereer (voorlopig enkel root en admin)</li>
      </ul>
    </li>
  </ul>
</div>

<div class="panel panel-info">
  <div class="panel-heading">
    <h4 class="panel-title">--2-- MAILING TABLES --</h4>
  </div>
  <div class="panel-body">
    <p>
      // create mailings table -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks 1 record bij)<br/>
      // create mails table    -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks de nodige records bij<br/>
      <br/>
      // De dubbele email-adressen uitfilteren<br/>
      // 2016 -- Dit gaan we proberen in de cm_mails te doen, niet in cm_enquetes ...
    </p>
    <p>
      // check for duplicate email adresses<br/>
      <code>SELECT algemeen_naam, mail_ik, mail_mama, mail_papa FROM cm_enquetes WHERE (season = '2016-2017') AND ((mail_ik = mail_mama) OR (mail_ik = mail_papa) OR (mail_mama = mail_papa)) ORDER BY algemeen_naam;<br/></code>
      // remove duplicates when identical found<br/>
      <code>UPDATE cm_enquetes set mail_mama = '' where mail_mama = mail_ik;<br/></code>
      <code>UPDATE cm_enquetes set mail_papa = '' where mail_papa = mail_ik;<br/></code>
      <code>UPDATE cm_enquetes set mail_papa = '' where mail_papa = mail_mama;<br/></code>
      // reset empty email adresses to NULL for the CONCAT_WS (concatenate with separator) later on<br/>
      <code>UPDATE cm_enquetes set mail_mama = NULL where mail_mama = '';<br/></code>
      <code>UPDATE cm_enquetes set mail_papa = NULL where mail_papa = '';<br/></code>
      // re-check for duplicate email adresses<br/>
      <code>SELECT algemeen_naam, mail_ik, mail_mama, mail_papa FROM cm_enquetes WHERE (season = '2016-2017') AND ((mail_ik = mail_mama) OR (mail_ik = mail_papa) OR (mail_mama = mail_papa)) ORDER BY algemeen_naam;<br/></code>
    </p>
  </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">
    <h4 class="panel-title">--3-- Create MAILING and MAILS --</h4>
  </div>
  <div class="panel-body">
    <p>
      // fill mailing<br/>
      //check<br/>
      cake page https://www.vcwolvertem.be/mailings<br/>
      //add<br/>
      cake page https://www.vcwolvertem.be/mailings/add<br/>
      //edit<br/>
      cake page https://www.vcwolvertem.be/mailings/edit/x<br/>
    </p>
    <p>
      // fill mails<br/>
      Generate mails through Clubman / mailings -> maak mails<br/>
    </p>
  </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">
    <h4 class="panel-title">--4-- DO THE MAIL --</h4>
  </div>
  <div class="panel-body">
    <p>
      // send mails<br/>
      Send mails through Clubman / mailings -> select mailing -> onderaan: "stuur alle mails"<br/>
    </p>
  </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">
    <h4 class="panel-title">--5-- CHECK --</h4>
  </div>
  <div class="panel-body">
    <p>
      Check the mailings@vcwolvertem.be mailbox
    </p>
  </div>
</div>
