<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Profesores.php';
require_once '../../config/config.php';
restrictAccess(['Administrador', 'Secretario']);
$database = new Database();
$db = $database->connect();

$profesores = new Profesores($db);
$result = $profesores->obtenerProfesores();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Profesores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Profesores</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Fecha de Cumpleaños</th>
            <th>Celular</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['doce_nombre']; ?></td>
            <td><?php echo $row['doce_apellido']; ?></td>
            <td><?php echo $row['doce_mail']; ?></td>
            <td><?php echo $row['doce_cumple']; ?></td>
            <td><?php echo $row['doce_cel']; ?></td>
            <td>
                <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="crear.php" class="btn btn-primary">Crear Nuevo Profesor</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
