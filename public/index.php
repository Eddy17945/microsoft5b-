<?php
// Habilitar errores para depuración (Eliminar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir la ruta base del proyecto
define('BASE_PATH', dirname(__DIR__));

// Iniciar sesión
session_start();

// Configuración de seguridad básica
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Cargar rutas
require_once BASE_PATH . '/routes/web.php';
?>