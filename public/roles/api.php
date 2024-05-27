<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Roles.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->connect();

$roles = new Roles($db);
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
            $data = $roles->obtenerRoles();
            $roles_array = [];
            while ($row = $data->fetch_assoc()) {
                $roles_array[] = $row;
            }
            $response['rows'] = count($roles_array);
            $response['data'] = $roles_array;
            $response['msg'] = 'Listado de roles';
            $response['status'] = 'OK';
        } elseif ($action == 'get' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $data = $roles->obtenerRolPorId($id);
            if ($data) {
                $response['rows'] = 1;
                $response['data'] = [$data];
                $response['msg'] = 'Rol obtenido';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Rol no encontrado';
            }
        } elseif ($action == 'del' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if ($roles->eliminarRol($id)) {
                $response['msg'] = 'Rol eliminado';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al eliminar el rol';
            }
        } else {
            $response['msg'] = 'Acción no válida';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_GET['action'] ?? '';
        $data = json_decode(file_get_contents('php://input'), true);

        if ($action == 'new') {
            if ($roles->crearRol($data['rol_name'])) {
                $new_data = $roles->obtenerRolPorId($db->insert_id);
                $response['rows'] = 1;
                $response['data'] = [$new_data];
                $response['msg'] = 'Rol agregado';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al agregar el rol';
            }
        } elseif ($action == 'update') {
            if ($roles->actualizarRol($data['id'], $data['rol_name'])) {
                $updated_data = $roles->obtenerRolPorId($data['id']);
                $response['rows'] = 1;
                $response['data'] = [$updated_data];
                $response['msg'] = 'Rol actualizado';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al actualizar el rol';
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
