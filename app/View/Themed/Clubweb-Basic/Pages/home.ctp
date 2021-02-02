<div class='mainpage'>

  <div class="row">
    <div class="col-md-4">
      <div class='text-center'>
        <img src="<?= (isset($cmclub['logo']) ? $this->base."/img/".$cmclub['logo'] : $this->base."/img/sports.png") ?>" alt="logo" height="120">
      </div>
    </div>
    <div class="col-md-7">
      <div class='text-center'>
        <h1>
          <?= (isset($cmclub['name']) ? $cmclub['name'] : "Clubman") ?><br/>
          <small>Welkom op onze website</small>
        </h1>
      </div>
  	</div>
    <div class="col-md-1">
    </div>
  </div><!--row-->

  <div class='clubman-newscontainer'>

    <div class='clubman-newsitems'>

      <div class="clubman-newsblock well well-sm text-center">
    		<div class="clubman-newssubtitle small">Beheer uw sportclub</div>
    		<div class="clubman-newstitle">
					Naar Clubman
        </div>
        <div class="clubman-newsshortmessage">
          <p>
            Om in te loggen in Clubman, gelieve op onderstaande knop te drukken.
          </p>
          <?=$this->Html->link('Log in <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>', array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-default btn-lg', 'title' => 'naar clubman', 'escape' => false))?>
    		</div>
    	</div>

    </div>

    <div class='clubman-newsitems'>

      <?=$this->element('newsflash', array('displaytype' => 'accordeon'));?>

    </div>

    <hr/>

    <nav>
      <ul class="nav nav-pills nav-justified">
        <li class="info">
          <?=$this->Html->link('weekendoverzicht', array('controller' => 'games', 'action' => 'shortoverview', 'all', $weekkalender['meta']['begin']['dateYMD'], $weekkalender['meta']['end']['dateYMD']), array('title' => 'de wedstrijden van aanstaande weekend'))?>
        </li>
        <li>
          <?=$this->Html->link('jeugd thuis', array('controller' => 'games', 'action' => 'homeoverview', 'jeugdcompetitie', $weekkalender['meta']['begin']['dateYMD']), array('title' => 'de thuiswedstrijden van de jeugd'))?>
        </li>
        <!--
        <li>
          <?=$this->Html->link('uitgebreid weekendoverzicht', array('controller' => 'games', 'action' => 'overview', 'all', $weekkalender['meta']['begin']['dateYMD'], $weekkalender['meta']['end']['dateYMD']), array('title' => 'de wedstrijden van aanstaande weekend, maar dan gedetailleerder'))?>
        </li>
        -->
        <li>
          <?=$this->Html->link('overzicht wijzigingen', array('controller' => 'games', 'action' => 'changes'), array('title' => 'wijzigingen ten opzichte van de oorspronkelijke kalender'))?>
        </li>
      </ul>
    </nav>

    <hr/>

  </div><!-- newscontainer -->

</div><!-- mainpage -->

<?php
  //pr($weekkalender);
?>
