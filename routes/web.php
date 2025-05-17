<?php
// No iniciamos la sesión aquí porque ya se inicia en index.php

// Definir constantes de rutas
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');

// Incluir los controladores necesarios
require_once APP_PATH . '/controllers/PersonaController.php';
require_once APP_PATH . '/controllers/SexoController.php';
require_once APP_PATH . '/controllers/DireccionController.php';
require_once APP_PATH . '/controllers/TelefonoController.php';
require_once APP_PATH . '/controllers/EstadocivilController.php';

// Cargar configuración de la base de datos 
require_once CONFIG_PATH . '/database.php';

// Verificar si existen parámetros GET para controller y action
$controller = isset($_GET['controller']) ? $_GET['controller'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Si no hay controller en GET, intentar obtenerlo de la URL
if (empty($controller)) {
    $requestUri = $_SERVER["REQUEST_URI"];
    $basePath = '/microsoft5b-/public/';  // Ajusta esto según la ruta base de tu aplicación

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

// Enrutar según controlador y acción
switch ($controller) {
    case 'persona':
        $personaController = new PersonaController();
        
        switch ($action) {
            case 'index':
                $personaController->index();
                break;
            case 'create':
                $personaController->create();
                break;
            case 'store':
                $personaController->store();
                break;
            case 'edit':
                if (isset($_GET['id'])) {
                    $personaController->edit();
                } else {
                    echo "Error: Falta el ID para editar.";
                }
                break;
            case 'view':
                if (isset($_GET['id'])) {
                    $personaController->view();
                } else {
                    echo "Error: Falta el ID para ver.";
                }
                break;
            case 'update':
                $personaController->update();
                break;
            case 'delete':
                $personaController->delete();
                break;
            default:
                $personaController->index();
                break;
        }
        break;
        
    case 'sexo':
        $sexoController = new SexoController();
        
        switch ($action) {
            case 'index':
                $sexoController->index();
                break;
            case 'edit':
                if (isset($_GET['idsexo'])) {
                    $sexoController->edit();
                } else {
                    echo "Error: Falta el ID para editar.";
                }
                break;
            case 'update':
                $sexoController->update();
                break;
            case 'delete':
                $sexoController->delete();
                break;
            default:
                $sexoController->index();
                break;
        }
        break;
        
    case 'direccion':
        $direccionController = new DireccionController();
        
        switch ($action) {
            case 'index':
                $direccionController->index();
                break;
            case 'edit':
                if (isset($_GET['id'])) {
                    $direccionController->edit();
                } else {
                    echo "Error: Falta el ID para editar.";
                }
                break;
            case 'update':
                $direccionController->update();
                break;
            default:
                $direccionController->index();
                break;
        }
        break;
        
    case 'telefono':
        $telefonoController = new TelefonoController();
        
        switch ($action) {
            case 'index':
                $telefonoController->index();
                break;
            case 'edit':
                if (isset($_GET['id'])) {
                    $telefonoController->edit();
                } else {
                    echo "Error: Falta el ID para editar.";
                }
                break;
            case 'update':
                $telefonoController->update();
                break;
            default:
                $telefonoController->index();
                break;
        }
        break;
        
    case 'estadocivil':
        $estadoCivilController = new EstadoCivilController();
        
        switch ($action) {
            case 'index':
                $estadoCivilController->index();
                break;
            case 'edit':
                if (isset($_GET['idestadocivil'])) {
                    $estadoCivilController->edit();
                } else {
                    echo "Error: Falta el ID para editar.";
                }
                break;
            case 'update':
                $estadoCivilController->update();
                break;
            default:
                $estadoCivilController->index();
                break;
        }
        break;
        
    default:
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
        break;
}
?>