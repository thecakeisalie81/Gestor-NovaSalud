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
        validarSesionAdmin();
        CREARDOCTOR($conn, $input);
        break;
    case 'PUT':
        validarSesionAdmin();
        if (isset($input['activar']) && $input['activar'] === true) {
            ACTIVARDOCTOR($conn, $input);
        } else {
            ACTUALIZARDOCTOR($conn, $input);
        }
        break;
    case 'DELETE':
        validarSesionAdmin();
        BORRARDOCTOR($conn, $input);
        break;
}


/**
 * GET /api/doctores.php
 * Obtiene la lista completa de doctores
 *
 * @return JSON
 * {
 *   total: int,
 *   data: [
 *     {
 *       id: int,
 *       name: string,
 *       age: int,
 *       phone: string,
 *       email: string,
 *       rol: string,
 *       specialty: string,
 *       state: string
 *     }
 *   ]
 * }
 *
 * @http 200 OK
 */
function OBTENERDOCTOR($conn)
{
    $query = "SELECT * FROM doctor";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $response = ["total" => count($rows), "data" => $rows];
    echo json_encode($response);
}


/**
 * Valida que la sesión pertenezca a un administrador
 *
 * @return void
 *
 * @http 403 Acceso denegado si no es admin
 */
function validarSesionAdmin()
{
    include_once("../system/session.php");

    if (
        !isset($_SESSION['id'], $_SESSION['rol']) ||
        $_SESSION['rol'] !== 'admin'
    ) {
        http_response_code(403);
        echo json_encode([
            "error" => "Acceso denegado. Solo administradores."
        ]);
        exit;
    }
}


/**
 * POST /api/doctores.php
 * Crea un nuevo doctor (solo administrador)
 *
 * @param name string       Nombre completo
 * @param age int           Edad
 * @param phone string      Teléfono
 * @param email string      Correo electrónico
 * @param pass string       Contraseña (cifrada)
 * @param rol string        Rol del usuario (doctor)
 * @param specialty string  Especialidad médica
 *
 * @return JSON
 * {
 *   success: boolean,
 *   id: int
 * }
 *
 * @http 201 Created
 * @http 400 Datos inválidos
 * @http 403 Acceso denegado
 * @http 500 Error interno
 */
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


/**
 * PUT /api/doctores.php
 * Actualiza los datos de un doctor existente (solo administrador)
 *
 * @param id int             ID del doctor
 * @param name string        Nombre completo
 * @param age int            Edad
 * @param phone string       Teléfono
 * @param email string       Correo electrónico
 * @param rol string         Rol del usuario
 * @param specialty string   Especialidad médica
 *
 * @return JSON
 * {
 *   success: boolean,
 *   message: string
 * }
 *
 * @http 200 OK
 * @http 400 Datos inválidos
 * @http 403 Acceso denegado
 * @http 404 Doctor no encontrado
 */
function ACTUALIZARDOCTOR($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID o datos inválidos"]);
        exit;
    }

    $doctor = new Doctor(
        $conn,
        $input['name'],
        $input['age'],
        $input['phone'],
        $input['email'],
        $input['rol'],
        $input['specialty']
    );

    $doctor->setId((int)$input['id']);

    if ($doctor->update()) {
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Datos del doctor actualizados"
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "error" => "Doctor no encontrado"
        ]);
    }
}


/**
 * DELETE /api/doctores.php
 * Elimina un doctor de forma lógica (estado Inactivo)
 * (solo administrador)
 *
 * @param id int ID del doctor
 *
 * @return JSON
 * {
 *   success: boolean,
 *   message: string
 * }
 *
 * @http 200 OK
 * @http 400 Datos inválidos
 * @http 403 Acceso denegado
 * @http 404 Doctor no encontrado
 */
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


/**
 * PUT /api/doctores.php
 * Activa un doctor previamente inactivado (solo administrador)
 *
 * @param id int ID del doctor
 * @param activar boolean Debe ser true
 *
 * @return JSON
 * {
 *   success: boolean,
 *   message: string
 * }
 *
 * @http 200 OK
 * @http 400 Falta ID
 * @http 403 Acceso denegado
 * @http 404 Doctor no encontrado
 */
function ACTIVARDOCTOR($conn, $input)
{
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta ID"]);
        exit;
    }

    $doctor = new Doctor($conn, "", 0, 0, "", "", "");
    $doctor->setId((int)$input['id']);

    if ($doctor->activar()) {
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Doctor marcado como Activo"
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "error" => "Doctor no encontrado"
        ]);
    }
}
