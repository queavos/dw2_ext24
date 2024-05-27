<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Profesores.php';
require_once '../../config/config.php';
restrictAccess(['Administrador', 'Secretario']);
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doce_nombre = $_POST['doce_nombre'];
    $doce_apellido = $_POST['doce_apellido'];
    $doce_mail = $_POST['doce_mail'];
    $doce_cumple = $_POST['doce_cumple'];
    $doce_cel = $_POST['doce_cel'];

    $database = new Database();
    $db = $database->connect();

    $profesores = new Profesores($db);

    try {
        $resultado = $profesores->crearProfesor($doce_nombre, $doce_apellido, $doce_mail, $doce_cumple, $doce_cel);
        if ($resultado) {
            header('Location: index.php');
        } else {
            $error = 'Error al crear el profesor.';
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Crear Nuevo Profesor</h1>
    <?php if ($error): ?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>
    <form action="crear.php" method="post">
        <div class="mb-3">
            <label for="doce_nombre" class="form-label">Nombre del Profesor:</label>
            <input type="text" name="doce_nombre" id="doce_nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="doce_apellido" class="form-label">Apellido del Profesor:</label>
            <input type="text" name="doce_apellido" id="doce_apellido" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="doce_mail" class="form-label">Email del Profesor:</label>
            <input type="email" name="doce_mail" id="doce_mail" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="doce_cumple" class="form-label">Fecha de Cumpleaños:</label>
            <input type="date" name="doce_cumple" id="doce_cumple" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="doce_cel" class="form-label">Celular del Profesor:</label>
            <input type="text" name="doce_cel" id="doce_cel" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
