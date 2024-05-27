<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Usuarios.php';
require_once '../../classes/Roles.php';
require_once '../../config/config.php';
restrictAccess(['Administrador']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_nombre = $_POST['user_nombre'];
    $user_mail = $_POST['user_mail'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $roles = $_POST['roles'];

    $database = new Database();
    $db = $database->connect();

    $usuarios = new Usuarios($db);
    $usuarios->crearUsuario($user_nombre, $user_mail, $username, $password, $roles);

    header('Location: index.php');
}

$database = new Database();
$db = $database->connect();
$roles = new Roles($db);
$roles_result = $roles->obtenerRoles();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Crear Nuevo Usuario</h1>
    <form action="crear.php" method="post">
        <div class="mb-3">
            <label for="user_nombre" class="form-label">Nombre del Usuario:</label>
            <input type="text" name="user_nombre" id="user_nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="user_mail" class="form-label">Email del Usuario:</label>
            <input type="email" name="user_mail" id="user_mail" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="roles" class="form-label">Roles:</label>
            <?php while ($row = $roles_result->fetch_assoc()): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="roles[]" id="role_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>">
                <label class="form-check-label" for="role_<?php echo $row['id']; ?>"><?php echo $row['rol_name']; ?></label>
            </div>
            <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

