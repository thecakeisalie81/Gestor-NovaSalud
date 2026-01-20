<?php

class Paciente extends Usuario
{
    private string $address;
    public function __construct($db, $name, $age, $phone, $email, $rol, $address, $state = null)
    {
        parent::__construct('paciente', $db, $name, $age, $phone, $email, $rol, $state);
        $this->address = $address;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function create()
    {
        if (!isset($this->password)) {
            throw new Exception("Debe asignar password antes de crear el paciente");
        }
        $query = "INSERT INTO " . $this->table . " (name, age, phone, email, pass, rol, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('siissss', $this->name, $this->age, $this->phone, $this->email, $this->password, $this->rol, $this->address);
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
        $query = "UPDATE " . $this->table . " SET name=?, age=?, phone=?, email=?, pass=?, rol=?, address=?  WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('siissssi', $this->name, $this->age, $this->phone, $this->email, $this->password, $this->rol, $this->address, $this->id);
        return $stmt->execute();
    }
}
