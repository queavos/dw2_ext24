<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Usuarios.php';
require_once '../../classes/Roles.php';
require_once '../../config/config.php';
restrictAccess(['Administrador']);
$database = new Database();
$db = $database->connect();

$usuarios = new Usuarios($db);
$roles = new Roles($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $user_nombre = $_POST['user_nombre'];
    $user_mail = $_POST['user_mail'];
    $username = $_POST['username'];
    $roles = $_POST['roles'];
    $usuarios->actualizarUsuario($id, $user_nombre, $user_mail, $username, $roles);
    header('Location: index.php');
} else {
    $id = $_GET['id'];
    $usuario = $usuarios->obtenerUsuarioPorId($id);
    $roles_result = $roles->obtenerRoles();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Editar Usuario</h1>
    <form action="editar.php" method="post">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
        <div class="mb-3">
            <label for="user_nombre" class="form-label">Nombre del Usuario:</label>
            <input type="text" name="user_nombre" id="user_nombre" class="form-control" value="<?php echo $usuario['user_nombre']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="user_mail" class="form-label">Email del Usuario:</label>
            <input type="email" name="user_mail" id="user_mail" class="form-control" value="<?php echo $usuario['user_mail']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo $usuario['username']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="roles" class="form-label">Roles:</label>
            <?php while ($row = $roles_result->fetch_assoc()): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="roles[]" id="role_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" <?php echo in_array($row['id'], $usuario['roles']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="role_<?php echo $row['id']; ?>"><?php echo $row['rol_name']; ?></label>
            </div>
            <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
