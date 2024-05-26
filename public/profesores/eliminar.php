<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Profesores.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->connect();

    $profesores = new Profesores($db);
    $profesores->eliminarProfesor($id);

    header('Location: index.php');
}
?>
