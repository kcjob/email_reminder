<?php
namespace UserSettings;

class UserSettingsAndIdsDAO {
  /**
    * NOTE: fetch_array does not work with prepare()
    *  Returns an array of the ids who opted out
    * @param type $connectToDb
    * @return Array $settings
    */
  static function getAllSettings($connectToDb)
  {
    /**
      * NOTE: fetch_array does not work with prepare()
      *  Returns an array of the ids who opted out
      * @param type $connectToDb
      * @return Array $settings
      */
    $usersAndSettings = [];
    $qry = "SELECT id,settings FROM core_users"; // limit 2";

    $qryResult = $connectToDb->query($qry); //prepare($qry);
    if(!$qryResult){
      throw new \Exception('Querry failed');
    }
    while($row = $qryResult -> fetch_array(MYSQLI_ASSOC)){
      $settings[] = $row; //An array of assoc arrays
    }
    return $settings;
  }

}
