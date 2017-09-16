<?php
namespace UserSessions;

class EmailSender
{
  static function mailmsg($msg, $emailDataObject, $configEmail)
  {

    // Create the Transport
    $transport = (new \Swift_SmtpTransport('outgoing.ccny.cuny.edu', 587, 'tls'))
      -> setUsername($configEmail->userName)
      -> setPassword($configEmail->userPassword);

    // Create the Mailer using your created Transport
    $mailer = new \Swift_Mailer($transport);

    // Create a message
    $message = (new \Swift_Message('Core Facilities Equipment Use'))
      -> setFrom($configEmail->fromName)
      //-> setTo($useremailAddress) // users email addresses
      //-> setTo($emailDataObject->userEmailAddress) // users email addresses
//      -> setTo($configEmail->sentTo)
      ->setContentType("text/html")
      -> setBody($msg);
    // Send the message
    $numSent = $mailer->send($message, $failures);

    /*
    // Note that often that only the boolean equivalent of the
    //return value is of concern (zero indicates FALSE)
    $totalEmails = 0;
    if ($mailer->send($message))
    {
      $totalEmails = $totalEmails + $numSent;
      //echo "Sent\n";
    }
    else
    {
      echo "Failed\n";
    }
    printf("Total Emails messages %d sent\n", $totalEmails);
    */
  }
}
