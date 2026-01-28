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


/**
 * GET /api/citas.php
 * Obtiene la lista completa de citas
 *
 * @return JSON Array
 * [
 *   {
 *     id: int,
 *     fecha: string,
 *     hour: string,
 *     paciente: int,
 *     doctor: int,
 *     state: string,
 *     description: string
 *   }
 * ]
 *
 * @http 200 OK
 */
function OBTENERCITA($conn)
{
    $query = "SELECT * FROM cita";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($rows);
}

/**
 * Valida que exista una sesión activa
 *
 * @return void
 *
 * @http 401 No autorizado
 */
function validarSesion()
{
    include_once("../system/session.php");
    if (!isset($_SESSION['id'], $_SESSION['rol'])) {
        http_response_code(401);
        echo json_encode(["error" => "No autorizado"]);
        exit;
    }
}


/**
 * POST /api/citas.php
 * Crea una nueva cita médica
 *
 * Requiere sesión activa (paciente o doctor)
 *
 * Lógica por rol:
 * - Paciente: usa su ID de sesión y debe indicar doctor
 * - Doctor: usa su ID de sesión y debe indicar paciente
 *
 * @param fecha string        Fecha de la cita (YYYY-MM-DD)
 * @param hour string         Hora de la cita (HH:MM)
 * @param paciente int|null   ID del paciente
 * @param doctor int|null     ID del doctor
 * @param state string        Estado inicial de la cita
 * @param description string Descripción o motivo
 *
 * @return JSON
 * {
 *   success: boolean,
 *   id: int
 * }
 *
 * @http 201 Created
 * @http 400 Datos inválidos
 * @http 401 No autorizado
 * @http 403 Rol no permitido
 * @http 500 Error interno
 */
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

    // Lógica según rol
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


/**
 * PUT /api/citas.php
 * Actualiza el estado de una cita
 *
 * Requiere sesión activa
 *
 * @param id int       ID de la cita
 * @param state string Nuevo estado de la cita
 *
 * @return JSON
 * {
 *   success: boolean
 * }
 *
 * @http 200 OK
 * @http 400 Falta ID o state
 * @http 401 No autorizado
 * @http 404 Cita no encontrada
 */
function ACTUALIZARCITA($conn, $input)
{
    if (!$input || !isset($input['id'], $input['state'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o state"]);
        exit;
    }

    // Solo actualizar el estado
    $query = "UPDATE cita SET state = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $input['state'], $input['id']);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        http_response_code(200);
        echo json_encode(["success" => true]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Cita no encontrada"]);
    }
}


/**
 * DELETE /api/citas.php
 * Elimina una cita de forma lógica (finalizada)
 *
 * Requiere sesión activa
 *
 * @param id int ID de la cita
 *
 * @return JSON
 * {
 *   success: boolean,
 *   message: string
 * }
 *
 * @http 200 OK
 * @http 400 Datos inválidos
 * @http 401 No autorizado
 * @http 404 Cita no encontrada
 */
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
