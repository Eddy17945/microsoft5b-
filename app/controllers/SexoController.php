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
        
        // Inicializar token CSRF si no existe
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
    
    // Display list of all sex options
    public function index() {
        $result = $this->sexo->readAll();
        $sexos = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Include view
        include APP_PATH . '/views/sexo/index.php';
    }
    
    // Display form to create a new sex option
    public function create() {
        // Include view
        include APP_PATH . '/views/sexo/create.php';
    }
    
    // Store a new sex option in database
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: La solicitud no es válida.");
            }
            
            // Set sexo property values
            $this->sexo->descripcion = $_POST['descripcion'];
            
            // Create the sex option
            if ($this->sexo->create()) {
                header('Location: /public/index.php?controller=sexo&action=index');
                exit();
            } else {
                // If creation failed
                include APP_PATH . '/views/sexo/create.php';
            }
        }
    }
    
    // Display form to edit a sex option
    public function edit() {
        if (isset($_GET['id'])) {
            $this->sexo->id_sexo = $_GET['id'];
            
            // Get the sex option data
            if ($this->sexo->readOne()) {
                // Include view
                include APP_PATH . '/views/sexo/edit.php';
            } else {
                header('Location: /public/index.php?controller=sexo&action=index');
                exit();
            }
        }
    }
    
    // Update a sex option in database
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: La solicitud no es válida.");
            }
            
            // Set sexo property values
            $this->sexo->id_sexo = $_POST['id_sexo'];
            $this->sexo->descripcion = $_POST['descripcion'];
            
            // Update the sex option
            if ($this->sexo->update()) {
                header('Location: /public/index.php?controller=sexo&action=index');
                exit();
            } else {
                // If update failed
                include APP_PATH . '/views/sexo/edit.php';
            }
        }
    }
    
    // View a sex option
    public function view() {
        if (isset($_GET['id'])) {
            $this->sexo->id_sexo = $_GET['id'];
            
            // Get the sex option data
            if ($this->sexo->readOne()) {
                // Include view
                include APP_PATH . '/views/sexo/view.php';
            } else {
                header('Location: /public/index.php?controller=sexo&action=index');
                exit();
            }
        }
    }
    
    // Delete a sex option
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            // Verificar token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: La solicitud no es válida.");
            }
            
            $this->sexo->id_sexo = $_GET['id'];
            
            if ($this->sexo->delete()) {
                header('Location: /public/index.php?controller=sexo&action=index');
                exit();
            } else {
                // Mostrar mensaje más amigable
                $_SESSION['error'] = "No se puede eliminar este registro porque está siendo utilizado por una o más personas.";
                header('Location: /public/index.php?controller=sexo&action=view&id=' . $this->sexo->id_sexo);
                exit();
            }
        }
    }
}
?>