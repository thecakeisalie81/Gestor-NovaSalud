<?php
include("../system/init.php");
header('Content-Type: application/json');
require_once("../libs/Cita.php");

$method = $_SERVER['REQUEST_METHOD'];

$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        OBTENERCITA($conn);
        break;
    case 'POST':
        validarSesion();
        CREARCITA($conn, $input);
        break;
    case 'PUT':
        validarSesion();
        ACTUALIZARCITA($conn, $input);
        break;
    case 'DELETE':
        validarSesion();
        BORRARCITA($conn, $input);
        break;
}

function OBTENERCITA($conn)
{
    $query = "SELECT * FROM cita";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($rows);
}


function validarSesion()
{
    include_once("../system/session.php");
    if (!isset($_SESSION['id'], $_SESSION['rol'])) {
        http_response_code(401);
        echo json_encode(["error" => "No autorizado"]);
        exit;
    }
}

function CREARCITA($conn, $input)
{
    if (!$input) {
        http_response_code(400);
        echo json_encode(["error" => "Datos inválidos"]);
        exit;
    }

    // Valores por defecto
    $paciente = $input['paciente'] ?? null;
    $doctor   = $input['doctor'] ?? null;

    // 🎭 Lógica según rol
    if ($_SESSION['rol'] === 'paciente') {
        $paciente = $_SESSION['id'];

        if (!$doctor) {
            http_response_code(400);
            echo json_encode(["error" => "Debe seleccionar un doctor"]);
            exit;
        }
    } elseif ($_SESSION['rol'] === 'doctor') {
        $doctor = $_SESSION['id'];

        if (!$paciente) {
            http_response_code(400);
            echo json_encode(["error" => "Debe seleccionar un paciente"]);
            exit;
        }
    } else {
        http_response_code(403);
        echo json_encode(["error" => "Rol no permitido"]);
        exit;
    }

    $cita = new Cita(
        'cita',
        $conn,
        $input['fecha'],
        $input['hour'],
        $paciente,
        $doctor,
        $input['state'],
        $input['description']
    );

    if ($cita->create()) {
        http_response_code(201);
        echo json_encode([
            "success" => true,
            "id" => $cita->getId()
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "error" => "No se pudo crear la cita"
        ]);
    }
}


function ACTUALIZARCITA($conn, $input)
{

    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o datos inválidos"]);
        exit;
    }
    $cita = new Cita('cita', $conn, $input['fecha'], $input['hour'], $input['paciente'], $input['doctor'], $input['state'], $input['description']);
    $cita->setId($input['id']);
    if ($cita->update()) {
        http_response_code(200);
        echo json_encode(["success" => true]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Cita no encontrada"]);
    }
}

function BORRARCITA($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o datos inválidos"]);
        exit;
    }

    $cita = new Cita('cita', $conn, "", "", 0, 0, "", "");
    $cita->setId($input['id']);
    if ($cita->delete()) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Cita marcada como finalizada"]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Cita no encontrada"]);
    }
}
