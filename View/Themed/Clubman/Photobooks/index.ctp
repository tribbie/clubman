<h2><?= (isset($cmclub['shortname']) ? $cmclub['shortname'] . ' - ' : 'Club') ?> foto albums</h2>

<div class="table-responsive">
	<table class='table table-striped table-condensed normalelijst'>
    <?php foreach ($photobooks as $photobook) : ?>
      <tr>
        <td class="text-center">
          <?php
            $image = $this->Html->image($photobook['Photobook']['cover'], array('alt' => $photobook['Photobook']['title'], 'width' => '64'));
            echo $this->Html->link($image, $photobook['Photobook']['url'], array('target'=>'_blank', 'escape' => false));
          ?>
        </td>
        <td>
          <?=$this->Html->link($photobook['Photobook']['title'], $photobook['Photobook']['url'], array('class' => 'boldlink', 'target' => '_blank'))?>
        </td>
        </tr>
    <?php endforeach; ?>
  </table>
</div>

<br/>
<?php
  pr($files);
  pr($photobooks);
?>
