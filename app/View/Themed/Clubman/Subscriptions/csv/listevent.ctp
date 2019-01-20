<?php
  echo "Evenement;Seizoen;Titel;Hash;Naam;E-mail;Inschrijving;Bevestigd;Bevestiging;";
  $extrafields = json_decode($event['Event']['subscribe_extra']);
  foreach ($extrafields as $extrafield) {
    echo '' . mb_convert_encoding(ucfirst($extrafield->code), "Windows-1252", "UTF-8") . ';';
  }
  echo "Opmerking;";
  echo "\n";
?>
<?php
  foreach ($event['Subscription'] as $subscription) {
    echo '"' . mb_convert_encoding($event['Event']['name'], "Windows-1252", "UTF-8") . '";';
    echo '"' . $event['Event']['season'] . '";';
    echo '"' . mb_convert_encoding($subscription['substitle'], "Windows-1252", "UTF-8") . '";';
    echo '"' . mb_convert_encoding($subscription['subshash'], "Windows-1252", "UTF-8") . '";';
    echo '"' . mb_convert_encoding($subscription['subsname'], "Windows-1252", "UTF-8") . '";';
    echo '"' . mb_convert_encoding($subscription['subsemail'], "Windows-1252", "UTF-8") . '";';
    echo '"' . $subscription['created'] . '";';
    echo '"' . (($subscription['confirmed']) ? 'ja' : 'neen') . '";';
    echo '"' . $subscription['confirmed_stamp'] . '";';
    $extras = json_decode($subscription['extra']);
    foreach ($extras as $extrakey => $extravalue) {
      echo '"' . mb_convert_encoding($extravalue, "Windows-1252", "UTF-8") . '";';
    }
    echo '"' . $subscription['remark'] . '";';
    echo "\n";
  }
?>
