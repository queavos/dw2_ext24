<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Oportunidades.php';

$database = new Database();
$db = $database->connect();

$oportunidades = new Oportunidades($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $opor_code = $_POST['opor_code'];
    $opor_name = $_POST['opor_name'];
    $oportunidades->actualizarOportunidad($id, $opor_code, $opor_name);
    header('Location: index.php');
} else {
    $id = $_GET['id'];
    $oportunidad = $oportunidades->obtenerOportunidadPorId($id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Oportunidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Editar Oportunidad</h1>
    <form action="editar.php" method="post">
        <input type="hidden" name="id" value="<?php echo $oportunidad['id']; ?>">
        <div class="mb-3">
            <label for="opor_code" class="form-label">Código de la Oportunidad:</label>
            <input type="text" name="opor_code" id="opor_code" class="form-control" value="<?php echo $oportunidad['opor_code']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="opor_name" class="form-label">Nombre de la Oportunidad:</label>
            <input type="text" name="opor_name" id="opor_name" class="form-control" value="<?php echo $oportunidad['opor_name']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
