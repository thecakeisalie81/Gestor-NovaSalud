<?php

class Admin extends Usuario
{
    private string $lastLogin;
    private int $activityLog;

    public function __construct($db, $name, $age, $phone, $email, $rol, $lastLogin, $activityLog, $state)
    {
        parent::__construct('admin', $db, $name, $age, $phone, $email, $rol, $state);
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

    public function create()
    {
        if (!isset($this->password)) {
            throw new Exception("Debe asignar password antes de crear el admin");
        }
        $query = "INSERT INTO " . $this->table . " (name, age, phone, email, pass, rol, lastLogin, activityLog) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('siissssi', $this->name, $this->age, $this->phone, $this->email, $this->password, $this->rol, $this->lastLogin, $this->activityLog);
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
        $query = "UPDATE " . $this->table . " SET name=?, age=?, phone=?, email=?, pass=?, rol=?, lastLogin=?, activityLog=?   WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('siisssisi', $this->name, $this->age, $this->phone, $this->email, $this->password, $this->rol, $this->lastLogin, $this->activityLog, $this->id);
        return $stmt->execute();
    }
}
