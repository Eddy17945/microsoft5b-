<?php
// config.php - Archivo de configuración principal

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Detectar si estamos en desarrollo local o en producción
$isLocal = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
           strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);

if ($isLocal) {
    // Configuración para desarrollo local
    define('BASE_URL', 'http://localhost/tu-proyecto/public/');
    define('ROOT_PATH', dirname(__DIR__));
} else {
    // Configuración para producción
    // Ajusta esta URL según tu servidor de producción
    define('BASE_URL', 'https://educaysoft.org/microsoft5b-/public/');
    define('ROOT_PATH', dirname(__DIR__));
}

// Definir rutas del sistema
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');

// Configuración de base de datos
define('DB_HOST', $isLocal ? 'localhost' : 'tu_host_produccion');
define('DB_NAME', $isLocal ? 'tu_db_local' : 'tu_db_produccion');
define('DB_USER', $isLocal ? 'root' : 'tu_usuario_produccion');
define('DB_PASS', $isLocal ? '' : 'tu_password_produccion');

// Configuración de errores
if ($isLocal) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Timezone
date_default_timezone_set('America/Mexico_City'); // Ajusta según tu zona horaria
?>