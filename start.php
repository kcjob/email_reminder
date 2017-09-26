<?php

require_once( __DIR__ . '/vendor/autoload.php');
use \UserSettings\DBConnect;
use \UserSettings\UserSettingsDAO;
use \UserSettings\OptionNameIds;
use \UserSettings\ValidSessions;
Use \UserSessions\SessionDAO;
Use \UserSessions\Session;
use \UserSessions\EmailInfoFromSessions;
use \UserSessions\EmailTemplateView;
use \UserSessions\EmailMessage;
use \UserSessions\ConfigEmail;
use \UserSessions\EmailSender;
use \UserSessions\EmailMsgData;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('database');
$dbStream = new StreamHandler('log/emailReminder.log', Logger::WARNING);
$log->pushHandler($dbStream);


//CONNECT TO DATABASE
try {
    $connectToDb = DBConnect::getConnection();
} catch (Exception $e) {
    $log->error($e->getMessage());
    echo "Database connection failed\r\n";
    die();
}

//RETRIEVE THE IDS OF USERS WHO OPTOUT
try{
$option_name = 'optout';
$option_value = 1;

$settings = UserSettingsDAO::getAllSettings($connectToDb);

$ArrayOfoptionNameIds = OptionNameIds::getOptionNameIds($settings,$option_name, $option_value);
}catch(Exception $e){
$log->error($e->getMessage());
die("Query failed!!\r\n");
}
//print_r($settings);
//print_r($ArrayOfoptionNameIds);
//RETRIEVE USER Sessions
if(count($ArrayOfoptionNameIds) < 1)
{
  $log->error('There are no '. $option_name .' users');
  die("There are no ". $option_name ." users \r\n");
}

try{
  $allSessionsInArray = SessionDAO::getSessionData($connectToDb);
  }catch(Exception $e){
  $log->error($e->getMessage());
  die("Query... $getALlSettings... failed!!\r\n");
}
//print_r($allSessionsInArray);

$validSessions = ValidSessions::getValidSessions($allSessionsInArray,$ArrayOfoptionNameIds);
if(count($validSessions) < 1)
{
  $log->error('There are no valid sessions');
      die("There are no valid sessions \r\n");
}
//print_r($validSessions);

//
try {
    $emailDataArray = EmailInfoFromSessions::getEmailInfo($validSessions);
} catch (Exception $e) {
    $log->error($e->getMessage());
    echo "$emailDataArray Somethin aint working\n" . $e->getMessage();
}
//print_r($emailDataArray);
try {
    EmailMessage::createAndSendEmail($emailDataArray);
} catch (Exception $e) {
    $log->error($e->getMessage());
    echo "EmailMessage Somethin aint working\n" . $e->getMessage();
}
