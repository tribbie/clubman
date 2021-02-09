<pre>
Subject,Start Date,Start Time,End Date,End Time,All Day Event,Description,Location,Private,Reminder On/Off
"MinX (b)",2010-12-31,20:00,2010-12-31,22:00,FALSE,"Miniemen Xongens (beker) tegen JVL","Sportschuur Wolvertem",FALSE,FALSE

Procedure:

- Put games in vcw_games

- Add referees into the vcw_games

- Export the info for Google Calendar

<hr/>Ronde 2
<hr/>
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
WHERE g.team_id > 2
AND g.team_id < 10
AND g.game_date > "2011-01-01"
ORDER BY g.game_date, g.game_time, g.team_id

<hr/>

- Save this as CSV
make sure the header line is correct (like line 1)
make sure date is in format YYYY-MM-DD (format cells with own style)

- Import in Google.
</pre>
