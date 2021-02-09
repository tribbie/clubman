<pre>
Procedure mailing enquete seniors 2012
======================================

-1-- PREPARE TABLES---
// Maak maar een nieuwe table vcw_enqueteseniors per jaar (dit omdat hier en daar al eens een veld bijkomt/weggaat).
// Eerst de oude dus renamen (naar vcw_enqueteseniorYYYYs -- rare naam, maar zo blijft het bruikbaar in CAKEPHP)
CREATE TABLE `vcw_enqueteseniors` (
  `id` binary(32) NOT NULL,
  `member_id` int(11) unsigned DEFAULT NULL,
  `teammember_id` int(11) unsigned DEFAULT NULL,
  `team_id` int(11) unsigned DEFAULT NULL,
  `algemeen_naam` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `algemeen_mail` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `algemeen_ploeg` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `algemeen_dubbelploeg` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `algemeen_volgendseizoen` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `training_aantal` int(2) unsigned DEFAULT '0',
  `training_di20002200` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `training_do20002200` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `training_vr19152100` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `wedstrijd_aantal` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `wedstrijd_recreatie` char(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '',
  `diversen_tekst` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

// create mailings table -- niet meer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks 1 record bij)

// create mails table    -- niet meer nodig (wijzigt normaal niet meer qua structuur, hier maken we straks de nodige records bij

// Vul de enquetes vooraf met de gekende gegevens (naam, email adressen en zo ...)
// Vooraan de MD5 zet je misschien best het jaartal of een of ander volgnummer)
INSERT INTO vcw_enqueteseniors (id, member_id, teammember_id, team_id, algemeen_naam, algemeen_mail, algemeen_ploeg)
SELECT MD5(CONCAT('2012',tm.id,tm.member_name,tm.member_id)) uid, tm.member_id, tm.id, tm.team_id, tm.member_name, m.email, t.name
 FROM vcw_teammembers tm
 left join vcw_teams t on t.id = tm.team_id
 left join vcw_members m on m.id = tm.member_id
 WHERE tm.team_id in (1115,1116,1117)
   AND (tm.team_function = "speelster" OR tm.team_function = "speler")

// De dubbelaars uitfilteren (even noteren waar member_id zelfde is)
select id, member_id, teammember_id, team_id, algemeen_naam from vcw_enqueteseniors order by member_id, teammember_id;
// De gestopten enz ... uitfilteren
select e.teammember_id, e.algemeen_naam, tm.remark from vcw_enqueteseniors e left join vcw_teammembers tm on tm.id = e.teammember_id where tm.remark <> "";
// Verwijder ze
delete from vcw_enqueteseniors where teammember_id in (11209,11202,11203,11152,11200,11115,11116,11117,11118,11120,11123,11081,11080,11201,11208,11137)
oblivio -- (11212,11214,11203,11202,11152,11211,11200,11115,11116,11117,11118,11120,11123,11260,11080,11235,11021,11237,11022,11261,11201,11255,11256,11236,11209,11210,11213,11242,11006,11247,11269,11048,11241,11240,11246,11005,11049,11248)
On Oblivio, they were deleted in the browse window (select the doubles, the delete them)


SELECT algemeen_naam, algemeen_mail from vcw_enqueteseniors where (algemeen_mail = '') or (algemeen_mail IS NULL);


// (re)fill mailings
//check
cake page http://www.oblivio.be/www/vcw/mailings
//add
cake page http://www.oblivio.be/www/vcw/mailings/add
//edit
cake page http://www.oblivio.be/www/vcw/mailings/edit/1
<a href='%%maillinkurl%%/%%maillinkmd5%%'>Link naar je vragenlijst</a><br/>

// (re)fill mails
ALTER TABLE vcw_mails AUTO_INCREMENT = 1101;
// vumini -- test
// mailing_id and ml.id => id of the newly added mailing record
INSERT INTO vcw_mails
      (id, name, mailing_id, mailsubject, mailfrom, mailto, mailcc, mailbcc, mailbody, maillinkurl, maillinkmd5, mailsent, created, modified)
SELECT NULL, e.algemeen_naam, 3, ml.name, 
  'voorzitter@vcwolvertem.be', e.algemeen_mail, NULL, NULL,
  'body elsewhere', 'http://vumini/cake_vcw/enqueteseniors/vulin', e.id, NULL, NOW(), NULL 
  FROM vcw_enqueteseniors e LEFT JOIN vcw_mailings ml ON ml.id = 3
// oblivio -- productie
INSERT INTO vcw_mails
      (id, name, mailing_id, mailsubject, mailfrom, mailto, mailcc, mailbcc, mailbody, maillinkurl, maillinkmd5, mailsent, created, modified)
SELECT NULL, e.algemeen_naam, 3, ml.name, 
  'voorzitter@vcwolvertem.be', e.algemeen_mail, NULL, NULL,
  'body elsewhere', 'http://www.oblivio.be/www/vcw/enqueteseniors/vulin', e.id, NULL, NOW(), NULL 
  FROM vcw_enqueteseniors e LEFT JOIN vcw_mailings ml ON ml.id = 3


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
Check the log file at http://www.vcwolvertem.be/vcwmailings/vcw_enquete_2012.log
