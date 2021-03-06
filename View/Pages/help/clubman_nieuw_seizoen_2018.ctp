<h2>VCW Clubman db -- new season todo</h2>

<hr/>
<br/>
<?= $this->Html->link('Check some Clubman database stuff', array('controller' => 'help', 'action' => 'database'))."<br/>\n"; ?>
<br/>


<hr/>
<h3>Historiek:</h3>
<p>
Archieven te vinden in volley / web / clubman / archief
</p>

<div>
  <table class="table">
    <tr>
      <th>Archief #</th>
      <th>Date archive</th>
      <th>camp advance paid last date</th>
      <th>camp balance paid last date</th>
      <th>fee advance paid last date</th>
      <th>fee balance paid last date</th>
    </tr>
    <tr>
      <td>#1</td>
      <td>2014-03-14</td>
      <td>2013-08-13</td>
      <td>2013-09-27</td>
      <td>2013-12-18</td>
      <td>2013-12-18</td>
    </tr>
    <tr>
      <td>#2</td>
      <td>2014-06-09</td>
      <td>2014-04-15</td>
      <td>2014-04-07</td>
      <td>2014-04-09</td>
      <td>2014-04-09</td>
    </tr>
    <tr>
      <td>#3</td>
      <td>2015-06-05</td>
      <td>2015-08-18</td>
      <td>2015-08-18</td>
      <td>?</td>
      <td>?</td>
    </tr>
    <tr>
      <td>#4</td>
      <td>2016-06-14</td>
      <td>?</td>
      <td>?</td>
      <td>2015-10-20</td>
      <td>2015-10-20</td>
    </tr>
    <tr>
      <td>#5</td>
      <td>2017-06-04</td>
      <td>-</td>
      <td>-</td>
      <td>2016-08-16</td>
      <td>2016-12-15</td>
    </tr>
    <tr>
      <td>#6</td>
      <td>2018-06-06</td>
      <td>-</td>
      <td>-</td>
      <td>NULL</td>
      <td>NULL</td>
    </tr>
  </table>
</div>

<div>
  <pre>
    Op 2014-06-09 begonnen met initializeren nieuw seizoen (2014-2015)
    Op 2015-06-05 begonnen met initializeren nieuw seizoen (2015-2016)
    Op 2016-06-11 begonnen met initializeren nieuw seizoen (2016-2017)
    - mailke gestuurd naar Anne en Marleen om eens af te stemmen
    - Marleen wil liever niets meer VCW doen
    Op 2017-06-04 begonnen met initializeren nieuw seizoen (2017-2018)
    - Mario wou met de nieuwe teams beginnen...
    Op 2018-06-06 begonnen met initializeren nieuw seizoen (2018-2019)
  </pre>
</div>

<hr/>
<h3>High level:</h3>
<div>
  0. backup database<br/>
  1. archiveer members (payments)<br/>
  2. resetten lidgeld (naar 0) en betaaldatums (naar NULL) -- NIET dat van het kamp!!<br/>
  3. aanpassen config/bootstrap.php<br/>
     Configure::write('Clubman.currentseason', '2016-2017');<br/>
  4. instellen auto-increment voor nieuw seizoen bij deze seizoensgebonden tables (zie verder)<br/>
     -> waarde (YY000001) -> want INT(11) ==> -2147483648 min and 2147483648 max<br/>
     -> dit voor het geval we ooit via seizoen gaan werken, en we dus bij een nieuw seizoen gewoon de auto-increment moeten aanpassen (zonder de tables leeg te maken) <br/>
  5. Nieuwe teams toevoegen (Laurens)<br/>
  6. Nieuwe teammembers toevoegen (Laurens)<br/>
  7. Nu kan je de lidgelden voorinvullen (180 jeugd, 210 senior)<br/>
     -> als "seizoen" is geïmplementeerd, dan zou ik deze financiële data in een aparte table steken (zowel voor lidgeld als voor kamp)<br/>
  8. De rest kan nu ook ingevuld worden<br/>
     8.1. cm_trainingmomentsteams<br/>
     8.2. cm_trainings<br/>
     8.3. cm_games<br/>
</div>

<hr/>
<h3># Backup database.</h3>

Via PHP My Admin - database - export<br/>
<pre>
- tables: all
- output: utf-8
- format: SQL
- format options: structure and data
</pre>

<hr/>
<h3># Archivering leden (payments).</h3>


<p>
  Pre-check data (should be 0 records)
</p>
<pre>
SELECT * from cm_memberarchives where created is null;
</pre>

<p>
  Copy over from members table to archive ...
</p>
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

<p>
  Set date
</p>
<pre>
  UPDATE cm_memberarchives set created = NOW() where created is null;
</pre>
<br/>


