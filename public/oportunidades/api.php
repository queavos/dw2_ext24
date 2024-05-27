<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Oportunidades.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->connect();

$oportunidades = new Oportunidades($db);
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
            $data = $oportunidades->obtenerOportunidades();
            $oportunidades_array = [];
            while ($row = $data->fetch_assoc()) {
                $oportunidades_array[] = $row;
            }
            $response['rows'] = count($oportunidades_array);
            $response['data'] = $oportunidades_array;
            $response['msg'] = 'Listado de oportunidades';
            $response['status'] = 'OK';
        } elseif ($action == 'get' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $data = $oportunidades->obtenerOportunidadPorId($id);
            if ($data) {
                $response['rows'] = 1;
                $response['data'] = [$data];
                $response['msg'] = 'Oportunidad obtenida';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Oportunidad no encontrada';
            }
        } elseif ($action == 'del' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if ($oportunidades->eliminarOportunidad($id)) {
                $response['msg'] = 'Oportunidad eliminada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al eliminar la oportunidad';
            }
        } else {
            $response['msg'] = 'Acción no válida';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_GET['action'] ?? '';
        $data = json_decode(file_get_contents('php://input'), true);

        if ($action == 'new') {
            if ($oportunidades->crearOportunidad($data['opor_code'], $data['opor_name'])) {
                $new_data = $oportunidades->obtenerOportunidadPorId($db->insert_id);
                $response['rows'] = 1;
                $response['data'] = [$new_data];
                $response['msg'] = 'Oportunidad agregada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al agregar la oportunidad';
            }
        } elseif ($action == 'update') {
            if ($oportunidades->actualizarOportunidad($data['id'], $data['opor_code'], $data['opor_name'])) {
                $updated_data = $oportunidades->obtenerOportunidadPorId($data['id']);
                $response['rows'] = 1;
                $response['data'] = [$updated_data];
                $response['msg'] = 'Oportunidad actualizada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al actualizar la oportunidad';
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
