<?php
class Profesores {
    private $conn;
    private $table = 'docentes';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un nuevo profesor con validación de datos
    public function crearProfesor($doce_nombre, $doce_apellido, $doce_mail, $doce_cumple, $doce_cel) {
        // Validar los datos
        if (empty($doce_nombre) || empty($doce_apellido) || empty($doce_mail) || empty($doce_cumple) || empty($doce_cel)) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        if (!filter_var($doce_mail, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El correo electrónico no es válido.');
        }

        // Insertar un nuevo profesor con la fecha y hora de creación
        $query = "INSERT INTO " . $this->table . " (doce_nombre, doce_apellido, doce_mail, doce_cumple, doce_cel, created_date_time) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("sssss", $doce_nombre, $doce_apellido, $doce_mail, $doce_cumple, $doce_cel); // Vincula los parámetros al statement
        return $stmt->execute(); // Ejecuta la consulta
    }

    // Método para obtener todos los profesores
    public function obtenerProfesores() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result; // Devuelve el resultado de la consulta
    }

    // Método para obtener un profesor por ID
    public function obtenerProfesorPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("i", $id); // Vincula el ID al statement
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Devuelve el profesor como un array asociativo
    }

    // Método para actualizar un profesor con validación de datos
    public function actualizarProfesor($id, $doce_nombre, $doce_apellido, $doce_mail, $doce_cumple, $doce_cel) {
        // Validar los datos
        if (empty($doce_nombre) || empty($doce_apellido) || empty($doce_mail) || empty($doce_cumple) || empty($doce_cel)) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        if (!filter_var($doce_mail, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El correo electrónico no es válido.');
        }

        // Actualizar un profesor con la fecha y hora de la última modificación
        $query = "UPDATE " . $this->table . " SET doce_nombre = ?, doce_apellido = ?, doce_mail = ?, doce_cumple = ?, doce_cel = ?, updated_date_time = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("sssssi", $doce_nombre, $doce_apellido, $doce_mail, $doce_cumple, $doce_cel, $id); // Vincula los parámetros al statement
        return $stmt->execute(); // Ejecuta la consulta
    }

    // Método para eliminar un profesor
    public function eliminarProfesor($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("i", $id); // Vincula el ID al statement
        return $stmt->execute(); // Ejecuta la consulta
    }
}
?>
