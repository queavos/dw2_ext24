<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Roles.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->connect();

    $roles = new Roles($db);
    $roles->eliminarRol($id);

    header('Location: index.php');
}
?>
