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
    
    public function index() {
        $result = $this->direccion->readAll();
        $direcciones = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Include view
        include APP_PATH . '/views/direccion/index.php';
    }
    
    // Display form to create a new address
    public function create() {
        $id_persona = isset($_GET['id_persona']) ? $_GET['id_persona'] : null;
        
        if ($id_persona) {
            // Si se proporciona un id_persona, obtener los datos de la persona
            $this->persona->id_persona = $id_persona;
            $this->persona->readOne();
        } else {
            // Get all personas para el dropdown
            $personas = $this->persona->readAll()->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // Include view
        include APP_PATH . '/views/direccion/create.php';
    }
    
    // Store a new address in database
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: La solicitud no es válida.");
            }
            
            // Set direccion property values
            $this->direccion->id_persona = $_POST['id_persona'] ?? $_GET['id_persona'];
            $this->direccion->calle = $_POST['calle'];
            $this->direccion->ciudad = $_POST['ciudad'];
            $this->direccion->estado = $_POST['estado'];
            $this->direccion->codigo_postal = $_POST['codigo_postal'];
            
            // Create the address
            if ($this->direccion->create()) {
                // Redirigir a la vista de la persona si venimos de ahí
                if (isset($_GET['id_persona'])) {
                    header('Location: /public/index.php?controller=persona&action=view&id=' . $this->direccion->id_persona);
                } else {
                    header('Location: /public/index.php?controller=direccion&action=index');
                }
                exit();
            } else {
                // If creation failed
                include APP_PATH . '/views/direccion/create.php';
            }
        }
    }

    public function byPersona() {
        if (isset($_GET['id_persona'])) {
            $id_persona = $_GET['id_persona'];
            
            // Get the person data
            $this->persona->id_persona = $id_persona;
            $persona = $this->persona->readOne();
            
            // Get addresses for this person
            $result = $this->direccion->readByPersona($id_persona);
            $direcciones = $result->fetchAll(PDO::FETCH_ASSOC);
            
            // Include view
            include APP_PATH . '/views/direccion/by_persona.php';
        } else {
            header('Location: /public/index.php?controller=persona&action=index');
            exit();
        }
    }
    
    // Display form to edit an address
    public function edit() {
        if (isset($_GET['id'])) {
            $this->direccion->id_direccion = $_GET['id'];
            
            // Get the address data
            if ($this->direccion->readOne()) {
                // Include view
                include APP_PATH . '/views/direccion/edit.php';
            } else {
                header('Location: /public/index.php?controller=direccion&action=index');
                exit();
            }
        }
    }
    
    // Update an address in database
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: La solicitud no es válida.");
            }
            
            // Set direccion property values
            $this->direccion->id_direccion = $_GET['id'];
            $this->direccion->calle = $_POST['calle'];
            $this->direccion->ciudad = $_POST['ciudad'];
            $this->direccion->estado = $_POST['estado'];
            $this->direccion->codigo_postal = $_POST['codigo_postal'];
            
            // Recuperar el id_persona actual
            $old_direccion = new Direccion($this->db);
            $old_direccion->id_direccion = $this->direccion->id_direccion;
            $old_direccion->readOne();
            $this->direccion->id_persona = $old_direccion->id_persona;
            
            // Update the address
            if ($this->direccion->update()) {
                header('Location: /public/index.php?controller=persona&action=view&id=' . $this->direccion->id_persona);
                exit();
            } else {
                // If update failed
                include APP_PATH . '/views/direccion/edit.php';
            }
        }
    }
    
    // Display address details
    public function view() {
        if (isset($_GET['id'])) {
            $this->direccion->id_direccion = $_GET['id'];
            
            // Get the address data
            if ($this->direccion->readOne()) {
                // Get the person's data
                $this->persona->id_persona = $this->direccion->id_persona;
                $this->persona->readOne();
                
                // Include view
                include APP_PATH . '/views/direccion/view.php';
            } else {
                header('Location: /public/index.php?controller=direccion&action=index');
                exit();
            }
        }
    }
    
    // Delete an address
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            // Verificar token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: La solicitud no es válida.");
            }
            
            $this->direccion->id_direccion = $_GET['id'];
            
            // Guardar el id_persona antes de eliminar
            $old_direccion = new Direccion($this->db);
            $old_direccion->id_direccion = $this->direccion->id_direccion;
            $old_direccion->readOne();
            $id_persona = $old_direccion->id_persona;
            
            if ($this->direccion->delete()) {
                // Redirigir a la vista de la persona
                header('Location: /public/index.php?controller=persona&action=view&id=' . $id_persona);
                exit();
            } else {
                echo "Error al eliminar la dirección.";
            }
        }
    }
}
?>