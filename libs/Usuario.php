<?php

abstract class Usuario
{
    private int $id;
    protected string $name;
    protected int $age;
    protected int $phone;
    protected string $email;
    protected string $password;
    protected string $rol;

    public function __construct($id, $name, $age, $phone, $email, $password, $rol)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->rol = $rol;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAge(): int
    {
        return $this->age;
    }
    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getPhone(): int
    {
        return $this->phone;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getRol(): string
    {
        return $this->rol;
    }
    public function setRol($rol)
    {
        $this->rol = $rol;
    }
}
