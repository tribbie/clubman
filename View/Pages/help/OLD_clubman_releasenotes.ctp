<h1>De VCW mysql database</h1>
<br>

<script>
function showhide(id) {
	if (document.getElementById) {
		obj = document.getElementById(id);
		if (obj.style.display == "none") {
			obj.style.display = "";
		} else {
			obj.style.display = "none";
		}
	}
}
</script>

<br/>
Nuttige MySQL statements en procedures ...<br/>
<br/>

<hr/>
<hr/>

<br/>

<a href="#" title="Version 0.5" onclick="showhide('rel05'); return(false)">Clubman v0.5 - Release for season 2016-2017</a>
<div style='display: none;' id='rel05'>
<div class='coolinfobox'>
verversen leden in vcw_members<br/>
<?php echo $this->Html->link('vcw_members_refresh', array('controller' => 'pages', 'action' => 'vcw_members_refresh'));?>
</div>
<hr>
</div>
<br/>


<a href="#" title="add games" onclick="showhide('item02'); return(false)">*** Toevoegen wedstrijden</a><br/>
<div style='display: none;' id='item02'>
<div class='coolinfobox'>
invullen wedstrijden in vcw_games<br/>
<?php echo $this->Html->link('vcw_games_add', array('controller' => 'pages', 'action' => 'vcw_games_add'));?>
</div>
<hr>
</div>
<br/>


<a href="#" title="referees" onclick="showhide('item03'); return(false)">*** Invullen scheidsrechters</a><br/>
<div style='display: none;' id='item03'>
<div class='coolinfobox'>
invullen schijdsrechters in vcw_games<br/>
<?php echo $this->Html->link('vcw_referees', array('controller' => 'pages', 'action' => 'vcw_referees'));?>
</div>
<hr>
</div>
<br/>


<a href="#" title="games 4 google" onclick="showhide('item04'); return(false)">*** Wedstrijden naar google calendar</a><br/>
<div style='display: none;' id='item04'>
<div class='coolinfobox'>
wedstrijden naar google calendar<br/>
<?php echo $this->Html->link('vcw_calendar_for_google', array('controller' => 'pages', 'action' => 'vcw_calendar_for_google'));?>
</div>
<hr>
</div>
<br/>


<a href="#" title="mailing" onclick="showhide('item05'); return(false)">*** Mailing (enquete 2011) voorbereiden</a><br/>
<div style='display: none;' id='item05'>
<div class='coolinfobox'>
mailing (enquete 2011) voorbereiden<br/>
<?php echo $this->Html->link('vcw_mailing_enquete_2011', array('controller' => 'pages', 'action' => 'vcw_mailing_enquete_2011'));?>
</div>
<hr>
</div>
<br/>


<a href="#" title="examples" onclick="showhide('item10'); return(false)">*** ALTER TABLE voorbeelden</a><br/>
<div style='display: none;' id='item10'>
<div class='coolinfobox'>
Verschillende voorbeelde om de structuur van een table aan te passen<br/>
<pre>
ALTER TABLE vcw_teams DROP trainer;
ALTER TABLE vcw_teammembers ADD remark VARCHAR(50) DEFAULT NULL AFTER team_priority;
ALTER TABLE vcw_teammembers CHANGE remark remark VARCHAR(50) DEFAULT NULL;
ALTER TABLE vcw_teams ADD remark VARCHAR(50) DEFAULT NULL AFTER home_game;
ALTER TABLE vcw_teams ADD team_type enum('volley','omkadering') DEFAULT NULL AFTER period;
ALTER TABLE vcw_teammembers_trainings AUTO_INCREMENT=0;
</pre>
</div>
<hr>
</div>
<br/>


<a href="#" title="alter trainings" onclick="showhide('item11'); return(false)">*** Korte trainingen aanpassen</a><br/>
<div style='display: none;' id='item11'>
<div class='coolinfobox'>
Korte trainingen aanpassen<br/>
<pre>
UPDATE cm_trainings SET end_time = '19:00:00'
 WHERE (
     (start_time = '17:45:00')
 AND (season = '2015-2016')
 AND (
     start_date = '2010-09-24' OR
     ...
     start_date = '2011-04-15' OR
     start_date = '2011-04-29'
 )
);

UPDATE cm_trainings SET start_time='19:00:00', end_time='20:00:00'
 WHERE (
     (start_time = '19:15:00')
 AND (season = '2015-2016')
 AND (
     start_date = '2010-09-24' OR
     ...
     start_date = '2011-04-15' OR
     start_date = '2011-04-29'
 )
);

