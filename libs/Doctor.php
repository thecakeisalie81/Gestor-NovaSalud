<?php

class Doctor extends Usuario
{
    private string $specialty;
    public function __construct($db, $name, $age, $phone, $email, $rol, $specialty)
    {
        parent::__construct('doctor', $db, $name, $age, $phone, $email, $rol);
        $this->specialty = $specialty;
    }

    public function getSpecialty(): string
    {
        return $this->specialty;
    }
    public function setSpecialty($specialty)
    {
        $this->specialty = $specialty;
    }

    public function create()
    {
        if (!isset($this->password)) {
            throw new Exception("Debe asignar password antes de crear el doctor");
        }
        $query = "INSERT INTO " . $this->table . " (name, age, phone, email, pass, rol, specialty) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('siissss', $this->name, $this->age, $this->phone, $this->email, $this->password, $this->rol, $this->specialty);
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
        $query = "UPDATE " . $this->table . " SET name=?, age=?, phone=?, email=?, pass=?, rol=?, specialty=?  WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('siissssi', $this->name, $this->age, $this->phone, $this->email, $this->password, $this->rol, $this->specialty, $this->id);
        return $stmt->execute();
    }
}
