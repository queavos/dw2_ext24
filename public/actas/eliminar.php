<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Actas.php';
require_once '../../config/config.php';
restrictAccess(['Administrador', 'Secretario']);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->connect();

    $actas = new Actas($db);
    try {
        $actas->eliminarActa($id);
        header('Location: index.php');
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}
?>
