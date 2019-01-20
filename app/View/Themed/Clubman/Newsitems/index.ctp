<!-- app/View/Newsitems/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> nieuws</h2>

<?=$this->Html->link("Nieuw nieuwsbericht", array('controller' => 'newsitems', 'action' => 'add'))?>
<hr/>

<div class='row'>
  <div class="col-sm-12">

    <div class="table-responsive">
      <table class="table table-striped table-condensed normalelijst">
        <tr class="groupheader info">
          <th>season</th>
          <th>id</th>
          <th>category</th>
          <th>title</th>
          <th>author</th>
          <th>status</th>
          <th class="text-right">actief van</th>
          <th class="text-right">tot</th>
          <th>akties</th>
        </tr>
        <?php foreach ($newsitems as $newsitem) : ?>
            <tr>
              <td><?=$newsitem['Newsitem']['season']?></td>
              <td><?=$this->Html->link('('.$newsitem['Newsitem']['id'].')', array('controller' => 'newsitems', 'action' => 'view', 'id' => $newsitem['Newsitem']['id']), array('class' => 'boldlink'))?></td>
              <td><?=$newsitem['Newsitem']['category']?></td>
              <td><?=$this->Html->link($newsitem['Newsitem']['title'], array('controller' => 'newsitems', 'action' => 'view', $newsitem['Newsitem']['name']), array('class' => 'boldlink'))?></td>
              <td><?=$newsitem['Newsitem']['author']?></td>
              <td><?=$newsitem['Newsitem']['status']?></td>
              <td class="text-right"><?=$newsitem['Newsitem']['activate_nice']?></td>
              <td class="text-right"><?=$newsitem['Newsitem']['expire_nice']?></td>
              <td>
      					<?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'newsitems', 'action' => 'edit', $newsitem['Newsitem']['id']), array('title' => 'wijzig dit nieuwsbericht', 'escape' => false))?>
              </td>
            </tr>
        <?php endforeach; ?>
      </table>
    </div>

  </div>
</div>


<?php
// pr($newsitems);
?>
