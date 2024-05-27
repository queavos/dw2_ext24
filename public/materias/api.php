<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Materias.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->connect();

$materias = new Materias($db);
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
            $data = $materias->obtenerMaterias();
            $materias_array = [];
            while ($row = $data->fetch_assoc()) {
                $materias_array[] = $row;
            }
            $response['rows'] = count($materias_array);
            $response['data'] = $materias_array;
            $response['msg'] = 'Listado de materias';
            $response['status'] = 'OK';
        } elseif ($action == 'get' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $data = $materias->obtenerMateriaPorId($id);
            if ($data) {
                $response['rows'] = 1;
                $response['data'] = [$data];
                $response['msg'] = 'Materia obtenida';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Materia no encontrada';
            }
        } elseif ($action == 'del' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if ($materias->eliminarMateria($id)) {
                $response['msg'] = 'Materia eliminada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al eliminar la materia';
            }
        } else {
            $response['msg'] = 'Acción no válida';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_GET['action'] ?? '';
        $data = json_decode(file_get_contents('php://input'), true);

        if ($action == 'new') {
            if ($materias->crearMateria($data['mate_code'], $data['mate_name'], $data['mate_anho'], $data['carre_id'], $data['doce_id'])) {
                $new_data = $materias->obtenerMateriaPorId($db->insert_id);
                $response['rows'] = 1;
                $response['data'] = [$new_data];
                $response['msg'] = 'Materia agregada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al agregar la materia';
            }
        } elseif ($action == 'update') {
            if ($materias->actualizarMateria($data['id'], $data['mate_code'], $data['mate_name'], $data['mate_anho'], $data['carre_id'], $data['doce_id'])) {
                $updated_data = $materias->obtenerMateriaPorId($data['id']);
                $response['rows'] = 1;
                $response['data'] = [$updated_data];
                $response['msg'] = 'Materia actualizada';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al actualizar la materia';
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