<hr/>
<h3># Initializeer auto-increment voor nieuw seizoen:</h3>
Volgende tables bevatten seizoensafhankelijke records.<br/>
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
Check effe de vorige grootste IDs.<br/>
<pre>
  select max(id) from cm_games;
  select max(id) from cm_gamesteammembers;
  select max(id) from cm_teammembers;
  select max(id) from cm_teams;
  select max(id) from cm_trainingmomentsteammembers;
  select max(id) from cm_trainingmomentsteams;
  select max(id) from cm_trainings;
  select max(id) from cm_trainingsteammembers;
  select max(id) from cm_efforts;
  select max(id) from cm_mails;
  select max(id) from cm_meterings;
  select max(id) from cm_pictures;
  select max(id) from cm_uploads;
</pre>
En stel de auto-increment in voor het volgende seizoen (als je dat wil).<br/>
<pre>
  ALTER TABLE cm_games AUTO_INCREMENT                      = 18000001;
  ALTER TABLE cm_gamesteammembers AUTO_INCREMENT           = 18000001;
  ALTER TABLE cm_teammembers AUTO_INCREMENT                = 18000001;
  ALTER TABLE cm_teams AUTO_INCREMENT                      = 18000001;
  ALTER TABLE cm_trainingmomentsteammembers AUTO_INCREMENT = 18000001;
  ALTER TABLE cm_trainingmomentsteams AUTO_INCREMENT       = 18000001;
  ALTER TABLE cm_trainings AUTO_INCREMENT                  = 18000001;
  ALTER TABLE cm_trainingsteammembers AUTO_INCREMENT       = 18000001;
  # bijkomend ook best ...
  ALTER TABLE cm_mails AUTO_INCREMENT     = 18000001;
  ALTER TABLE cm_efforts AUTO_INCREMENT   = 18000001;
  ALTER TABLE cm_meterings AUTO_INCREMENT = 18000001;
  ALTER TABLE cm_pictures AUTO_INCREMENT  = 18000001;
  ALTER TABLE cm_uploads AUTO_INCREMENT   = 18000001;
</pre>
<br/>

<hr/>
<h3># Resetten lidgeld en betaaldatums (naar NULL).</h3>
Pre-check ... <br/>
<pre>
  SELECT DISTINCT membershipfee, COUNT(*) from cm_members  WHERE 1 GROUP BY membershipfee;
  SELECT DISTINCT membershipfee_discount, COUNT(*) from cm_members  WHERE 1 GROUP BY membershipfee_discount;
  SELECT DISTINCT membership_advancepaid, COUNT(*) from cm_members  WHERE 1 GROUP BY membership_advancepaid;
  SELECT DISTINCT membership_balancepaid, COUNT(*) from cm_members  WHERE 1 GROUP BY membership_balancepaid;
</pre>
Resetten van de lidgeld info in de members table ... <br/>
<pre>
 indien de prijs niet moet of niet wijzigt
  UPDATE cm_members set membership_advancepaid = NULL, membership_balancepaid = NULL WHERE 1;
 indien de prijs wel moet en/of wijzigt
  UPDATE cm_members set membershipfee = 0, membershipfee_discount = 0, membership_advancepaid = NULL, membership_balancepaid = NULL WHERE 1;
  nog te doen
  UPDATE cm_members set membershipfee = 180 where [[jeugdspeler = 1]] AND active = 1;
  UPDATE cm_members set membershipfee = 210 where [[seniorspeler = 1]] AND active = 1;
</pre>
<br/>


<hr/>
... Dit moet misschien best na het kamp ...


<hr/>
<h3># Resetten kampgeld (naar 0) en betaaldatums (naar NULL).</h3>
Pre-check ...<br/>
<pre>
  SELECT DISTINCT camp, COUNT(*) from cm_members  WHERE 1 GROUP BY camp;
  SELECT DISTINCT campfee, COUNT(*) from cm_members  WHERE 1 GROUP BY campfee;
  SELECT DISTINCT camp_advance, COUNT(*) from cm_members  WHERE 1 GROUP BY camp_advance;
  SELECT DISTINCT camp_balance, COUNT(*) from cm_members  WHERE 1 GROUP BY camp_balance;
</pre>
Resetten van de kamp info in de members table ...<br/>
<pre>
  # Alles kamp op nul(l) zetten
  UPDATE cm_members set camp = 0, campfee = 0, camp_advance = NULL, camp_balance = NULL WHERE 1;
  # Prijs voorinstellen indien het gebruikt wordt
  UPDATE cm_members set campfee = 0 where YEAR(birthdate) <= 2006 AND YEAR(birthdate) >= 1996 AND active = 1;
</pre>
<br/>


<hr/>
<hr/>
TOT hier gedaan (06/06/2018)
<hr/>

