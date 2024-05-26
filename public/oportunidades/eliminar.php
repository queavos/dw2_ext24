<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Oportunidades.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->connect();

    $oportunidades = new Oportunidades($db);
    $oportunidades->eliminarOportunidad($id);

    header('Location: index.php');
}
?>
