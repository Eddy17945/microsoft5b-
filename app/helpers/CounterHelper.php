<?php
// Archivo: app/helpers/CounterHelper.php

class CounterHelper {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Obtiene el número de registros de una tabla
     * @param string $table Nombre de la tabla
     * @return int Número de registros
     */
    public function countRecords($table) {
        try {
            // Verificar qué tablas existen en la base de datos
            $tables = $this->listTables();
            
            // Si la tabla no existe con ese nombre exacto, buscar similares
            if (!in_array($table, $tables)) {
                // Intentar con versión singular/plural
                $singular = rtrim($table, 's');
                $plural = $singular . 's';
                
                if (in_array($singular, $tables)) {
                    $table = $singular;
                } elseif (in_array($plural, $tables)) {
                    $table = $plural;
                }
            }
            
            // Ejecutar la consulta de conteo
            $sql = "SELECT COUNT(*) as total FROM $table";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Registrar para depuración
            error_log("Contando registros de tabla '$table': " . $result['total']);
            
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Error al contar registros de '$table': " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Obtiene una lista de todas las tablas en la base de datos
     * @return array Lista de nombres de tablas
     */
    public function listTables() {
        try {
            // Consulta para obtener todas las tablas (compatible con MySQL)
            $sql = "SHOW TABLES";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $tables = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                $tables[] = $row[0];
            }
            
            // Registrar para depuración
            error_log("Tablas encontradas: " . implode(", ", $tables));
            
            return $tables;
        } catch (PDOException $e) {
            error_log("Error al listar tablas: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtiene estadísticas generales del sistema
     * @return array Arreglo con estadísticas
     */
    public function getStats() {
        // Posibles nombres de tablas para cada categoría
        $posibleTables = [
            'personas' => ['personas', 'persona', 'contactos', 'contacto', 'users', 'usuarios', 'usuario'],
            'direcciones' => ['direcciones', 'direccion', 'addresses', 'address', 'domicilios', 'domicilio'],
            'telefonos' => ['telefonos', 'telefono', 'phones', 'phone', 'numeros', 'numero']
        ];
        
        $stats = [];
        
        // Obtener todas las tablas disponibles
        $tables = $this->listTables();
        
        // Para cada categoría, buscar la primera tabla que exista
        foreach ($posibleTables as $category => $tableOptions) {
            $found = false;
            foreach ($tableOptions as $table) {
                if (in_array($table, $tables)) {
                    $stats[$category] = $this->countRecords($table);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $stats[$category] = 0;
            }
        }
        
        return $stats;
    }
}