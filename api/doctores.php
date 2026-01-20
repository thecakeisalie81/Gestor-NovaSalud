<?php
include("../system/init.php");
include("../libs/Usuario.php");
header('Content-Type: application/json');
require_once("../libs/Doctor.php");


$method = $_SERVER['REQUEST_METHOD'];

$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        OBTENERDOCTOR($conn);
        break;
    case 'POST':
        CREARDOCTOR($conn, $input);
        break;
    case 'PUT':
        ACTUALIZARDOCTOR($conn, $input);
        break;
    case 'DELETE':
        BORRARDOCTOR($conn, $input);
        break;
}


function OBTENERDOCTOR($conn)
{
    $query = "SELECT * FROM doctor";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($rows);
}


function CREARDOCTOR($conn, $input)
{
    if (!$input) {
        http_response_code(400);
        echo json_encode(["error" => "Datos inválidos"]);
        exit;
    }

    $doctor = new Doctor($conn, $input['name'], $input['age'], $input['phone'], $input['email'], $input['rol'], $input['specialty']);
    $doctor->setPassword($input['pass']);
    if ($doctor->create()) {
        http_response_code(201);
        echo json_encode(["success" => true, "id" => $doctor->getId()]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "No se pudo crear el Doctor"]);
    }
}

function ACTUALIZARDOCTOR($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o datos inválidos"]);
        exit;
    }

    $doctor = new Doctor($conn, $input['name'], $input['age'], $input['phone'], $input['email'], $input['rol'], $input['specialty']);
    $doctor->setPassword($input['pass']);
    $doctor->setId((int)$input['id']);

    if ($doctor->update()) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Datos del doctor actualizados"]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Doctor no encontrado"]);
    }
}

function BORRARDOCTOR($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o datos inválidos"]);
        exit;
    }

    $doctor = new Doctor($conn, "", 0, 0, "", "", "");
    $doctor->setId((int)$input['id']);

    if ($doctor->delete()) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Doctor marcado como Inactivo"]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Doctor no encontrado"]);
    }
}
