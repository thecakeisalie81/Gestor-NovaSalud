<?php

//Se usa para mostrar el doctor asignado a la cita
$url = "http://localhost/Gestor-NovaSalud/api/doctores.php";
$response = file_get_contents($url);
$data = json_decode($response, true);
$doctoresMap = [];
foreach ($data['data'] as $doctor) {
    $doctoresMap[$doctor['id']] = ['name' => $doctor['name'], 'specialty' => $doctor['specialty']];
}

//Trae todas las citas confirmadas del paciente
$response = file_get_contents("http://localhost/Gestor-NovaSalud/api/citas.php");
$data = json_decode($response, true);
$todasCitas = array_filter($data, function ($cita) {
    return isset($cita['paciente']) && $cita['paciente'] === $_SESSION['id'];
});

$misCitasConfirmadas = array_filter($data, function ($cita) {
    return isset($cita['paciente']) && $cita['paciente'] === $_SESSION['id'] && $cita['state'] === 'confirmada';
});
$totalCitasPaciente = count($misCitasConfirmadas);

$misCitasNoConfirmadas = array_filter($data, function ($cita) {
    return isset($cita['paciente']) && $cita['paciente'] === $_SESSION['id'] && $cita['state'] !== 'confirmada';
});



//Sirve  para mostrar los doctores y especialidad de las citas agendadas
foreach ($misCitasConfirmadas as &$cita) {
    if (isset($doctoresMap[$cita['doctor']])) {
        $cita['doctor_nombre']    = $doctoresMap[$cita['doctor']]['name'];
        $cita['doctor_specialty'] = $doctoresMap[$cita['doctor']]['specialty'];
    } else {
        $cita['doctor_nombre']    = '';
        $cita['doctor_specialty'] = '';
    }
}
unset($cita);

//Sirve  para mostrar los doctores y especialidad de las citas no agendadas
foreach ($misCitasNoConfirmadas as &$cita) {
    if (isset($doctoresMap[$cita['doctor']])) {
        $cita['doctor_nombre']    = $doctoresMap[$cita['doctor']]['name'];
        $cita['doctor_specialty'] = $doctoresMap[$cita['doctor']]['specialty'];
    } else {
        $cita['doctor_nombre']    = '';
        $cita['doctor_specialty'] = '';
    }
}
unset($cita);

//