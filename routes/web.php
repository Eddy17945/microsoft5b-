<?php
// Incluir configuración de la base de datos
require_once CONFIG_PATH . '/database.php';

// Incluir los controladores necesarios
require_once APP_PATH . '/controllers/PersonaController.php';
require_once APP_PATH . '/controllers/SexoController.php';
require_once APP_PATH . '/controllers/DireccionController.php';
require_once APP_PATH . '/controllers/TelefonoController.php';
require_once APP_PATH . '/controllers/EstadoCivilController.php';

// Verificar si existen parámetros GET para controller y action
$controller = isset($_GET['controller']) ? $_GET['controller'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Si no hay controller en GET, intentar obtenerlo de la URL
if (empty($controller)) {
    $requestUri = $_SERVER["REQUEST_URI"];
    
    // Obtener la ruta base a partir de SCRIPT_NAME
    $basePath = dirname($_SERVER['SCRIPT_NAME']);
    if (substr($basePath, -1) !== '/') {
        $basePath .= '/';
    }
    
    // Remover el prefijo basePath
    $route = str_replace($basePath, '', $requestUri);
    $route = strtok($route, '?'); // Quitar parámetros GET
    
    // Si la ruta está vacía o es solo '/', mostrar página principal
    if (empty($route) || $route === '/') {
        // Página principal
        $stats = ['personas' => 0, 'direcciones' => 0, 'telefonos' => 0];
        
        // Crear la conexión a la base de datos
        $database = new Database();
        $conn = $database->getConnection();
        
        // Cargar helper de contador si existe
        if ($conn instanceof PDO) {
            $counterFile = APP_PATH . "/helpers/CounterHelper.php";
            if (file_exists($counterFile)) {
                require_once $counterFile;
                $counter = new CounterHelper($conn);
                $stats = $counter->getStats();
            }
        }
        
        // Incluir layout principal con el menú
        include_once APP_PATH . "/views/layouts/main.php";
        exit;
    } else {
        // Si hay un controlador en la URL (formato: controlador/acción)
        $parts = explode('/', trim($route, '/'));
        $controller = isset($parts[0]) ? $parts[0] : '';
        $action = isset($parts[1]) ? $parts[1] : 'index';
    }
}

// Sanitizar entradas para seguridad
$controller = htmlspecialchars(strtolower(trim($controller)));
$action = htmlspecialchars(strtolower(trim($action)));

// Registrar los controladores disponibles
$controllers = [
    'persona' => 'PersonaController',
    'sexo' => 'SexoController',
    'direccion' => 'DireccionController',
    'telefono' => 'TelefonoController',
    'estadocivil' => 'EstadoCivilController'
];

// Verificar si el controlador solicitado existe
if (!array_key_exists($controller, $controllers)) {
    // Si no existe controlador, mostrar página principal
    $stats = ['personas' => 0, 'direcciones' => 0, 'telefonos' => 0];
    
    // Crear la conexión a la base de datos
    $database = new Database();
    $conn = $database->getConnection();
    
    // Cargar helper de contador si existe
    if ($conn instanceof PDO) {
        $counterFile = APP_PATH . "/helpers/CounterHelper.php";
        if (file_exists($counterFile)) {
            require_once $counterFile;
            $counter = new CounterHelper($conn);
            $stats = $counter->getStats();
        }
    }
    
    // Incluir layout principal con el menú
    include_once APP_PATH . "/views/layouts/main.php";
    exit;
}

// Crear instancia del controlador apropiado
$controllerClass = $controllers[$controller];
$controllerInstance = new $controllerClass();

// Verificar si el método existe en el controlador
if (!method_exists($controllerInstance, $action)) {
    // Si no existe el método, usar index como predeterminado
    $action = 'index';
}

// Ejecutar la acción del controlador
$controllerInstance->$action();
?>