<?php
namespace UserSessions;
use UserSessionsEmailMessageData;

class EmailInfoFromSessions
{
  static function getEmailInfo($validSessions){
    $emailMsgArray = [];

    foreach ($validSessions as $session) {
      $userId = $session -> userId;
      $emailData = new EmailMessageData($session); // create a new object

      if (!array_key_exists($userId, $emailMsgArray)){
        $emailMsgArray[$userId] = $emailData;
        array_push($emailMsgArray[$userId] -> dataArray, $emailData -> sessionData);
      } else {
        array_push($emailMsgArray[$userId] -> dataArray, $emailData -> sessionData);
      }
    }
    return $emailMsgArray;
  }

}
