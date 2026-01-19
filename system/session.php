<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: Login.php");
    exit();
}

require_once("config.php");
