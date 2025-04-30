<?php
class Telefono {
    private $conn;
    private $table_name = "telefono";
    
    public $id_telefono;
    public $id_persona;
    public $numero;
    public $tipo;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Read all phone numbers
    public function readAll() {
        $query = "SELECT t.*, p.nombre, p.apellido 
                  FROM " . $this->table_name . " t
                  LEFT JOIN persona p ON t.id_persona = p.id_persona
                  ORDER BY t.id_telefono";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Read one phone number
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_telefono = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_telefono);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id_persona = $row['id_persona'];
            $this->numero = $row['numero'];
            $this->tipo = $row['tipo'];
            return true;
        }
        
        return false;
    }
    
    // Create a new phone number
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET id_persona=:id_persona, numero=:numero, tipo=:tipo";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_persona = htmlspecialchars(strip_tags($this->id_persona));
        $this->numero = htmlspecialchars(strip_tags($this->numero));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        
        // Bind values
        $stmt->bindParam(":id_persona", $this->id_persona);
        $stmt->bindParam(":numero", $this->numero);
        $stmt->bindParam(":tipo", $this->tipo);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Update a phone number
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET id_persona=:id_persona, numero=:numero, tipo=:tipo
                WHERE id_telefono=:id_telefono";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_telefono = htmlspecialchars(strip_tags($this->id_telefono));
        $this->id_persona = htmlspecialchars(strip_tags($this->id_persona));
        $this->numero = htmlspecialchars(strip_tags($this->numero));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        
        // Bind values
        $stmt->bindParam(":id_telefono", $this->id_telefono);
        $stmt->bindParam(":id_persona", $this->id_persona);
        $stmt->bindParam(":numero", $this->numero);
        $stmt->bindParam(":tipo", $this->tipo);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Delete a phone number
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_telefono = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_telefono);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Read all phone numbers by person ID
    public function readByPersona($id_persona) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_persona = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_persona);
        $stmt->execute();
        
        return $stmt;
    }
}
?>