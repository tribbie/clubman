<pre>
Procedure import new members table
==================================

--- BACKUP ---
Backup the current table -- if you want
DROP TABLE vcw_members_backup (existing backup-table)
CREATE TABLE vcw_members_backup SELECT * FROM vcw_members

Make csv file from current table -- if you want
SELECT * FROM vcw_members
 INTO OUTFILE '/var/www/doorgeef/vcw_members.csv'
 FIELDS TERMINATED BY ';'
 OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";
 
--- PREPARE ---
Export Marleen haar spreadsheet
- Indien nodig: een kopie van de laatste 'ID' kolom vooraan zetten
- Save as CSV in UTF-8, met puntkomma als delimiter en dubbelquote
- Indien nodig ;ONWAAR; vervangen door ;FALSE;

--- REFRESH ---
Op test systeem (vumini)
LOAD DATA INFILE '/var/www/doorgeef/db_vcw/20122013ronde2/vcw.members_for_mysql_0x.csv'
 REPLACE
 INTO TABLE vcw.vcw_members
 FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";
 
Op Productie systeem (oblivio)
Via phpMyAdmin
-> select table "vcw_members"
-> select tab "import"
-> choose file
-> utf8
-> CSV using LOAD DATA
--> select "Replace table data"
GO

--- CHECK ---
Post-Checking ...
 SELECT * FROM vcw_members
 INTO OUTFILE '/var/www/doorgeef/vcw_members_new.csv'
 FIELDS TERMINATED BY ';'
 OPTIONALLY ENCLOSED BY '"'
 LINES TERMINATED BY "\n";
 </pre>
