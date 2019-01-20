<?php
/*
 /app/View/Helper/LinkHelper.php

 A helper to
*/
App::uses('AppHelper', 'View/Helper');

class LinkHelper extends AppHelper {
  public $helpers = array('Html');

  public function cakephpExample_makeEdit($title, $url) {
    // Use the HTML helper to output
    // formatted data:
    $link = $this->Html->link($title, $url, array('class' => 'edit'));
    return '<div class="editOuter">' . $link . '</div>';
  }

  public function mergeLinkIds($linkIdsPerRole, $currentRoles) {
    $mergedLinks = array();
  	foreach ($currentRoles as $oneRole) {
  		foreach ($linkIdsPerRole[$oneRole] as $linkId) {
  			$mergedLinks[$linkId][] = $oneRole;
  		}
  	}
    return $mergedLinks;
  }

  public function showLinks($linkInfo, $linkIdsToShow) {
    $theLinks = '';
    foreach ($linkIdsToShow as $linkId => $linkOrigin) {
      $theLinks .= $this->Html->link($linkInfo[$linkId]['linktext'], $linkInfo[$linkId]['linkoptions'])."<br/>\n";
    }
    return $theLinks;
  }

}
