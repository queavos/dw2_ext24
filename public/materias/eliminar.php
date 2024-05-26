<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Materias.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->connect();

    $materias = new Materias($db);
    try {
        $materias->eliminarMateria($id);
        header('Location: index.php');
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}
?>
