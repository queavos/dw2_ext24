<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Facultades.php';

$database = new Database();
$db = $database->connect();

$facultades = new Facultades($db);
$result = $facultades->obtenerFacultades();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Facultades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Facultades</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Código Facultad</th>
            <th>Nombre Facultad</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['facu_code']; ?></td>
            <td><?php echo $row['facu_name']; ?></td>
            <td>
                <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="crear.php" class="btn btn-primary">Crear Nueva Facultad</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
