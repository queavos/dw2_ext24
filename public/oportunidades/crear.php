<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Oportunidades.php';
require_once '../../config/config.php';
restrictAccess(['Administrador']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $opor_code = $_POST['opor_code'];
    $opor_name = $_POST['opor_name'];

    $database = new Database();
    $db = $database->connect();

    $oportunidades = new Oportunidades($db);
    $oportunidades->crearOportunidad($opor_code, $opor_name);

    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Oportunidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Crear Nueva Oportunidad</h1>
    <form action="crear.php" method="post">
        <div class="mb-3">
            <label for="opor_code" class="form-label">Código de la Oportunidad:</label>
            <input type="text" name="opor_code" id="opor_code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="opor_name" class="form-label">Nombre de la Oportunidad:</label>
            <input type="text" name="opor_name" id="opor_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
