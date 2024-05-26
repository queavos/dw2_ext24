<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Facultades.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->connect();

    $facultades = new Facultades($db);
    $facultades->eliminarFacultad($id);

    header('Location: index.php');
}
?>
