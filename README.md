
## 🏥 Sistema de Gestión de Citas Médicas

Este proyecto es un Sistema de Gestión de Citas Médicas desarrollado como una aplicacion web, el objetivo de este es administrar las citas, pacientes, y doctores de una clinica privada ficticia llamada Clinica NovaSalud.

El sistema está pensado como un proyecto académico/práctico, aplicando buenas prácticas de desarrollo backend, seguridad básica mediante sesiones y roles ademas de consumo de APIs REST.


## ⚙️ Instalación y configuración



Clonar el repositorio:

git clone https://github.com/thecakeisalie81/Proyecto_Backend.git

Importar la base de datos en MySQL usando el archivo citas_medicas.sql presente en el repositorio


Configurar la conexión a la base de datos:

Entrar a la carpeta system del proyecto y luego a config.php y modificar los datos de la conexion a la base de datos

define('DB_HOST', 'localhost');\
define('DB_USER', 'root');\
define('DB_PASS', '1234');\
define('DB_NAME', 'citas_medicas');

Ejecutar el proyecto en un servidor local (XAMPP, WAMP, Laragon)
## 🧪 Usuarios de prueba 

🔹Administradores

Correo: Maria.Garcia@example.com / contraseña: MG123456 \
Correo: Juana.Vargas@gmail.com /Contraseña: JV1234566


🔹Doctores

Correo: ana.lopez@hospital.com / Contraseña: DrAL1234\
Correo: cmendez@hospital.com / Contraseña: DrCM1234\
Correo: Mmendez@hospital.com / Contraseña: DrMM1234\
Correo: GPerez@hospital.com / Contraseña: DrGP1234\
Correo: juan.perez@hospital.com / Contraseña: DrJP1234 


🔹Pacientes

Correo: pedro@gmail.com / Contraseña: PR123456 \
Correo: maria@gmail.com / Contraseña: MT123456 \
Correo: luis@gmail.com / Contraseña: LF123456 \
Correo: sofia@gmail.com / Contraseña: SM123456 \
Correo: daniel@gmail.com / Contraseña: DR123456\
Correo: andrea@gmail.com / contraseña: AV123456 \
Correo: jose@gmail.com / contraseña: JN123456 \
Correo: paola@gmail.com / contraseña: PJ123456 \
Correo: ricardo@gmail.com / contraseña: RS123456 \
Correo: natalia@gmail.com / contraseña: NC123456 

## Funcionalidades

🔹 Autenticación y roles

Inicio de sesión por correo y contraseña

Roles disponibles:

Paciente

Doctor

Administrador

Redirección automática al dashboard correspondiente según el rol

Validación de estado del usuario:

Usuarios con state = Inactivo no pueden iniciar sesión

🔹 Gestión de usuarios

Registro y manejo de usuarios por rol

Control de estado (Activo / Inactivo)

Contraseñas almacenadas de forma segura usando password_hash()

🔹 Gestión de citas médicas

Creación de citas médicas

Asignación de:

Paciente

Doctor

Fecha y hora

Estados de citas (ejemplo: pendiente, activa, finalizada)

Visualización de citas del día

Relación de citas usando IDs y mapeo a nombres mediante APIs

🔹 Consumo de APIs REST

API de doctores

API de pacientes

API de citas

Respuestas en formato JSON

Separación clara entre frontend y backend
## Tech Stack

Tecnologías utilizadas

🔹Backend

PHP 

MySQL

APIs REST

Sesiones PHP para autenticación

🔹Frontend 

HTML5

CSS3

JavaScript

## 🔌 Descripción de los endpoints principales

El sistema expone varios endpoints REST que permiten el acceso y gestión de la información de manera estructurada, usando el formato JSON.

📅 Endpoints de Citas

GET /api/citas.php
Obtiene el listado de todas las citas registradas.

Método: GET

Respuesta:

[
  {
    "id": 1,
    "fecha": "2026-01-28",
    "hour": "09:00",
    "paciente": 3,
    "doctor": 2,
    "state": "Pendiente",
    "description": "Consulta general"
  }
]

POST /api/citas.php
Crea una nueva cita médica.

Método: POST

Parámetros esperados:

{
  "fecha": "2026-01-30",
  "hour": "10:30",
  "paciente": 1,
  "doctor": 4,
  "description": "Control médico"
}\

👨‍⚕️ Endpoints de Doctores

GET /api/doctores.php
Obtiene el listado de doctores activos del sistema.

Método: GET

Respuesta:

{
  "total": 5,
  "data": [
    {
      "id": 1,
      "name": "Pedro Gutiérrez",
      "state": "Activo"
    }
  ]
}\

🧑‍🤝‍🧑 Endpoints de Pacientes

GET /api/pacientes.php
Obtiene el listado de pacientes registrados.

Método: GET

Respuesta:

[
  {
    "id": 1,
    "name": "María Vargas",
    "state": "Activo"
  }
]\

🔐 Endpoint de Autenticación (Login)

POST /login.php
Valida las credenciales del usuario y crea la sesión según su rol.

Método: POST

Validaciones:

Correo y contraseña

Estado del usuario (Activo)

Resultado:

Redirección al dashboard correspondiente

Mensaje de error si las credenciales son inválidas o el usuario está inactivo

## Authors

- [@thecakeisalie81](https://github.com/thecakeisalie81)

