<?php

class Paciente extends Usuario
{
    private string $address;
    public function __construct($name, $age, $phone, $email, $password, $rol, $address)
    {
        parent::__construct($name, $age, $phone, $email, $password, $rol);
        $this->address = $address;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
}
