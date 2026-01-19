<?php

class Doctor extends Usuario
{
    private string $specialty;
    public function __construct($id, $name, $age, $phone, $email, $password, $rol, $specialty)
    {
        parent::__construct($id, $name, $age, $phone, $email, $password, $rol);
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
