<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Actas.php';

 
header('Content-Type: application/json');

$database = new Database();
$db = $database->connect();

$actas = new Actas($db);
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
            $data = $actas->obtenerActas();
            $actas_array = [];
            while ($row = $data->fetch_assoc()) {
                $row['acta_archivo'] = BASE_URL . $row['acta_archivo'];
                $row['acta_planilla'] = BASE_URL . $row['acta_planilla'];
                $actas_array[] = $row;
            }
            $response['rows'] = count($actas_array);
            $response['data'] = $actas_array;
            $response['msg'] = 'Listado de actas';
            $response['status'] = 'OK';
        } elseif ($action == 'get' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $data = $actas->obtenerActaPorId($id);
            if ($data) {
                $response['rows'] = 1;
                $response['data'] = [$data];
                $response['msg'] = 'Acta obtenida';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Acta no encontrada';
            }
        } elseif ($action == 'del' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if ($actas->eliminarActa($id)) {
                $response['msg'] = 'Acta eliminada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al eliminar la acta';
            }
        } else {
            $response['msg'] = 'Acción no válida';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_GET['action'] ?? '';
        $data = json_decode(file_get_contents('php://input'), true);

        if ($action == 'new') {
            $acta_archivo_nombre = $data['acta_codi'] . "_acta.pdf";
            $acta_planilla_nombre = $data['acta_codi'] . "_planilla.pdf";
            if ($actas->crearActa($data['acta_codi'], $data['acta_fecha'], $acta_archivo_nombre, $data['acta_recibido'], $acta_planilla_nombre, $data['mate_id'], $data['opor_id'], $data['usr_id'])) {
                $new_data = $actas->obtenerActaPorId($db->insert_id);
                $new_data['acta_archivo'] = BASE_URL . $new_data['acta_archivo'];
                $new_data['acta_planilla'] = BASE_URL . $new_data['acta_planilla'];
                $response['rows'] = 1;
                $response['data'] = [$new_data];
                $response['msg'] = 'Acta agregada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al agregar la acta';
            }
        } elseif ($action == 'update') {
            $acta_archivo_nombre = $data['acta_codi'] . "_acta.pdf";
            $acta_planilla_nombre = $data['acta_codi'] . "_planilla.pdf";
            if ($actas->actualizarActa($data['id'], $data['acta_codi'], $data['acta_fecha'], $acta_archivo_nombre, $data['acta_recibido'], $acta_planilla_nombre, $data['mate_id'], $data['opor_id'], $data['usr_id'])) {
                $updated_data = $actas->obtenerActaPorId($data['id']);
                $updated_data['acta_archivo'] = BASE_URL . $updated_data['acta_archivo'];
                $updated_data['acta_planilla'] = BASE_URL . $updated_data['acta_planilla'];
                $response['rows'] = 1;
                $response['data'] = [$updated_data];
                $response['msg'] = 'Acta actualizada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al actualizar la acta';
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
