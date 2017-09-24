<?php

require_once( __DIR__ . '/vendor/autoload.php');

use \UserSettings\DBConnect;
use \UserSettings\UserSettingsDAO;
use \SettingsOptions\UpdateSettingsOption;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$settingsLog = new Logger('database');
$dbStream = new StreamHandler('log/emailReminder.log', Logger::WARNING);
$settingsLog->pushHandler($dbStream);


$userEmail =  $_POST["emailAddy"];
$option_name = 'optout';
$option_value = 1;

//CONNECT TO DATABASE
try {
    $connectToDb = DBConnect::getConnection();
} catch (Exception $e) {
    $log->error($e->getMessage());
    echo "Database connection failed\r\n";
    die();
}

//GET SETTINGS VALUE BY EMAIL
try{
    $settingsValue = UserSettingsDAO::getSettingsByEmail($connectToDb, $userEmail);
} catch(Exception $e){
    $settingsLog->error($e->getMessage());
    echo $e->getMessage();
}
//print_r($settingsValue);

$newSettingsValue = UpdateSettingsOption::updateSettingsOptionValue($settingsValue,$option_name, $option_value);

//update the settings column with new json string
try {
    UserSettingsDAO::setSettingsByEmail($connectToDb, $newSettingsValue, $userEmail);
    //print_r($connectToDb);
} catch (Exception $e) {
    $settingsLog->error($e->getMessage());
    echo $e->getMessage();
}
