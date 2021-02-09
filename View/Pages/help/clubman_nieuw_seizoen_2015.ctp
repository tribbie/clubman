<h1>VCW Clubman db -- new season todo</h1>
<br/>
<hr/>
<br/>
<?= $this->Html->link('Check some Clubman database stuff', array('controller' => 'pages', 'action' => 'vcw_database'))."<br/>\n"; ?>
<br/>
<hr/>
<pre>
                                    Archief #1     Archief #2     Archief #2
                                    2014-03-14     2014-06-09	  2015-06-05

camp advance paid last date         2013-08-13     2014-04-15     info lost (removed before archiveing)
camp balance paid last date         2013-09-27     2014-04-07     info lost (removed before archiveing)

fee advance paid last date          2013-12-18     2014-04-09
fee balance paid last date          2013-12-18     2014-04-09

Op 2014-06-09 begonnen met initializeren nieuw seizoen (2014-2015)
Op 2015-06-05 begonnen met initializeren nieuw seizoen (2015-2016)
</pre>

<hr/>

<h4>High level:</h4>
0. backup database<br/>
1. archiveer members (payments)<br/>
2. resetten lidgeld (naar 0) en betaaldatums (naar NULL) -- NIET dat van het kamp!!<br/>
3. aanpassen config/bootstrap.php<br/>
   Configure::write('Clubman.currentseason', '2015-2016');<br/>
4. instellen auto-increment voor nieuw seizoen bij deze seizoensgebonden tables (zie verder)<br/>
   -> waarde (YY000001) -> want INT(11) ==> -2147483648 min and 2147483648 max<br/>
   -> dit voor het geval we ooit via seizoen gaan werken, en we dus bij een nieuw seizoen gewoon de auto-increment moeten aanpassen (zonder de tables leeg te maken) <br/>
5. Nieuwe teams toevoegen (Jurgen)<br/>
6. Nieuwe teammembers toevoegen (Jurgen)<br/>
7. Nu kan je de lidgelden voorinvullen (180 jeugd, 210 senior)<br/>
   -> als "seizoen" is geïmplementeerd, dan zou ik deze financiële data in een aparte table steken (zowel voor lidgeld als voor kamp)<br/>
8. De rest kan nu ook ingevuld worden<br/>
   8.1. cm_trainingmomentsteams<br/>
   8.2. cm_trainings<br/>
   8.3. cm_games<br/>
<br/>

<hr/>

<h4># Archivering leden (payments).</h4>
Copy over from members table to archive ... <br/>
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
</pre>
<br/>

Set date<br/>
<pre>
  UPDATE cm_memberarchives set created = NOW() where created is null;
</pre>
<br/>

<hr/>

<h4># Resetten lidgeld (naar 0) en betaaldatums (naar NULL).</h4>
<pre>
Resetten van de kamp info in de members table ... 
  UPDATE cm_members set camp = 0, campfee = NULL, camp_advance = NULL, camp_balance = NULL WHERE 1;
  UPDATE cm_members set campfee = 195 where YEAR(birthdate) <= 2006 AND YEAR(birthdate) >= 1996 AND active = 1;
</pre>
<br/>
Resetten van de lidgeld info in de members table ... <br/>
<pre>
 indien de prijs niet wijzigt
  UPDATE cm_members set membership_advancepaid = NULL, membership_balancepaid = NULL WHERE 1;
 indien de prijs wel wijzigt
  UPDATE cm_members set membershipfee = 0, membershipfee_discount = 0, membership_advancepaid = NULL, membership_balancepaid = NULL WHERE 1;
  nog te doen
  UPDATE cm_members set membershipfee = 180 where [[jeugdspeler = 1]] AND active = 1;
  UPDATE cm_members set membershipfee = 210 where [[seniorspeler = 1]] AND active = 1;
</pre>
<br/>

<hr/>

<h4># Volgende tables bevatten seizoensafhankelijke records.</h4>
<pre>
 table cm_gamesteammembers;
 table cm_games;
 table cm_trainingsteammembers;
 table cm_trainings;
 table cm_teammembers;
 table cm_teams;
 table cm_trainingmomentsteammembers;
 table cm_trainingmomentsteams;
</pre>
<br/>

<hr/>

<h4># Initializeer auto-increment voor nieuw seizoen: - done</h4>
<pre>
ALTER TABLE cm_games AUTO_INCREMENT = 15000001;
ALTER TABLE cm_gamesteammembers AUTO_INCREMENT = 15000001;
ALTER TABLE cm_teammembers AUTO_INCREMENT = 15000001;
ALTER TABLE cm_teams AUTO_INCREMENT = 15000001;
ALTER TABLE cm_trainingmomentsteammembers AUTO_INCREMENT = 15000001;
ALTER TABLE cm_trainingmomentsteams AUTO_INCREMENT = 15000001;
ALTER TABLE cm_trainings AUTO_INCREMENT = 15000001;
ALTER TABLE cm_trainingsteammembers AUTO_INCREMENT = 15000001;
# bijkomend ook best ...
ALTER TABLE cm_efforts AUTO_INCREMENT = 15000001;
ALTER TABLE cm_enquetes AUTO_INCREMENT = 15000001;
ALTER TABLE cm_meterings AUTO_INCREMENT = 15000001;
ALTER TABLE cm_pictures AUTO_INCREMENT = 15000001;
ALTER TABLE cm_uploads AUTO_INCREMENT = 15000001;
</pre>
<br/>

