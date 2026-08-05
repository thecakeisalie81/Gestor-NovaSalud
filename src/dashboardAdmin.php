<?php

//Trae los admins que hay en la DB
$url = "http://localhost/Gestor-NovaSalud/api/administradores.php";
$response = file_get_contents($url);

if ($response === false) {
    $data = []; // si la API no responde, inicializa como array vacío
} else {
    $data = json_decode($response, true);
    if (!is_array($data)) {
        $data = []; // si la respuesta no es un array válido
    }
}

$admins = array_filter($data, function ($admin) {
    return isset($admin['state']) && $admin['state'] === "Activo";
});
$totalAdminsActivos = count($admins);

$adminsInactivos = array_filter($data, function ($admin) {
    return isset($admin['state']) && $admin['state'] === "Inactivo";
});
$totalAdminsInactivos = count($adminsInactivos);


//Trae los doctores activos que hay en la DB
$url = "http://localhost/Gestor-NovaSalud/api/doctores.php";
$response = file_get_contents($url);
$data = json_decode($response, true);
$totalDoctores = $data['total'];

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

//Trae todas las citas y filtra las que estan pendientes de revision
$response = file_get_contents("http://localhost/Gestor-NovaSalud/api/citas.php");
$data = json_decode($response, true);
$pendientes = array_filter($data, function ($cita) {
    return isset($cita['state']) && $cita['state'] === "pendiente";
});
$totalPendientes = count($pendientes);

//Trae todas las citas y filtra las que ya fueron asignadas
$abiertas = array_filter($data, function ($cita) {
    return isset($cita['state']) && $cita['state'] === "confirmada";
});
$totalAbiertas = count($abiertas);

//Trae las citas que estan asignadas para el dia de HOY
date_default_timezone_set("America/Costa_Rica");
$hoy = date("Y-m-d");
$citasHoy = array_filter($data, function ($cita) use ($hoy) {
    return isset($cita['fecha']) && $cita['fecha'] === $hoy;
});
$totalHoy = count($citasHoy);

//Sirve  para mostrar los nombres de doctor y paciente que hay en las citas de hoy
foreach ($citasHoy as &$cita) {
    $cita['doctor_nombre']   = $doctoresMap[$cita['doctor']] ?? '';
    $cita['paciente_nombre'] = $pacientesMap[$cita['paciente']] ?? '';
}
unset($cita);

//