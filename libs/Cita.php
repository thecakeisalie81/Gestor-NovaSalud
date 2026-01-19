<?php

class Cita
{
    protected $conn;
    protected $table;
    private ?int $id = null;
    private string $date;
    private string $hour;
    private int $paciente;
    private int $doctor;
    private string $state;
    private string $description;

    public function __construct($table, $db, $date, $hour, $paciente, $doctor, $state, $description)
    {
        $this->conn = $db;
        $this->table = $table;
        $this->date = $date;
        $this->hour = $hour;
        $this->paciente = $paciente;
        $this->doctor = $doctor;
        $this->state = $state;
        $this->description = $description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDate(): string
    {
        return $this->date;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getHour(): string
    {
        return $this->hour;
    }
    public function setHour($hour)
    {
        $this->hour = $hour;
    }

    public function getPaciente(): int
    {
        return $this->paciente;
    }
    public function setPaciente($paciente)
    {
        $this->paciente = $paciente;
    }

    public function getDoctor(): int
    {
        return $this->doctor;
    }
    public function setDoctor($doctor)
    {
        $this->doctor = $doctor;
    }

    public function getState(): string
    {
        return $this->state;
    }
    public function setState($state)
    {
        $this->state = $state;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " (fecha, hour, paciente, doctor, state, description) VALUES (?, ? ,?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssiiss', $this->date, $this->hour, $this->paciente, $this->doctor, $this->state, $this->description);
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
        $query = "UPDATE " . $this->table . " SET fecha=?, hour=?, paciente=?, doctor=?, state=?, description=?  WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssiissi', $this->date, $this->hour, $this->paciente, $this->doctor, $this->state, $this->description, $this->id);
        return $stmt->execute();
    }

    public function delete()
    {
        if ($this->id === null) {
            throw new Exception("No se puede eliminar sin ID");
        }
        $query = "DELETE FROM " . $this->table . " WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }
}
