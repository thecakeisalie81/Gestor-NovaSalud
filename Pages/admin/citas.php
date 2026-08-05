<?php
include_once("../../system/session.php");
include_once("../../src/citasAdmin.php");
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
    <link rel="stylesheet" href="../../assets/css/sidebar.css" />
    <link rel="stylesheet" href="../../assets/css/button.css" />

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
                    <h1>Administracion de citas</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Administracion de citas</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="text">
                        <h3><?php echo $totalAbiertas ?></h3>
                        <p>Citas agendadas</p>
                    </span>
                </li>
                <li>
                    <i class='bx bx-time'></i>
                    <span class="text">
                        <h3><?php echo $totalPendientes ?></h3>
                        <p>Citas pendientes de aprobacion</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Citas por pendientes de aprobacion</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Especialidad</th>
                                <th>description</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($misCitasNoConfirmadas as $cita): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cita['doctor_nombre']) ?></td>
                                    <td><?= htmlspecialchars($cita['doctor_specialty']) ?></td>
                                    <td><?= htmlspecialchars($cita['description']) ?></td>
                                    <td><?= htmlspecialchars($cita['fecha']) ?></td>
                                    <td><?= htmlspecialchars($cita['hour']) ?></td>
                                    <td>
                                        <button
                                            class="btn-aprobado"
                                            data-id="<?= $cita['id'] ?>">
                                            <i class='bx bx-check-circle'></i> Aprobar
                                        </button>

                                        <button
                                            class="btn-noaprobado"
                                            data-id="<?= $cita['id'] ?>">
                                            <i class='bx bxs-x-circle'></i> No aprobar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Citas agendadas</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Especialidad</th>
                                <th>description</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($misCitasConfirmadas as $cita): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cita['doctor_nombre']) ?></td>
                                    <td><?= htmlspecialchars($cita['doctor_specialty']) ?></td>
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
    <script src="../../assets/js/cambiarEstado.js"></script>
</body>

</html>