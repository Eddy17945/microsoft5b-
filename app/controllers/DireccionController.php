<?php
class DireccionController {
    private $db;
    private $direccion;
    private $persona;
    
    public function __construct() {
        // Include necessary files
        require_once APP_PATH . '/models/Direccion.php';
        require_once APP_PATH . '/models/Persona.php';
        
        // Create database connection
        global $database;
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Initialize objects
        $this->direccion = new Direccion($this->db);
        $this->persona = new Persona($this->db);
    }
    
    // Display list of all direcciones
    public function index() {
        $result = $this->direccion->readAll();
        $direcciones = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Capturar salida en buffer
        ob_start();
        include APP_PATH . '/views/direccion/index.php';
        $content = ob_get_clean();
        
        // Incluir layout principal con contenido
        include_once APP_PATH . '/views/layouts/main.php';
    }
  
    // Display form to create a new direccion
    public function create() {
        // Get all personas for the dropdown
        $result = $this->persona->readAll();
        $personas = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Capturar salida en buffer
        ob_start();
        include APP_PATH .'/views/direccion/create.php';
        $content = ob_get_clean();
        
        // Incluir layout principal con contenido
        include_once APP_PATH . '/views/layouts/main.php';
    }
    
    // Store a new direccion in database
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set direccion property values
            $this->direccion->id_persona = $_POST['id_persona'];
            $this->direccion->calle = $_POST['calle'];
            $this->direccion->ciudad = $_POST['ciudad'];
            $this->direccion->estado = $_POST['estado'];
            $this->direccion->codigo_postal = $_POST['codigo_postal'];
            
            // Create the direccion
            if ($this->direccion->create()) {
                $_SESSION['message'] = "Dirección creada exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=direccion&action=index');
                exit();
            } else {
                // If creation failed
                $_SESSION['message'] = "Error al crear la dirección";
                $_SESSION['message_type'] = "danger";
                
                // Get all personas for the dropdown again
                $result = $this->persona->readAll();
                $personas = $result->fetchAll(PDO::FETCH_ASSOC);
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/direccion/create.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            }
        }
    }
    
    // Display form to edit a direccion
    public function edit() {
        if (isset($_GET['id'])) {
            $this->direccion->id_direccion = $_GET['id'];
            
            // Get the direccion data
            if ($this->direccion->readOne()) {
                // Get all personas for the dropdown
                $result = $this->persona->readAll();
                $personas = $result->fetchAll(PDO::FETCH_ASSOC);
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/direccion/edit.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            } else {
                $_SESSION['message'] = "Dirección no encontrada";
                $_SESSION['message_type'] = "warning";
                header('Location: ' . BASE_URL . 'index.php?controller=direccion&action=index');
                exit();
            }
        }
    }
    
    // Update a direccion in database
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set direccion property values
            $this->direccion->id_direccion = $_POST['id_direccion'];
            $this->direccion->id_persona = $_POST['id_persona'];
            $this->direccion->calle = $_POST['calle'];
            $this->direccion->ciudad = $_POST['ciudad'];
            $this->direccion->estado = $_POST['estado'];
            $this->direccion->codigo_postal = $_POST['codigo_postal'];
            
            // Update the direccion
            if ($this->direccion->update()) {
                $_SESSION['message'] = "Dirección actualizada exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=direccion&action=index');
                exit();
            } else {
                // If update failed
                $_SESSION['message'] = "Error al actualizar la dirección";
                $_SESSION['message_type'] = "danger";
                $this->edit();
            }
        }
    }

    public function view() {
        if (isset($_GET['id'])) {
            $this->direccion->id_direccion = $_GET['id'];
            
            // Get the direccion data
            if ($this->direccion->readOne()) {
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/direccion/view.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            } else {
                $_SESSION['message'] = "Dirección no encontrada";
                $_SESSION['message_type'] = "warning";
                header('Location: ' . BASE_URL . 'index.php?controller=direccion&action=index');
                exit();
            }
        }
    }
    
    // Delete a direccion
    public function delete() {
        if (isset($_GET['id'])) {
            $this->direccion->id_direccion = $_GET['id'];
            
            if ($this->direccion->delete()) {
                $_SESSION['message'] = "Dirección eliminada exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=direccion&action=index');
                exit();
            } else {
                $_SESSION['message'] = "Error al eliminar la dirección";
                $_SESSION['message_type'] = "danger";
                header('Location: ' . BASE_URL . 'index.php?controller=direccion&action=index');
                exit();
            }
        }
    }
}
?>