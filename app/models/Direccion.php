<?php
class Direccion {
    private $conn;
    private $table_name = "direccion";
    
    public $id_direccion;
    public $id_persona;
    public $calle;
    public $ciudad;
    public $estado;
    public $codigo_postal;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Read all addresses
    public function readAll() {
        $query = "SELECT d.*, p.nombre, p.apellido 
                  FROM " . $this->table_name . " d
                  LEFT JOIN persona p ON d.id_persona = p.id_persona
                  ORDER BY d.id_direccion";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Read one address
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_direccion = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_direccion);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id_persona = $row['id_persona'];
            $this->calle = $row['calle'];
            $this->ciudad = $row['ciudad'];
            $this->estado = $row['estado'];
            $this->codigo_postal = $row['codigo_postal'];
            return true;
        }
        
        return false;
    }
    
    // Create a new address
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET id_persona=:id_persona, calle=:calle, ciudad=:ciudad, 
                    estado=:estado, codigo_postal=:codigo_postal";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_persona = htmlspecialchars(strip_tags($this->id_persona));
        $this->calle = htmlspecialchars(strip_tags($this->calle));
        $this->ciudad = htmlspecialchars(strip_tags($this->ciudad));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->codigo_postal = htmlspecialchars(strip_tags($this->codigo_postal));
        
        // Bind values
        $stmt->bindParam(":id_persona", $this->id_persona);
        $stmt->bindParam(":calle", $this->calle);
        $stmt->bindParam(":ciudad", $this->ciudad);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":codigo_postal", $this->codigo_postal);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Update an address
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET id_persona=:id_persona, calle=:calle, ciudad=:ciudad, 
                    estado=:estado, codigo_postal=:codigo_postal
                WHERE id_direccion=:id_direccion";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_direccion = htmlspecialchars(strip_tags($this->id_direccion));
        $this->id_persona = htmlspecialchars(strip_tags($this->id_persona));
        $this->calle = htmlspecialchars(strip_tags($this->calle));
        $this->ciudad = htmlspecialchars(strip_tags($this->ciudad));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->codigo_postal = htmlspecialchars(strip_tags($this->codigo_postal));
        
        // Bind values
        $stmt->bindParam(":id_direccion", $this->id_direccion);
        $stmt->bindParam(":id_persona", $this->id_persona);
        $stmt->bindParam(":calle", $this->calle);
        $stmt->bindParam(":ciudad", $this->ciudad);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":codigo_postal", $this->codigo_postal);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Delete an address
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_direccion = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_direccion);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Read all addresses by person ID
    // Read all addresses by person ID
     public function readByPersona($id_persona) {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id_persona = ?";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $id_persona);
    $stmt->execute();
    
    return $stmt;
}
}
?>
