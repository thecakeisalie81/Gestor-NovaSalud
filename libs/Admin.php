<?php

class Admin extends Usuario
{
    private string $lastLogin;
    private int $activityLog;

    public function __construct($id, $name, $age, $phone, $email, $password, $rol, $lastLogin, $activityLog)
    {
        parent::__construct($id, $name, $age, $phone, $email, $password, $rol);
        $this->lastLogin = $lastLogin;
        $this->activityLog = $activityLog;
    }

    public function getLastLogin(): string
    {
        return $this->lastLogin;
    }
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    public function getActivityLog(): int
    {
        return $this->activityLog;
    }
    public function setActivityLog($activityLog)
    {
        $this->activityLog = $activityLog;
    }
}
