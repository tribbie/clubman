<?=(trim($newsitem['Newsitem']['subtitle']) == '') ? 'Club nieuws' : trim($newsitem['Newsitem']['subtitle'])?>
<h2><?=$newsitem['Newsitem']['title']?></h2>

<?=$this->Markdown->transform($newsitem['Newsitem']['content'])?>
