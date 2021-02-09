<h1>VCW Clubman db -- new season todo</h1>
<br/>
<hr/>
<pre>
                                    Archief #1     Archief #2
                                    2014-03-14     2014-06-09

camp advance paid last date         2013-08-13     2014-04-15
camp balance paid last date         2013-09-27     2014-04-07

fee advance paid last date          2013-12-18     2014-04-09
fee balance paid last date          2013-12-18     2014-04-09

Op 2014-06-09 begonnen met initializeren nieuw seizoen (2014-2015)

---------------------------------------------------------------------------------------
eerste char: records (X = removed)
tweede char: auto-increment (Y = yearly-update)
derde char:  seizoen te implementeren (! = yes)


---	cm_auditrecords			10,540	MyISAM	utf8_general_ci	2 MiB	-
-Y!	cm_efforts			935	MyISAM	utf8_general_ci	65 KiB	-
-Y!	cm_enquetes			52	MyISAM	utf8_general_ci	22.4 KiB	-
XY!	cm_games			321	MyISAM	utf8_general_ci	59.1 KiB	-
XY!	cm_gamesteammembers		3,059	MyISAM	utf8_general_ci	176.9 KiB	20 B
	cm_mailings			1	MyISAM	utf8_general_ci	2.6 KiB	-
	cm_mails			52	MyISAM	utf8_general_ci	14.1 KiB	-
--!	cm_memberarchives		776	MyISAM	utf8_general_ci	63.6 KiB	-
---	cm_members			388	MyISAM	utf8_general_ci	77.9 KiB	560 B
-Y-	cm_meterings			0	MyISAM	utf8_general_ci	1 KiB	-
?Y!	cm_pictures			341	MyISAM	utf8_general_ci	38.6 KiB	-
XY!	cm_teammembers			240	MyISAM	utf8_general_ci	17.8 KiB	-
XY!	cm_teams			18	MyISAM	utf8_general_ci	5.1 KiB	-
---	cm_tempref			46	MyISAM	utf8_general_ci	2.3 KiB	-
---	cm_trainingmoments		10	MyISAM	utf8_general_ci	2.5 KiB	-
XY!	cm_trainingmomentsteammembers	0	MyISAM	utf8_general_ci	1 KiB	-
XY!	cm_trainingmomentsteams		26	MyISAM	utf8_general_ci	3.2 KiB	96 B
XY!	cm_trainings			1,063	MyISAM	utf8_general_ci	99.9 KiB	-
XY!	cm_trainingsteammembers		8,347	MyISAM	utf8_general_ci	458.8 KiB	-
-Y!	cm_uploads			22	MyISAM	utf8_general_ci	5.4 KiB	-
---	cm_users			37	MyISAM	utf8_general_ci	6.2 KiB	-
---	cm_view_for_google_calendar	316	View	---	-	-

---------------------------------------------------------------------------------------

High level:
1. backup database (done)
2. resetten lidgeld (naar 0) en betaaldatums (naar NULL) -- NIET dat van het kamp!!
3. truncaten van de seizoensgebonden tables (zie verder) -- Als "seizoen" geïmplementeerd is, zal dit niet meer nodig zijn...
4. instellen auto-increment voor nieuw seizoen bij deze seizoensgebonden tables (zie verder)
   -> waarde (YY000001) -> want INT(11) ==> -2147483648 min and 2147483648 max
   -> dit voor het geval we ooit via seizoen gaan werken, en we dus bij een nieuw seizoen gewoon de auto-increment moeten aanpassen (zonder de tables leeg te maken) 
5. Nieuwe teams toevoegen
6. Nieuwe teammembers toevoegen
7. Nu kan je de lidgelden voorinvullen (180 jeugd, 210 senior)
   -> als "seizoen" is geïmplementeerd, dan zou ik deze financiële data in een aparte table steken (zowel voor lidgeld als voor kamp)
8. De rest kan nu ook ingevuld worden
   - cm_trainingmomentsteams
   - cm_trainings
   - cm_games


