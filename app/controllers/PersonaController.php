<?php
// Andreina Crespo - AndreinaC18 hizo el código de la clase PersonaController
class PersonaController {
    private $db;
    private $persona;
    private $sexo;
    private $estadoCivil;
    
    public function __construct() {
        // Include necessary files
        require_once APP_PATH . '/models/Persona.php';
        require_once APP_PATH . '/models/Sexo.php';
        require_once APP_PATH . '/models/EstadoCivil.php';
        
        // Create database connection
        global $database;
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Initialize objects
        $this->persona = new Persona($this->db);
        $this->sexo = new Sexo($this->db);
        $this->estadoCivil = new EstadoCivil($this->db);
    }
    
    // Display list of all persons
    public function index() {
        $result = $this->persona->readAll();
        $personas = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Capturar salida en buffer
        ob_start();
        include APP_PATH . '/views/persona/index.php';
        $content = ob_get_clean();
        
        // Incluir layout principal con contenido
        include_once APP_PATH . '/views/layouts/main.php';
    }
  
    // Display form to create a new person
    public function create() {
        // Get all sexo options
        $sexos = $this->sexo->readAll()->fetchAll(PDO::FETCH_ASSOC);
        
        // Get all estado civil options
        $estadosCiviles = $this->estadoCivil->readAll()->fetchAll(PDO::FETCH_ASSOC);
        
        // Capturar salida en buffer
        ob_start();
        include APP_PATH .'/views/persona/create.php';
        $content = ob_get_clean();
        
        // Incluir layout principal con contenido
        include_once APP_PATH . '/views/layouts/main.php';
    }
    
    // Store a new person in database
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set persona property values
            $this->persona->nombre = $_POST['nombre'];
            $this->persona->apellido = $_POST['apellido'];
            $this->persona->fecha_nacimiento = $_POST['fecha_nacimiento'];
            $this->persona->id_sexo = $_POST['id_sexo'];
            $this->persona->id_estadocivil = $_POST['id_estadocivil'];
            
            // Create the person
            if ($this->persona->create()) {
                $_SESSION['message'] = "Persona creada exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=persona&action=index');
                exit();
            } else {
                // If creation failed
                $_SESSION['message'] = "Error al crear la persona";
                $_SESSION['message_type'] = "danger";
                
                // Get all sexo options and estado civil for the form again
                $sexos = $this->sexo->readAll()->fetchAll(PDO::FETCH_ASSOC);
                $estadosCiviles = $this->estadoCivil->readAll()->fetchAll(PDO::FETCH_ASSOC);
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/persona/create.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            }
        }
    }
    
    // Display form to edit a person
    public function edit() {
        if (isset($_GET['id'])) {
            $this->persona->id_persona = $_GET['id'];
            
            // Get the person data
            if ($this->persona->readOne()) {
                // Get all sexo options
                $sexos = $this->sexo->readAll()->fetchAll(PDO::FETCH_ASSOC);
                
                // Get all estado civil options
                $estadosCiviles = $this->estadoCivil->readAll()->fetchAll(PDO::FETCH_ASSOC);
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/persona/edit.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            } else {
                $_SESSION['message'] = "Persona no encontrada";
                $_SESSION['message_type'] = "warning";
                header('Location: ' . BASE_URL . 'index.php?controller=persona&action=index');
                exit();
            }
        }
    }
    
    // Update a person in database
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set persona property values
            $this->persona->id_persona = $_POST['id_persona'];
            $this->persona->nombre = $_POST['nombre'];
            $this->persona->apellido = $_POST['apellido'];
            $this->persona->fecha_nacimiento = $_POST['fecha_nacimiento'];
            $this->persona->id_sexo = $_POST['id_sexo'];
            $this->persona->id_estadocivil = $_POST['id_estadocivil'];
            
            // Update the person
            if ($this->persona->update()) {
                $_SESSION['message'] = "Persona actualizada exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=persona&action=index');
                exit();
            } else {
                // If update failed
                $_SESSION['message'] = "Error al actualizar la persona";
                $_SESSION['message_type'] = "danger";
                $this->edit();
            }
        }
    }

    public function view() {
        if (isset($_GET['id'])) {
            $this->persona->id_persona = $_GET['id'];
            
            // Get the person data
            if ($this->persona->readOne()) {
                // Get direcciones for this person
                require_once APP_PATH . '/models/Direccion.php';
                $direccion = new Direccion($this->db);
                $resultDirecciones = $direccion->readByPersona($this->persona->id_persona);
                $direcciones = $resultDirecciones->fetchAll(PDO::FETCH_ASSOC);
                
                // Get teléfonos for this person
                require_once APP_PATH . '/models/Telefono.php';
                $telefono = new Telefono($this->db);
                $resultTelefonos = $telefono->readByPersona($this->persona->id_persona);
                $telefonos = $resultTelefonos->fetchAll(PDO::FETCH_ASSOC);
                
                // Capturar salida en buffer
                ob_start();
                include APP_PATH . '/views/persona/view.php';
                $content = ob_get_clean();
                
                // Incluir layout principal con contenido
                include_once APP_PATH . '/views/layouts/main.php';
            } else {
                $_SESSION['message'] = "Persona no encontrada";
                $_SESSION['message_type'] = "warning";
                header('Location: ' . BASE_URL . 'index.php?controller=persona&action=index');
                exit();
            }
        }
    }
    
    // Delete a person
    public function delete() {
        if (isset($_GET['id'])) {
            $this->persona->id_persona = $_GET['id'];
            
            if ($this->persona->delete()) {
                $_SESSION['message'] = "Persona eliminada exitosamente";
                $_SESSION['message_type'] = "success";
                header('Location: ' . BASE_URL . 'index.php?controller=persona&action=index');
                exit();
            } else {
                $_SESSION['message'] = "Error al eliminar la persona";
                $_SESSION['message_type'] = "danger";
                header('Location: ' . BASE_URL . 'index.php?controller=persona&action=index');
                exit();
            }
        }
    }
}
?>