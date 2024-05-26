<?php
class Materias {
    private $conn;
    private $table = 'materias';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una nueva materia con validación de datos
    public function crearMateria($mate_code, $mate_name, $mate_anho, $carre_id, $doce_id) {
        // Validar los datos
        if (empty($mate_code) || empty($mate_name) || empty($mate_anho) || empty($carre_id) || empty($doce_id)) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        // Insertar una nueva materia con la fecha y hora de creación
        $query = "INSERT INTO " . $this->table . " (mate_code, mate_name, mate_anho, carre_id, doce_id, created_date_time) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("ssiii", $mate_code, $mate_name, $mate_anho, $carre_id, $doce_id); // Vincula los parámetros al statement
        
        if ($stmt->execute() === false) { // Verificar si la ejecución de la declaración fue exitosa
            throw new Exception('Error al ejecutar la declaración: ' . $stmt->error);
        }

        return true; // Devuelve true si la ejecución fue exitosa
    }

    // Método para obtener todas las materias con la sigla de la carrera y el nombre completo del docente
    public function obtenerMaterias() {
        $query = "SELECT m.id, m.mate_code, m.mate_name, m.mate_anho, c.carre_sigla, CONCAT(d.doce_apellido, ' ', d.doce_nombre) AS docente 
                  FROM " . $this->table . " m 
                  JOIN carreras c ON m.carre_id = c.id 
                  JOIN docentes d ON m.doce_id = d.id";
        $result = $this->conn->query($query);

        // Verificar si la consulta fue exitosa
        if ($result === false) {
            throw new Exception('Error en la consulta: ' . $this->conn->error);
        }

        return $result; // Devuelve el resultado de la consulta
    }

    // Método para obtener una materia por ID
    public function obtenerMateriaPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("i", $id); // Vincula el ID al statement
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Devuelve la materia como un array asociativo
    }

    // Método para actualizar una materia con validación de datos
    public function actualizarMateria($id, $mate_code, $mate_name, $mate_anho, $carre_id, $doce_id) {
        // Validar los datos
        if (empty($mate_code) || empty($mate_name) || empty($mate_anho) || empty($carre_id) || empty($doce_id)) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        // Actualizar una materia con la fecha y hora de la última modificación
        $query = "UPDATE " . $this->table . " SET mate_code = ?, mate_name = ?, mate_anho = ?, carre_id = ?, doce_id = ?, updated_date_time = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("ssiiii", $mate_code, $mate_name, $mate_anho, $carre_id, $doce_id, $id); // Vincula los parámetros al statement
        
        if ($stmt->execute() === false) { // Verificar si la ejecución de la declaración fue exitosa
            throw new Exception('Error al ejecutar la declaración: ' . $stmt->error);
        }

        return true; // Devuelve true si la ejecución fue exitosa
    }

    // Método para eliminar una materia
    public function eliminarMateria($id) {
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