<hr/>

<h4># De aanwezigheden op wedstrijden initializeren</h4>
-- de aanwezigheden op wedstrijden "aan"-zetten<br/>
-- Neem team x -- bv. test -- id = <strong>15000026</strong><br/>
-- Vermenigvuldig het aantal spelers ( 0 > prio > 99) met het aantal wedstrijden<br/>
<br/>

<h5>-- 1/ check of er al aanwezigheden zijn voor dat team (tot nu toe -- ter info)</h5>
<pre>
SELECT gtm.id presid, t.id tid, t.name, g.id gameid, g.game_date, gtm.teammember_id, gtm.season, gtm.status, gtm.created
 FROM cm_gamesteammembers gtm
 LEFT JOIN cm_games g on gtm.game_id = g.id
 LEFT JOIN cm_teams t on g.team_id = t.id
 WHERE g.season = <strong>'2015-2016'</strong>
 AND t.id = <strong>15000026</strong>
</pre>

<h5>-- 2/ Zoveel zouden het in totaal moeten zijn (gans het seizoen -- ter info)</h5>
<pre>
SET SQL_BIG_SELECTS=1;
SELECT gtm.id, g.team_id tid, t.name, tm.id tmid, tm.teampriority, g.id gid, g.game_date, NOW()
 FROM cm_teammembers tm
 LEFT JOIN cm_teams t on tm.team_id = t.id
 LEFT JOIN cm_games g on tm.team_id = g.team_id
 LEFT JOIN cm_gamesteammembers gtm on (tm.id = gtm.teammember_id) and (g.id = gtm.game_id)
 WHERE g.season = <strong>"2015-2016"</strong>
 AND tm.teampriority > 0
 AND tm.teampriority < 99
 AND t.id = <strong>15000026</strong>
</pre>

<h5>-- 3/ Zoveel zouden er dan bij in moeten komen (deze zullen dus toegevoegd worden -- ter voorbereiding)</h5>
<pre>
SET SQL_BIG_SELECTS=1;
SELECT tm.id tmid, g.id gameid, <strong>'2015-2016'</strong>, 'aanwezig', NOW()
 FROM cm_teammembers tm
 LEFT JOIN cm_teams t on tm.team_id = t.id
 LEFT JOIN cm_games g on tm.team_id = g.team_id
 LEFT JOIN cm_gamesteammembers gtm on (tm.id = gtm.teammember_id) and (g.id = gtm.game_id)
 WHERE g.season = <strong>"2015-2016"</strong>
 AND tm.teampriority > 0
 AND tm.teampriority < 99
 AND g.game_date > <strong>"2016-01-01"</strong>
 AND gtm.id IS NULL
 AND t.id = <strong>15000026</strong>
</pre>

<h5>-- 4/ Volgende zal nieuwe aanwezigheden initializeren op 'aanwezig' zonder bestaande te overschrijven (DIT IS DE TOEVOEGING)</h5>
<pre>
SET SQL_BIG_SELECTS=1;
INSERT INTO cm_gamesteammembers (teammember_id, game_id, season, status, created)
 SELECT tm.id tmid, g.id gameid, <strong>'2015-2016'</strong>, 'aanwezig', NOW()
 FROM cm_teammembers tm
 LEFT JOIN cm_teams t on tm.team_id = t.id
 LEFT JOIN cm_games g on tm.team_id = g.team_id
 LEFT JOIN cm_gamesteammembers gtm on (tm.id = gtm.teammember_id) and (g.id = gtm.game_id)
 WHERE g.season = <strong>"2015-2016"</strong>
 AND tm.teampriority > 0
 AND tm.teampriority < 99
 AND g.game_date > <strong>"2016-01-01"</strong>
 AND gtm.id IS NULL
 AND t.id = <strong>15000026</strong>
</pre>

<h5>-- Volgende zal bestaande aanwezigheden met blanko status op 'aanwezig' zetten</h5>
<pre>
SELECT season, teammember_id, game_id, status FROM cm_gamesteammembers WHERE id >= 15000000 AND id < 16000000 AND status = '';
UPDATE cm_gamesteammembers SET status = 'aanwezig' WHERE id >= 15000000 AND id < 16000000 AND status = '';
</pre>

<h5>-- Volgende zal bestaande seizoen (2015-2016) invullen waar het niet is ingevuld</h5>
<pre>
SELECT season, teammember_id, game_id, status FROM cm_gamesteammembers WHERE id >= 15000000 AND id < 16000000 AND season is null;
UPDATE cm_gamesteammembers SET season = '2015-2016' WHERE id >= 15000000 AND id < 16000000 AND season is null;
</pre>
<hr/>


