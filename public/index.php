<?php
// Habilitar errores para depuración (Eliminar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir la ruta base del proyecto y otras rutas importantes
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('ROUTE_PATH', BASE_PATH . '/routes');
define('PUBLIC_PATH', BASE_PATH . '/public');

// Determinar la URL base (método más confiable)
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$requestUri = $_SERVER['REQUEST_URI'];

// Asegurar que termina con una barra diagonal
if (substr($scriptDir, -1) !== '/') {
    $scriptDir .= '/';
}

// Definir BASE_URL para uso en vistas
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
define('BASE_URL', $protocol . $host . $scriptDir);

// Iniciar sesión
session_start();

// Configuración de seguridad básica
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once 'routes/config.php';

// Cargar rutas - aseguramos que el archivo existe antes de incluirlo
$routerFile = ROUTE_PATH . '/web.php';

if (file_exists($routerFile)) {
    require_once $routerFile;
} else {
    die("Error: El archivo de rutas no existe en: " . $routerFile);
}
?>
