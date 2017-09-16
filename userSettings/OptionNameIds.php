<?php
namespace UserSettings;

class OptionNameIds
{
  /**
    * NOTE: Creates an arry of the IDs of users who satisfy $option_name
    * @param type $idAndSettingsArray, $option_name
    * @return Array $optionNameIds
    */
  static function getOptionNameIds($idAndSettingsArray, $option_name){
    //print_r($idAndSettingsArray);

    foreach($idAndSettingsArray as $idAndSettings)
    {
      //print_r($idAndSettings);
        $settingsOptionArray = json_decode($idAndSettings['settings'], TRUE);
        //print_r($settingsOptionArray);
        foreach($settingsOptionArray as $key => $value){
         if($key == $option_name){
            if($settingsOptionArray[$key] == 1){
              $optionNameIds[] = $idAndSettings['id'];
            }
          }

        }
    }
    return $optionNameIds;

  }
}
