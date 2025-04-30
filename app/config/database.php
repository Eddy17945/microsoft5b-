
<?php
class Database {
    private $host = "localhost"; // Localhost
    private $port = "3306";       // Puerto MySQL
    private $db_name = "microsoft5bx"; // Nombre de tu BD
    private $username = "microsoft5bx";   // Usuario
    private $password = "microsoft5bx"; // Tu contraseña
    private $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            // Cadena de conexión con puerto explícito
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES 'utf8mb4'"); // Para soportar emojis y caracteres especiales
            
            // Opcional: Verificar conexión (solo desarrollo)
            error_log("✅ Conexión exitosa a MySQL en 127.0.0.1:3306");
            
        } catch(PDOException $e) {
            // Log detallado del error
            error_log("❌ Error de conexión: " . $e->getMessage());
            die("Error al conectar con la base de datos. Revisa el archivo error_log.");
        }
        
        return $this->conn;
    }
}
?>
