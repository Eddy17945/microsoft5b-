<?php
class EstadoCivilController {
    private $db;
    private $estadoCivil;
    
    public function __construct() {
        // Include necessary files
        require_once APP_PATH . '/models/EstadoCivil.php';
        
        // Create database connection
        global $database;
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Initialize objects
        $this->estadoCivil = new EstadoCivil($this->db);
    }
    
    // Display list of all estados civiles
    public function index() {
        $result = $this->estadoCivil->readAll();
        $estadosCiviles = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Capturar salida en buffer
        ob_start();
        include APP_PATH . '/views/estadocivil/index.php';
        $content = ob_get_clean();
        
        // Incluir layout principal con contenido
        include_once APP_PATH . '/views/layouts/main.php';
    }
  
    // Display form to create a new estado civil
    public function create() {
        // Capturar salida en buffer
        ob_start();
        include APP_PATH .'/views/estadocivil/create.php';
        $content = ob_get_clean();
        
        // Incluir layout principal con contenido
        include_once APP_PATH . '/views/layouts/main.php';
    }
    
    // Store a new estado civil in database
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set estado civil property values
            $this->estadoCivil->descripcion = $_POST['descripcion'];
            
            // Create the estado civil
            if ($this->estadoCivil->create()) {
                $_SESSION['message'] = "Estado Civil creado exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=estadocivil&action=index');
                exit();
            } else {
                // If creation failed
                $_SESSION['message'] = "Error al crear el Estado Civil";
                $_SESSION['message_type'] = "danger";
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/estadocivil/create.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            }
        }
    }
    
    // Display form to edit an estado civil
    public function edit() {
        if (isset($_GET['id'])) {
            $this->estadoCivil->id_estadocivil = $_GET['id'];
            
            // Get the estado civil data
            if ($this->estadoCivil->readOne()) {
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/estadocivil/edit.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            } else {
                $_SESSION['message'] = "Estado Civil no encontrado";
                $_SESSION['message_type'] = "warning";
                header('Location: ' . BASE_URL . 'index.php?controller=estadocivil&action=index');
                exit();
            }
        }
    }
    
    // Update an estado civil in database
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set estado civil property values
            $this->estadoCivil->id_estadocivil = $_POST['id_estadocivil'];
            $this->estadoCivil->descripcion = $_POST['descripcion'];
            
            // Update the estado civil
            if ($this->estadoCivil->update()) {
                $_SESSION['message'] = "Estado Civil actualizado exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=estadocivil&action=index');
                exit();
            } else {
                // If update failed
                $_SESSION['message'] = "Error al actualizar el Estado Civil";
                $_SESSION['message_type'] = "danger";
                $this->edit();
            }
        }
    }

    public function view() {
        if (isset($_GET['id'])) {
            $this->estadoCivil->id_estadocivil = $_GET['id'];
            
            // Get the estado civil data
            if ($this->estadoCivil->readOne()) {
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/estadocivil/view.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            } else {
                $_SESSION['message'] = "Estado Civil no encontrado";
                $_SESSION['message_type'] = "warning";
                header('Location: ' . BASE_URL . 'index.php?controller=estadocivil&action=index');
                exit();
            }
        }
    }
    
    // Delete an estado civil
    public function delete() {
        if (isset($_GET['id'])) {
            $this->estadoCivil->id_estadocivil = $_GET['id'];
            
            if ($this->estadoCivil->delete()) {
                $_SESSION['message'] = "Estado Civil eliminado exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=estadocivil&action=index');
                exit();
            } else {
                $_SESSION['message'] = "Error al eliminar el Estado Civil";
                $_SESSION['message_type'] = "danger";
                header('Location: ' . BASE_URL . 'index.php?controller=estadocivil&action=index');
                exit();
            }
        }
    }
}
?>