<?php
namespace UserSessions;
use UserSessions\EmailMessageData;
use UserSessions\ConfigEmail;

class EmailMessage
{
  static function createAndSendEmail(array $emailDataArray){
    $email_params = parse_ini_file("emailParams.ini");
    foreach ($emailDataArray as $emailDataObject) {
      $objValues = get_object_vars($emailDataObject);
      //print_r($emailDataObject);
      $app = new EmailTemplateView();
      $msg = $app->generateView($objValues);
      $configEmail = new ConfigEmail($email_params['userName'] , $email_params['userPassword'],$email_params['fromName'], $email_params['sentTo']);
      //EmailSender::mailmsg($msg, $userEmailsAddress, $configEmail);
      EmailSender::mailmsg($msg, $emailDataObject, $configEmail);
    }
  }
}
