
<h3>Procedure mailing enquete 2017 - CLUBMAN</h3>


<br/>
In het kort:<br/>
--1-- PREPARE ENQUETES --<br/>
- We proberen steeds dezelfde tabel te gebruiken. Velden mogen bijkomen - verwijderen doen we niet (deze tonen we gewoon niet)<br/>
- Vul de enquetes vooraf met de gekende gegevens (naam, email adressen en zo ...)<br/>
<br/>
--2-- MAILING TABLES --<br/>
- create mailings table -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks 1 record bij)<br/>
- create mails table    -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks de nodige records bij)<br/>
- Vul ze<br/>
<br/>
--3-- Create MAILING and MAILS --<br/>
- via Clubman<br/>
<br/>
--4-- DO THE MAIL --<br/>
- via Clubman<br/>
<br/>
-5-- CHECK ---<br/>
- Check the mailings@vcwolvertem.be mailbox<br/>

<br/>
<hr/>
<p>
  Opmerkingen:
  <ol>
    <li>ten laatste antwoord tegen 20 februari 2017</li>
    <li>Trainingen: Maandag 19u00 - 21u00  --> toevoegen</li>
    <li>Wedstrijden: 18jaar op 1/01/2018 ipv 1/1/2017</li>
  </ol>
</p>


<hr/>
<br/>

<h4>--1-- PREPARE ENQUETES --</h4>
// Wijzigingen ...<br/>
- altijd alleen nieuwe velden toevoegen<br/>
- nooit velden weghalen (deze tonen we gewoon niet) -- anders gooi je info van vorige jaren weg<br/>
<pre>
  alter table cm_enquetes add algemeen_ploeg_tevreden char(16) DEFAULT '' after algemeen_ploeg;
  alter table cm_enquetes add training_ma19002100 char(10) DEFAULT '' after training_aantal;
  alter table cm_enquetes add diversen_lidgeld_hoog char(10) DEFAULT '' after volley_leuk;
</pre>
// Vul de enquetes vooraf met de gekende gegevens (naam, email adressen en zo ...)<br/>
// Dit zit nu reeds in Clubman: onder enquetes / genereer (voorlopig enkel root en admin)<br/>
<br/>
# Add test-entries - (for Jurgen en Tribbie en Steph) - via speciaal team<br/>
# - eventueel wel de naam aanpassen<br/>
#   -> Bart Seghers --> AAA - Bart Seghers - test<br/>
<br/>
<br/>

<h4>--2-- MAILING TABLES ---</h4>
// create mailings table -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks 1 record bij)<br/>
// create mails table    -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks de nodige records bij<br/>
<br/>
// De dubbele email-adressen uitfilteren<br/>
// 2016 -- Dit gaan we proberen in de cm_mails te doen, niet in cm_enquetes ...
<pre>
// check for duplicate email adresses
SELECT algemeen_naam, mail_ik, mail_mama, mail_papa FROM cm_enquetes WHERE (season = '2016-2017') AND ((mail_ik = mail_mama) OR (mail_ik = mail_papa) OR (mail_mama = mail_papa)) ORDER BY algemeen_naam;
// remove duplicates when identical found
UPDATE cm_enquetes set mail_mama = '' where mail_mama = mail_ik;
UPDATE cm_enquetes set mail_papa = '' where mail_papa = mail_ik;
UPDATE cm_enquetes set mail_papa = '' where mail_papa = mail_mama;
// reset empty email adresses to NULL for the CONCAT_WS (concatenate with separator) later on
UPDATE cm_enquetes set mail_mama = NULL where mail_mama = '';
UPDATE cm_enquetes set mail_papa = NULL where mail_papa = '';
// re-check for duplicate email adresses
SELECT algemeen_naam, mail_ik, mail_mama, mail_papa FROM cm_enquetes WHERE (season = '2016-2017') AND ((mail_ik = mail_mama) OR (mail_ik = mail_papa) OR (mail_mama = mail_papa)) ORDER BY algemeen_naam;
</pre>
<br/>
<br/>

<h4>--3-- Create MAILING and MAILS ---</h4>
// fill mailing<br/>
//check<br/>
cake page http://www.vcwolvertem.be/mailings<br/>
//add<br/>
cake page http://www.vcwolvertem.be/mailings/add<br/>
//edit<br/>
cake page http://www.vcwolvertem.be/mailings/edit/x<br/>
<br/>
// fill mails<br/>
Generate mails through Clubman/mailings -> maak mails<br/>
<br/>
<br/>

<h4>--4-- DO THE MAIL ---</h4>
// send mails<br/>
Send mails through Clubman/mailings -> select mailing -> onderaan: "stuur alle mails"<br/>
<br/>
