<?php
// Tamara Becerra hizo el código de la clase TelefonoController
class TelefonoController {
    private $db;
    private $telefono;
    private $persona;
    
    public function __construct() {
        // Include necessary files
        require_once APP_PATH . '/models/Telefono.php';
        require_once APP_PATH . '/models/Persona.php';
        
        // Create database connection
        global $database;
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Initialize objects
        $this->telefono = new Telefono($this->db);
        $this->persona = new Persona($this->db);
    }
    
    // Display list of all phone numbers
    public function index() {
        $result = $this->telefono->readAll();
        $telefonos = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Capturar salida en buffer
        ob_start();
        include APP_PATH . '/views/telefono/index.php';
        $content = ob_get_clean();
        
        // Incluir layout principal con contenido
        include_once APP_PATH . '/views/layouts/main.php';
    }
    
    // Display form to create a new phone number
    public function create() {
        $id_persona = isset($_GET['id_persona']) ? $_GET['id_persona'] : null;
        
        if ($id_persona) {
            // Si se proporciona un id_persona, obtener los datos de la persona
            $this->persona->id_persona = $id_persona;
            $this->persona->readOne();
            $persona = $this->persona; // Asignar el objeto persona completo
        } else {
            // Get all personas para el dropdown
            $result = $this->persona->readAll();
            $personas = $result->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // Generate CSRF token if not exists
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        // Capturar salida en buffer
        ob_start();
        include APP_PATH . '/views/telefono/create.php';
        $content = ob_get_clean();
        
        // Incluir layout principal con contenido
        include_once APP_PATH . '/views/layouts/main.php';
    }
    
    // Store a new phone number in database
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: La solicitud no es válida.");
            }
            
            // Set telefono property values
            $this->telefono->id_persona = isset($_POST['id_persona']) ? $_POST['id_persona'] : $_GET['id_persona'];
            $this->telefono->numero = $_POST['numero'];
            $this->telefono->tipo = $_POST['tipo'];
            
            // Create the phone number
            if ($this->telefono->create()) {
                $_SESSION['message'] = "Teléfono creado exitosamente";
                $_SESSION['message_type'] = "success";
                
                // Redirigir a la vista de la persona si venimos de ahí
                if (isset($_GET['id_persona'])) {
                    header('Location: ' . BASE_URL . 'index.php?controller=persona&action=view&id=' . $_GET['id_persona']);
                } else {
                    header('Location: ' . BASE_URL . 'index.php?controller=telefono&action=index');
                }
                exit();
            } else {
                // If creation failed
                $_SESSION['message'] = "Error al crear el teléfono";
                $_SESSION['message_type'] = "danger";
                
                if (isset($_GET['id_persona'])) {
                    $id_persona = $_GET['id_persona'];
                    $this->persona->id_persona = $id_persona;
                    $this->persona->readOne();
                    $persona = $this->persona; // Asignar el objeto persona completo
                } else {
                    $result = $this->persona->readAll();
                    $personas = $result->fetchAll(PDO::FETCH_ASSOC);
                }
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/telefono/create.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            }
        }
    }
    
    // Display form to edit a phone number
    public function edit() {
        if (isset($_GET['id'])) {
            $this->telefono->id_telefono = $_GET['id'];
            
            // Get the phone data
            if ($this->telefono->readOne()) {
                // Generate CSRF token if not exists
                if (!isset($_SESSION['csrf_token'])) {
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                }
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/telefono/edit.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            } else {
                $_SESSION['message'] = "Teléfono no encontrado";
                $_SESSION['message_type'] = "warning";
                header('Location: ' . BASE_URL . 'index.php?controller=telefono&action=index');
                exit();
            }
        }
    }
    
    // Update a phone number in database
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: La solicitud no es válida.");
            }
            
            // Set telefono property values
            $this->telefono->id_telefono = $_GET['id'];
            $this->telefono->numero = $_POST['numero'];
            $this->telefono->tipo = $_POST['tipo'];
            
            // Recuperar el id_persona actual
            $old_telefono = new Telefono($this->db);
            $old_telefono->id_telefono = $this->telefono->id_telefono;
            $old_telefono->readOne();
            $this->telefono->id_persona = $old_telefono->id_persona;
            
            // Update the phone number
            if ($this->telefono->update()) {
                $_SESSION['message'] = "Teléfono actualizado exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=persona&action=view&id=' . $this->telefono->id_persona);
                exit();
            } else {
                // If update failed
                $_SESSION['message'] = "Error al actualizar el teléfono";
                $_SESSION['message_type'] = "danger";
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/telefono/edit.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            }
        }
    }
    
    // Display phone number details
    public function view() {
        if (isset($_GET['id'])) {
            $this->telefono->id_telefono = $_GET['id'];
            
            // Get the phone data
            if ($this->telefono->readOne()) {
                // Get the person's data
                $this->persona->id_persona = $this->telefono->id_persona;
                $this->persona->readOne();
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/telefono/view.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            } else {
                $_SESSION['message'] = "Teléfono no encontrado";
                $_SESSION['message_type'] = "warning";
                header('Location: ' . BASE_URL . 'index.php?controller=telefono&action=index');
                exit();
            }
        }
    }
    
    // Delete a phone number
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            // Verificar token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: La solicitud no es válida.");
            }
            
            $this->telefono->id_telefono = $_GET['id'];
            
            // Guardar el id_persona antes de eliminar
            $old_telefono = new Telefono($this->db);
            $old_telefono->id_telefono = $this->telefono->id_telefono;
            $old_telefono->readOne();
            $id_persona = $old_telefono->id_persona;
            
            if ($this->telefono->delete()) {
                $_SESSION['message'] = "Teléfono eliminado exitosamente";
                $_SESSION['message_type'] = "success";
                // Redirigir a la vista de la persona
                header('Location: ' . BASE_URL . 'index.php?controller=persona&action=view&id=' . $id_persona);
                exit();
            } else {
                $_SESSION['message'] = "Error al eliminar el teléfono";
                $_SESSION['message_type'] = "danger";
                header('Location: ' . BASE_URL . 'index.php?controller=persona&action=view&id=' . $id_persona);
                exit();
            }
        }
    }
    
    // Obtener teléfonos por persona
    public function byPersona() {
        if (isset($_GET['id_persona'])) {
            $id_persona = $_GET['id_persona'];
            
            // Get the person data
            $this->persona->id_persona = $id_persona;
            $persona = $this->persona->readOne();
            
            // Get telefonos for this person
            $result = $this->telefono->readByPersona($id_persona);
            $telefonos = $result->fetchAll(PDO::FETCH_ASSOC);
            
            // Capturar salida en buffer
            ob_start();
            include APP_PATH . '/views/telefono/by_persona.php';
            $content = ob_get_clean();
            
            // Incluir layout principal con contenido
            include_once APP_PATH . '/views/layouts/main.php';
        } else {
            $_SESSION['message'] = "Persona no especificada";
            $_SESSION['message_type'] = "warning";
            header('Location: ' . BASE_URL . 'index.php?controller=persona&action=index');
            exit();
        }
    }
}
?>