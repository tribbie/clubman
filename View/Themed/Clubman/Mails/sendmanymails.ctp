<h1>Result of the send-many-mails</h1>

<?php if (count($mailingresult['mailsnotok']) > 0) : ?>
  <h2>Mislukte mails</h2>
  <?php foreach ($mailingresult['mailsnotok'] as $mailid => $notokmail) : ?>
    [rc=<?=$notokmail['rc']?>] <?=$notokmail['msg']?> (id=<?=$notokmail['id']?>)<br/>
  <?php endforeach ; ?>
  <hr/>
<?php endif; ?>
<h2>Gelukte mails</h2>
<?php foreach ($mailingresult['mailsok'] as $mailid => $okmail) : ?>
  <?=$okmail['msg']?> (id=<?=$okmail['id']?>)<br/>
<?php endforeach ; ?>


<?php
//pr($mailingresult);
//pr($mailing);
?>
