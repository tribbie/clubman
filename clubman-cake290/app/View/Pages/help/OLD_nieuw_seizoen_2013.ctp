<h1>VCW db -- new season todo</h1>
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

Wat bij aanvang van een nieuw seizoen ...<br/>
<br/>

<hr/>

<a href="#" title="overzicht" onclick="showhide('item00'); return(false)">*** Overzicht</a><br/> 
<div style='display: none;' id='item00'> 
<div class='coolinfobox'>

<font size='-1'>
De tables met een - vooraan worden eigenlijk nog niet gebruikt.<br/>
De andere moeten dus voor een nieuw seizoen opgevuld worden.<br/>
<br/></font>
<pre>
+-----+---------------------------+
|     + Tables_in_vcw             |
+-----+---------------------------+
|  -  + vcw_clubs                 |
|  -  + vcw_comments              |
|  -  + vcw_enquetes              |
|  -  + vcw_events                |
|  v  + vcw_games                 |
|  -  + vcw_mailings              |
|  -  + vcw_mails                 |
|  v  + vcw_members               |
|  -  + vcw_newsitems             |
|  -  + vcw_posts                 |
|  -  + vcw_sporthalls            |
|  v  + vcw_teammembers           |
|  v  + vcw_teammembers_games     |
|  v  + vcw_teammembers_trainings |
|  v  + vcw_teams                 |
|  v  + vcw_trainings             |
|  -  + vcw_uploads               |
|  v  + vcw_users                 |
+-----+---------------------------+
</pre>

<ul>
<li>vernieuwe members in table vcw_members</li>
<li>nieuwe teams in table vcw_teams</li>
<li>nieuwe teammembers in table vcw_teammembers</li>
<li>nieuwe kalender in table vcw_games</li>
<li>nieuwe aanwezigheden in table vcw_teammembers_games</li>
<li>nieuwe trainingen in table vcw_trainings</li>
<li>nieuwe aanwezigheden in table vcw_teammembers_trainings</li>
<li>korte trainingen in table vcw_trainings aanpassen</li>
</ul> 
</div>
</div> 
<br/><hr/>

<a href="#" title="members refreshen" onclick="showhide('item01'); return(false)">*** Members</a><br/> 
<div style='display: none;' id='item01'> 
<div class='coolinfobox'>
<ul>
<li>Backup (als je wil)
<ul><font size="-1">
<li>DROP TABLE vcw_members_backup (existing backup-table)</li>
<li>CREATE TABLE vcw_members_backup SELECT * FROM vcw_members</li>
</font></ul>
</li>
<li>Haal info van spreadsheet Marleen (query Tribbie)</li>
<li>Open in libre office
<ul><font size="-1">
	<li>Check kolommen met layout table vcw_members</li>
	<li>Save als csv voor import</li>
	<ul>
		<li>UTF-8</li>
		<li>puntcomma</li>
	</ul>
</font></ul>
</li>
<li>Editeer csv file
<ul><font size="-1">
	<li>Verwijder eerste "hoofding" lijn</li>
	<li>Vervang ;WAAR; door ;TRUE;</li>
	<li>Vervang ;ONWAAR; door ;FALSE;</li>
	<li>Vervang "NULL" door NULL</li>
	<li>Character encoding UTF-8</li>
	<li>Bij Stijn De Neef staat een slechte quote in "D'Hoogvorstlaan 45"</li>
</font></ul>
</li>
<li>Importeer
<br/>** NIEUW ** nu mogelijk via members/import (op vumini toch)<br/>
<ul><font size="-1">
	<li>LOAD DATA INFILE '/var/www/doorgeef/db_vcw/20122013ronde1/vcw.members_for_mysql.csv' REPLACE INTO TABLE vcw.vcw_members FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY "\n";</li>
