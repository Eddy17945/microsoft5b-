<?php
// AndreinaC18 - Andreina Crespo actualizó la clase Persona
class Persona {
    private $conn;
    private $table_name = "persona";
    
    public $id_persona;
    public $nombre;
    public $apellido;
    public $fecha_nacimiento;
    public $id_sexo;
    public $id_estadocivil;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Read all persons
    public function readAll() {
        $query = "SELECT p.id_persona, p.nombre, p.apellido, p.fecha_nacimiento, 
                  s.descripcion as sexo_descripcion, ec.descripcion as estadocivil_descripcion
                  FROM " . $this->table_name . " p
                  LEFT JOIN sexo s ON p.id_sexo = s.id_sexo
                  LEFT JOIN estadocivil ec ON p.id_estadocivil = ec.id_estadocivil
                  ORDER BY p.id_persona DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Read one person
    public function readOne() {
        $query = "SELECT p.id_persona, p.nombre, p.apellido, p.fecha_nacimiento, 
                  p.id_sexo, p.id_estadocivil, s.descripcion as sexo, ec.descripcion as estado_civil
                  FROM " . $this->table_name . " p
                  LEFT JOIN sexo s ON p.id_sexo = s.id_sexo
                  LEFT JOIN estadocivil ec ON p.id_estadocivil = ec.id_estadocivil
                  WHERE p.id_persona = ?
                  LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_persona);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->nombre = $row['nombre'];
            $this->apellido = $row['apellido'];
            $this->fecha_nacimiento = $row['fecha_nacimiento'];
            $this->id_sexo = $row['id_sexo'];
            $this->id_estadocivil = $row['id_estadocivil'];
            return true;
        }
        
        return false;
    }
    
    // Create a new person
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET nombre=:nombre, apellido=:apellido, fecha_nacimiento=:fecha_nacimiento, 
                    id_sexo=:id_sexo, id_estadocivil=:id_estadocivil";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->fecha_nacimiento = htmlspecialchars(strip_tags($this->fecha_nacimiento));
        $this->id_sexo = htmlspecialchars(strip_tags($this->id_sexo));
        $this->id_estadocivil = htmlspecialchars(strip_tags($this->id_estadocivil));
        
        // Bind values
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":fecha_nacimiento", $this->fecha_nacimiento);
        $stmt->bindParam(":id_sexo", $this->id_sexo);
        $stmt->bindParam(":id_estadocivil", $this->id_estadocivil);
        
        if($stmt->execute()) {
            $this->id_persona = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }
    
    // Update a person
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET nombre=:nombre, apellido=:apellido, fecha_nacimiento=:fecha_nacimiento, 
                    id_sexo=:id_sexo, id_estadocivil=:id_estadocivil
                WHERE id_persona=:id_persona";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->fecha_nacimiento = htmlspecialchars(strip_tags($this->fecha_nacimiento));
        $this->id_sexo = htmlspecialchars(strip_tags($this->id_sexo));
        $this->id_estadocivil = htmlspecialchars(strip_tags($this->id_estadocivil));
        $this->id_persona = htmlspecialchars(strip_tags($this->id_persona));
        
        // Bind values
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":fecha_nacimiento", $this->fecha_nacimiento);
        $stmt->bindParam(":id_sexo", $this->id_sexo);
        $stmt->bindParam(":id_estadocivil", $this->id_estadocivil);
        $stmt->bindParam(":id_persona", $this->id_persona);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Delete a person
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_persona = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_persona);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>
