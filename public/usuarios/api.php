<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Usuarios.php';
 

header('Content-Type: application/json');

$database = new Database();
$db = $database->connect();

$usuarios = new Usuarios($db);
$response = [
    'rows' => 0,
    'data' => [],
    'msg' => '',
    'status' => 'FAIL'
];

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $action = $_GET['action'] ?? '';
        if ($action == 'list') {
            $data = $usuarios->obtenerUsuarios();
            $usuarios_array = [];
            while ($row = $data->fetch_assoc()) {
                $usuarios_array[] = $row;
            }
            $response['rows'] = count($usuarios_array);
            $response['data'] = $usuarios_array;
            $response['msg'] = 'Listado de usuarios';
            $response['status'] = 'OK';
        } elseif ($action == 'get' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $data = $usuarios->obtenerUsuarioPorId($id);
            if ($data) {
                $response['rows'] = 1;
                $response['data'] = [$data];
                $response['msg'] = 'Usuario obtenido';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Usuario no encontrado';
            }
        } elseif ($action == 'del' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if ($usuarios->eliminarUsuario($id)) {
                $response['msg'] = 'Usuario eliminado';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al eliminar el usuario';
            }
        } else {
            $response['msg'] = 'Acción no válida';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_GET['action'] ?? '';
        $data = json_decode(file_get_contents('php://input'), true);

        if ($action == 'new') {
            if ($usuarios->crearUsuario($data['username'], $data['password'], $data['user_nombre'], $data['user_mail'], $data['roles'])) {
                $new_data = $usuarios->obtenerUsuarioPorId($db->insert_id);
                $response['rows'] = 1;
                $response['data'] = [$new_data];
                $response['msg'] = 'Usuario agregado';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al agregar el usuario';
            }
        } elseif ($action == 'update') {
            if ($usuarios->actualizarUsuario($data['id'], $data['username'], $data['user_nombre'], $data['user_mail'], $data['roles'])) {
                $updated_data = $usuarios->obtenerUsuarioPorId($data['id']);
                $response['rows'] = 1;
                $response['data'] = [$updated_data];
                $response['msg'] = 'Usuario actualizado';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al actualizar el usuario';
            }
        } elseif ($action == 'change_password') {
            if ($usuarios->cambiarContrasena($data['id'], $data['new_password'])) {
                $response['msg'] = 'Contraseña cambiada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al cambiar la contraseña';
            }
        } elseif ($action == 'login') {
            $user = $usuarios->login($data['username'], $data['password']);
            if ($user) {
                $response['rows'] = 1;
                $response['data'] = [$user];
                $response['msg'] = 'Login exitoso';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Usuario o contraseña incorrectos';
            }
        } else {
            $response['msg'] = 'Acción no válida';
        }
    } else {
        $response['msg'] = 'Método no permitido';
    }
} catch (Exception $e) {
    $response['msg'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?>
