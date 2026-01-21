<?php

class Admin extends Usuario
{
    private string $lastLogin;

    public function __construct($db, $name, $age, $phone, $email, $rol, $lastLogin, $state = null)
    {
        parent::__construct('admin', $db, $name, $age, $phone, $email, $rol, $state);
        $this->lastLogin = $lastLogin;
    }

    public function getLastLogin(): string
    {
        return $this->lastLogin;
    }
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }


    public function create()
    {
        if (!isset($this->password)) {
            throw new Exception("Debe asignar password antes de crear el admin");
        }
        $query = "INSERT INTO " . $this->table . " (name, age, phone, email, pass, rol, lastLogin) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('siissss', $this->name, $this->age, $this->phone, $this->email, $this->password, $this->rol, $this->lastLogin);
        if ($stmt->execute()) {
            $this->id = $this->conn->insert_id;
            return true;
        }

        return false;
    }

    public function update()
    {
        if ($this->id === null) {
            throw new Exception("No se puede actualizar sin ID");
        }
        $query = "UPDATE " . $this->table . " SET name=?, age=?, phone=?, email=?, pass=?, rol=?, lastLogin=?   WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('siissssi', $this->name, $this->age, $this->phone, $this->email, $this->password, $this->rol, $this->lastLogin, $this->id);
        if ($stmt->execute()) {
            return $stmt->affected_rows > 0;
        }
        return false;
    }
}
