<?php

//Trae los doctores activos que hay en la DB
$url = "http://localhost/Gestor-NovaSalud/api/doctores.php";
$response = file_get_contents($url);
$data = json_decode($response, true);

//Se usa para mostrar el nombre del doctor asignado a las citas de hoy
$doctoresMap = [];
foreach ($data['data'] as $doctor) {
    $doctoresMap[$doctor['id']] = $doctor['name'];
}

//Se usa para mostrar el nombre del paciente asignado a las citas de hoy
$response = file_get_contents("http://localhost/Gestor-NovaSalud/api/pacientes.php");
$pacientes = json_decode($response, true);
$pacientesMap = [];
foreach ($pacientes as $paciente) {
    $pacientesMap[$paciente['id']] = $paciente['name'];
}

//Trae todas las citas y filtra las que son del paciente logeado
$response = file_get_contents("http://localhost/Gestor-NovaSalud/api/citas.php");
$data = json_decode($response, true);
$misCitas = array_filter($data, function ($cita) {
    return isset($cita['paciente']) && $cita['paciente'] === $_SESSION['id'];
});
$totalCitasPaciente = count($misCitas);

//Trae las citas que estan asignadas para el dia de HOY
date_default_timezone_set("America/Costa_Rica");
$hoy = date("Y-m-d");
$citasHoy = array_filter($misCitas, function ($cita) use ($hoy) {
    return isset($cita['fecha']) && $cita['fecha'] === $hoy;
});
$totalHoy = count($citasHoy);

//Sirve  para mostrar los nombres de doctor y paciente que hay en las citas de hoy
foreach ($citasHoy as $cita) {

    $nombreDoctor = $doctoresMap[$cita['doctor']] ?? 'Doctor desconocido';
    $nombrePaciente = $pacientesMap[$cita['paciente']] ?? 'Paciente desconocido';

    $listaCitasHoy[] = [
        $nombreDoctor,
        $nombrePaciente
    ];
}

foreach ($citasHoy as &$cita) {
    $cita['doctor_nombre']   = $doctoresMap[$cita['doctor']] ?? '';
    $cita['paciente_nombre'] = $pacientesMap[$cita['paciente']] ?? '';
}
unset($cita);
