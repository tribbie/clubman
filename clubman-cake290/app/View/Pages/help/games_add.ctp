<pre>
Procedure import new games in games table
=========================================

--- BACKUP ---
Backup the current table -- if you want
DROP vcw_backup_games (existing backup-table)
CREATE TABLE vcw_backup_games SELECT * FROM vcw_games

Make csv file from current table -- if you want
SELECT * FROM vcw_games
 INTO OUTFILE '/var/www/doorgeef/db_vcw/games/vcw_games_old.csv'
 FIELDS TERMINATED BY ';'
 OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";


--- PREPARE ---
Export Rans zijn spreadsheet
- In excel zorgen dat de kolommen overeen komen met de table structuur
- Eventueel reeds lege kolommen in vullen
- Overige lege kolommen opvullen met NULL
- Datum veld in YYYY-MM-DD formaat zetten
- save as CSV in UTF-8, met puntkomma als delimiter en dubbelquote
- in de tekstfile, "NULL" vervangen door NULL (dubbel quotes weghalen)
- eventueel eerste lijn met veldnamen verwijderen
- overhalen naar vumini (/var/www/doorgeef/db_vcw/20102011ronde2/vcw.calendar4mysql.csv)


--- IMPORT ---
Op test systeem (vumini)
LOAD DATA INFILE '/var/www/doorgeef/db_vcw/20102011ronde2/vcw.calendar4mysql.csv'
 INTO TABLE vcw.vcw_games
 FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";

Op Productie systeem (oblivio)
Via phpMyAdmin
-> select table "vcw_games"
-> select tab "import"
-> choose file
-> utf8
-> CSV using LOAD DATA
GO


--- POST PROCESS ---
update vcw_games set game_change=NULL where game_change="" and id > 181;
update vcw_games set created=NOW() where created IS NULL and id > 181;
update vcw_games set game_code="competitie" where game_code="comp" and id > 181;


--- CHECK ---
Post-Checking ...
 SELECT * FROM vcw_games
 INTO OUTFILE '/var/www/doorgeef/db_vcw/games/vcw_games_new.csv'
 FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";
 </pre>
