<?php
class Roles {
    private $conn;
    private $table = 'roles';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un nuevo rol
    public function crearRol($rol_name) {
        $query = "INSERT INTO " . $this->table . " (rol_name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $rol_name); // Vincula el nombre del rol al statement
        return $stmt->execute(); // Ejecuta la consulta
    }

    // Método para obtener todos los roles
    public function obtenerRoles() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result; // Devuelve el resultado de la consulta
    }

    // Método para obtener un rol por ID
    public function obtenerRolPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); // Vincula el ID al statement
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Devuelve el rol como un array asociativo
    }

    // Método para actualizar un rol
    public function actualizarRol($id, $rol_name) {
        $query = "UPDATE " . $this->table . " SET rol_name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $rol_name, $id); // Vincula el nombre del rol y el ID al statement
        return $stmt->execute(); // Ejecuta la consulta
    }

    // Método para eliminar un rol
    public function eliminarRol($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); // Vincula el ID al statement
        return $stmt->execute(); // Ejecuta la consulta
    }
}
?>
