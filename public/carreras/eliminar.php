<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Carreras.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->connect();

    $carreras = new Carreras($db);
    $carreras->eliminarCarrera($id);

    header('Location: index.php');
}
?>
