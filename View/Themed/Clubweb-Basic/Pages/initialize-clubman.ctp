<h2>Installeer en initializeer Clubman</h2>

<p>
  Hier zijn de Clubman installatie- en initializatiestappen.
</p>

<div class="panel panel-default">
  <div class="panel-heading">Backup / export</div>
  <div class="panel-body">
    <p>
      Op je development server.
    </p>
<pre>
sudo tar -czf clubman_yyyymmdd.tgz clubman
mysqldump -u bart -p --no-data clubman > clubman_structure_only.sql
mysqldump -u bart -p --no-create-info clubman > clubman_data_only.sql
mysqldump -u bart -p clubman > clubman_structure_and_data.sql
</pre>
  </div>
  <div class="panel-heading">Transfer / install</div>
  <div class="panel-body">
    <p>
      Copieer vanop je development server.
    </p>
<pre>
scp -P 55455 -p thefile.ext clubman.oblivio.be:/var/tmp
</pre>
    <p>
      Op je Clubman server.
    </p>
<pre>
sudo tar -xzf clubman_yyyymmdd.tgz
</pre>
  </div>
  <div class="panel-heading">Prepare mySQL / initialize Clubman</div>
  <div class="panel-body">
    <p>
      Op je Clubman server.
    </p>
<pre>
CREATE USER 'user4clubman'@'localhost' IDENTIFIED BY 'password4clubman';
GRANT ALL ON clubman.* TO 'user4clubman'@'localhost';
CREATE DATABASE clubman;
USE clubman;
SOURCE clubman_structure_only.sql;
</pre>
    <p>
      Als je nu wil inloggen, moet je eerst het root wachtwoord instellen. De root user wordt dan aangemaakt met dit wachtwoord.
    </p>
  </div>
</div>
