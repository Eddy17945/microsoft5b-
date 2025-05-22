<?php
// Incluir configuración de la base de datos
require_once CONFIG_PATH . '/database.php';

// Incluir los controladores necesarios
require_once APP_PATH . '/controllers/PersonaController.php';
require_once APP_PATH . '/controllers/SexoController.php';
require_once APP_PATH . '/controllers/DireccionController.php';
require_once APP_PATH . '/controllers/TelefonoController.php';
require_once APP_PATH . '/controllers/EstadoCivilController.php';

// Función para mostrar página principal
function showHomePage() {
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
}

// Obtener controller y action de los parámetros GET
$controller = isset($_GET['controller']) ? $_GET['controller'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Sanitizar entradas para seguridad
$controller = htmlspecialchars(strtolower(trim($controller)));
$action = htmlspecialchars(strtolower(trim($action)));

// Si no hay controlador, mostrar página principal
if (empty($controller)) {
    showHomePage();
    exit;
}

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
    showHomePage();
    exit;
}

// Crear instancia del controlador apropiado
$controllerClass = $controllers[$controller];

// Verificar si la clase del controlador existe
if (!class_exists($controllerClass)) {
    http_response_code(500);
    die("Error: Controlador $controllerClass no encontrado");
}

$controllerInstance = new $controllerClass();

// Verificar si el método existe en el controlador
if (!method_exists($controllerInstance, $action)) {
    // Si no existe el método, usar index como predeterminado
    $action = 'index';
}

// Ejecutar la acción del controlador
try {
    $controllerInstance->$action();
} catch (Exception $e) {
    http_response_code(500);
    die("Error al ejecutar la acción: " . $e->getMessage());
}
?>