seizoen 2015-2016:

UPDATE cm_trainings SET end_time='20:00:00', remark='korte training'
 WHERE (
     (season = '2015-2016')
 AND (trainingmoment_id = 6)
 AND (start_time = '19:00:00')
 AND (
     start_date = '2015-08-21' OR
     start_date = '2015-09-04' OR
     start_date = '2015-09-18' OR
     start_date = '2015-10-09' OR
     start_date = '2015-10-16' OR
     start_date = '2015-10-30' OR
     start_date = '2015-11-13' OR
     start_date = '2015-11-27' OR
     start_date = '2016-02-05' OR
     start_date = '2016-02-19' OR
     start_date = '2016-03-04' OR
     start_date = '2016-03-18' OR
     start_date = '2016-04-01' OR
     start_date = '2016-04-29'
 )
);

</pre>
</div>
<hr>
</div>
<br/>


<a href="#" title="initialize presences" onclick="showhide('item12'); return(false)">*** De aanwezigheden op wedstrijden initializeren</a><br/>
<div style='display: none;' id='item12'>
<div class='coolinfobox'>
De aanwezigheden op wedstrijden initializeren<br/>
-- de aanwezigheden op wedstrijden "aan"-zetten<br/>
-- Neem team x -- bv. test -- id = 15000026<br/>
<br/>
-- 1/ check of er al aanwezigheden zijn voor dat team
<pre>
SELECT gtm.id presid, t.id tid, t.name, g.id gameid, g.game_date, gtm.teammember_id, gtm.season, gtm.status, gtm.created
 FROM cm_gamesteammembers gtm
 LEFT JOIN cm_games g on gtm.game_id = g.id
 LEFT JOIN cm_teams t on g.team_id = t.id
 WHERE g.season = '2015-2016'
 AND t.id = 15000026
</pre>

-- 2/ Zoveel zouden het in totaal moeten zijn
<pre>
SET SQL_BIG_SELECTS=1;
SELECT gtm.id, g.team_id tid, t.name, tm.id tmid, tm.teampriority, g.id gid, g.game_date, NOW()
 FROM cm_teammembers tm
 LEFT JOIN cm_teams t on tm.team_id = t.id
 LEFT JOIN cm_games g on tm.team_id = g.team_id
 LEFT JOIN cm_gamesteammembers gtm on (tm.id = gtm.teammember_id) and (g.id = gtm.game_id)
 WHERE g.season = "2015-2016"
 AND tm.teampriority > 0
 AND tm.teampriority < 99
 AND t.id = 15000026
</pre>

-- 3/ Zoveel zouden er dan bij in moeten komen
<pre>
SET SQL_BIG_SELECTS=1;
SELECT tm.id tmid, g.id gameid, '2015-2016', 'aanwezig', NOW()
 FROM cm_teammembers tm
 LEFT JOIN cm_teams t on tm.team_id = t.id
 LEFT JOIN cm_games g on tm.team_id = g.team_id
 LEFT JOIN cm_gamesteammembers gtm on (tm.id = gtm.teammember_id) and (g.id = gtm.game_id)
 WHERE g.season = "2015-2016"
 AND tm.teampriority > 0
 AND tm.teampriority < 99
 AND gtm.id IS NULL
 AND t.id = 15000026
</pre>

-- 4/ Volgende zal nieuwe aanwezigheden initializeren op 'aanwezig' zonder bestaande te overschrijven
<pre>
SET SQL_BIG_SELECTS=1;
INSERT INTO cm_gamesteammembers (teammember_id, game_id, season, status, created)
 SELECT tm.id tmid, g.id gameid, '2015-2016', 'aanwezig', NOW()
 FROM cm_teammembers tm
 LEFT JOIN cm_teams t on tm.team_id = t.id
 LEFT JOIN cm_games g on tm.team_id = g.team_id
 LEFT JOIN cm_gamesteammembers gtm on (tm.id = gtm.teammember_id) and (g.id = gtm.game_id)
 WHERE g.season = "2015-2016"
 AND tm.teampriority > 0
 AND tm.teampriority < 99
 AND gtm.id IS NULL
 AND t.id = 15000026
</pre>

-- Volgende zal bestaande aanwezigheden met blanko status op 'aanwezig' zetten
<pre>
SELECT season, teammember_id, game_id, status FROM cm_gamesteammembers WHERE id >= 15000000 AND id < 16000000 AND status = '';
UPDATE cm_gamesteammembers SET status = 'aanwezig' WHERE id >= 15000000 AND id < 16000000 AND status = '';
</pre>

