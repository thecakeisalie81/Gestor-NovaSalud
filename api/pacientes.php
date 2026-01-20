<?php
include("../system/init.php");
include("../libs/Usuario.php");
header('Content-Type: application/json');
require_once("../libs/Paciente.php");


$method = $_SERVER['REQUEST_METHOD'];

$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        OBTENERPACIENTE($conn);
        break;
    case 'POST':
        CREARPACIENTE($conn, $input);
        break;
    case 'PUT':
        ACTUALIZARPACIENTE($conn, $input);
        break;
    case 'DELETE':
        BORRARPACIENTE($conn, $input);
        break;
}


function OBTENERPACIENTE($conn)
{
    $query = "SELECT * FROM paciente";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($rows);
}


function CREARPACIENTE($conn, $input)
{
    if (!$input) {
        http_response_code(400);
        echo json_encode(["error" => "Datos inválidos"]);
        exit;
    }

    $paciente = new Paciente($conn, $input['name'], $input['age'], $input['phone'], $input['email'], $input['rol'], $input['address']);
    $paciente->setPassword($input['pass']);
    if ($paciente->create()) {
        http_response_code(201);
        echo json_encode(["success" => true, "id" => $paciente->getId()]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "No se pudo crear el Doctor"]);
    }
}
function ACTUALIZARPACIENTE($conn, $input) {}
function BORRARPACIENTE($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o datos inválidos"]);
        exit;
    }

    $paciente = new Paciente($conn, "", 0, 0, "", "", "");
    $paciente->setId((int)$input['id']);

    if ($paciente->delete()) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Paciente marcado como Inactivo"]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Paciente no encontrado"]);
    }
}
