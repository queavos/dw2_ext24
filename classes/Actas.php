<?php
class Actas {
    private $conn;
    private $table = 'actas';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una nueva acta con validación de datos y carga de archivos
    public function crearActa($acta_codi, $acta_fecha, $acta_archivo, $acta_recibido, $acta_planilla, $mate_id, $opor_id, $usr_id) {
        // Validar los datos
        if (empty($acta_codi) || empty($acta_fecha) || empty($acta_recibido) || empty($mate_id) || empty($opor_id) || empty($usr_id)) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        // Subir archivos y renombrar
        $acta_archivo_nombre = $this->subirArchivo($acta_archivo, $acta_codi . "_acta.pdf");
        $acta_planilla_nombre = $this->subirArchivo($acta_planilla, $acta_codi . "_planilla.pdf");

        // Construir la cadena de consulta SQL manualmente
        $sql = sprintf(
            "INSERT INTO %s (acta_codi, acta_fecha, acta_archivo, acta_recibido, acta_planilla, mate_id, opor_id, usr_id, created_date_time) VALUES ('%s', '%s', '%s', '%s', '%s', %d, %d, %d, NOW())",
            $this->table,
            $this->conn->real_escape_string($acta_codi),
            $this->conn->real_escape_string($acta_fecha),
            $this->conn->real_escape_string($acta_archivo_nombre),
            $this->conn->real_escape_string($acta_recibido),
            $this->conn->real_escape_string($acta_planilla_nombre),
            $mate_id,
            $opor_id,
            $usr_id
        );

        // Mostrar la consulta SQL generada para depuración
        // echo $sql;

        // Ejecutar la consulta SQL
        if ($this->conn->query($sql) === false) {
            throw new Exception('Error al ejecutar la consulta: ' . $this->conn->error);
        }

        return true; // Devuelve true si la ejecución fue exitosa
    }

    // Método para subir archivos
    private function subirArchivo($archivo, $nombre_nuevo) {
        $target_dir = "uploads/";
        
        // Verificar si el directorio de destino existe, si no, crearlo
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . basename($nombre_nuevo);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es un PDF
        if ($fileType != "pdf") {
            throw new Exception('Solo se permiten archivos PDF.');
        }

        // Intentar subir el archivo (sobrescribe si ya existe)
        if (move_uploaded_file($archivo["tmp_name"], $target_file)) {
            return $nombre_nuevo;
        } else {
            throw new Exception('Error al subir el archivo.');
        }
    }

    // Método para obtener todas las actas con los nombres de las materias, oportunidades y usuarios
    public function obtenerActas() {
        $query = "SELECT a.id, a.acta_codi, a.acta_fecha, a.acta_archivo, a.acta_recibido, a.acta_planilla,a.mate_id ,CONCAT(m.mate_code, ' - ', m.mate_name) AS materia,m.doce_id,CONCAT(d.doce_apellido, ' ', d.doce_nombre) AS docente ,a.opor_id ,o.opor_code,a.usr_id, u.user_nombre 
                  FROM " . $this->table . " a 
                  JOIN materias m ON a.mate_id = m.id 
                  JOIN oportunidades o ON a.opor_id = o.id 
                  JOIN usuarios u ON a.usr_id = u.id 
                  JOIN docentes d ON m.doce_id= d.id ";
        $result = $this->conn->query($query);

        // Verificar si la consulta fue exitosa
        if ($result === false) {
            throw new Exception('Error en la consulta: ' . $this->conn->error);
        }

        return $result; // Devuelve el resultado de la consulta
    }

    // Método para obtener una acta por ID
    public function obtenerActaPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la declaración fue exitosa
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param("i", $id); // Vincula el ID al statement
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Devuelve la acta como un array asociativo
    }

    // Método para actualizar una acta con validación de datos y carga de archivos
    public function actualizarActa($id, $acta_codi, $acta_fecha, $acta_archivo, $acta_recibido, $acta_planilla, $mate_id, $opor_id, $usr_id) {
        // Validar los datos
        if (empty($acta_codi) || empty($acta_fecha) || empty($acta_recibido) || empty($mate_id) || empty($opor_id) || empty($usr_id)) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        // Obtener los nombres actuales de los archivos
        $acta = $this->obtenerActaPorId($id);
        $acta_archivo_actual = $acta['acta_archivo'];
        $acta_planilla_actual = $acta['acta_planilla'];

        // Subir archivos y renombrar si se han subido nuevos archivos
        $acta_archivo_nombre = $acta_archivo['error'] === UPLOAD_ERR_NO_FILE ? $acta_archivo_actual : $this->subirArchivo($acta_archivo, $acta_codi . "_acta.pdf");
        $acta_planilla_nombre = $acta_planilla['error'] === UPLOAD_ERR_NO_FILE ? $acta_planilla_actual : $this->subirArchivo($acta_planilla, $acta_codi . "_planilla.pdf");

        // Construir la cadena de consulta SQL manualmente
        $sql = sprintf(
            "UPDATE %s SET acta_codi = '%s', acta_fecha = '%s', acta_archivo = '%s', acta_recibido = '%s', acta_planilla = '%s', mate_id = %d, opor_id = %d, usr_id = %d, updated_date_time = NOW() WHERE id = %d",
            $this->table,
            $this->conn->real_escape_string($acta_codi),
            $this->conn->real_escape_string($acta_fecha),
            $this->conn->real_escape_string($acta_archivo_nombre),
            $this->conn->real_escape_string($acta_recibido),
            $this->conn->real_escape_string($acta_planilla_nombre),
            $mate_id,
            $opor_id,
            $usr_id,
            $id
        );

        // Mostrar la consulta SQL generada para depuración
        // echo $sql;

        // Ejecutar la consulta SQL
        if ($this->conn->query($sql) === false) {
            throw new Exception('Error al ejecutar la consulta: ' . $this->conn->error);
        }

        return true; // Devuelve true si la ejecución fue exitosa
    }

    // Método para eliminar una acta
    public function eliminarActa($id) {
        // Obtener los nombres de los archivos antes de eliminar el registro
        $acta = $this->obtenerActaPorId($id);
        $acta_archivo = "uploads/" . $acta['acta_archivo'];
        $acta_planilla = "uploads/" . $acta['acta_planilla'];

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

        // Eliminar los archivos del servidor
        if (file_exists($acta_archivo)) {
            unlink($acta_archivo);
        }
        if (file_exists($acta_planilla)) {
            unlink($acta_planilla);
        }

        return true; // Devuelve true si la ejecución fue exitosa
    }
}
?>
