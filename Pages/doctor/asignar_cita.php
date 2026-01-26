<?php
include_once("../../system/session.php");

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
    <link rel="stylesheet" href="/PROYECTO_BACKEND/assets/css/solicitud.css" />
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
                    <h1>Solicitud de cita</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Solicitud de cita</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Crear nueva cita</h3>
                    </div>

                    <form class="form-cita">
                        <div class="form-grid">

                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="date" id="fecha" name="fecha" required>
                            </div>

                            <div class="form-group">
                                <label for="hora">Hora</label>
                                <input type="time" id="hora" name="hora" required>
                            </div>

                            <div class="form-group">
                                <label for="paciente">Paciente</label>
                                <select id="paciente" name="paciente" required>
                                    <option value="">Seleccione un paciente</option>
                                    <option value="1">Juan Pérez</option>
                                    <option value="2">María González</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="doctor">Doctor</label>
                                <select id="doctor" name="doctor" required>
                                    <option value="">Seleccione un doctor</option>
                                    <option value="1">Dr. Pedro Gutiérrez</option>
                                    <option value="2">Dra. Ana Soto</option>
                                </select>
                            </div>

                            <div class="form-group full">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" name="descripcion" rows="4"
                                    placeholder="Motivo de la cita..."></textarea>
                            </div>

                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                Guardar cita
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src="../../assets/js/pageOut.js"></script>
</body>

</html>