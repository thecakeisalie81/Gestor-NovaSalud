<?php
include_once("../../system/session.php");
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
                    <h1>Administradores</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Administradores</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bx-first-aid'></i>
                    <span class="text">
                        <h3><?php echo $totalAdminsActivos ?></h3>
                        <p>Administradores Activos</p>
                    </span>
                </li>

                <li>
                    <i class='bx bx-first-aid'></i>
                    <span class="text">
                        <h3><?php echo $totalAdminsInactivos ?></h3>
                        <p>Administradores Inactivos</p>
                    </span>
                </li>

                <li class="js-abrir-crear-admin" style="cursor:pointer;">
                    <i class='bx bx-user-plus'></i>
                    <span class="text">
                        <p>Agregar nuevo administrador</p>
                    </span>
                </li>

            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Administradores activos</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Edad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admins as $admin): ?>
                                <tr>
                                    <td><?= htmlspecialchars($admin['name']) ?></td>
                                    <td><?= htmlspecialchars($admin['phone']) ?></td>
                                    <td><?= htmlspecialchars($admin['email']) ?></td>
                                    <td><?= htmlspecialchars($admin['age']) ?></td>
                                    <td>
                                        <button
                                            class="btn-aprobado js-editar-admin"
                                            data-id="<?= $admin['id'] ?>"
                                            data-name="<?= htmlspecialchars($admin['name']) ?>"
                                            data-age="<?= $admin['age'] ?>"
                                            data-phone="<?= htmlspecialchars($admin['phone']) ?>"
                                            data-email="<?= htmlspecialchars($admin['email']) ?>">
                                            <i class='bx bx-edit'></i> Editar datos
                                        </button>

                                        <button
                                            class="btn-noaprobado js-inactivar-admin"
                                            data-id="<?= $admin['id'] ?>">
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
                        <h3>Administradores Inactivos</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Edad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($adminsInactivos as $admin): ?>
                                <tr>
                                    <td><?= htmlspecialchars($admin['name']) ?></td>
                                    <td><?= htmlspecialchars($admin['phone']) ?></td>
                                    <td><?= htmlspecialchars($admin['email']) ?></td>
                                    <td><?= htmlspecialchars($admin['age']) ?></td>
                                    <td>
                                        <button
                                            class="btn-aprobado js-activar-admin"
                                            data-id="<?= $admin['id'] ?>">
                                            <i class='bx bx-check'></i> Marcar como Activo
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="modalEditarAdmin" class="modal" style="display:none;">
                <div class="modal-content">
                    <h3>Editar Administrador</h3>

                    <form id="formEditarAdmin">
                        <input type="hidden" id="edit_admin_id">

                        <label>Nombre</label>
                        <input type="text" id="edit_admin_name" required>

                        <label>Edad</label>
                        <input type="number" id="edit_admin_age" required>

                        <label>Teléfono</label>
                        <input type="text" id="edit_admin_phone" required>

                        <label>Email</label>
                        <input type="email" id="edit_admin_email" required>

                        <div class="modal-actions">
                            <button type="submit" class="btn-aprobado">Guardar</button>
                            <button type="button" id="cerrarModalAdmin" class="btn-noaprobado">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>


            <div id="modalCrearAdmin" class="modal" style="display:none;">
                <div class="modal-content">
                    <h3>Registrar nuevo administrador</h3>

                    <form id="formCrearAdmin">
                        <label>Nombre</label>
                        <input type="text" id="create_name" required>

                        <label>Edad</label>
                        <input type="number" id="create_age" required>

                        <label>Teléfono</label>
                        <input type="text" id="create_phone" required>

                        <label>Email</label>
                        <input type="email" id="create_email" required>

                        <label>Contraseña</label>
                        <input type="password" id="create_pass" required>

                        <div class="modal-actions">
                            <button type="submit" class="btn-aprobado">Registrar</button>
                            <button type="button" id="cerrarCrearAdmin" class="btn-noaprobado">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>



        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src="../../assets/js/pageOut.js"></script>
    <script src="../../assets/js/eliminarAdmin.js"></script>
    <script src="../../assets/js/activarAdmin.js"></script>
    <script src="../../assets/js/crearAdmin.js"></script>
    <script src="../../assets/js/editarAdmin.js"></script>
    <script>
        const totalAdminsActivos = <?= $totalAdminsActivos ?>;
    </script>

</body>

</html>