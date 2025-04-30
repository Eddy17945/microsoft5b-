<?php
class EstadoCivil {
    private $conn;
    private $table_name = "estadocivil";
    
    public $id_estadocivil;
    public $descripcion;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Read all civil status options
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_estadocivil";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Read one civil status option
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_estadocivil = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_estadocivil);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->descripcion = $row['descripcion'];
            return true;
        }
        
        return false;
    }
    
    // Create a new civil status option
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET descripcion=:descripcion";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        
        // Bind values
        $stmt->bindParam(":descripcion", $this->descripcion);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Update a civil status option
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET descripcion=:descripcion WHERE id_estadocivil=:id_estadocivil";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->id_estadocivil = htmlspecialchars(strip_tags($this->id_estadocivil));
        
        // Bind values
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":id_estadocivil", $this->id_estadocivil);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Delete a civil status option
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_estadocivil = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_estadocivil);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>
