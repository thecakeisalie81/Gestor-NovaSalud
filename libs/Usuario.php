<?php

abstract class Usuario
{
    protected $conn;
    protected $table;
    protected ?int $id = null;
    protected string $name;
    protected int $age;
    protected int $phone;
    protected string $email;
    protected string $password;
    protected string $rol;
    protected ?string $state;


    public function __construct($table, $db, $name, $age, $phone, $email, $rol, $state = null)
    {
        $this->conn = $db;
        $this->table = $table;
        $this->name = $name;
        $this->age = $age;
        $this->phone = $phone;
        $this->email = $email;
        $this->rol = $rol;
        $this->state = $state;
    }

    public function getId(): ?int
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

    abstract public function create();
    abstract public function update();
    public function activar()
    {
        if ($this->id === null) {
            throw new Exception("No se puede activar sin ID");
        }

        $query = "UPDATE " . $this->table . " SET state=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $finalState = "Activo";
        $stmt->bind_param('si', $finalState, $this->id);

        if ($stmt->execute()) {
            return $stmt->affected_rows > 0;
        }
        return false;
    }

    public function delete()
    {
        if ($this->id === null) {
            throw new Exception("No se puede eliminar sin ID");
        }
        $query = "UPDATE " . $this->table . " SET state=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $finalState = "Inactivo";
        $stmt->bind_param('si', $finalState, $this->id);
        if ($stmt->execute()) {
            return $stmt->affected_rows > 0;
        }
        return false;
    }
}
