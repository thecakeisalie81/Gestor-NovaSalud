<?php
include_once("../../system/session.php");
include_once("../../src/citasAsignadas.php");
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
                    <h1>Calendario de citas</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Calendario</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="text">
                        <h3><?php echo $totalCitasDoctor ?></h3>
                        <p>Citas agendadas</p>
                    </span>
                </li>
            </ul>


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
                                <th>Paciente</th>
                                <th>description</th>
                                <th>Fecha</th>
                                <th>Hora</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($misCitas as $cita): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cita['paciente_nombre']) ?></td>
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