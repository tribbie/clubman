<hr/>
<br/>
<div class="table-responsive">
	<table class='table table-striped table-condensed normalelijst'>
    <tr>
      <th colspan="6"><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : '')?> Clubman gebruikersoverzicht - per rol</th>
    </tr>
    <tr class="headerrow">
      <th>Id</th>
      <th>Gebruiker</th>
      <th>Status</th>
      <th>Naam</th>
      <th>Email</th>
      <th>Opmerking</th>
    </tr>
    <?php
      $currentrole = '';
      foreach($users as $user) {
        if ($user['User']['role'] <> $currentrole) {
          $currentrole = $user['User']['role'];
          echo '<tr class="groupheader">';
          echo '<td colspan="6"><strong>' . $currentrole . '</strong></td>';
          echo('</tr>');
        }
        echo '<tr>';
        echo '<td class="simplevalue">' . $user['User']['id'] . '</td>';
        echo '<td class="simplevalue">' . $user['User']['username'] . '</td>';
        echo '<td class="simplevalue">' . (($user['User']['active'] == 1) ? 'actief' : 'inactief') . '</td>';
        echo '<td class="simplevalue">' . $user['Member']['name'] . '</td>';
        echo '<td class="simplevalue">' . $user['Member']['email'] . '</td>';
        echo '<td class="simplevalue">' . $user['User']['remark'] . '</td>';
        echo '</tr>';
      }
    ?>
  </table>
</div>

<?php
// pr($users);
?>
