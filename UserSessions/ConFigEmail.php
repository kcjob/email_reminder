<?php
namespace UserSessions;

class ConfigEmail
{
  public $userName;
  public $userPassword;
  public $fromName;
  public $sentTo;
  public function __construct($userName, $userPassword,$fromName, $sentTo)
  {

    $this->userName = $userName;
    $this->userPassword = $userPassword;
    $this->fromName = $fromName;
    $this->sentTo = $sentTo;
  }
}
