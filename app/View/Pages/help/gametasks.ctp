<pre>
Procedure import new referees in games table
=========================================

--- BACKUP ---
Not really necessary

--- PREPREPARE ---
Make spreadsheet with referees
- /games/fortasks
  -> Thuiswedstrijden jeugd
- haal lijst taken (scheidsrechters enz...)
- merge

--- PREPARE ---
Export Scheids spreadsheet
- In excel blad maken met game_id en scheidsrechter[,markeerder,scorebord]

--- IMPORT ---
Put the referees etc into vcw_games
/games/importtasks

 </pre>
