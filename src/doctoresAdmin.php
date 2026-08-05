<?php

//Trae los doctores activos y inactivos que hay en la DB
$url = "http://localhost/Gestor-NovaSalud/api/doctores.php";
$response = file_get_contents($url);
$data = json_decode($response, true);
$doctoresActivos = array_filter($data['data'], function ($doctor) {
    return isset($doctor['state']) && $doctor['state'] === "Activo";
});
$totalDoctoresActivos = count($doctoresActivos);

$doctoresInactivos = array_filter($data['data'], function ($doctor) {
    return isset($doctor['state']) && $doctor['state'] === "Inactivo";
});
$totalDoctoresInactivos = count($doctoresInactivos);