# Volgende tables bevatten seizoensafhankelijke records.
# Deze mogen dus weg.

truncate table cm_gamesteammembers;
truncate table cm_games;

truncate table cm_trainingsteammembers;
truncate table cm_trainings;

truncate table cm_teammembers;
truncate table cm_teams;

truncate table cm_trainingmomentsteammembers;
truncate table cm_trainingmomentsteams;

## EENMALIG - done
# Voeg column seizoen toe (formaat YYYY-YYYY)
alter table cm_games add column season char(10) DEFAULT NULL after opponent_club_id;
alter table cm_gamesteammembers add column season char(10) DEFAULT NULL after game_id;
alter table cm_teammembers add column season char(10) DEFAULT NULL after member_id;
alter table cm_teams add column season char(10) DEFAULT NULL after picture_id;
alter table cm_trainingmomentsteammembers add column season char(10) DEFAULT NULL after teammember_id;
alter table cm_trainingmomentsteams add column season char(10) DEFAULT NULL after team_id;
alter table cm_trainings add column season char(10) DEFAULT NULL after team_id;
alter table cm_trainingsteammembers add column season char(10) DEFAULT NULL after training_id;
alter table cm_efforts add column season char(10) DEFAULT NULL after team_id;
alter table cm_enquetes add column season char(10) DEFAULT NULL after team_prio;
alter table cm_meterings add column season char(10) DEFAULT NULL after member_id;
alter table cm_pictures add column season char(10) DEFAULT NULL after id;
alter table cm_uploads add column season char(10) DEFAULT NULL after id;

# Verander de teamtype column (niet meer enum('volley', 'omkadering')) - done
alter table cm_teams modify teamtype varchar(20) DEFAULT NULL;

## EENMALIG - done
# Zet vorig seizoen (2013-2014) in records van vorig seizoen
update cm_games set season = "2013-2014" where season IS NULL;
update cm_gamesteammembers set season = "2013-2014" where season IS NULL;
update cm_teammembers set season = "2013-2014" where season IS NULL;
update cm_teams set season = "2013-2014" where season IS NULL;
update cm_trainingmomentsteammembers set season = "2013-2014" where season IS NULL;
update cm_trainingmomentsteams set season = "2013-2014" where season IS NULL;
update cm_trainings set season = "2013-2014" where season IS NULL;
update cm_trainingsteammembers set season = "2013-2014" where season IS NULL;
update cm_efforts set season = "2013-2014" where season IS NULL;
update cm_enquetes set season = "2013-2014" where season IS NULL;
update cm_meterings set season = "2013-2014" where season IS NULL;
update cm_pictures set season = "2013-2014" where season IS NULL;
update cm_uploads set season = "2013-2014" where season IS NULL;


# Initializeer auto-increment voor nieuw seizoen: - done
ALTER TABLE cm_games AUTO_INCREMENT = 14000001;
ALTER TABLE cm_gamesteammembers AUTO_INCREMENT = 14000001;
ALTER TABLE cm_teammembers AUTO_INCREMENT = 14000001;
ALTER TABLE cm_teams AUTO_INCREMENT = 14000001;
ALTER TABLE cm_trainingmomentsteammembers AUTO_INCREMENT = 14000001;
ALTER TABLE cm_trainingmomentsteams AUTO_INCREMENT = 14000001;
ALTER TABLE cm_trainings AUTO_INCREMENT = 14000001;
ALTER TABLE cm_trainingsteammembers AUTO_INCREMENT = 14000001;
# bijkomend ook best ...
ALTER TABLE cm_efforts AUTO_INCREMENT = 14000001;
ALTER TABLE cm_enquetes AUTO_INCREMENT = 14000001;
ALTER TABLE cm_meterings AUTO_INCREMENT = 14000001;
ALTER TABLE cm_pictures AUTO_INCREMENT = 14000001;
ALTER TABLE cm_uploads AUTO_INCREMENT = 14000001;

</pre>
<hr/>
