<?php

namespace Optout;

class UpdateUserSettings {
  //------------SETTER by EMAIL--------------------
  static function setUserSettingsByEmail($connectToDb, $settingsObject, $userEmail)
  {
    $qryUpdate = "UPDATE core_users
    SET settings = ?
    WHERE email = ?"; //'dfimiarz@ccny.cuny.edu'";
    $qryResults = $connectToDb->prepare($qryUpdate);
    if(!$qryResults){
		  throw new \Exception('Querry failed');
	  }
    $qryResults -> bind_param("ss", $settingsObject, $userEmail);
    $qryResults -> execute();
    //print_r($qryResults);
    if($qryResults->affected_rows > 0){
      echo ("You've been successfully removed from Core Facilty's Reminder System");
    }
  }

}
