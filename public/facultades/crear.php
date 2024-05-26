<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Facultades.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $facu_code = $_POST['facu_code'];
    $facu_name = $_POST['facu_name'];

    $database = new Database();
    $db = $database->connect();

    $facultades = new Facultades($db);
    $facultades->crearFacultad($facu_code, $facu_name);

    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Facultad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Crear Nueva Facultad</h1>
    <form action="crear.php" method="post">
        <div class="mb-3">
            <label for="facu_code" class="form-label">Código de la Facultad:</label>
            <input type="text" name="facu_code" id="facu_code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="facu_name" class="form-label">Nombre de la Facultad:</label>
            <input type="text" name="facu_name" id="facu_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
