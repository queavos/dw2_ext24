<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Facultades.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->connect();

$facultades = new Facultades($db);
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
            $data = $facultades->obtenerFacultades();
            $facultades_array = [];
            while ($row = $data->fetch_assoc()) {
                $facultades_array[] = $row;
            }
            $response['rows'] = count($facultades_array);
            $response['data'] = $facultades_array;
            $response['msg'] = 'Listado de facultades';
            $response['status'] = 'OK';
        } elseif ($action == 'get' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $data = $facultades->obtenerFacultadPorId($id);
            if ($data) {
                $response['rows'] = 1;
                $response['data'] = [$data];
                $response['msg'] = 'Facultad obtenida';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Facultad no encontrada';
            }
        } elseif ($action == 'del' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if ($facultades->eliminarFacultad($id)) {
                $response['msg'] = 'Facultad eliminada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al eliminar la facultad';
            }
        } else {
            $response['msg'] = 'Acción no válida';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_GET['action'] ?? '';
        $data = json_decode(file_get_contents('php://input'), true);

        if ($action == 'new') {
            if ($facultades->crearFacultad($data['facu_code'], $data['facu_name'])) {
                $new_data = $facultades->obtenerFacultadPorId($db->insert_id);
                $response['rows'] = 1;
                $response['data'] = [$new_data];
                $response['msg'] = 'Facultad agregada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al agregar la facultad';
            }
        } elseif ($action == 'update') {
            if ($facultades->actualizarFacultad($data['id'], $data['facu_code'], $data['facu_name'])) {
                $updated_data = $facultades->obtenerFacultadPorId($data['id']);
                $response['rows'] = 1;
                $response['data'] = [$updated_data];
                $response['msg'] = 'Facultad actualizada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al actualizar la facultad';
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
