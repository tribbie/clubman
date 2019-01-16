<!-- app/View/Newsitems/view.ctp -->
<?=(trim($newsitem['Newsitem']['subtitle']) == '') ? 'Club nieuws' : trim($newsitem['Newsitem']['subtitle'])?>

<h2><?=$newsitem['Newsitem']['title']?></h2>

<?php if (trim($newsitem['Newsitem']['image_url']) != '') : ?>
<div class='newsitemview imgright'>
  <p align=center>
    <img src='<?=$this->base."/files/uploads/".$newsitem['Newsitem']['image_url']?>' class='imgright' height='240' title='<?= (isset($cmclub['shortname']) ? $cmclub['shortname'] . ' - ' : 'Clubman') ?>' alt='foto'/>
  </p>
</div>
<?php endif ; ?>

<div class='newsitemview'>
  <?=$this->Markdown->transform($newsitem['Newsitem']['content'])?>
</div>


<hr/>

<!--<h4><?=$newsitem['Newsitem']['name']?></h4>-->
<!--<h4>Foto "<?=$newsitem['Newsitem']['image_url']?>"</h4>-->
<?php
// pr($newsitem);
?>
