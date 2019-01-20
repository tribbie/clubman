<ul class="nav navbar-nav navbar-right">

  <?php foreach($cmmenuMerged as $menuitem) : ?>

    <?php if (isset($menuitem['sub'])) : ?>
      <li class="dropdown">
        <?=$this->Html->link($menuitem['main']['label'], $menuitem['main']['linkarray'], array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'role'=>'button', 'aria-haspopup'=>'true', 'aria-expanded'=>'false'))?>
        <ul class="dropdown-menu">

          <?php if (!empty($menuitem['main']['linkarray'])) : ?>
            <li>
              <?=$this->Html->link('Overview', $menuitem['main']['linkarray'], array('class'=>''))?>
            </li>
            <li role="separator" class="divider"></li>
          <?php endif; ?>


          <?php foreach ($menuitem['sub'] as $submenuitem) : ?>
            <?php if ($submenuitem['label'] == 'separator') : ?>
              <li role="separator" class="divider"></li>
            <?php elseif ($submenuitem['label'] == 'teamlist') : ?>
              <?php foreach($clubmanteams[$submenuitem['category']] as $clubmanteam) : ?>
                <li><?=$this->Html->link($clubmanteam['Team']['name'], array('controller' => 'teams', 'action' => 'view', $clubmanteam['Team']['id']))?></li>
              <?php endforeach; ?>
            <?php else : ?>
              <li>
                <?=$this->Html->link($submenuitem['label'], $submenuitem['linkarray'], array('class'=>''))?>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </li>
    <?php else : ?>
      <li>
        <?=$this->Html->link($menuitem['main']['label'], $menuitem['main']['linkarray'], array('class'=>''))?>
      </li>
    <?php endif; ?>

  <?php endforeach; ?>

  <li>
    <p class="navbar-btn">
      <?=$this->Html->link('Log uit <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>', array('controller' => 'users', 'action' => 'logout'), array('class' => 'btn btn-default', 'title' => 'naar clubweb', 'escape' => false)); ?>
    </p>
  </li>
<!--
  <li>
    <button class="btn btn-default navbar-btn">
      <?=$this->Html->link('Log in <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>', array('controller' => 'users', 'action' => 'login'), array('title' => 'naar clubman', 'escape' => false)); ?>
    </button>
  </li>
-->
</ul>
