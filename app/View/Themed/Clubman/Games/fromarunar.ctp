<?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root']))) : ?>
  <h3>ARUNAR info</h3>
  <p>
    Wekelijks ('s maandags om 2:00) worden de kalenders (komende weekend), uitslagen (vorig weekend) en rangschikkingen geëxporteerd.
  </p>

  <div class='box'>
    <p>
    <?php if ($xmlexists) : ?>
      De rangschikkingen van deze week (<?=$rangschikkingenxmlfile?>) is reeds gedownload.
      <ul>
        <li>Open de <a class="boldlink" href="<?=$this->base?>/<?=$rangschikkingenxmlfile?>">rangschikking van deze week</a></li>
      </ul>
    <?php else : ?>
      De rangschikkingen van deze week (<?=$rangschikkingenxmlfile?>) is nog niet gedownload.
      <ul>
        <li>Bekijk de <a class="boldlink" href="http://haezeleer.be/arunar/exports/vb_kalender.xml">wekelijkse kalender</a></li>
        <li>Bekijk de <a class="boldlink" href="http://haezeleer.be/arunar/exports/vb_rangschikkingen.xml">wekelijkse rangschikkingen</a></li>
        <li>Bekijk de <a class="boldlink" href="http://haezeleer.be/arunar/exports/vb_uitslagen.xml">wekelijkse uitslagen</a></li>
        <li>Bekijk de <a class="boldlink" href="http://haezeleer.be/arunar/rapporten/export4club.php?bond=vb&stamnr=VB1072">volledige kalender</a></li>
      </ul>
    <?php endif; ?>
    </p>
  </div>

  <hr/>
  <div class='box'>
    Alle rangschikkingen:
    <ul>
    <?php foreach($rangschikkingenxmlfiles as $afile) : ?>
      <li><a class="boldlink" href="<?=$this->base?>/<?=$afile['filename']?>">rangschikking van <?=$afile['filestamp']?></a></li>

    <?php endforeach; ?>
  </ul>
  </div>
  <hr/>

<?php
//  pr($rangschikkingenxmlfiles);
?>

<?php endif ; ?>
