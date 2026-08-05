<?php
//Se usa para mostrar el nombre del paciente asignado a las citas
$response = file_get_contents("http://localhost/Gestor-NovaSalud/api/pacientes.php");
$pacientes = json_decode($response, true);
$pacientesMap = [];
foreach ($pacientes as $paciente) {
    $pacientesMap[$paciente['id']] = $paciente['name'];
}

//Trae todas las citas y filtra las que son del doctor logeado, ademas de ser citas confirmadas
$response = file_get_contents("http://localhost/Gestor-NovaSalud/api/citas.php");
$data = json_decode($response, true);
$misCitas = array_filter($data, function ($cita) {
    return isset($cita['doctor']) && $cita['doctor'] === $_SESSION['id'] && $cita['state'] === 'confirmada';
});
$totalCitasDoctor = count($misCitas);


//Sirve  para mostrar los mombres de los pacientes que hay en las citas de hoy
foreach ($misCitas as &$cita) {
    $cita['paciente_nombre'] = $pacientesMap[$cita['paciente']] ?? '';
}
unset($cita);