</font></ul>
</li>
<li>Importeer op web (via phpMyAdmin)
<ul><font size="-1">
	<li>select table "vcw_members"</li>
	<li>select tab "import"</li>
	<li>choose file</li>
	<li>character set UTF-8</li>
	<li>CSV using LOAD DATA</li>
	<li>select "Replace table data"</li>
</font></ul>
</li>
<li>Naverwerking in mySQL
<ul><font size="-1">
	<li>UPDATE vcw_members SET created = NOW() where created IS NULL;</li>
	<li>UPDATE vcw_members SET modified = NOW();</li>
</font></ul>
</li>
</ul> 
</div>
</div> 
<br/><hr/>

<a href="#" title="teams initializeren" onclick="showhide('item02'); return(false)">*** Teams</a><br/> 
<div style='display: none;' id='item02'> 
<div class='coolinfobox'>
<ul>
<li>Toon teams van incvars ()</li>
<li>Save het als csv</li>
<li>Open in libre office</li>
<li>Voeg wat kolommen toe</li>
<li>Zet in ID het YY van het seizoen, en dan volgnummer.</li>
<li>Save als csv voor import</li>
<li>Verander "NULL" door NULL in csv</li>
<li>Importeer
<ul><font size="-1">
	<li>LOAD DATA INFILE '/var/www/doorgeef/db_vcw/20122013ronde1/vcw.teams_for_mysql.csv' INTO TABLE vcw.vcw_teams FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY "\n";</li>
</font></ul>
</li>
</ul> 
</div>
</div>

<br/><hr/>

<a href="#" title="teammembers initializeren" onclick="showhide('item03'); return(false)">*** Teammembers</a><br/> 
<div style='display: none;' id='item03'> 
<div class='coolinfobox'>
<ul>
<li>Haal info van spreadsheet Marleen (lijst Imelda)</li>
<li>Open in libre office
<ul><font size="-1">
	<li>Kopieer ID kolom van achter naar member_id kolom vooraan</li>
	<li>Verwijder overtollige kolommen (adres, postcode, ...)</li>
	<li>Voeg wat kolommen toe (id, team_id)</li>
	<li>Concateneer naam + voornaam</li>
	<li>Vul team_id op</li>
	<li>Vul team_priority op (of via naverwerking)</li>
	<li>Save als csv voor import</li>
</font></ul>
</li>
<li>Editeer CSV voor import
<ul><font size="-1">
	<li>Verwijder eerste "hoofding" lijn</li>
	<li>Vervang "NULL" door NULL in de csv</li>
</font></ul>
</li>
<li>Stel de auto-increment in voor het nieuwe seizoen (YY001)
<ul><font size="-1">
	<li>ALTER TABLE vcw_teammembers AUTO_INCREMENT = 12001;</li>
</font></ul>
</li>
<li>Importeer
<ul><font size="-1">
	<li>LOAD DATA INFILE '/var/www/doorgeef/db_vcw/20122013ronde1/vcw.teammembers_for_mysql.csv' INTO TABLE vcw.vcw_teammembers FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY "\n";</li>
</font></ul>
</li>
<li>Importeer op web (via phpMyAdmin)
<ul><font size="-1">
	<li>select table "vcw_teammembers"</li>
	<li>select tab "import"</li>
	<li>choose file</li>
	<li>character set latin1</li>
	<li>character set utf8 (dit geeft precies problemen met speciale karakters)</li>
	<li>CSV using LOAD DATA</li>
	<li>OR when having problems with encodings: export from vumini: SELECT * FROM vcw_teammembers WHERE id > 12000 INTO OUTFILE '/var/www/doorgeef/vcw.teammembers_for_mysql.csv' FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY "\n";</li>	
	
</font></ul>
</li>
<li>Naverwerking in mySQL
<ul><font size="-1">
	<li>update vcw_teammembers set created=NOW() where created IS NULL and id > 12000;</li>
	<li>update vcw_teammembers set team_priority = 0 where team_id > 1200;</li>
	<li>update vcw_teammembers set team_priority = 1 where team_id > 1200 and team_function = 'speelster';</li>
	<li>update vcw_teammembers set team_priority = 1 where team_id > 1200 and team_function = 'speler';</li>

