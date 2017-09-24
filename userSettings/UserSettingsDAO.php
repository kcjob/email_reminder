<?php

namespace UserSettings;
use UserSettings\DBConnect;

class UserSettingsDAO
{
  /**
  * Data Access Object
  * Because static methods are callable without an instance of the object created,
  * the pseudo-variable $this is not available inside the method declared as static.
  */
  private $option_name;
  private $user_id;

  function __construc()
  {

  }


  //------------SETTER by EMAIL--------------------
  static function setSettingsByEmail($connectToDb, $settingsObject, $userEmail)
  {

    $UpdateOptionQuery = "UPDATE core_users
                          SET settings = ?
                          WHERE email = ?";

    $OptionQueryResult = $connectToDb->prepare($UpdateOptionQuery);
    if(!$OptionQueryResult){
      throw new Exception('Querry failed');
    }
    $OptionQueryResult -> execute();
	  $OptionQueryResult -> bind_param('ss', $settingsObject, $userEmail);
    $OptionQueryResult -> execute();
  }

  //------------SETTER by ID--------------------
  static function setSettingsById($connectToDb, $settingsObject, $user_id)
  {

    $UpdateOptionQuery = "UPDATE core_users
                          SET settings = ?
                          WHERE id = ?";

    $OptionQueryResult = $connectToDb->prepare($UpdateOptionQuery);
    if(!$OptionQueryResult){
      throw new Exception('Querry failed');
    }
    $OptionQueryResult -> execute();
	  $OptionQueryResult -> bind_param('ss', $settingsObject, $user_id);
    $OptionQueryResult -> execute();
  }



  //------------GETTER BY ID--------------------
  static function getSettingsByUser_id($connectToDb, $user_id)
  {
    $optionByUser_idQuery = "SELECT settings
                    FROM core_users
                    WHERE id = ?";

    $queryResult = $connectToDb->prepare($optionByUser_idQuery);
    if(!$queryResult){
      throw new Exception('Querry failed');
    }
    $queryResult -> bind_param('i', $user_id);
    $queryResult -> execute();
    $queryResult -> bind_result($settings);

    try{
      $queryResult -> fetch();
      return  $settings; //$this -> parseJson($settings, $option_name);
    } catch (Exception $e) {
      $log->error($e->getMessage());
      echo "Database connection failed\r\n";
      die();
    }

  }

  //------------GETTER BY EMAIL--------------------
  static function getSettingsByEmail($connectToDb, $email)
  {
    $optionByEmailQuery = "SELECT settings
                    FROM core_users
                    WHERE email = ?";

    $queryResult = $connectToDb->prepare($optionByEmailQuery);
    if(!$queryResult){
      throw new Exception('Querry failed');
    }
    $queryResult -> bind_param('s', $email);
    $queryResult -> execute();
    $queryResult -> bind_result($settings);

    try{
      $queryResult -> fetch();
      return  $settings; //$this -> parseJson($settings, $option_name);
    } catch (Exception $e) {
      $log->error($e->getMessage());
      echo "Database connection failed\r\n";
      die();
    }

  }

  //------------------GETTER ALL SETTINGS-----------------
  static function getAllsettings($connectToDb)
  {
    /**
      * NOTE: fetch_array does not work with prepare()
      *  Returns an array of the ids who opted out
      * @param type $connectToDb
      * @return Array $settings
      */
    $usersAndSettings = [];
    $qry = "SELECT id,settings FROM core_users limit 3";

    $qryResult = $connectToDb->query($qry); //prepare($qry);
    if(!$qryResult){
      throw new \Exception('$GetAllSettings Querry failed');
    }
    while($row = $qryResult -> fetch_array(MYSQLI_ASSOC)){
      $settings[] = $row; //An array of assoc arrays
    }
    return $settings;
  }


  //----------------
  static function parseJson($settings, $option_name)
  {
    if($settings == ""){
      return false;
    }
    $settingsOptionArray = json_decode($settings, TRUE);
    foreach($settingsOptionArray as $key => $value){
      if($settingsOptionArray[$option_name])
        return true;
    }
  }

}
