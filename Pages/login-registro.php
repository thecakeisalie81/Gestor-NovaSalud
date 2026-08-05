<?php
require_once("../system/init.php");
require_once('../libs/Usuario.php');
require_once('../libs/Paciente.php');
require_once('../src/login.php');
require_once('../src/signup.php');

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

    <script src="../assets/js/login.js"></script>
</body>



</html>