</font></ul>
</li>
</ul> 
</div>
</div> 
<br/><hr/>

<a href="#" title="games initializeren" onclick="showhide('item04'); return(false)">*** Games</a><br/> 
<div style='display: none;' id='item04'> 
<div class='coolinfobox'>
<ul>
<li>Zorg dat de teams bestaan
<ul><font size="-1">
   <li>Ronde 1: nieuwe teams aanmaken</li>
   <li>Ronde 2: eventuele nieuwe teams bijmaken</li>
   <li>Ronde 2: eventueel reeks aanpassen</li>
</font></ul>
</li>
<li>Haal kalender van spreadsheet Rans (of ARUNAR -- met sporthallen)</li>
<li>Open (of paste) in libre office
<ul><font size="-1">
   <li>Zorg dat de datum YYYY-MM-DD is</li>
   <li>Voeg wat kolommen toe</li>
   <li>Vul de kolommen in (zeker ook team_id)</li>
	<li>Save als csv voor import (dubbelquote en puntkomma) -- UTF-8</li>
</font></ul>
</li>
<li>Editeer CSV voor import
<ul><font size="-1">
	<li>Verwijder eerste "hoofding" lijn</li>
   <li>Verander "NULL" door NULL</li>
   <li>Verander blanko"; door "; (sommige velden hebben een blanko aan het einde)</li>
</font></ul>
</li>
<li>Vergroot het game_hall veld naar 100 characters
<ul><font size="-1">
	<li>ALTER TABLE vcw_games CHANGE game_hall game_hall VARCHAR(100) DEFAULT NULL;</li>
</font></ul>
</li>
<li>Stel de auto-increment in voor het nieuwe seizoen (YY001)
<ul><font size="-1">
	<li>ALTER TABLE vcw_games AUTO_INCREMENT = 12001;</li>
</font></ul>
</li>
<li>Importeer in mySQL
<ul><font size="-1">
	<li>LOAD DATA INFILE '/var/www/doorgeef/db_vcw/20122013ronde1/vcw.calendar_for_mysql.csv' INTO TABLE vcw.vcw_games FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY "\n";</li>
</font></ul>
</li>
<li>Importeer op web (via phpMyAdmin)
<ul><font size="-1">
	<li>select table "vcw_games"</li>
	<li>select tab "import"</li>
	<li>choose file</li>
	<li>character set utf8 (dit geeft precies problemen met speciale karakters)</li>
	<li>CSV using LOAD DATA</li>
</font></ul>
</li>
<li>Naverwerking in mySQL
<ul><font size="-1">
	<li>UPDATE vcw_games SET game_change = NULL WHERE game_change="" AND season = "2012-2013";</li>
	<li>UPDATE vcw_games SET created = NOW() WHERE created IS NULL AND season = "2012-2013";</li>
	<li>UPDATE vcw_games SET game_code="competitie" WHERE game_code="comp" AND season = "2012-2013";</li>
	<li>UPDATE vcw_games SET game_t123 = NULL WHERE game_t123 = 0 AND season = "2012-2013";</li>
	<li>UPDATE vcw_games SET game_home_or_away = "A" WHERE season = "2012-2013";</li>
	<li>UPDATE vcw_games SET game_home_or_away = "H" WHERE game_home LIKE "Wolvertem%" AND season = "2012-2013";</li>
	<li>UPDATE vcw_games SET home_game = TRUE WHERE game_home_or_away = "H" AND season = "2012-2013";</li>
	<li>UPDATE vcw_games SET home_game = FALSE WHERE game_home_or_away = "A" AND season = "2012-2013";</li>
	<li>game_coach_id invullen per ploeg (hier moet de teammember_id van de coach in komen)</li>
	<li>UPDATE vcw_games SET game_coach_id = 12038 WHERE game_coach_id IS NULL AND team_id = 1203;</li>
