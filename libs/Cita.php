<?php

class Cita
{
    private int $id;
    private string $date;
    private string $hour;
    private int $paciente;
    private int $doctor;
    private string $state;
    private string $description;

    public function __construct($id, $date, $hour, $paciente, $doctor, $state, $description)
    {
        $this->id = $id;
        $this->date = $date;
        $this->hour = $hour;
        $this->paciente = $paciente;
        $this->doctor = $doctor;
        $this->state = $state;
        $this->description = $description;
    }

    public function getId(): int
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
    public function set($description)
    {
        $this->description = $description;
    }
}
