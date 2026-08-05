<?php


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
