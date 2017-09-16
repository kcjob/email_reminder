<?php

require_once( __DIR__ . '/vendor/autoload.php');

use \UserSettings\DBConnect;
use \UserSettings\UserSettingsDAO;
//use \UserSettings\UserSettingsAndIdsDAO;
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
$optout_name = 'optout';

$settings = UserSettingsDAO::getAllSettings($connectToDb);
$ArrayOfoptionNameIds = OptionNameIds::getOptionNameIds($settings,$optout_name);
}catch(Exception $e){
$log->error($e->getMessage());
die("Query failed!!\r\n");
}
//print_r($settings);
//print_r($ArrayOfoptionNameIds);
//RETRIEVE USER Sessions
if(count($ArrayOfoptionNameIds) < 1)
{
    echo "There are no option_name users";
}

try{
  $allSessionsInArray = SessionDAO::getSessionData($connectToDb);
  }catch(Exception $e){
  $log->error($e->getMessage());
  die("Query... $getALlSettings... failed!!\r\n");
}
//print_r($allSessionsInArray);

$validSessions = ValidSessions::getValidSessions($allSessionsInArray,$ArrayOfoptionNameIds);
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
