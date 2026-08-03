<?php
include_once("../../system/session.php");
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
    <link rel="stylesheet" href="../../assets/css/modal.css" />
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
                    <h1>Administracion de doctores</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Administracion de doctores</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bx-first-aid'></i>
                    <span class="text">
                        <h3><?php echo $totalDoctoresActivos ?></h3>
                        <p>Doctores Activos</p>
                    </span>
                </li>

                <li>
                    <i class='bx bx-first-aid'></i>
                    <span class="text">
                        <h3><?php echo $totalDoctoresInactivos ?></h3>
                        <p>Doctores Inactivos</p>
                    </span>
                </li>

                <li class="js-abrir-crear-doctor" style="cursor:pointer;">
                    <i class='bx bx-user-plus'></i>
                    <span class="text">
                        <p>Agregar nuevo doctor</p>
                    </span>
                </li>

            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Doctores activos</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Especialidad</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Edad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doctoresActivos as $doctor): ?>
                                <tr>
                                    <td><?= htmlspecialchars($doctor['name']) ?></td>
                                    <td><?= htmlspecialchars($doctor['specialty']) ?></td>
                                    <td><?= htmlspecialchars($doctor['phone']) ?></td>
                                    <td><?= htmlspecialchars($doctor['email']) ?></td>
                                    <td><?= htmlspecialchars($doctor['age']) ?></td>
                                    <td>
                                        <button
                                            class="btn-aprobado js-editar-doctor"
                                            data-id="<?= $doctor['id'] ?>"
                                            data-name="<?= htmlspecialchars($doctor['name']) ?>"
                                            data-age="<?= $doctor['age'] ?>"
                                            data-phone="<?= htmlspecialchars($doctor['phone']) ?>"
                                            data-email="<?= htmlspecialchars($doctor['email']) ?>"
                                            data-specialty="<?= htmlspecialchars($doctor['specialty']) ?>">
                                            <i class='bx bx-edit'></i> Editar datos
                                        </button>

                                        <button
                                            class="btn-noaprobado js-inactivar-doctor"
                                            data-id="<?= $doctor['id'] ?>">
                                            <i class='bx bxs-x-circle'></i> Marcar como inactivo
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
                        <h3>Doctores Inactivos</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Especialidad</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Edad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doctoresInactivos as $doctor): ?>
                                <tr>
                                    <td><?= htmlspecialchars($doctor['name']) ?></td>
                                    <td><?= htmlspecialchars($doctor['specialty']) ?></td>
                                    <td><?= htmlspecialchars($doctor['phone']) ?></td>
                                    <td><?= htmlspecialchars($doctor['email']) ?></td>
                                    <td><?= htmlspecialchars($doctor['age']) ?></td>
                                    <td>
                                        <button
                                            class="btn-aprobado js-activar-doctor"
                                            data-id="<?= $doctor['id'] ?>">
                                            <i class='bx bx-check'></i> Marcar como Activo
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="modalEditarDoctor" class="modal" style="display:none;">
                <div class="modal-content">
                    <h3>Editar Doctor</h3>

                    <form id="formEditarDoctor">
                        <input type="hidden" id="edit_id">

                        <label>Nombre</label>
                        <input type="text" id="edit_name" required>

                        <label>Edad</label>
                        <input type="number" id="edit_age" required>

                        <label>Teléfono</label>
                        <input type="text" id="edit_phone" required>

                        <label>Email</label>
                        <input type="email" id="edit_email" required>

                        <label>Especialidad</label>
                        <input type="text" id="edit_specialty" required>

                        <div class="modal-actions">
                            <button type="submit" class="btn-aprobado">Guardar</button>
                            <button type="button" id="cerrarModal" class="btn-noaprobado">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="modalCrearDoctor" class="modal" style="display:none;">
                <div class="modal-content">
                    <h3>Registrar nuevo doctor</h3>

                    <form id="formCrearDoctor">
                        <label>Nombre</label>
                        <input type="text" id="create_name" required>

                        <label>Edad</label>
                        <input type="number" id="create_age" required>

                        <label>Teléfono</label>
                        <input type="text" id="create_phone" required>

                        <label>Email</label>
                        <input type="email" id="create_email" required>

                        <label>Especialidad</label>
                        <input type="text" id="create_specialty" required>

                        <label>Contraseña</label>
                        <input type="password" id="create_pass" required>

                        <div class="modal-actions">
                            <button type="submit" class="btn-aprobado">Registrar</button>
                            <button type="button" id="cerrarCrearDoctor" class="btn-noaprobado">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>


        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src="../../assets/js/pageOut.js"></script>
    <script src="../../assets/js/editarDoctor.js"></script>
    <script src="../../assets/js/eliminarDoctor.js"></script>
    <script src="../../assets/js/activarDoctor.js"></script>
    <script src="../../assets/js/crearDoctor.js"></script>
</body>

</html>