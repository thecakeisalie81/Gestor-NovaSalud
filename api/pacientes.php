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


/**
 * GET /api/pacientes.php
 * Obtiene todos los pacientes registrados
 *
 * @return JSON Array
 * [
 *   {
 *     id: int,
 *     name: string,
 *     age: int,
 *     phone: string,
 *     email: string,
 *     rol: string,
 *     address: string,
 *     state: string
 *   }
 * ]
 *
 * @http 200 OK
 */
function OBTENERPACIENTE($conn)
{
    $query = "SELECT * FROM paciente";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($rows);
}


/**
 * POST /api/pacientes.php
 * Crea un nuevo paciente
 *
 * @param name string  Nombre completo del paciente
 * @param age int      Edad del paciente
 * @param phone string Teléfono de contacto
 * @param email string Correo electrónico
 * @param pass string  Contraseña (se almacena cifrada)
 * @param rol string   Rol del usuario (paciente)
 * @param address string Dirección del paciente
 *
 * @return JSON
 * {
 *   success: boolean,
 *   id: int
 * }
 *
 * @http 201 Created
 * @http 400 Datos inválidos
 * @http 500 Error interno
 */
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


/**
 * PUT /api/pacientes.php
 * Actualiza los datos de un paciente existente
 *
 * @param id int        ID del paciente
 * @param name string  Nombre completo
 * @param age int      Edad
 * @param phone string Teléfono
 * @param email string Correo electrónico
 * @param pass string  Contraseña (opcional)
 * @param rol string   Rol del usuario
 * @param address string Dirección
 *
 * @return JSON
 * {
 *   success: boolean,
 *   message: string
 * }
 *
 * @http 200 OK
 * @http 400 Datos inválidos
 * @http 404 Paciente no encontrado
 */
function ACTUALIZARPACIENTE($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o datos inválidos"]);
        exit;
    }

    $paciente = new Paciente($conn, $input['name'], $input['age'], $input['phone'], $input['email'], $input['rol'], $input['address']);
    $paciente->setPassword($input['pass']);
    $paciente->setId((int)$input['id']);

    if ($paciente->update()) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Datos del paciente actualizados"]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Paciente no encontrado"]);
    }
}


/**
 * DELETE /api/pacientes.php
 * Elimina un paciente de forma lógica (estado Inactivo)
 *
 * @param id int ID del paciente
 *
 * @return JSON
 * {
 *   success: boolean,
 *   message: string
 * }
 *
 * @http 200 OK
 * @http 400 Datos inválidos
 * @http 404 Paciente no encontrado
 */
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
