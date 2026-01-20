<?php
include("../system/init.php");
include("../libs/Usuario.php");
header('Content-Type: application/json');
require_once("../libs/Admin.php");


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
    $query = "SELECT * FROM admin";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($rows);
}


function CREARDOCTOR($conn, $input) {}
function ACTUALIZARDOCTOR($conn, $input) {}

function BORRARDOCTOR($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o datos inválidos"]);
        exit;
    }

    $admin = new Admin($conn, "", 0, 0, "", "", "", "");
    $admin->setId((int)$input['id']);

    if ($admin->delete()) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Administrador marcado como Inactivo"]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Administrador no encontrado"]);
    }
}
