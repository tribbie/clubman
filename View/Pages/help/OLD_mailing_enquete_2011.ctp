<pre>
Procedure mailing enquete 2011
==============================

-1-- PREPARE TABLES---
// create vcw_enquetes table
CREATE TABLE `vcw_enquetes` (
  `id` binary(32) NOT NULL,
  `member_id` int(11) unsigned DEFAULT NULL,
  `teammember_id` int(11) unsigned DEFAULT NULL,
  `team_id` int(11) unsigned DEFAULT NULL,
  `algemeen_naam` varchar(50) DEFAULT '',
  `algemeen_ploeg` varchar(30) DEFAULT '',
  `algemeen_dubbelploeg` varchar(30) DEFAULT '',
  `algemeen_volgendseizoen` char(10) DEFAULT '',
  `training_aantal` int(2) unsigned DEFAULT '0',
  `training_di20002200` char(10) DEFAULT '',
  `training_wo17001830` char(10) DEFAULT '',
  `training_wo18302000` char(10) DEFAULT '',
  `training_do19302130` char(10) DEFAULT '',
  `training_vr17451915` char(10) DEFAULT '',
  `training_vr19152100` char(10) DEFAULT '',
  `wedstrijd_aantal` char(10) DEFAULT '',
  `studies_mindertrainen` tinyint(1) DEFAULT '0',
  `studies_opkot` tinyint(1) DEFAULT '0',
  `studies_geenwedstrijden` tinyint(1) DEFAULT '0',
  `studies_stage` tinyint(1) DEFAULT '0',
  `studies_andere` text,
  `bengels_training` char(10) DEFAULT '',
  `mail_ik` varchar(50) DEFAULT '',
  `mail_ikfrequentie` char(10) DEFAULT '',
  `mail_mama` varchar(50) DEFAULT '',
  `mail_mamafrequentie` char(10) DEFAULT '',
  `mail_papa` varchar(50) DEFAULT '',
  `mail_papafrequentie` char(10) DEFAULT '',
  `begeleiding_pvmama` tinyint(1) DEFAULT '0',
  `begeleiding_pvpapa` tinyint(1) DEFAULT '0',
  `begeleiding_pvandere` varchar(50) DEFAULT '',
  `organisatie_naam` varchar(50) DEFAULT '',
  `organisatie_taak` varchar(30) DEFAULT '',
  `diversen_tekst` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)
// create mailings table
CREATE TABLE `vcw_mailings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `body` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)
// create mails table
CREATE TABLE `vcw_mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `mailing_id` int(11) NOT NULL,
  `mailsubject` varchar(150) DEFAULT NULL,
  `mailfrom` varchar(50) DEFAULT NULL,
  `mailto` varchar(64) DEFAULT NULL,
  `mailcc` varchar(128) DEFAULT NULL,
  `mailbcc` varchar(64) DEFAULT NULL,
  `mailbody` text,
  `maillinkurl` varchar(100) DEFAULT NULL,
  `maillinkmd5` varchar(48) DEFAULT NULL,
  `mailsent` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)


-2-- FILL TABLES ---
// (re)fill enquetes
DELETE FROM vcw_enquetes;
// Alle spelers en speelsters -- daarna maar even de dubbels uithalen
INSERT INTO vcw_enquetes (id, member_id, teammember_id, team_id, algemeen_naam, algemeen_ploeg, mail_ik, mail_mama, mail_papa)
SELECT MD5(CONCAT('1',tm.id,tm.member_name,tm.member_id)) uid, tm.member_id, tm.id, tm.team_id, tm.member_name, t.name, m.email, m.email_mama, m.email_papa
 FROM vcw_teammembers tm
 left join vcw_teams t on t.id = tm.team_id
 left join vcw_members m on m.id = tm.member_id
 WHERE team_id < 14
   AND (tm.team_function = "speelster" OR tm.team_function = "speler")
   AND (tm.id not in (191,213,5,15,16,7,214,8,11,18,224))
// to check for (most of the) duplicate email adresses
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

// (re)fill mailings and mails
DELETE FROM vcw_mailings;
DELETE FROM vcw_mails;

// (re)fill mailings
//check
cake page http://www.oblivio.be/www/vcw/mailings
//add
cake page http://www.oblivio.be/www/vcw/mailings/add
//edit
cake page http://www.oblivio.be/www/vcw/mailings/edit/1

// (re)fill mails
// vumini -- test
INSERT INTO vcw_mails
      (id, name, mailing_id, mailsubject, mailfrom, mailto, mailcc, mailbcc, mailbody, maillinkurl, maillinkmd5, mailsent, created, modified)
SELECT NULL, e.algemeen_naam, 1, ml.name, 
  'jeugd@vcwolvertem.be', e.mail_ik, REPLACE(CONCAT_WS(';', e.mail_mama, e.mail_papa), ';', ','), NULL,
  'body elsewhere', 'http://vumini/cake_vcw/enquetes/vulin', e.id, NULL, NOW(), NULL 
  FROM vcw_enquetes e LEFT JOIN vcw_mailings ml ON ml.id = 1
// oblivio -- productie
INSERT INTO vcw_mails
      (id, name, mailing_id, mailsubject, mailfrom, mailto, mailcc, mailbcc, mailbody, maillinkurl, maillinkmd5, mailsent, created, modified)
SELECT NULL, e.algemeen_naam, 1, ml.name, 
  'jeugd@vcwolvertem.be', e.mail_ik, REPLACE(CONCAT_WS(';', e.mail_mama, e.mail_papa), ';', ','), NULL,
  'body elsewhere', 'http://www.oblivio.be/www/vcw/enquetes/vulin', e.id, NULL, NOW(), NULL 
  FROM vcw_enquetes e LEFT JOIN vcw_mailings ml ON ml.id = 1


-3-- EXPORT TO CSV INTO VCW SITE ---
// vumini -- test
// export the vcw_mails table to csv, and put the csv on the VCW site
SELECT * FROM vcw_mails
 INTO OUTFILE '/var/www/doorgeef/vcw_mails.csv'
 FIELDS TERMINATED BY ';'
 OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";
// oblivio -- productie
// export the vcw_mails table to a csv
// replace ", " with "," (remove blanks after comma) and put the csv on the VCW site


-4-- DO THE MAIL ---
// empty the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2011.log
// run the mailing script at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2011_page.php


-5-- CHECK ---
Check the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2011.log
