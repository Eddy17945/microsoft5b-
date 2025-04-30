<?php
session_start();

// Configuración de seguridad básica
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Constantes de rutas
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');  

// Autoload de clases 
spl_autoload_register(function ($class) {     
    $file = APP_PATH . '/' . str_replace('\\', '/', $class) . '.php';     
    if (file_exists($file)) {         
        require $file;     
    } 
});  

// Manejo de errores 
set_error_handler(function($errno, $errstr, $errfile, $errline) {     
    error_log("Error: [$errno] $errstr in $errfile on line $errline");     
    if (ini_get('display_errors')) {         
        echo "<div class='alert alert-danger'>Error: $errstr</div>";     
    } 
});  

// Obtener parámetros de la URL 
$controller = $_GET['controller'] ?? 'persona'; 
$action = $_GET['action'] ?? 'index'; 
$id = $_GET['id'] ?? null;  

// Validar y sanitizar entradas 
$controller = preg_replace('/[^a-z]/', '', strtolower($controller)); 
$action = preg_replace('/[^a-z]/', '', strtolower($action)); 
$id = filter_var($id, FILTER_VALIDATE_INT);  

// Cargar configuración de la base de datos 
require_once APP_PATH . '/config/database.php';  

// Definir ruta base de vistas
define('VIEWS_PATH', APP_PATH . '/views/');

try {     
    // Instanciar el controlador     
    $controllerClassName = ucfirst($controller) . 'Controller';     
    $controllerFile = APP_PATH . "/controllers/{$controllerClassName}.php";          
    
    if (!file_exists($controllerFile)) {         
        throw new Exception("Controlador no encontrado: {$controllerFile}");     
    }          
    
    // Incluir explícitamente el archivo del controlador
    require_once $controllerFile;
    
    // Instanciar el controlador
    $controllerInstance = new $controllerClassName();
    
    // Verificar que el método (acción) existe
    if (!method_exists($controllerInstance, $action)) {
        throw new Exception("Acción no encontrada: {$action}");
    }
    
    // Obtener el contenido de la vista 
    ob_start(); 
    if ($id !== false && $id !== null) {     
        $controllerInstance->$action($id); 
    } else {     
        $controllerInstance->$action(); 
    } 
    $content = ob_get_clean();  
    
    // Incluir layout principal 
    require VIEWS_PATH . 'layouts/main.php';  
    
} catch (PDOException $e) {     
    error_log("Error de base de datos: " . $e->getMessage());     
    $_SESSION['error'] = "Error de conexión con la base de datos";     
    header("Location: error.php");
    exit();
} catch (Exception $e) {     
    error_log("Error general: " . $e->getMessage());     
    $_SESSION['error'] = $e->getMessage();     
    header("Location: error.php");
    exit();
} 
?>