<?php
include_once("../../system/session.php");
//Trae los doctores activos que hay en la DB
$url = "http://localhost/Proyecto_Backend/api/doctores.php";
$response = file_get_contents($url);
$data = json_decode($response, true);
$totalDoctores = $data['total'];

//Se usa para mostrar el nombre del doctor asignado a las citas de hoy
$doctoresMap = [];
foreach ($data['data'] as $doctor) {
    $doctoresMap[$doctor['id']] = $doctor['name'];
}

//Se usa para mostrar el nombre del paciente asignado a las citas de hoy
$response = file_get_contents("http://localhost/Proyecto_Backend/api/pacientes.php");
$pacientes = json_decode($response, true);
$pacientesMap = [];
foreach ($pacientes as $paciente) {
    $pacientesMap[$paciente['id']] = $paciente['name'];
}

//Trae todas las citas y filtra las que estan pendientes de revision
$response = file_get_contents("http://localhost/Proyecto_Backend/api/citas.php");
$data = json_decode($response, true);
$pendientes = array_filter($data, function ($cita) {
    return isset($cita['state']) && $cita['state'] === "pendiente";
});
$totalPendientes = count($pendientes);

//Trae todas las citas y filtra las que ya fueron abiertas
$abiertas = array_filter($data, function ($cita) {
    return isset($cita['state']) && $cita['state'] !== "pendiente" && $cita['state'] !== "finalizada";
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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="/PROYECTO_BACKEND/assets/css/sidebar.css" />
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet" />

    <title>AdminHub</title>
</head>

<body>


    <?php include("../layout/sidebar.php") ?>


    <!-- CONTENT -->
    <section id="content">

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-bell-ring'></i>
                    <span class="text">
                        <h3><?php echo $totalPendientes ?></h3>
                        <p>Solicitudes de cita</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-calendar'></i>
                    <span class="text">
                        <h3><?php echo $totalAbiertas ?></h3>
                        <p>Citas asignadas</p>
                    </span>
                </li>
                <li>
                    <i class='bx bx-first-aid'></i>
                    <span class="text">
                        <h3><?php echo $totalDoctores ?></h3>
                        <p>Doctores</p>
                    </span>
                </li>
            </ul>


            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Citas de hoy</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Doctor</th>
                                <th>description</th>
                                <th>Fecha</th>
                                <th>Hora</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($citasHoy as $cita): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cita['paciente_nombre']) ?></td>
                                    <td><?= htmlspecialchars($cita['doctor_nombre']) ?></td>
                                    <td><?= htmlspecialchars($cita['description']) ?></td>
                                    <td><?= htmlspecialchars($cita['fecha']) ?></td>
                                    <td><?= htmlspecialchars($cita['hour']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src="../../assets/js/pageOut.js"></script>
</body>

</html>