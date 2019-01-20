
<h3>Procedure mailing enquete 2016 - CLUBMAN</h3>


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
--3-- EXPORT TO CSV INTO VCW SITE --<br/>
- export the cm_mails table to csv, and put the csv on the VCW site<br/>
<br/>
--4-- DO THE MAIL --<br/>
- empty the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2015.log<br/>
- check the mailing script at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2015_page.php<br/>
- run the mailing script at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2015page.php<br/>
<br/>
-5-- CHECK ---<br/>
- Check the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2015.log<br/>

<br/>
<hr/>
<br/>
<h4>--1-- PREPARE ENQUETES --</h4>
// Wijzigingen ...<br/>
- altijd alleen nieuwe velden toevoegen<br/>
- nooit velden weghalen (deze tonen we gewoon niet) -- anders gooi je info van vorige jaren weg<br/>
<pre>
alter table cm_enquetes add volley_leuk TEXT after volley_toekomst;
alter table cm_enquetes add training_vr17301900 char(10) DEFAULT '' after training_do19302130;
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
SELECT algemeen_naam, mail_ik, mail_mama, mail_papa FROM cm_enquetes WHERE (season = '2015-2016') AND ((mail_ik = mail_mama) OR (mail_ik = mail_papa) OR (mail_mama = mail_papa)) ORDER BY algemeen_naam;
// remove duplicates when identical found
UPDATE cm_enquetes set mail_mama = '' where mail_mama = mail_ik;
UPDATE cm_enquetes set mail_papa = '' where mail_papa = mail_ik;
UPDATE cm_enquetes set mail_papa = '' where mail_papa = mail_mama;
// reset empty email adresses to NULL for the CONCAT_WS (concatenate with separator) later on
UPDATE cm_enquetes set mail_mama = NULL where mail_mama = '';
UPDATE cm_enquetes set mail_papa = NULL where mail_papa = '';
// re-check for duplicate email adresses
SELECT algemeen_naam, mail_ik, mail_mama, mail_papa FROM cm_enquetes WHERE (season = '2015-2016') AND ((mail_ik = mail_mama) OR (mail_ik = mail_papa) OR (mail_mama = mail_papa)) ORDER BY algemeen_naam;
</pre>
<br/>
<br/>
// fill mailings<br/>
//check<br/>
cake page http://www.vcwolvertem.be/mailings<br/>
//add<br/>
cake page http://www.vcwolvertem.be/mailings/add<br/>
//edit<br/>
cake page http://www.vcwolvertem.be/mailings/edit/x<br/>
<br/>
<pre>
// fill mails
ALTER TABLE cm_mails AUTO_INCREMENT = 160001;
// mailing_id and ml.id => id of the newly added mailing record
// first -- nestorix -- test
INSERT INTO cm_mails
      (id, name, mailing_id, mailsubject, mailfrom, mailto, mailcc, mailbcc, mailbody, maillinkurl, maillinkmd5, mailsent, created, modified)
SELECT NULL, e.algemeen_naam, 3, ml.name,
  'jongvcw@vcwolvertem.be', e.mail_ik, REPLACE(CONCAT_WS(';', e.mail_mama, e.mail_papa), ';', ','), NULL,
  'body elsewhere', 'http://nestorix/vcw-one/enquetes/vulin', e.id, NULL, NOW(), NULL
  FROM cm_enquetes e LEFT JOIN cm_mailings ml ON ml.id = 3
  WHERE season = '2015-2016' AND e.algemeen_naam NOT LIKE "AAA%"
// next -- vcwolvertem.be -- productie
INSERT INTO cm_mails
      (id, name, mailing_id, mailsubject, mailfrom, mailto, mailcc, mailbcc, mailbody, maillinkurl, maillinkmd5, mailsent, created, modified)
SELECT NULL, e.algemeen_naam, ___here_goes_the_mailing_id___, ml.name,
  'jongvcw@vcwolvertem.be', e.mail_ik, REPLACE(CONCAT_WS(';', e.mail_mama, e.mail_papa), ';', ','), NULL,
  'body elsewhere', 'http://www.vcwolvertem.be/enquetes/vulin', e.id, NULL, NOW(), NULL
  FROM cm_enquetes e LEFT JOIN cm_mailings ml ON ml.id = ___here_goes_the_mailing_id___
  WHERE season = '2015-2016'
- add this for the real entries --  AND e.algemeen_naam NOT LIKE "AAA%"
- add this for the test entries --  AND e.algemeen_naam LIKE "AAA%"
</pre>
<br/>
<h4>--3-- EXPORT TO CSV INTO VCW SITE ---</h4>
// export the cm_mails table to csv, and put the csv on the 'normal' VCW site<br/>
<br/>
// nestorix -- test<br/>
<pre>
SELECT * FROM cm_mails
 WHERE id > 160000
 INTO OUTFILE '/var/tmp/vcw_mails_2016.csv'
 FIELDS TERMINATED BY ';'
 OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";
</pre>
<br/>
// vcwolvertem.be -- productie<br/>
// export the cm_mails table to a csv -- double quotes, punt comma, replace NULL door [blank] -- (id > 160000)<br/>
// replace ", " with "," (remove blanks after comma)<br/>
// - put the csv on the VCW site (in vcwmailings/data/vcw_enquete_2016_list.csv)<br/>
// - copy some testlines a test csv on the VCW site (in vcwmailings/data/vcw_enquete_2016_list_test.csv)<br/>
// - put the mail-text (mail-body) on the VCW site (in vcwmailings/data/vcw_enquete_2016_mail.txt)<br/>
<br/>
<br/>
<h4>--4-- DO THE MAIL ---</h4>
http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2016_page.php => daar de goede link (als hij actief is)<br/>
// empty the log file at http://www.vcwolvertem.be/vcwmailings/log/vcw_enquete_2016.log<br/>
// run the mailing script at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2016_page.php<br/>
<br/>
<br/>
<h4>--5-- CHECK ---</h4>
// Check the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2016.log<br/>
<br/>