<hr/>
Nu is het aan VCW om de teams samen te stellen...
<hr/>

... Zzzzzzz ...

<hr/>
<h3># De aanwezigheden op wedstrijden initializeren</h3>
-- de aanwezigheden op wedstrijden "aan"-zetten<br/>
-- Neem team x -- bv. test -- id = <strong>16000026</strong><br/>
-- Vermenigvuldig het aantal spelers ( 0 > prio > 99) met het aantal wedstrijden<br/>
<br/>

<h5>-- 1/ check of er al aanwezigheden zijn voor dat team (tot nu toe -- ter info)</h5>
<pre>
SELECT gtm.id presid, t.id tid, t.name, g.id gameid, g.game_date, gtm.teammember_id, gtm.season, gtm.status, gtm.created
 FROM cm_gamesteammembers gtm
 LEFT JOIN cm_games g on gtm.game_id = g.id
 LEFT JOIN cm_teams t on g.team_id = t.id
 WHERE g.season = <strong>'2016-2017'</strong>
 AND t.id = <strong>16000026</strong>
</pre>

<h5>-- 2/ Zoveel zouden het in totaal moeten zijn (gans het seizoen -- ter info)</h5>
<pre>
SET SQL_BIG_SELECTS=1;
SELECT gtm.id, g.team_id tid, t.name, tm.id tmid, tm.teampriority, g.id gid, g.game_date, NOW()
 FROM cm_teammembers tm
 LEFT JOIN cm_teams t on tm.team_id = t.id
 LEFT JOIN cm_games g on tm.team_id = g.team_id
 LEFT JOIN cm_gamesteammembers gtm on (tm.id = gtm.teammember_id) and (g.id = gtm.game_id)
 WHERE g.season = <strong>"2016-2017"</strong>
 AND tm.teampriority > 0
 AND tm.teampriority < 99
 AND t.id = <strong>16000026</strong>
</pre>

<h5>-- 3/ Zoveel zouden er dan bij in moeten komen (deze zullen dus toegevoegd worden -- ter voorbereiding)</h5>
<pre>
SET SQL_BIG_SELECTS=1;
SELECT tm.id tmid, g.id gameid, <strong>'2016-2017'</strong>, 'aanwezig', NOW()
 FROM cm_teammembers tm
 LEFT JOIN cm_teams t on tm.team_id = t.id
 LEFT JOIN cm_games g on tm.team_id = g.team_id
 LEFT JOIN cm_gamesteammembers gtm on (tm.id = gtm.teammember_id) and (g.id = gtm.game_id)
 WHERE g.season = <strong>"2016-2017"</strong>
 AND tm.teampriority > 0
 AND tm.teampriority < 99
 AND g.game_date > <strong>"2017-01-01"</strong>
 AND gtm.id IS NULL
 AND t.id = <strong>16000026</strong>
</pre>

<h5>-- 4/ Volgende zal nieuwe aanwezigheden initializeren op 'aanwezig' zonder bestaande te overschrijven (DIT IS DE TOEVOEGING)</h5>
<pre>
SET SQL_BIG_SELECTS=1;
INSERT INTO cm_gamesteammembers (teammember_id, game_id, season, status, created)
 SELECT tm.id tmid, g.id gameid, <strong>'2016-2017'</strong>, 'aanwezig', NOW()
 FROM cm_teammembers tm
 LEFT JOIN cm_teams t on tm.team_id = t.id
 LEFT JOIN cm_games g on tm.team_id = g.team_id
 LEFT JOIN cm_gamesteammembers gtm on (tm.id = gtm.teammember_id) and (g.id = gtm.game_id)
 WHERE g.season = <strong>"2016-2017"</strong>
 AND tm.teampriority > 0
 AND tm.teampriority < 99
 AND g.game_date > <strong>"2016-01-01"</strong>
 AND gtm.id IS NULL
 AND t.id = <strong>16000026</strong>
</pre>

<h5>-- Volgende zal bestaande seizoen (2016-2017) invullen waar het niet is ingevuld</h5>
<pre>
  SELECT season, teammember_id, game_id, status FROM cm_gamesteammembers WHERE id >= 16000000 AND id < 17000000 AND season is null;
  UPDATE cm_gamesteammembers SET season = '2016-2017' WHERE id >= 16000000 AND id < 17000000 AND season is null;
</pre>

<h5>-- Volgende zal bestaande aanwezigheden met blanko status op 'aanwezig' zetten</h5>
<pre>
SELECT season, teammember_id, game_id, status FROM cm_gamesteammembers WHERE season="2016-2017" AND status = '';
UPDATE cm_gamesteammembers SET status = 'aanwezig' WHERE season="2016-2017" AND status = '';
</pre>
<hr/>
