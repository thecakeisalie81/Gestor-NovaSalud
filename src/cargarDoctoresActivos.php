<?php

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Obtener doctores activos desde la API

$urlDoctores = "http://localhost/Gestor-NovaSalud/api/doctores.php";
$responseDoctores = file_get_contents($urlDoctores);
$doctoresData = json_decode($responseDoctores, true);
$doctoresActivos = array_filter($doctoresData['data'], function ($doctor) {
    return isset($doctor['state']) && $doctor['state'] === "Activo";
});
