<?php
class Carreras {
    private $conn;
    private $table = 'carreras';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una nueva carrera con validación de datos
    public function crearCarrera($carre_sigla, $carre_nombre, $facu_id) {
        // Validar los datos
        if (empty($carre_sigla) || empty($carre_nombre) || empty($facu_id)) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        // Insertar una nueva carrera con la fecha y hora de creación
        $query = "INSERT INTO " . $this->table . " (carre_sigla, carre_nombre, facu_id, created_date_time) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("ssi", $carre_sigla, $carre_nombre, $facu_id); // Vincula los parámetros al statement
        
        if ($stmt->execute() === false) { // Verificar si la ejecución de la declaración fue exitosa
            throw new Exception('Error al ejecutar la declaración: ' . $stmt->error);
        }

        return true; // Devuelve true si la ejecución fue exitosa
    }

    // Método para obtener todas las carreras con el código de la facultad
    public function obtenerCarreras() {
        $query = "SELECT c.id, c.carre_sigla, c.carre_nombre,c.facu_id, f.facu_code 
                  FROM " . $this->table . " c 
                  JOIN facultades f ON c.facu_id = f.id";
        $result = $this->conn->query($query);

        // Verificar si la consulta fue exitosa
        if ($result === false) {
            throw new Exception('Error en la consulta: ' . $this->conn->error);
        }

        return $result; // Devuelve el resultado de la consulta
    }

    // Método para obtener una carrera por ID
    public function obtenerCarreraPorId($id) {
        $query = "SELECT c.*, f.facu_code FROM " . $this->table . " c JOIN facultades f ON c.facu_id = f.id  WHERE c.id = ?";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("i", $id); // Vincula el ID al statement
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Devuelve la carrera como un array asociativo
    }

    // Método para actualizar una carrera con validación de datos
    public function actualizarCarrera($id, $carre_sigla, $carre_nombre, $facu_id) {
        // Validar los datos
        if (empty($carre_sigla) || empty($carre_nombre) || empty($facu_id)) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        // Actualizar una carrera con la fecha y hora de la última modificación
        $query = "UPDATE " . $this->table . " SET carre_sigla = ?, carre_nombre = ?, facu_id = ?, updated_date_time = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("ssii", $carre_sigla, $carre_nombre, $facu_id, $id); // Vincula los parámetros al statement
        
        if ($stmt->execute() === false) { // Verificar si la ejecución de la declaración fue exitosa
            throw new Exception('Error al ejecutar la declaración: ' . $stmt->error);
        }

        return true; // Devuelve true si la ejecución fue exitosa
    }

    // Método para eliminar una carrera
    public function eliminarCarrera($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("i", $id); // Vincula el ID al statement
        
        if ($stmt->execute() === false) { // Verificar si la ejecución de la declaración fue exitosa
            throw new Exception('Error al ejecutar la declaración: ' . $stmt->error);
        }

        return true; // Devuelve true si la ejecución fue exitosa
    }
}
?>
