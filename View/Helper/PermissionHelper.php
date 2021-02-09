<?php
/*
 /app/View/Helper/PermissionHelper.php

 A helper to
*/
App::uses('AppHelper', 'View/Helper');

class PermissionHelper extends AppHelper {

  public function iAmOneOf($currentRoles, $listOfRoles) {
    /// check is one of the roles of the user is in the list of role
    /// If it is, then return true
    $amI = false;
    foreach ($currentRoles as $oneRole) {
      if (in_array($oneRole, $listOfRoles)) {
        $amI = true;
      }
    }
    return $amI;
  }

}
