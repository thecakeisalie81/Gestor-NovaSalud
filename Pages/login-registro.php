<?php
require_once("../system/init.php");
require_once('../libs/Usuario.php');
require_once('../libs/Paciente.php');

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

if (isset($_POST['signup'])) {

    $name  = trim($_POST['name']);
    $age   = (int) $_POST['age'];
    $phone = (int) $_POST['phone'];
    $email = trim($_POST['email']);
    $pass  = $_POST['pass'];
    $rol     = 'paciente';
    $address = trim($_POST['address']);


    $check = $conn->prepare("SELECT id FROM paciente WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "El correo ya está registrado";
        exit;
    }
    $check->close();

    try {
        $paciente = new Paciente(
            $conn,
            $name,
            $age,
            $phone,
            $email,
            $rol,
            $address
        );

        $paciente->setPassword($pass);

        if ($paciente->create()) {

            $_SESSION['id']  = $paciente->getId();
            $_SESSION['rol'] = 'paciente';
            header("Location: paciente/dashboard.php");
            exit;
        } else {
            echo "Error al registrar el paciente";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Ingresar</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="post">
                <h1>Create Account</h1>
                <input name="name" type="text" placeholder="Nombre" required>
                <input name="age" type="number" placeholder="Edad" required>
                <input name="phone" type="number" placeholder="Numero telefonico" required>
                <input name="email" type="email" placeholder="Email" required>
                <input name="pass" type="password" placeholder="Contraseña" required>
                <input name="address" type="text" placeholder="Direccion" required>
                <button name="signup" type="submit">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="post">
                <h1>Sign In</h1>
                <input name="email_log" type="email" placeholder="Email">
                <input name="pass_log" type="password" placeholder="Contraseña">
                <a href="#">Forget Your Password?</a>
                <button name="login" type="submit">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bienvenido!</h1>
                    <p>Registre sus datos para poder hacer crear su cuenta</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Bienvenido devuelta!</h1>
                    <p>Ingrese sus datos para hacer uso del sistema</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/PROYECTO_BACKEND/assets/js/login.js"></script>
</body>



</html>