<?php
class Facultades {
    private $conn;
    private $table = 'facultades';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una nueva facultad
    public function crearFacultad($facu_code, $facu_name) {
        // Insertar una nueva facultad con la fecha y hora de creación
        $query = "INSERT INTO " . $this->table . " (facu_code, facu_name, created_date_time) VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $facu_code, $facu_name); // Vincula los parámetros al statement
        return $stmt->execute(); // Ejecuta la consulta
    }

    // Método para obtener todas las facultades
    public function obtenerFacultades() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result; // Devuelve el resultado de la consulta
    }

    // Método para obtener una facultad por ID
    public function obtenerFacultadPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); // Vincula el ID al statement
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Devuelve la facultad como un array asociativo
    }

    // Método para actualizar una facultad
    public function actualizarFacultad($id, $facu_code, $facu_name) {
        // Actualizar una facultad con la fecha y hora de la última modificación
        $query = "UPDATE " . $this->table . " SET facu_code = ?, facu_name = ?, updated_date_time = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $facu_code, $facu_name, $id); // Vincula los parámetros al statement
        return $stmt->execute(); // Ejecuta la consulta
    }

    // Método para eliminar una facultad
    public function eliminarFacultad($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); // Vincula el ID al statement
        return $stmt->execute(); // Ejecuta la consulta
    }
}
?>
