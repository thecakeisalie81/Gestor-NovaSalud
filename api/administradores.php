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
        ACTUALIZARADMIN($conn, $input);
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
    if (!$input) {
        http_response_code(400);
        echo json_encode(["error" => "Datos inválidos"]);
        exit;
    }

    $admin = new Admin($conn, $input['name'], $input['age'], $input['phone'], $input['email'], $input['rol'], $input['lastLogin']);
    $admin->setPassword($input['pass']);
    if ($admin->create()) {
        http_response_code(201);
        echo json_encode(["success" => true, "id" => $admin->getId()]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "No se pudo crear el Doctor"]);
    }
}

function ACTUALIZARADMIN($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o datos inválidos"]);
        exit;
    }

    $admin = new Admin($conn, $input['name'], $input['age'], $input['phone'], $input['email'], $input['rol'], $input['lastLogin']);
    $admin->setPassword($input['pass']);
    $admin->setId((int)$input['id']);

    if ($admin->update()) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Datos del administrador actualizados"]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Administrador no encontrado"]);
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
