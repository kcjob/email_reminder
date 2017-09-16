<?php
namespace UserSettings;

class ValidSessions{
  /**
    * NOTE: An array of sessions for users who have not opted out
    * @param type $allSessionsInArray, $ArrayOfoptoutIds
    * @return $validSessions
    */

  static function getValidSessions($allSessionsInArray, $ArrayOfoptoutIds){
    foreach($allSessionsInArray as $sessionObject){
      if (!in_array($sessionObject -> userId, $ArrayOfoptoutIds)){
        $validSessions[] = $sessionObject;
      }
    }
    if(count($validSessions) < 1)
    {
        echo "There are no users";
    }
    return $validSessions;
  }
}
