<?php
namespace UserSessions;

class EmailSender
{
  static function mailmsg($msg, $emailDataObject, $configEmail)
  {
    $totalEmails = 0;
    $failures = [];

    // Create the Transport
    $transport = (new \Swift_SmtpTransport('outgoing.ccny.cuny.edu', 587, 'tls'))
      -> setUsername($configEmail->userName)
      -> setPassword($configEmail->userPassword);
    $mailer = new \Swift_Mailer($transport);

    // create and register logger
//    $logger = new Swift_Plugins_Loggers_EchoLogger();

   $sentEmaillogger = new \Swift_Plugins_Loggers_ArrayLogger();
    $mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($sentEmaillogger));


    // Create a message
    $message = (new \Swift_Message('Core Facilities Equipment Use'))
      -> setFrom($configEmail->fromName)
      -> setTo($emailDataObject->userEmailAddress) // users email addresses
      -> setTo($configEmail->sentTo)
      ->setContentType("text/html")
      -> setBody($msg);
    //echo $message->toString();

    // Send the message
    $mailer->send($message, $failures);

    // output log
    file_put_contents('sentEmails.log', $sentEmaillogger->dump());

/*
    //Display Results
    if ($mailer->send($message))
    {
      $totalEmails = $totalEmails + $numSent;
      printf("Total Email messages %d sent\n", $totalEmails);
    }
    if ($failures) {
      echo "Couldn't send to the following addresses:<br>";
      foreach ($failures as $failure) {
        echo $failure . '<br>';
      }
    }
*/
  }
}