</font></ul>
</li>
</ul> 
</div>
</div> 
<br/><hr/>

<a href="#" title="aanwezigheden games initializeren" onclick="showhide('item05'); return(false)">*** Teammembers_Games</a><br/> 
<div style='display: none;' id='item05'> 
<div class='coolinfobox'>
<ul>
<li>in mySQL
<ul><font size="-1">
	<li>ALTER TABLE vcw_teammembers_games AUTO_INCREMENT = 120001;</li>
	<li>INSERT INTO vcw_teammembers_games (teammember_id, game_id, created) SELECT tm.id, g.id, NOW() FROM vcw_teammembers tm, vcw_games g WHERE tm.team_id = g.team_id AND g.season = "2012-2013" AND g.game_date > "2012-01-01" AND tm.team_id in (1203, 1204, 1205, 1206, ...) AND (tm.team_function = 'speelster' OR tm.team_function = 'speler');</li>
</font></ul>
</li>
</ul> 
</div>
</div> 
<br/><hr/>

<a href="#" title="trainings initializeren" onclick="showhide('item06'); return(false)">*** Trainings</a><br/> 
<div style='display: none;' id='item06'> 
<div class='coolinfobox'>
<ul>
<li>Stel de auto-increment in voor het nieuwe seizoen (YY0001)
<ul><font size="-1">
	<li>ALTER TABLE vcw_trainings AUTO_INCREMENT = 120001;</li>
</font></ul>
</li>
<li>Dit wordt gegenereerd door <a href="http://vumini/oblivio/prive/mysql/vcw_generate_trainings.php">vcw_generate_trainings.php</a>
<ul><font size="-1">
	<li>Gelieve eerst het script up-to-date te zetten</li>
	<li>Dit vooral wat de teams betreft, begin- en einddatum en eventueel de mogelijke begin- en einduren</li>
</font></ul>
</li>
<li>Exporteer de nieuwe trainingen naar een csv
<ul><font size="-1">
	<li>SELECT NULL, team_id, start_date, start_time, end_time, remark, NULL, NULL FROM vcw_trainings WHERE id > 120000 INTO OUTFILE '/var/www/doorgeef/vcw.trainings_for_mysql.csv' FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY "\n";</li>
</font></ul>
</li>
<li>Editeer CSV voor import
<ul><font size="-1">
	<li>Vervang \N door NULL in de csv</li>
</font></ul>
</li>
<li>Importeer op web (via phpMyAdmin)
<ul><font size="-1">
	<li>select table "vcw_trainings"</li>
	<li>select tab "import"</li>
	<li>choose file</li>
	<li>character set latin1</li>
	<li>character set utf8 (dit geeft precies problemen met speciale karakters)</li>
	<li>CSV using LOAD DATA</li>
</font></ul>
</li>

</ul> 
</div>
</div> 
<br/><hr/>

<a href="#" title="aanwezigheden trainings initializeren" onclick="showhide('item07'); return(false)">*** Teammembers_Trainings</a><br/> 
<div style='display: none;' id='item07'> 
<div class='coolinfobox'>
<ul>
<li>Stel de auto-increment in voor het nieuwe seizoen (YY0001)
<ul><font size="-1">
	<li>ALTER TABLE vcw_teammembers_trainings AUTO_INCREMENT = 120001;</li>
</font></ul>
</li>
</ul> 
</div>
</div> 
<br/><hr/>

<a href="#" title="korte trainingen" onclick="showhide('item08'); return(false)">*** Korte trainingen</a><br/> 
<div style='display: none;' id='item08'> 
<div class='coolinfobox'>
<ul>
<li>Stel de korte trainingen in
<ul><font size="-1">
	<li>Shift 1<br/>
	<pre>
