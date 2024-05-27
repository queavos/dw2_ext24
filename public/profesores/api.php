<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Profesores.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->connect();

$docentes = new Profesores($db);
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
            $data = $docentes->obtenerProfesores();
            $docentes_array = [];
            while ($row = $data->fetch_assoc()) {
                $docentes_array[] = $row;
            }
            $response['rows'] = count($docentes_array);
            $response['data'] = $docentes_array;
            $response['msg'] = 'Listado de docentes';
            $response['status'] = 'OK';
        } elseif ($action == 'get' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $data = $docentes->obtenerProfesorPorId($id);
            if ($data) {
                $response['rows'] = 1;
                $response['data'] = [$data];
                $response['msg'] = 'Docente obtenido';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Docente no encontrado';
            }
        } elseif ($action == 'del' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if ($docentes->eliminarProfesor($id)) {
                $response['msg'] = 'Docente eliminado';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al eliminar el docente';
            }
        } else {
            $response['msg'] = 'Acción no válida';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_GET['action'] ?? '';
        $data = json_decode(file_get_contents('php://input'), true);

        if ($action == 'new') {
            if ($docentes->crearProfesor($data['doce_nombre'], $data['doce_apellido'], $data['doce_mail'], $data['doce_cumple'], $data['doce_cel'])) {
                $new_data = $docentes->obtenerDocentePorId($db->insert_id);
                $response['rows'] = 1;
                $response['data'] = [$new_data];
                $response['msg'] = 'Docente agregado';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al agregar el docente';
            }
        } elseif ($action == 'update') {
            if ($docentes->actualizarProfesor($data['id'], $data['doce_nombre'], $data['doce_apellido'], $data['doce_mail'], $data['doce_cumple'], $data['doce_cel'])) {
                $updated_data = $docentes->obtenerDocentePorId($data['id']);
                $response['rows'] = 1;
                $response['data'] = [$updated_data];
                $response['msg'] = 'Docente actualizado';
                $response['status'] = 'OK';
            } else {
                $response['msg'] = 'Error al actualizar el docente';
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
