<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../classes/Database.php';
require_once '../classes/Usuarios.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit();
}

$database = new Database();
$db = $database->connect();

$usuarios = new Usuarios($db);
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = 'Las nuevas contraseñas no coinciden.';
    } else {
        try {
            // Cambiar la contraseña
            $usuarios->cambiarContrasena($user_id, $new_password);
            $success = 'Contraseña cambiada con éxito.';
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

// Obtener lista de usuarios
$query = "SELECT id, username, user_nombre FROM usuarios";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4">Cambiar Contraseña de Usuario</h1>
    <?php if ($error): ?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>
    <?php if ($success): ?>
    <div class="alert alert-success">
        <?php echo $success; ?>
    </div>
    <?php endif; ?>
    <form action="admin_cambiar_contrasena.php" method="post">
        <div class="mb-3">
            <label for="user_id" class="form-label">Seleccionar Usuario:</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['username'] . ' - ' . $row['user_nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">Nueva Contraseña:</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña:</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