UPDATE vcw_trainings SET end_time = '19:00:00'
 WHERE ( start_time = '17:45:00'
 AND ( start_date = '2011-09-02' OR
       start_date = '2011-09-16' OR
       start_date = '2011-09-30' OR
       start_date = '2011-10-14' OR
       start_date = '2011-10-28' OR
       start_date = '2011-11-25' OR
       start_date = '2011-12-09' OR
       start_date = '2012-01-06' OR
       start_date = '2012-02-03' OR
       start_date = '2012-03-02' OR
       start_date = '2012-03-16' OR
       start_date = '2012-03-30' OR
       start_date = '2012-04-27'
     )
);</pre></li>
	<li>Shift 2<br/>
	<pre>
UPDATE vcw_trainings SET start_time = '19:00:00', end_time = '20:00:00'
 WHERE ( start_time = '19:15:00'
 AND ( start_date = '2011-09-02' OR
       start_date = '2011-09-16' OR
       start_date = '2011-09-30' OR
       start_date = '2011-10-14' OR
       start_date = '2011-10-28' OR
       start_date = '2011-11-25' OR
       start_date = '2011-12-09' OR
       start_date = '2012-01-06' OR
       start_date = '2012-02-03' OR
       start_date = '2012-03-02' OR
       start_date = '2012-03-16' OR
       start_date = '2012-03-30' OR
       start_date = '2012-04-27'
     )
);</pre></li>
</font></ul>
</li>
</ul> 
</div>
</div> 
<br/><hr/>

<a href="#" title="korte trainingen" onclick="showhide('item09'); return(false)">*** Scheidsrechters</a><br/> 
<div style='display: none;' id='item09'> 
<div class='coolinfobox'>
<ul>
<li>Exporteer scheidsrechter spreadsheet
<ul><font size="-1">
	<li>In excel blad maken met game_id en naam scheidsrechter(s)</li>
	<li>"Save as" CSV in UTF-8, met puntkomma als delimiter en dubbelquote</li>
	<li>Eventueel eerste lijn met veldnamen verwijderen</li>
	<li>Overhalen naar vumini (/var/www/doorgeef/db_vcw/20122013ronde1/vcw.referees_for_mysql.csv)</li>
</font></ul>
</li>
<li>Create temporary table
<ul><font size="-1">
	<li><pre>CREATE TABLE vcw_tempref (game_id INT(11) UNSIGNED, referee VARCHAR(50));</pre></li>
</font></ul>
</li>
<li>Upload referees in temp table
<ul><font size="-1">
	<li>Op test systeem (vumini)<br/>
	<pre>
LOAD DATA INFILE '/var/www/doorgeef/db_vcw/20122013ronde1/vcw.referees_for_mysql.csv'
 INTO TABLE vcw.vcw_tempref
 FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";</pre></li>
	<li>Op productie systeem (oblivio) - via phpMyAdmin<br/>
	<pre>
-> select table "vcw_tempref"
-> select tab "import"
-> choose file
-> utf8
-> CSV using LOAD DATA
=> GO</pre></li>
</font></ul>
</li>
<li>Importeer scheidsrechters in vcw_games
<ul><font size="-1">
	<li><pre>
UPDATE vcw_games g
 LEFT JOIN vcw_tempref r ON r.game_id = g.id
 SET g.game_referee = r.referee
 WHERE r.game_id = g.id;</pre></li>
</font></ul>
</li>
</ul> 
</div>
</div> 
<br/><hr/>

<a href="#" title="games initializeren" onclick="showhide('item10'); return(false)">*** Games into Google calendar</a><br/> 
<div style='display: none;' id='item10'> 
<div class='coolinfobox'>
<ul>
<li>Zie dat de kalender compleet in VCWdb staat (inclusief scheidsrechters)</li>
<li>Selecteer de nodige informatie
<ul><font size="-1">
	<li>