-- Volgende zal bestaande seizoen (2015-2016) invullen waar het niet is ingevuld
<pre>
SELECT season, teammember_id, game_id, status FROM cm_gamesteammembers WHERE id >= 15000000 AND id < 16000000 AND season is null;
UPDATE cm_gamesteammembers SET season = '2015-2016' WHERE id >= 15000000 AND id < 16000000 AND season is null;
</pre>
</div>
<hr>
</div>
<br/>


<a href="#" title="fill in referees" onclick="showhide('item13'); return(false)">*** Invullen scheidsrechters in table vcw_games (old)</a><br/>
<div style='display: none;' id='item13'>
<div class='coolinfobox'>
invullen scheidsrechters in table vcw_games (via temporary table)<br/>
<pre>
CREATE TABLE vcw_tempref (game_id INT(11) UNSIGNED, referee VARCHAR(50));

LOAD DATA INFILE '/var/www/doorgeef/vcw_database/vcw_referees_01.csv'
 INTO TABLE vcw.vcw_tempref
 FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";

UPDATE vcw_games g
 LEFT JOIN vcw_tempref r ON r.game_id = g.id
 SET g.game_referee = r.referee
 WHERE r.game_id = g.id

SELECT g.id, r.game_id, r.referee
 FROM vcw_games g
 LEFT JOIN vcw_tempref r ON r.game_id = g.id
 WHERE r.game_id = g.id
</pre>
</div>
<hr>
</div>
<br/>


<a href="#" title="fill teammembers" onclick="showhide('item14'); return(false)">*** Invullen membernamen en licenties in vcw_teammembers</a><br/>
<div style='display: none;' id='item14'>
<div class='coolinfobox'>
Invullen membernamen en licenties in vcw_teammembers<br/>
<pre>
SELECT tm.id, tm.member_id, tm.member_name, tm.member_license, m.naam, m.voornaam, m.vvb_licentie, m.id
FROM vcw_teammembers tm
LEFT JOIN vcw_members m ON m.id = tm.member_id
WHERE tm.member_name = ""
OR tm.member_license = "";

UPDATE vcw_teammembers tm
 LEFT JOIN vcw_members m ON m.id = tm.member_id
 SET tm.member_name = CONCAT(m.naam, ' ', m.voornaam)
 WHERE tm.member_name = ""

UPDATE vcw_teammembers tm
 LEFT JOIN vcw_members m ON m.id = tm.member_id
 SET tm.member_license = m.vvb_licentie
 WHERE tm.member_license = ""
</pre>
</div>
<hr>
</div>
<br/>


<a href="#" title="fill in coaches" onclick="showhide('item15'); return(false)">*** Invullen coach in table vcw_games</a><br/>
<div style='display: none;' id='item15'>
<div class='coolinfobox'>
Invullen coach_id (from vcw_teammembers) in table vcw_games<br/>
<pre>
SELECT team_id, id, member_name, team_function
 FROM vcw_teammembers
 WHERE team_function <> "speler"
 AND team_function <> "speelster"
 AND team_id=3;

--- 2010 - 2011 ---

UPDATE vcw_games SET game_coach_id = 140 WHERE game_coach_id IS NULL AND team_id = 3;
UPDATE vcw_games SET game_coach_id = 153 WHERE game_coach_id IS NULL AND team_id = 4;
UPDATE vcw_games SET game_coach_id = 161 WHERE game_coach_id IS NULL AND team_id = 5;
UPDATE vcw_games SET game_coach_id = 165 WHERE game_coach_id IS NULL AND team_id = 6;
UPDATE vcw_games SET game_coach_id = 172 WHERE game_coach_id IS NULL AND team_id = 7;
UPDATE vcw_games SET game_coach_id = 176 WHERE game_coach_id IS NULL AND team_id = 8;
UPDATE vcw_games SET game_coach_id = 181 WHERE game_coach_id IS NULL AND team_id = 9;

UPDATE vcw_games SET game_coach_id = 192 WHERE game_coach_id IS NULL AND team_id = 12;
UPDATE vcw_games SET game_coach_id = 197 WHERE game_coach_id IS NULL AND team_id = 13;

UPDATE vcw_games SET game_coach_id = 202 WHERE game_coach_id IS NULL AND team_id = 15;

--- check ---

select team_id, game_coach_id, count(team_id) from vcw_games group by team_id, game_coach_id;

</pre>
</div>
<hr>
</div>
<br/>


