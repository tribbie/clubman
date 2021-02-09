<?php
class ClubmanUtilityLib {

  /// Function checks how many of the elements in findArray are found in the $listArray
  /// This is a function that can be used to see if one (or more) of my cumulated roles is in a specified list of roles
  public function elementsInArray($findArray, $listArray) {
    $timesFound = 0;
    foreach ($findArray as $oneElement) {
      if (in_array($oneElement, $listArray)) {
        $timesFound += 1;
      }
    }
    return $timesFound;
  }

}
