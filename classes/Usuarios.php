<?php
class Usuarios {
    private $conn;
    private $table = 'usuarios';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un nuevo usuario
    public function crearUsuario($user_nombre, $user_mail, $username, $password, $roles) {
        // Iniciar una transacción para asegurar la atomicidad
        $this->conn->begin_transaction();

        try {
            // Insertar el nuevo usuario en la tabla de usuarios
            $query = "INSERT INTO " . $this->table . " (user_nombre, user_mail, username, password) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $hashed_password = sha1($password); // Encriptar la contraseña con SHA-1
            $stmt->bind_param("ssss", $user_nombre, $user_mail, $username, $hashed_password);
            $stmt->execute();
            $user_id = $stmt->insert_id; // Obtener el ID del usuario recién creado

            // Insertar roles del usuario en la tabla usr_roles
            $query = "INSERT INTO usr_roles (usr_id, rol_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);
            foreach ($roles as $rol_id) {
                $stmt->bind_param("ii", $user_id, $rol_id);
                $stmt->execute();
            }

            // Confirmar la transacción
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conn->rollback();
            return false;
        }
    }

    // Método para obtener todos los usuarios
    public function obtenerUsuarios() {
        $query = "SELECT u.id, u.user_nombre, u.user_mail, u.username, GROUP_CONCAT(r.rol_name SEPARATOR ', ') AS roles
                  FROM " . $this->table . " u
                  LEFT JOIN usr_roles ur ON u.id = ur.usr_id
                  LEFT JOIN roles r ON ur.rol_id = r.id
                  GROUP BY u.id";
        $result = $this->conn->query($query);
        return $result;
    }

    // Método para obtener un usuario por ID
    public function obtenerUsuarioPorId($id) {
        // Obtener datos del usuario
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();

        // Obtener roles del usuario
        $query = "SELECT rol_id FROM usr_roles WHERE usr_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $roles = [];
        while ($row = $result->fetch_assoc()) {
            $roles[] = $row['rol_id'];
        }
        $usuario['roles'] = $roles;

        return $usuario;
    }

    // Método para actualizar un usuario
    public function actualizarUsuario($id, $user_nombre, $user_mail, $username, $roles) {
        // Iniciar una transacción para asegurar la atomicidad
        $this->conn->begin_transaction();

        try {
            // Actualizar el usuario en la tabla de usuarios
            $query = "UPDATE " . $this->table . " SET user_nombre = ?, user_mail = ?, username = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssi", $user_nombre, $user_mail, $username, $id);
            $stmt->execute();

            // Eliminar roles actuales del usuario
            $query = "DELETE FROM usr_roles WHERE usr_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // Insertar nuevos roles del usuario
            $query = "INSERT INTO usr_roles (usr_id, rol_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);
            foreach ($roles as $rol_id) {
                $stmt->bind_param("ii", $id, $rol_id);
                $stmt->execute();
            }

            // Confirmar la transacción
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conn->rollback();
            return false;
        }
    }

    // Método para eliminar un usuario
    public function eliminarUsuario($id) {
        // Iniciar una transacción para asegurar la atomicidad
        $this->conn->begin_transaction();

        try {
            // Eliminar roles del usuario
            $query = "DELETE FROM usr_roles WHERE usr_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // Eliminar el usuario
            $query = "DELETE FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // Confirmar la transacción
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conn->rollback();
            return false;
        }
    }
    /* LOGIN */

    public function login($username, $password) {
        $query = "SELECT u.id, u.username, u.user_nombre, r.rol_name as role
                  FROM " . $this->table . " u
                  JOIN usr_roles ur ON u.id = ur.usr_id
                  JOIN roles r ON ur.rol_id = r.id
                  WHERE u.username = ? AND u.password = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración: ' . $this->conn->error);
        }

        $stmt->bind_param('ss', $username, $password);

        if ($stmt->execute() === false) {
            throw new Exception('Error al ejecutar la declaración: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /* FIN LOGIN*/
}
?>

