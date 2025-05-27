<?php
// Archivo de diagnóstico para resolver problemas de rutas
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnóstico de Configuración</h1>";
echo "<pre>";

// Información del servidor
echo "<h2>Variables del Servidor</h2>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME'] . "\n";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "PHP_SELF: " . $_SERVER['PHP_SELF'] . "\n";

// Calcular BasePath como lo hace tu web.php
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$basePath = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
echo "Calculated BasePath: " . $basePath . "\n\n";

// Constantes definidas
echo "<h2>Constantes Definidas</h2>";
echo "BASE_URL: " . (defined('BASE_URL') ? BASE_URL : 'No definido') . "\n";
echo "APP_PATH: " . (defined('APP_PATH') ? APP_PATH : 'No definido') . "\n";
echo "CONFIG_PATH: " . (defined('CONFIG_PATH') ? CONFIG_PATH : 'No definido') . "\n\n";

// Verificar si existen archivos críticos
echo "<h2>Verificación de Archivos</h2>";
$filesToCheck = [
    '/controllers/SexoController.php',
    '/views/sexo/index.php',
    '/views/sexo/create.php',
    '/models/Sexo.php',
    '/public/index.php',
    '/.htaccess'
];

if (defined('APP_PATH')) {
    foreach ($filesToCheck as $file) {
        $fullPath = APP_PATH . $file;
        echo "$fullPath: " . (file_exists($fullPath) ? "Existe" : "NO EXISTE") . "\n";
    }
}

// Comprobar si las clases de controladores están disponibles
echo "\n<h2>Verificación de Clases</h2>";
$classesToCheck = [
    'PersonaController',
    'SexoController',
    'DireccionController',
    'TelefonoController',
    'EstadoCivilController'
];

foreach ($classesToCheck as $class) {
    echo "$class: " . (class_exists($class) ? "Definida" : "NO DEFINIDA") . "\n";
}

// Información de URL
echo "\n<h2>Procesamiento de URL</h2>";
$requestUri = $_SERVER["REQUEST_URI"];
$requestPath = parse_url($requestUri, PHP_URL_PATH);
echo "RequestPath: $requestPath\n";

// Remover el prefijo basePath como lo hace tu web.php
$route = '';
if (!empty($basePath) && strpos($requestPath, $basePath) === 0) {
    $route = substr($requestPath, strlen($basePath));
} else {
    $route = $requestPath;
}
$route = trim($route, '/');
echo "Processed Route: $route\n";

// Simular lo que haría tu sistema de rutas
$parts = explode('/', $route);
$controller = isset($parts[0]) ? $parts[0] : '';
$action = isset($parts[1]) ? $parts[1] : 'index';
echo "Extracted Controller: '$controller'\n";
echo "Extracted Action: '$action'\n";

echo "</pre>";
?>