<pre>
check the cm_view_for_google_calendar (mysql view)
OR
</pre>
<pre>
SELECT CONCAT(t.mini_name, if((g.home_game = 1), '', ' uit'), 
if (g.game_code = 'beker', '(b)', '')) Subject,
       g.game_date StartDate,
       g.game_time StartTime,
       g.game_date EndDate,
       ADDTIME(g.game_time, '02:00:00') EndTime,
       "FALSE" AllDay, 
       CONCAT(t.name, if((g.home_game = 1), CONCAT(' tegen ', g.game_away, 
if (g.game_referee IS NULL, '', CONCAT(' (ref. ', g.game_referee, ')'))), 
CONCAT(' op ', g.game_home))) Description,
       g.game_hall Location,
       "FALSE" Private,
       "FALSE" ReminderOnOff
FROM vcw_games g
LEFT JOIN vcw_teams t ON t.id = g.team_id
WHERE g.team_id > 1200
AND g.season = "2012-2013"
AND g.game_date > "2012-09-01"
ORDER BY g.game_date, g.game_time, g.team_id
</pre>
	</li>
</font></ul>
</li>
<li>Save as CSV</li>
<li>Editeer CSV voor import
<ul><font size="-1">
	<li>Voeg "hoofding" lijn toe</li>
   <li>Field delimiter moet komma zijn!</li>
   <li>Enclosed by dubbel quote!</li>
   <li>Vervang "FALSE" door FALSE</li>
   <li>Vervang "TRUE" door TRUE</li>
</font></ul>
</li>
<li>Verwijder de eerste jeugd-competitiegames vanaf 1 januari (omdat hier geen scheidsrechters in staan)</li>
<li>Importeer in Google calendar
<ul><font size="-1">
	<li>Mijn agenda's</li>
	<li>Dropdown - Instellingen</li>
	<li>Hier vind je een link "Agenda importeren"</li>
</font></ul>
</li>
</ul> 
</div>
</div> 

<br/><hr/>

<a href="#" title="mailing_enquetes" onclick="showhide('item11'); return(false)">*** Mailing voor enquetes</a><br/> 
<div style='display: none;' id='item11'> 
<div class='coolinfobox'>
mailing (enquete 2012) voorbereiden<br/>
<a href="/cake_vcw/pages/vcw_mailing_enquete_2012">vcw_mailing_enquete_2012</a>
</div>
</div> 

<br/><hr/>


<a href="#" title="mailing_enquetes" onclick="showhide('item12'); return(false)">*** Verjaardagen</a><br/> 
<div style='display: none;' id='item12'> 
<div class='coolinfobox'>
Verjaardagen voorbereiden voor kalender VCW<br/>
<ul>
<li>Extract van de vcw_members table</li>
<li>Selecteer de nodige informatie
<ul><font size="-1">
	<li>
<pre>
SELECT voornaam, naam, 
date_format(geboortedatum, "%d/%m/%Y") as ddmmyyyy, 
ABS(date_format(geboortedatum, "%c")) as m, 
ABS(date_format(geboortedatum, "%e")) as d, 
ABS(date_format(geboortedatum, "%Y")) as yyyy
FROM `vcw_members` 
WHERE (naam <> "") and (voornaam <> "") and (date_format(geboortedatum, "%e") <> 0)
order by m, d, yyyy desc
</pre>	
	</li>
</font></ul>
</li>
<li>Export (of save) as CSV zonder quotes en met ; als delimiter</li>
<li>Zet deze info in kal_vdag.csv</li>
</ul>
</div>
</div> 

<br/><hr/>


<font size='-1'>
<?php echo $this->Html->link('andere (oudere) bron van informatie', array('controller' => 'pages', 'action' => 'vcw_database')); ?><br/>
Hier staat nog wat ivm toevoegen wedstrijden, korte trainingen, scheidsrechters, coaches, google calendar, enquetes, ...
</font>
<hr/></br>

