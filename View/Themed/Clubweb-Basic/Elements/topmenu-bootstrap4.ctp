<ul class="navbar-nav ml-auto">

  <?php foreach($cmmenuMerged as $menukey => $menuitem) : ?>

    <?php if (isset($menuitem['sub'])) : ?>
      <li class="nav-item dropdown">
        <?=$this->Html->link($menuitem['main']['label'], $menuitem['main']['linkarray'], array('class'=>'nav-link dropdown-toggle', 'id' => 'dropdown-'.$menukey, 'data-toggle'=>'dropdown', 'aria-haspopup'=>'true', 'aria-expanded'=>'false'))?>
        <div class="dropdown-menu" aria-labelledby="dropdown-<?=$menukey?>">
          <?php foreach ($menuitem['sub'] as $submenuitem) : ?>
            <?php if ($submenuitem['label'] == 'separator') : ?>
              <div class="dropdown-divider"></div>
            <?php elseif ($submenuitem['label'] == 'teamlist') : ?>
              <?php foreach($clubmanteams[$submenuitem['category']] as $clubmanteam) : ?>
                <?=$this->Html->link($clubmanteam['Team']['name'], array('controller' => 'teams', 'action' => 'view', 'name' => $clubmanteam['Team']['shortname']), array('class'=>'dropdown-item'))?>
              <?php endforeach; ?>
            <?php else : ?>
              <?=$this->Html->link($submenuitem['label'], $submenuitem['linkarray'], array('class'=>'dropdown-item'))?>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </li>
    <?php else : ?>
      <li class="nav-item">
        <?=$this->Html->link($menuitem['main']['label'], $menuitem['main']['linkarray'], array('class'=>'nav-link'))?>
      </li>
    <?php endif; ?>

  <?php endforeach; ?>

  <li class="nav-item">
      <?=$this->Html->link('Log in <span class="fa fa-sign-in" aria-hidden="true"></span>', array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-outline-dark', 'title' => 'naar clubman', 'escape' => false)); ?>
  </li>

</ul>
