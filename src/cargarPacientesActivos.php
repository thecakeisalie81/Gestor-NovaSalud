<?php

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Obtener pacientes activos desde la API
$urlPacientes = "http://localhost/Gestor-NovaSalud/api/pacientes.php";
$responsePacientes = file_get_contents($urlPacientes);
$pacientesData = json_decode($responsePacientes, true);
$pacientes = is_array($pacientesData) ? $pacientesData : [];
