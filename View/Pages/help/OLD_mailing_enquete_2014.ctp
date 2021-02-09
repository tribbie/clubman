<pre>
Procedure mailing enquete 2014 - CLUBMAN
========================================

In het kort:
-1-- PREPARE TABLES ---
// Maak maar een nieuwe table cm_enquetes per jaar (dit omdat hier en daar al eens een veld bijkomt/weggaat).
// Eerst de oude dus renamen (naar cm_enqueteYYYYs -- rare naam, maar zo blijft het bruikbaar in CAKEPHP)

-2-- mailing tables ---
// create mailings table -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks 1 record bij)
// create mails table    -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks de nodige records bij)
// Vul de enquetes vooraf met de gekende gegevens (naam, email adressen en zo ...)
// Vooraan de MD5 zet je misschien best het jaartal of een of ander volgnummer)

-3-- EXPORT TO CSV INTO VCW SITE ---
// export the cm_mails table to csv, and put the csv on the VCW site

-4-- DO THE MAIL ---
// empty the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2014.log
// check the mailing script at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2014_page.php
// run the mailing script at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2014_page.php

-5-- CHECK ---
// Check the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2014.log

// =====================================================================================

-1-- PREPARE TABLES---
// Maak maar een nieuwe table cm_enquetes per jaar (dit omdat hier en daar al eens een veld bijkomt/weggaat).
// Eerst de oude dus renamen (naar cm_enqueteYYYYs -- rare naam, maar zo blijft het bruikbaar in CAKEPHP)
CREATE TABLE `cm_enquetes` (
  `id` binary(32) NOT NULL,
  `member_id` int(11) unsigned DEFAULT NULL,
  `teammember_id` int(11) unsigned DEFAULT NULL,
  `team_id` int(11) unsigned DEFAULT NULL,
  `team_prio` int(2) unsigned DEFAULT NULL,
  `algemeen_seizoen` varchar(10) DEFAULT '',
  `algemeen_naam` varchar(50) DEFAULT '',
  `algemeen_ploeg` varchar(30) DEFAULT '',
  `algemeen_dubbelploeg` varchar(30) DEFAULT '',
  `algemeen_volgendseizoen` char(10) DEFAULT '',
  `algemeen_volgendseizoenploeg` varchar(30) DEFAULT '',
  `algemeen_volgendseizoendubbelploeg` varchar(30) DEFAULT '',
  `training_aantal` int(2) unsigned DEFAULT '0',
  `training_di20002200` char(10) DEFAULT '',
  `training_wo17001830` char(10) DEFAULT '',
  `training_wo18302000` char(10) DEFAULT '',
  `training_do19302130` char(10) DEFAULT '',
  `training_vr17451915` char(10) DEFAULT '',
  `training_vr19152100` char(10) DEFAULT '',
  `training_za09001000` char(10) DEFAULT '',
  `locatie_elders` char(10) DEFAULT '',
  `wedstrijd_aantal` char(10) DEFAULT '',
  `engagement_steun_ouders` char(10) DEFAULT '',
  `engagement_andere_activiteiten` varchar(100) DEFAULT NULL,
  `engagement_prio_volleybal` char(10) DEFAULT '',
  `studies_mindertrainen` tinyint(1) DEFAULT '0',
  `studies_opkot` tinyint(1) DEFAULT '0',
  `studies_geenwedstrijden` tinyint(1) DEFAULT '0',
  `studies_stage` tinyint(1) DEFAULT '0',
  `studies_andere` text,
  `allerjongsten_training` char(10) DEFAULT '',
  `mail_ik` varchar(50) DEFAULT '',
  `mail_ikfrequentie` char(10) DEFAULT '',
  `mail_mama` varchar(50) DEFAULT '',
  `mail_mamafrequentie` char(10) DEFAULT '',
  `mail_papa` varchar(50) DEFAULT '',
  `mail_papafrequentie` char(10) DEFAULT '',
  `begeleiding_pvmama` char(10) DEFAULT '',
  `begeleiding_pvpapa` char(10) DEFAULT '',
  `begeleiding_pvandere` varchar(50) DEFAULT '',
  `organisatie_naam` varchar(50) DEFAULT '',
  `organisatie_taak` varchar(30) DEFAULT '',
  `volley_toekomst` varchar(100) DEFAULT NULL,
  `diversen_tekst` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)

-2-- mailing tables
// create mailings table -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks 1 record bij)
CREATE TABLE `cm_mailings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `body` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)

// create mails table    -- enkel de eerste keer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks de nodige records bij
CREATE TABLE `cm_mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `mailing_id` int(11) NOT NULL,
  `mailsubject` varchar(150) DEFAULT NULL,
  `mailfrom` varchar(50) DEFAULT NULL,
  `mailto` varchar(64) DEFAULT NULL,
  `mailcc` varchar(128) DEFAULT NULL,
  `mailbcc` varchar(64) DEFAULT NULL,
  `mailbody` text,
  `maillinkurl` varchar(50) DEFAULT NULL,
  `maillinkmd5` varchar(48) DEFAULT NULL,
  `mailsent` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)


// Vul de enquetes vooraf met de gekende gegevens (naam, email adressen en zo ...)
// Vooraan de MD5 zet je misschien best het jaartal (of een of ander volgnummer -- is nu automatisch jaartal)
// De laatste -- AND zijn de teams die je wil enqueteren ...