<a href="#" title="generate trainings" onclick="showhide('item16'); return(false)">*** Trainingen genereren</a><br/>
<div style='display: none;' id='item16'>
<div class='coolinfobox'>
De trainingen kunnen gegenereerd worden door een php script<br/>
<pre>
http://vumini/oblivio/prive/mysql/vcw_generate_trainings.php
</pre>
</div>
<hr>
</div>
<br/>


<a href="#" title="archive payments" onclick="showhide('item18'); return(false)">*** Archivering betalingen lidgeld en kamp leden ...</a><br/>
<div style='display: none;' id='item18'>
<div class='coolinfobox'>
<pre>
CREATE TABLE `cm_memberarchives` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) unsigned DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `licensenumber` varchar(20) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `membershipfee` int(11) unsigned DEFAULT NULL,
  `membershipfee_discount` int(11) unsigned DEFAULT NULL,
  `membership_advancepaid` date DEFAULT NULL,
  `membership_balancepaid` date DEFAULT NULL,
  `camp` tinyint(1) DEFAULT '0',
  `campfee` int(11) unsigned DEFAULT NULL,
  `camp_advance` date DEFAULT NULL,
  `camp_balance` date DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `nickname` varchar(40) DEFAULT NULL,
  `remark` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)
</pre>
copy over from members table to archive ...
<br/>
<pre>
INSERT INTO cm_memberarchives
 (member_id, lastname, firstname, licensenumber, birthdate,
  membershipfee, membershipfee_discount, membership_advancepaid, membership_balancepaid,
  camp, campfee, camp_advance, camp_balance,
  active, nickname, remark)
  SELECT id, lastname, firstname, licensenumber, birthdate,
         membershipfee, membershipfee_discount, membership_advancepaid, membership_balancepaid,
         camp, campfee, camp_advance, camp_balance,
         active, nickname, remark
  FROM cm_members;

  UPDATE cm_memberarchives set created = NOW() where created is null;
</pre>
Resetten van de kamp info in de members table ...
<br/>
<pre>
  UPDATE cm_members set camp = 0, campfee = NULL, camp_advance = NULL, camp_balance = NULL WHERE 1;
  UPDATE cm_members set campfee = 195 where YEAR(birthdate) <= 2006 AND YEAR(birthdate) >= 1996 AND active = 1;
</pre>
Resetten van de lidgeld info in de members table ...
<br/>
<pre>
  UPDATE cm_members set membershipfee = 0, membershipfee_discount = 0, membership_advancepaid = NULL, membership_balancepaid = NULL WHERE 1;
  nog te doen
  UPDATE cm_members set membershipfee = 180 where [[jeugdspeler = 1]] AND active = 1;
  UPDATE cm_members set membershipfee = 210 where [[seniorspeler = 1]] AND active = 1;
</pre>
Tables leeg te maken voor nieuw seizoen ...
<br/>
<pre>
  Eerst backup!
*	cm_games			321	MyISAM	utf8_general_ci	59.1 KiB	-
*	cm_gamesteammembers		3,059	MyISAM	utf8_general_ci	176.9 KiB	20 B
*	cm_teammembers			240	MyISAM	utf8_general_ci	17.8 KiB	-
*	cm_teams			18	MyISAM	utf8_general_ci	5.1 KiB	-
	cm_trainingmoments		10	MyISAM	utf8_general_ci	2.5 KiB	-
*	cm_trainingmomentsteammembers	0	MyISAM	utf8_general_ci	1 KiB	-
*	cm_trainingmomentsteams		26	MyISAM	utf8_general_ci	3.2 KiB	96 B
*	cm_trainings			1,063	MyISAM	utf8_general_ci	99.9 KiB	-
*	cm_trainingsteammembers		8,347	MyISAM	utf8_general_ci	458.8 KiB	-
</pre>
</div>
<hr>
</div>
<br/>



<hr/>
<hr/>

<br/>

<a href="#" title="and more ..." onclick="showhide('item50'); return(false)">*** En nog wat ...</a><br/>
<div style='display: none;' id='item50'>
<div class='coolinfobox'>
En nog wat ...<br/>
<pre>
SELECT * FROM vcw_trainings
 INTO OUTFILE '/var/www/doorgeef/vcw_trainings.csv'
 FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";

SELECT * FROM vcw_users
 INTO OUTFILE '/var/www/doorgeef/vcw_users.csv'
 FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";

LOAD DATA INFILE '/var/www/doorgeef/vcw_database/vanMarleen/import_persons.csv'
 INTO TABLE vcw.vcw_persons
 FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";
</pre>
</div>
<hr>
</div>
<br/>


<hr/>
<hr/>
