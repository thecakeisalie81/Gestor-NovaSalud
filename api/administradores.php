<?php
include("../system/init.php");
include("../libs/Usuario.php");
header('Content-Type: application/json');
require_once("../libs/Admin.php");


$method = $_SERVER['REQUEST_METHOD'];

$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        OBTENERADMIN($conn);
        break;
    case 'POST':
        CREARADMIN($conn, $input);
        break;
    case 'PUT':
        if (isset($input['accion']) && $input['accion'] === 'cambiar_estado') {
            CAMBIARESTADOADMIN($conn, $input);
        } else {
            ACTUALIZARADMIN($conn, $input);
        }
        break;
    case 'DELETE':
        BORRARADMIN($conn, $input);
        break;
}


function OBTENERADMIN($conn)
{
    $query = "SELECT * FROM admin";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($rows);
}


function CREARADMIN($conn, $input)
{
    try {
        if (!$input || !isset($input['pass'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Faltan datos obligatorios"]);
            return;
        }

        $lastLogin = date("Y-m-d H:i:s");

        $admin = new Admin(
            $conn,
            $input['name'],
            $input['age'],
            $input['phone'],
            $input['email'],
            $input['rol'],
            $lastLogin
        );


        $admin->setPassword($input['pass']);

        if ($admin->create()) {
            http_response_code(201);
            echo json_encode([
                "success" => true,
                "id" => $admin->getId()
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => "No se pudo crear el administrador"
            ]);
        }
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "error" => $e->getMessage()
        ]);
    }
}


function ACTUALIZARADMIN($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Datos inválidos"]);
        exit;
    }

    // Obtener admin actual
    $stmt = $conn->prepare("SELECT rol, lastLogin FROM admin WHERE id = ?");
    $stmt->bind_param("i", $input['id']);
    $stmt->execute();
    $adminActual = $stmt->get_result()->fetch_assoc();

    if (!$adminActual) {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Administrador no encontrado"]);
        exit;
    }

    $admin = new Admin(
        $conn,
        $input['name'],
        $input['age'],
        $input['phone'],
        $input['email'],
        $adminActual['rol'],
        $adminActual['lastLogin']
    );

    $admin->setId((int)$input['id']);

    if ($admin->update()) {
        echo json_encode(["success" => true]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "No se pudo actualizar"]);
    }
}

function CAMBIARESTADOADMIN($conn, $input)
{
    if (!isset($input['id'])) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "error" => "ID requerido"
        ]);
        exit;
    }

    $state = "Activo";

    $stmt = $conn->prepare(
        "UPDATE admin SET state = ? WHERE id = ?"
    );
    $stmt->bind_param("si", $state, $input['id']);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "error" => $stmt->error
        ]);
    }
}





function BORRARADMIN($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o datos inválidos"]);
        exit;
    }

    $admin = new Admin($conn, "", 0, 0, "", "", "");
    $admin->setId((int)$input['id']);

    if ($admin->delete()) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Administrador marcado como Inactivo"]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Administrador no encontrado"]);
    }
}