# Fills the enquetes
INSERT INTO cm_enquetes (id, member_id, teammember_id, team_id, team_prio, algemeen_seizoen, algemeen_naam, algemeen_ploeg, mail_ik, mail_mama, mail_papa)
SELECT MD5(CONCAT(YEAR(CURDATE()),tm.id,m.lastname,m.firstname,tm.member_id)) uid, 
       tm.member_id, tm.id, tm.team_id, tm.teampriority, t.season, CONCAT(m.lastname, ' ', m.firstname) mname,
       t.name, m.email, m.mom_email, m.dad_email
 FROM cm_teammembers tm
 left join cm_teams t on t.id = tm.team_id
 left join cm_members m on m.id = tm.member_id
 WHERE (t.season = "2013-2014")
   AND (tm.teampriority = 1)
   AND (t.category <> "Seniors")
   AND (t.id in (1,2,3,4,5,6,7,16))

//// Volgende zou niet meer nodig moeten zijn -- wel best checken ...
// De dubbelaars uitfilteren (even noteren waar member_id zelfde is)
// deze checkt de dubbels
select algemeen_naam from cm_enquetes group by algemeen_naam having count(algemeen_naam) > 1 order by algemeen_naam
select id, member_id, teammember_id, team_id, algemeen_naam from cm_enquetes order by member_id, teammember_id;
// De gestopten enz ... uitfilteren
select e.teammember_id, e.algemeen_naam, tm.remark from cm_enquetes e left join cm_teammembers tm on tm.id = e.teammember_id where tm.remark <> "";
// Verwijder ze
delete from cm_enquetes where teammember_id in (11209,11202,11203,11152,11200,11115,11116,11117,11118,11120,11123,11081,11080,11201,11208,11137)
// Oblivio
oblivio -- (11212,11214,11203,11202,11152,11211,11200,11115,11116,11117,11118,11120,11123,11260,11080,11235,11021,11237,11022,11261,11201,11255,11256,11236,11209,11210,11213,11242,11006,11247,11269,11048,11241,11240,11246,11005,11049,11248)
On Oblivio, they were deleted in the browse window (select the doubles, the delete them)


// De dubbele email-adressen uitfilteren
SELECT algemeen_naam, mail_ik, mail_mama, mail_papa from cm_enquetes where (mail_ik = mail_mama) or (mail_ik = mail_papa) or (mail_mama = mail_papa);
// remove duplicates when identical found
UPDATE cm_enquetes set mail_mama = '' where mail_mama = mail_ik;
UPDATE cm_enquetes set mail_papa = '' where mail_papa = mail_ik;
UPDATE cm_enquetes set mail_papa = '' where mail_papa = mail_mama;
// reset empty email adresses to NULL for the CONCAT_WS (concatenate with separator) later on
UPDATE cm_enquetes set mail_mama = NULL where mail_mama = '';
UPDATE cm_enquetes set mail_papa = NULL where mail_papa = '';
// re-check for duplicate email adresses
SELECT algemeen_naam, mail_ik, mail_mama, mail_papa from cm_enquetes where (mail_ik = mail_mama) or (mail_ik = mail_papa) or (mail_mama = mail_papa);
// check met Jurgen wie er gestopt is ...


// (re)fill mailings
//check
cake page http://www.oblivio.be/www/clubman/mailings
//add
cake page http://www.oblivio.be/www/clubman/mailings/add
//edit
cake page http://www.oblivio.be/www/clubman/mailings/edit/1

// (re)fill mails
ALTER TABLE cm_mails AUTO_INCREMENT = 140001;
// nestorix -- test
// mailing_id and ml.id => id of the newly added mailing record
INSERT INTO cm_mails
      (id, name, mailing_id, mailsubject, mailfrom, mailto, mailcc, mailbcc, mailbody, maillinkurl, maillinkmd5, mailsent, created, modified)
SELECT NULL, e.algemeen_naam, 1, ml.name, 
  'jeugd@vcwolvertem.be', e.mail_ik, REPLACE(CONCAT_WS(';', e.mail_mama, e.mail_papa), ';', ','), NULL,
  'body elsewhere', 'http://nestorix/cake_clubman/enquetes/vulin', e.id, NULL, NOW(), NULL 
  FROM cm_enquetes e LEFT JOIN cm_mailings ml ON ml.id = 5
// oblivio -- productie
INSERT INTO cm_mails
      (id, name, mailing_id, mailsubject, mailfrom, mailto, mailcc, mailbcc, mailbody, maillinkurl, maillinkmd5, mailsent, created, modified)
SELECT NULL, e.algemeen_naam, 1, ml.name, 
  'jeugd@vcwolvertem.be', e.mail_ik, REPLACE(CONCAT_WS(';', e.mail_mama, e.mail_papa), ';', ','), NULL,
  'body elsewhere', 'http://www.oblivio.be/www/clubman/enquetes/vulin', e.id, NULL, NOW(), NULL 
  FROM cm_enquetes e LEFT JOIN cm_mailings ml ON ml.id = 1


-3-- EXPORT TO CSV INTO VCW SITE ---
// export the cm_mails table to csv, and put the csv on the 'normal' VCW site

// vumini -- test
SELECT * FROM cm_mails
 WHERE id > 14000
 INTO OUTFILE '/var/www/doorgeef/vcw_mails_2014.csv'
 FIELDS TERMINATED BY ';'
 OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";
 
// oblivio -- productie
// export the cm_mails table to a csv -- double quotes, punt comma -- (id > 14000)
// replace ", " with "," (remove blanks after comma) 
// - put the csv on the VCW site (in vcwmailings/data/vcw_enquete_2014_list.csv)
// - copy some testlines a test csv on the VCW site (in vcwmailings/data/vcw_enquete_2014_list_test.csv)
// - put the mail-text (mail-body) on the VCW site (in vcwmailings/data/vcw_enquete_2014_mail.txt)


-4-- DO THE MAIL ---
// empty the log file at http://www.vcwolvertem.be/vcwmailings/log/vcw_enquete_2014.log
// run the mailing script at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2014_page.php


-5-- CHECK ---
// Check the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2014.log
