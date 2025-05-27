<?php
class SexoController {
    private $db;
    private $sexo;
    
    public function __construct() {
        // Include necessary files
        require_once APP_PATH . '/models/Sexo.php';
        
        // Create database connection
        global $database;
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Initialize objects
        $this->sexo = new Sexo($this->db);
    }
    
    // Display list of all sexos
    public function index() {
        $result = $this->sexo->readAll();
        $sexos = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Capturar salida en buffer
        ob_start();
        include APP_PATH . '/views/sexo/index.php';
        $content = ob_get_clean();
        
        // Incluir layout principal con contenido
        include_once APP_PATH . '/views/layouts/main.php';
    }
  
    // Display form to create a new sexo
    public function create() {
        // Capturar salida en buffer
        ob_start();
        include APP_PATH .'/views/sexo/create.php';
        $content = ob_get_clean();
        
        // Incluir layout principal con contenido
        include_once APP_PATH . '/views/layouts/main.php';
    }
    
    // Store a new sexo in database
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set sexo property values
            $this->sexo->descripcion = $_POST['descripcion'];
            
            // Create the sexo
            if ($this->sexo->create()) {
                $_SESSION['message'] = "Sexo creado exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=sexo&action=index');
                exit();
            } else {
                // If creation failed
                $_SESSION['message'] = "Error al crear el sexo";
                $_SESSION['message_type'] = "danger";
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/sexo/create.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            }
        }
    }
    
    // Display form to edit a sexo
    public function edit() {
        if (isset($_GET['id'])) {
            $this->sexo->id_sexo = $_GET['id'];
            
            // Get the sexo data
            if ($this->sexo->readOne()) {
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/sexo/edit.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            } else {
                $_SESSION['message'] = "Sexo no encontrado";
                $_SESSION['message_type'] = "warning";
                header('Location: ' . BASE_URL . 'index.php?controller=sexo&action=index');
                exit();
            }
        }
    }
    
    // Update a sexo in database
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set sexo property values
            $this->sexo->id_sexo = $_POST['id_sexo'];
            $this->sexo->descripcion = $_POST['descripcion'];
            
            // Update the sexo
            if ($this->sexo->update()) {
                $_SESSION['message'] = "Sexo actualizado exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=sexo&action=index');
                exit();
            } else {
                // If update failed
                $_SESSION['message'] = "Error al actualizar el sexo";
                $_SESSION['message_type'] = "danger";
                $this->edit();
            }
        }
    }

    public function view() {
        if (isset($_GET['id'])) {
            $this->sexo->id_sexo = $_GET['id'];
            
            // Get the sexo data
            if ($this->sexo->readOne()) {
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/sexo/view.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            } else {
                $_SESSION['message'] = "Sexo no encontrado";
                $_SESSION['message_type'] = "warning";
                header('Location: ' . BASE_URL . 'index.php?controller=sexo&action=index');
                exit();
            }
        }
    }
    
    // Delete a sexo
    public function delete() {
        if (isset($_GET['id'])) {
            $this->sexo->id_sexo = $_GET['id'];
            
            if ($this->sexo->delete()) {
                $_SESSION['message'] = "Sexo eliminado exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=sexo&action=index');
                exit();
            } else {
                $_SESSION['message'] = "Error al eliminar el sexo";
                $_SESSION['message_type'] = "danger";
                header('Location: ' . BASE_URL . 'index.php?controller=sexo&action=index');
                exit();
            }
        }
    }
}
?>