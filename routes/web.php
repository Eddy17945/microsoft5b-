<?php
session_start();

// Definir constantes de rutas
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// Incluir los controladores necesarios
require_once '../app/controllers/PersonaController.php';
require_once '../app/controllers/SexoController.php';
require_once '../app/controllers/DireccionController.php';
require_once '../app/controllers/TelefonoController.php';
require_once '../app/controllers/EstadocivilController.php';

// Cargar configuración de la base de datos 
require_once '../app/config/database.php';

$requestUri = $_SERVER["REQUEST_URI"];
$basePath = '/microsoft5b-/public/';  // Ajusta esto según la ruta base de tu aplicación
// Remover el prefijo basePath
$route = str_replace($basePath, '', $requestUri);
$route = strtok($route, '?'); // Quitar parámetros GET
 
// Mostrar el menú si no se ha solicitado ninguna acción específica
if (empty($route) || $route === '/') {
    // Inicializar estadísticas si tienes helpers para conteo
    $stats = ['personas' => 0, 'direcciones' => 0, 'telefonos' => 0];
    
    // Cargar helper de contador si existe y si la conexión está disponible
    if (isset($conn) && $conn instanceof PDO) {
        $counterFile = "../app/helpers/CounterHelper.php";
        if (file_exists($counterFile)) {
            require_once $counterFile;
            $counter = new CounterHelper($conn);
            $stats = $counter->getStats();
        }
    }
    
    // Incluir layout principal con el menú
    require_once "../app/views/layouts/main.php";
} else {
    // Enrutar a los controladores según la ruta
    switch ($route) {
        case 'persona':
        case 'persona/index':
            $controller = new PersonaController();
            $controller->index();
            break;
            
        case 'persona/edit':
            if (isset($_GET['id'])) {
                $controller = new PersonaController();
                $controller->edit($_GET['id']);
            } else {
                echo "Error: Falta el ID para editar.";
            }
            break;
            
        case 'persona/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new PersonaController();
                $controller->update();
            }
            break;
            
        case 'persona/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new PersonaController();
                $controller->delete();
            }
            break;
            
        case 'sexo':
        case 'sexo/index':
            $controller = new SexoController();
            $controller->index();
            break;
            
        case 'sexo/edit':
            if (isset($_GET['idsexo'])) {
                $controller = new SexoController();
                $controller->edit($_GET['idsexo']);
            } else {
                echo "Error: Falta el ID para editar.";
            }
            break;
            
        case 'sexo/eliminar':
            if (isset($_GET['idsexo'])) {
                $controller = new SexoController();
                $controller->delete($_GET['idsexo']);
            } else {
                echo "Error: Falta el ID para eliminar.";
            }
            break;
            
        case 'sexo/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new SexoController();
                $controller->delete();
            }
            break;
            
        case 'sexo/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new SexoController();
                $controller->update();
            }
            break;
            
        case 'direccion':
        case 'direccion/index':
            $controller = new DireccionController();
            $controller->index();
            break;
            
        case 'direccion/edit':
            if (isset($_GET['id'])) {
                $controller = new DireccionController();
                $controller->edit($_GET['id']);
            } else {
                echo "Error: Falta el ID para editar.";
            }
            break;
            
        case 'direccion/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new DireccionController();
                $controller->update();
            }
            break;
            
        case 'telefono':
        case 'telefono/index':
            $controller = new TelefonoController();
            $controller->index();
            break;
            
        case 'telefono/edit':
            if (isset($_GET['id'])) {
                $controller = new TelefonoController();
                $controller->edit($_GET['id']);
            } else {
                echo "Error: Falta el ID para editar.";
            }
            break;
            
        case 'telefono/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new TelefonoController();
                $controller->update();
            }
            break;
            
        case 'estadocivil':
        case 'estadocivil/index':
            $controller = new EstadoCivilController();
            $controller->index();
            break;
            
        case 'estadocivil/edit':
            if (isset($_GET['idestadocivil'])) {
                $controller = new EstadocivilController();
                $controller->edit($_GET['idestadocivil']);
            } else {
                echo "Error: Falta el ID para editar.";
            }
            break;
            
        case 'estadocivil/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new EstadocivilController();
                $controller->update();
            }
            break;
            
        default:
            echo "Error 404: Página no encontrada.";
            break;
    }
}
?>