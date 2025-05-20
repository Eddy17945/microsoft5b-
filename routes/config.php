<?php
// Detectar automáticamente la URL base
function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    
    // Obtener la ruta base
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    $baseDir = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
    
    // Asegurarse de que termina con una barra
    if (substr($baseDir, -1) !== '/') {
        $baseDir .= '/';
    }
    
    return $protocol . $domainName . $baseDir;
}

// Definir rutas principales
define('ROOT_PATH', dirname(__FILE__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('ROUTE_PATH', BASE_PATH . '/routes');


// URL base para enlaces y redirecciones
define('BASE_URL', getBaseUrl());

// Configuración de la zona horaria
date_default_timezone_set('America/Guayaquil');

// Iniciar sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>