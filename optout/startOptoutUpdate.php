<?php

require_once( __DIR__ . '/vendor/autoload.php');

use \Optout\DBConnect;
use \Optout\OptoutDAO;
use \Optout\AddUserToDB;
use \Optout\UpdateUserSettings;
/*
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('database');
$dbStream = new StreamHandler('log/emailReminder.log', Logger::WARNING);
$log->pushHandler($dbStream);
*/

$userEmail = $_POST["emailAddy"];
$settingsObject = '{"optout": 1}';

//CONNECT TO DATABASE
try {
    $connectToDb = DBConnect::getConnection();
} catch (Exception $e) {
    $log->error($e->getMessage());
    echo "Database connection failed\r\n";
    die();
}

try {
    UpdateUserSettings::setUserSettingsByEmail($connectToDb, $settingsObject, $userEmail);
    //print_r($connectToDb);
} catch (Exception $e) {
    //$log->error($e->getMessage());
    echo "Somethin aint working\n" . $e->getMessage();
}
