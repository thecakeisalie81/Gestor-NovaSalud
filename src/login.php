<?php

session_start();
if (isset($_POST['login'])) {

    $email = $_POST['email_log'];
    $pass  = $_POST['pass_log'];

    function intentarLogin($conn, $tabla, $email, $pass, $rol)
    {
        $sql = "SELECT id, pass, state FROM $tabla WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {

            // Verifica contraseña
            if (password_verify($pass, $row['pass'])) {

                // 🔴 Si está inactivo, no deja iniciar sesión
                if ($row['state'] !== 'Activo') {
                    mysqli_stmt_close($stmt);
                    return 'inactivo';
                }

                // ✅ Usuario activo → inicia sesión
                $_SESSION['id']  = $row['id'];
                $_SESSION['rol'] = $rol;
                mysqli_stmt_close($stmt);
                return true;
            }
        }

        mysqli_stmt_close($stmt);
        return false;
    }

    $resultado = intentarLogin($conn, 'paciente', $email, $pass, 'paciente');

    if ($resultado === false) {
        $resultado = intentarLogin($conn, 'doctor', $email, $pass, 'doctor');
    }

    if ($resultado === false) {
        $resultado = intentarLogin($conn, 'admin', $email, $pass, 'admin');
    }

    if ($resultado === true) {

        switch ($_SESSION['rol']) {
            case 'paciente':
                header("Location: paciente/dashboard.php");
                break;
            case 'doctor':
                header("Location: doctor/dashboard.php");
                break;
            case 'admin':
                header("Location: admin/dashboard.php");
                break;
        }
        exit;
    } elseif ($resultado === 'inactivo') {

        echo "❌ Tu cuenta está inactiva. Contacta al administrador.";
    } else {

        echo "❌ Credenciales inválidas";
    }

    mysqli_close($conn);
}
