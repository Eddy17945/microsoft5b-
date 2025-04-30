<?php
class Sexo {
    private $conn;
    private $table_name = "sexo";
    
    public $id_sexo;
    public $descripcion;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Read all sex options
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_sexo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Read one sex option
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_sexo = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_sexo);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->descripcion = $row['descripcion'];
            return true;
        }
        
        return false;
    }
    
    // Create a new sex option
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
    
    // Update a sex option
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET descripcion=:descripcion WHERE id_sexo=:id_sexo";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->id_sexo = htmlspecialchars(strip_tags($this->id_sexo));
        
        // Bind values
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":id_sexo", $this->id_sexo);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Delete a sex option
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_sexo = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_sexo);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>
