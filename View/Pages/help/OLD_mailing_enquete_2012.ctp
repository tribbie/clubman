<pre>
Procedure mailing enquete 2012
==============================

In het kort:
-1-- PREPARE TABLES ---
// Maak maar een nieuwe table vcw_enquetes per jaar (dit omdat hier en daar al eens een veld bijkomt/weggaat).
// Eerst de oude dus renamen (naar vcw_enqueteYYYYs -- rare naam, maar zo blijft het bruikbaar in CAKEPHP)

-2-- mailing tables ---
// create mailings table -- niet meer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks 1 record bij)
// create mails table    -- niet meer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks de nodige records bij
// Vul de enquetes vooraf met de gekende gegevens (naam, email adressen en zo ...)
// Vooraan de MD5 zet je misschien best het jaartal of een of ander volgnummer)

-3-- EXPORT TO CSV INTO VCW SITE ---
// export the vcw_mails table to csv, and put the csv on the VCW site

-4-- DO THE MAIL ---
// empty the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2012.log
// run the mailing script at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2012_page.php

-5-- CHECK ---
// Check the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2012.log

// =====================================================================================

-1-- PREPARE TABLES---
// Maak maar een nieuwe table vcw_enquetes per jaar (dit omdat hier en daar al eens een veld bijkomt/weggaat).
// Eerst de oude dus renamen (naar vcw_enqueteYYYYs -- rare naam, maar zo blijft het bruikbaar in CAKEPHP)
CREATE TABLE `vcw_enquetes` (
  `id` binary(32) NOT NULL,
  `member_id` int(11) unsigned DEFAULT NULL,
  `teammember_id` int(11) unsigned DEFAULT NULL,
  `team_id` int(11) unsigned DEFAULT NULL,
  `algemeen_naam` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `algemeen_ploeg` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `algemeen_dubbelploeg` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `algemeen_volgendseizoen` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `training_aantal` int(2) unsigned DEFAULT '0',
  `training_di20002200` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
    `training_di20002130` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
    `training_di20302200` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `training_wo17001830` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `training_wo18302000` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `training_do20002200` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
    `training_do20002130` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
    `training_do20302200` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `training_vr17451915` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `training_vr19152100` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
    `locatie_elders` tinyint(1) DEFAULT '0',
  `wedstrijd_aantal` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `studies_mindertrainen` tinyint(1) DEFAULT '0',
  `studies_opkot` tinyint(1) DEFAULT '0',
  `studies_geenwedstrijden` tinyint(1) DEFAULT '0',
  `studies_stage` tinyint(1) DEFAULT '0',
  `studies_andere` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `mail_ik` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `mail_ikfrequentie` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `mail_mama` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `mail_mamafrequentie` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `mail_papa` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `mail_papafrequentie` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `begeleiding_pvmama` tinyint(1) DEFAULT '0',
  `begeleiding_pvpapa` tinyint(1) DEFAULT '0',
  `begeleiding_pvandere` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `organisatie_naam` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `organisatie_taak` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
    `volley_toekomst` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci,
  `diversen_tekst` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-2-- mailing tables
// create mailings table -- niet meer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks 1 record bij)

// create mails table    -- niet meer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks de nodige records bij

// Vul de enquetes vooraf met de gekende gegevens (naam, email adressen en zo ...)
// Vooraan de MD5 zet je misschien best het jaartal of een of ander volgnummer)
// De laatste -- AND (tm.id not in (...)) zijn volgens mij de dubbelaars -- hier moet je eerst even achteraan...
INSERT INTO vcw_enquetes (id, member_id, teammember_id, team_id, algemeen_naam, algemeen_ploeg, mail_ik, mail_mama, mail_papa)
SELECT MD5(CONCAT('2012',tm.id,tm.member_name,tm.member_id)) uid, tm.member_id, tm.id, tm.team_id, tm.member_name, t.name, m.email, m.email_mama, m.email_papa
 FROM vcw_teammembers tm
 left join vcw_teams t on t.id = tm.team_id
 left join vcw_members m on m.id = tm.member_id
 WHERE tm.team_id in (1101,1102,1103,1118,1104,1105,1106,1107,1108,1109,1110,1111,1113)
   AND (tm.team_function = "speelster" OR tm.team_function = "speler")

// De dubbelaars uitfilteren (even noteren waar member_id zelfde is)
select id, member_id, teammember_id, team_id, algemeen_naam from vcw_enquetes order by member_id, teammember_id;
// De gestopten enz ... uitfilteren
select e.teammember_id, e.algemeen_naam, tm.remark from vcw_enquetes e left join vcw_teammembers tm on tm.id = e.teammember_id where tm.remark <> "";
// Oblivio
delete from vcw_enquetes where teammember_id in (11009,11010,11011,11032,11035,11047,11056,11081,11137,11215,11216,11217,11218)
// Verwijder ze
delete from vcw_enquetes where teammember_id in (11209,11202,11203,11152,11200,11115,11116,11117,11118,11120,11123,11081,11080,11201,11208,11137)
oblivio -- (11212,11214,11203,11202,11152,11211,11200,11115,11116,11117,11118,11120,11123,11260,11080,11235,11021,11237,11022,11261,11201,11255,11256,11236,11209,11210,11213,11242,11006,11247,11269,11048,11241,11240,11246,11005,11049,11248)
On Oblivio, they were deleted in the browse window (select the doubles, the delete them)


// De dubbele email-adressen uitfilteren
SELECT algemeen_naam, mail_ik, mail_mama, mail_papa from vcw_enquetes where (mail_ik = mail_mama) or (mail_ik = mail_papa) or (mail_mama = mail_papa);
// remove duplicates when identical found
UPDATE vcw_enquetes set mail_mama = '' where mail_mama = mail_ik;
UPDATE vcw_enquetes set mail_papa = '' where mail_papa = mail_ik;
UPDATE vcw_enquetes set mail_papa = '' where mail_papa = mail_mama;
// reset empty email adresses to NULL for the CONCAT_WS (concatenate with separator) later on
UPDATE vcw_enquetes set mail_mama = NULL where mail_mama = '';
UPDATE vcw_enquetes set mail_papa = NULL where mail_papa = '';
// to check for (most of the) duplicate email adresses
SELECT algemeen_naam, mail_ik, mail_mama, mail_papa from vcw_enquetes where (mail_ik = mail_mama) or (mail_ik = mail_papa) or (mail_mama = mail_papa);


// (re)fill mailings
//check
cake page http://www.oblivio.be/www/vcw/mailings
//add
cake page http://www.oblivio.be/www/vcw/mailings/add
//edit
cake page http://www.oblivio.be/www/vcw/mailings/edit/1

// (re)fill mails
ALTER TABLE vcw_mails AUTO_INCREMENT = 1101;
// vumini -- test
// mailing_id and ml.id => id of the newly added mailing record
INSERT INTO vcw_mails
      (id, name, mailing_id, mailsubject, mailfrom, mailto, mailcc, mailbcc, mailbody, maillinkurl, maillinkmd5, mailsent, created, modified)
SELECT NULL, e.algemeen_naam, 2, ml.name, 
  'jeugd@vcwolvertem.be', e.mail_ik, REPLACE(CONCAT_WS(';', e.mail_mama, e.mail_papa), ';', ','), NULL,
  'body elsewhere', 'http://vumini/cake_vcw/enquetes/vulin', e.id, NULL, NOW(), NULL 
  FROM vcw_enquetes e LEFT JOIN vcw_mailings ml ON ml.id = 2
// oblivio -- productie
INSERT INTO vcw_mails
      (id, name, mailing_id, mailsubject, mailfrom, mailto, mailcc, mailbcc, mailbody, maillinkurl, maillinkmd5, mailsent, created, modified)
SELECT NULL, e.algemeen_naam, 2, ml.name, 
  'jeugd@vcwolvertem.be', e.mail_ik, REPLACE(CONCAT_WS(';', e.mail_mama, e.mail_papa), ';', ','), NULL,
  'body elsewhere', 'http://www.oblivio.be/www/vcw/enquetes/vulin', e.id, NULL, NOW(), NULL 
  FROM vcw_enquetes e LEFT JOIN vcw_mailings ml ON ml.id = 2


-3-- EXPORT TO CSV INTO VCW SITE ---
// export the vcw_mails table to csv, and put the csv on the VCW site

// vumini -- test
SELECT * FROM vcw_mails
 WHERE id > 1100
 INTO OUTFILE '/var/www/doorgeef/vcw_mails_2012.csv'
 FIELDS TERMINATED BY ';'
 OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";
 
// oblivio -- productie
// export the vcw_mails table to a csv -- double quotes, punt comma -- (id > 1100)
// replace ", " with "," (remove blanks after comma) and put the csv on the VCW site


-4-- DO THE MAIL ---
// empty the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2012.log
// run the mailing script at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2012_page.php


-5-- CHECK ---
// Check the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2012.log
