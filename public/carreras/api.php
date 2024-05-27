<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Carreras.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->connect();

$carreras = new Carreras($db);
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
            $data = $carreras->obtenerCarreras();
            $carreras_array = [];
            while ($row = $data->fetch_assoc()) {
                $carreras_array[] = $row;
            }
            $response['rows'] = count($carreras_array);
            $response['data'] = $carreras_array;
            $response['msg'] = 'Listado de carreras';
            $response['status'] = 'OK';
        } elseif ($action == 'get' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $data = $carreras->obtenerCarreraPorId($id);
            if ($data) {
                $response['rows'] = 1;
                $response['data'] = [$data];
                $response['msg'] = 'Carrera obtenida';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Carrera no encontrada';
            }
        } elseif ($action == 'del' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if ($carreras->eliminarCarrera($id)) {
                $response['msg'] = 'Carrera eliminada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al eliminar la carrera';
            }
        } else {
            $response['msg'] = 'Acción no válida';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_GET['action'] ?? '';
        $data = json_decode(file_get_contents('php://input'), true);

        if ($action == 'new') {
            if ($carreras->crearCarrera($data['carre_sigla'], $data['carre_nombre'], $data['facu_id'])) {
                $new_data = $carreras->obtenerCarreraPorId($db->insert_id);
                $response['rows'] = 1;
                $response['data'] = [$new_data];
                $response['msg'] = 'Carrera agregada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al agregar la carrera';
            }
        } elseif ($action == 'update') {
            if ($carreras->actualizarCarrera($data['id'], $data['carre_sigla'], $data['carre_nombre'], $data['facu_id'])) {
                $updated_data = $carreras->obtenerCarreraPorId($data['id']);
                $response['rows'] = 1;
                $response['data'] = [$updated_data];
                $response['msg'] = 'Carrera actualizada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al actualizar la carrera';
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
