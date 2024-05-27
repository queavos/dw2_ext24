<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Roles.php';
require_once '../../config/config.php';
restrictAccess(['Administrador']);
$database = new Database();
$db = $database->connect();

$roles = new Roles($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $rol_name = $_POST['rol_name'];
    $roles->actualizarRol($id, $rol_name);
    header('Location: index.php');
} else {
    $id = $_GET['id'];
    $rol = $roles->obtenerRolPorId($id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Rol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Editar Rol</h1>
    <form action="editar.php" method="post">
        <input type="hidden" name="id" value="<?php echo $rol['id']; ?>">
        <div class="mb-3">
            <label for="rol_name" class="form-label">Nombre del Rol:</label>
            <input type="text" name="rol_name" id="rol_name" class="form-control" value="<?php echo $rol['rol_name']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
