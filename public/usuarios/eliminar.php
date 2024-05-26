<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Usuarios.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->connect();

    $usuarios = new Usuarios($db);
    $usuarios->eliminarUsuario($id);

    header('Location: index.php');
}
?>
