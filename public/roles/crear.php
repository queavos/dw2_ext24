<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Roles.php';
require_once '../../config/config.php';
restrictAccess(['Administrador']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rol_name = $_POST['rol_name'];

    $database = new Database();
    $db = $database->connect();

    $roles = new Roles($db);
    $roles->crearRol($rol_name);

    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Rol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Crear Nuevo Rol</h1>
    <form action="crear.php" method="post">
        <div class="mb-3">
            <label for="rol_name" class="form-label">Nombre del Rol:</label>
            <input type="text" name="rol_name" id="rol_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
