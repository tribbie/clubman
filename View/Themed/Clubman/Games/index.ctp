<!-- app/View/Games/index.ctp -->
<h2>Overzicht <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : "Clubman")?> wedstrijden</h2>

<?=$this->Html->link('Nieuwe wedstrijd', array('controller' => 'games', 'action' => 'add'))?>
<hr/>

<div class="row">
  <div class="col-sm-12">

		<div class="table-responsive">
			<table class="table table-striped table-condensed normalelijst">
				<tr class='groupheader info'>
					<th class="text-right">Datum</th>
					<th>Tijdstip</th>
          <th>Team</th>
					<th>Type</th>
          <th>Data</th>
					<th>Thuisploeg</th>
					<th>Bezoekers</th>
					<th>Opmerking</th>
					<th>Aktie</th>
				</tr>
				<?php foreach ($games as $game) : ?>
          <?php
    				$trtitle = $game['Game']['game_code'];
    				if ($game['Game']['game_change'] == '') {
    					$tdclass = "";
    				} elseif ($game['Game']['game_change'] == 'afgelast') {
    					$tdclass = "class='gamecancel'";
    					$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
    				} elseif ($game['Game']['game_change'] == 'te verplaatsen') {
    					$tdclass = "class='gametochange'";
    					$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
    				} else {
    					$tdclass = "class='gamechange'";
    					$trtitle .= " (wedstrijd " . $game['Game']['game_change'] . ")";
    				}
    			?>
    			<!-- De wedstrijd -->
    			<tr title="<?=$trtitle?>">
            <td class="text-right"><?=$this->Html->link($game['Game']['game_date_nice'], array('controller' => 'games', 'action' => 'view', $game['Game']['id']))?></td>
						<td><?=$game['Game']['game_time_nice']?></td>
            <td <?=$tdclass?>><?=$game['Team']['name']?></td>
						<td <?=$tdclass?>><?=$game['Game']['game_code']?></td>
            <td><?=(count($game['Gamesteammember']) == 0) ? '' : count($game['Gamesteammember'])?></td>
						<td <?=$tdclass?>><?=$game['Game']['game_home']?></td>
						<td <?=$tdclass?>><?=$game['Game']['game_away']?></td>
						<td><?=$game['Game']['remark']?></td>
						<td>
              <?=$this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('controller' => 'games', 'action' => 'edit', $game['Game']['id']), array('title' => 'wijzig deze wedstrijd', 'escape' => false))?>
              <?php if ($loggedIn and ($this->Permission->iAmOneOf($cmCurrentRoles, ['root', 'admin']))) : ?>
                <?=$this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'games', 'action' => 'delete', $game['Game']['id']), array('title' => 'verwijder deze wedstrijd', 'escape' => false))?>
              <?php endif; ?>
            </td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>

<?php
// pr($games);
?>
