<?php

class Admin extends Usuario
{
    private string $lastLogin;
    private int $activityLog;

    public function __construct($name, $age, $phone, $email, $password, $rol, $specialty)
    {
        parent::__construct($name, $age, $phone, $email, $password, $rol);
        $this->specialty = $specialty;
    }

    public function getSpecialty(): string
    {
        return $this->specialty;
    }
    public function setName($specialty)
    {
        $this->specialty = $specialty;
    }
}
