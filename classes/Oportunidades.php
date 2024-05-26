<?php
class Oportunidades {
    private $conn;
    private $table = 'oportunidades';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una nueva oportunidad
    public function crearOportunidad($opor_code, $opor_name) {
        // Insertar una nueva oportunidad con la fecha y hora de creación
        $query = "INSERT INTO " . $this->table . " (opor_code, opor_name, created_date_time) VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $opor_code, $opor_name); // Vincula el código y el nombre de la oportunidad al statement
        return $stmt->execute(); // Ejecuta la consulta
    }

    // Método para obtener todas las oportunidades
    public function obtenerOportunidades() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result; // Devuelve el resultado de la consulta
    }

    // Método para obtener una oportunidad por ID
    public function obtenerOportunidadPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); // Vincula el ID al statement
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Devuelve la oportunidad como un array asociativo
    }

    // Método para actualizar una oportunidad
    public function actualizarOportunidad($id, $opor_code, $opor_name) {
        // Actualizar una oportunidad con la fecha y hora de la última modificación
        $query = "UPDATE " . $this->table . " SET opor_code = ?, opor_name = ?, updated_date_time = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $opor_code, $opor_name, $id); // Vincula el código, el nombre y el ID al statement
        return $stmt->execute(); // Ejecuta la consulta
    }

    // Método para eliminar una oportunidad
    public function eliminarOportunidad($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); // Vincula el ID al statement
        return $stmt->execute(); // Ejecuta la consulta
    }
}
?>
