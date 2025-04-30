<?php
class EstadoCivilController {
    private $db;
    private $estadoCivil;
    
    public function __construct() {
        // Include necessary files
        
        require_once APP_PATH .'/models/EstadoCivil.php';
        
        // Create database connection
        global $database;
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Initialize objects
        $this->estadoCivil = new EstadoCivil($this->db);
    }
    
    // Display list of all civil status options
    public function index() {
        $result = $this->estadoCivil->readAll();
        $estadosCiviles = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Include view
        include APP_PATH . '/views/estadocivil/index.php';
    }
    
    // Display form to create a new civil status option
    public function create() {
        // Include view
        include APP_PATH . '/views/estadocivil/create.php';
    }
    
    // Store a new civil status option in database
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set estadoCivil property values
            $this->estadoCivil->descripcion = $_POST['descripcion'];
            
            // Create the civil status option
            if ($this->estadoCivil->create()) {
                header('Location: index.php?controller=estadocivil&action=index');
                exit();
            } else {
                // If creation failed
                include APP_PATH .  '/views/estadocivil/create.php';
            }
        }
    }

    public function view() {
        if (isset($_GET['id'])) {
            $this->estadoCivil->id_estadocivil = $_GET['id'];
            
            // Get the civil status option data
            if ($this->estadoCivil->readOne()) {
                // Include view
                include APP_PATH . '/views/estadocivil/view.php';
            } else {
                header('Location: index.php?controller=estadocivil&action=index');
                exit();
            }
        }
    }
    
    // Display form to edit a civil status option
    public function edit() {
        if (isset($_GET['id'])) {
            $this->estadoCivil->id_estadocivil = $_GET['id'];
            
            // Get the civil status option data
            if ($this->estadoCivil->readOne()) {
                // Include view
                include APP_PATH . '/views/estadocivil/edit.php';
            } else {
                header('Location: index.php?controller=estadocivil&action=index');
                exit();
            }
        }
    }
    
    // Update a civil status option in database
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set estadoCivil property values
            $this->estadoCivil->id_estadocivil = $_POST['id_estadocivil'];
            $this->estadoCivil->descripcion = $_POST['descripcion'];
            
            // Update the civil status option
            if ($this->estadoCivil->update()) {
                header('Location: index.php?controller=estadocivil&action=index');
                exit();
            } else {
                // If update failed
                $this->edit();
            }
        }
    }
    
    // Delete a civil status option
    public function delete() {
        if (isset($_GET['id'])) {
            $this->estadoCivil->id_estadocivil = $_GET['id'];
            
            if ($this->estadoCivil->delete()) {
                header('Location: index.php?controller=estadocivil&action=index');
                exit();
            } else {
                echo "Failed to delete civil status option. It may be in use by one or more persons.";
            }
        }
    }
}
?>
