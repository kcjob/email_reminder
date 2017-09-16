<?php
namespace UserSessions;

class Session{
  public $userId;
  public $userEmail;
  public $coreEquipment;
  public $userName;
  public $sessionDate;
  public $sessionStartTime;
  public $sessionEndTime;

	public function __construct($userId, $userEmail,$coreEquipment, $userName, $sessionDate, $sessionStartTime, $sessionEndTime)
  {
    $this->userId = $userId;
    $this->userEmail = $userEmail;
    $this->coreEquipment = $coreEquipment;
    $this->userName = $userName;
    $this->sessionDate = $sessionDate;
    $this->sessionStartTime = $sessionStartTime;
    $this->sessionEndTime = $sessionEndTime;
  }

}
