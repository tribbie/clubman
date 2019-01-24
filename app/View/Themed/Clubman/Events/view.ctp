<h2><?=ucfirst($event['Event']['title'])?> - <?=$event['Event']['year']?></h2>

<?=$this->Markdown->transform($event['Event']['content'])?>

<?php if ($event['Event']['subscribe_able']) : ?>

  <hr/>
  <?php if ($event['Event']['subscribe_able_now']) : ?>

    <?php $showSubsciptionsButton = true; ?>

    <?php if ($event['Event']['status'] == 'test') : ?>
      <div class="alert alert-danger">
        <p class="text-center">
          OPGELET: VOORLOPIG ENKEL OM TE TESTEN<br/>
          NOG GEEN OFFICIELE INSCHRIJVINGEN MOGELIJK
        </p>
      </div>
    <?php endif; ?>

    <?php if ($event['Event']['subscribe_max'] > 0) : ?>
      <div class="alert alert-warning">
        <p class="text-center">
          OPGELET: Maximum <?=$event['Event']['subscribe_max']?> inschrijvingen!
          <?php $subscriptionsLeft = $event['Event']['subscribe_max'] - count($event['Subscription']); ?>
          <?php if ($subscriptionsLeft < 1) : ?>
            </br>
            Maximum bereikt!
            <?php $showSubsciptionsButton = false; ?>
          <?php elseif ($subscriptionsLeft < 10) : ?>
            </br>
            Nog <?=$subscriptionsLeft?> inschrijvingen mogelijk!
          <?php endif; ?>
        </p>
      </div>
    <?php endif; ?>

    <?php if ($showSubsciptionsButton == true) : ?>
      <?=$this->Html->link('Schrijf in', array('controller' => 'subscriptions', 'action' => 'subscribe', $event['Event']['id']), array('class' => 'btn btn-default'))?><br/>
    <?php else : ?>
      <div class="alert alert-danger">
        <p class="text-center">
          Geen inschrijvingen meer mogelijk!
        </p>
      </div>
    <?php endif; ?>

  <?php else : ?>

    <div class="alert alert-danger"><font size='+2'>Momenteel geen inschrijvingen mogelijk.</font></div>

    <?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
      <?=$this->Html->link('Schrijf toch in', array('controller' => 'subscriptions', 'action' => 'subscribe', $event['Event']['id']), array('class' => 'btn btn-default'))?><br/>
    <?php endif; ?>

  <?php endif; ?>

  <?php if (isset($event['Event']['subscribe_date_start_nice'])) : ?>
    <!-- Inschrijven kan van <?=$event['Event']['subscribe_date_start_nice']?> tot <?=$event['Event']['subscribe_date_end_nice']?>. -->
  <?php endif; ?>

  <hr/>

  <font size='-1'>
  Hier is de lijst van de inschrijvingen:<br/>
  <br/>
  <table class='table table-striped table-condensed'>
  <tr>
  <th title='volgnummer'>Nr</th>
  <th title='datum inschrijving'>Datum</th>
  <th title='naam deelnemer'>Naam</th>
  </tr>
  <?php
  // toon de lijst van de inschrijvingen
    $inscount = 0;
    $inschrijvingen = $event['Subscription'];
    if (count($inschrijvingen) > 0) {
      foreach ($inschrijvingen as $inschrijving) {
        if ($inschrijving['confirmed'] == true) {
          $inscount += 1;
          print("<tr>\n");
          print("<td title='".$inschrijving['confirmed_stamp_nice']."' align='right'>" . $inscount . "</td>");
          print("<td title='datum inschrijving'>" . $inschrijving['created_nice'] . "</td>");
          print("<td title='naam deelnemer'>" . $inschrijving['subsname'] . "</td>");
          print("</tr>\n");
        }
      }
    } else {
      print("<tr><td colspan='3'>Nog geen inschrijvingen</td></tr>\n");
    }
  ?>
  </table>
  </font>


<?php else : ?>

  <!--
    <hr/>
    <div class="alert alert-primary"><font size='+1'>Dit is een evenement zonder inschrijvingen.</font></div>
    <hr/>
  -->

<?php endif; ?>


<br/>
<?php
// pr($event['Subscription']);
// pr($this->request);
?>
