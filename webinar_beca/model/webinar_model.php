<?php
include 'db_config.php';

class WebinarModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function insertData($table, $data) {
        // Obtener los nombres de los campos y los valores
        $fields = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        
        // Escapar los valores para evitar inyección SQL
        foreach ($data as $key => $value) {
            $data[$key] = $this->conn->real_escape_string($value);
        }
        
        // Construir y ejecutar la consulta SQL
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>